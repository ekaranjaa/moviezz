<?php

class UserController extends Controller
{
    private $model;
    private $user;
    private $auth;
    private $handler;

    public function __construct()
    {
        $this->model = $this->model('user');
        $this->auth = $this->extension('auth/auth');
        $this->handler = $this->extension('upload/upload');

        $this->user = [
            'id' => $_POST['id'],
            'avatar' => $_FILES['avatar'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password']
        ];
    }

    public function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fields = [
                'username' => $this->user['username'],
                'password' => $this->user['password']
            ];

            if ($this->auth->fields($fields)) {
                $username = $this->user['username'];
                $password = $this->user['password'];

                $data = $this->model->read($this->user);

                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        if ($username == $row['username']) {
                            if (password_verify($password, $row['password'])) {
                                $_SESSION['fb'] = 'Successfully signed in.';

                                $_SESSION['user'] = [
                                    'id' => $row['id'],
                                    'avatar' => $row['avatar'],
                                    'name' => $row['name'],
                                    'email' => $row['email'],
                                    'username' => $row['username']
                                ];
                                header('location: /');
                            } else {
                                $_SESSION['fb'] = 'Incorrect password for user ' . $username;
                                header('location: /user/signin');
                            }
                        } else {
                            $_SESSION['fb'] = 'User ' . $username . ' does not exist.';
                            header('location: /user/signin');
                        }
                    }
                } else {
                    $_SESSION['fb'] = 'User ' . $username . ' does not exist.';
                    header('location: /user/signin');
                }
            } else {
                $_SESSION['fb'] = $this->auth->fb;
                header('location: /user/signin');
            }
        } else {
            $this->view('auth/signin');
        }
    }

    public function signout()
    {
        unset($_SESSION['user']);

        $_SESSION['fb'] = 'Signed out';
        header('location: /');
    }

    public function reset()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fields = [
                'email' => $this->user['email'],
                'password' => $this->user['password'],
                'confirm_password' => $this->user['confirm_password']
            ];

            if ($this->auth->fields($fields)) {
                if ($this->auth->email($this->user['email'])) {
                    $passwords = [$this->user['password'], $this->user['confirm_password']];
                    if ($this->auth->password($passwords)) {
                        $email = $this->user['email'];
                        $data = $this->model->read($this->user);

                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                                $this->user['name'] = $row['name'];
                                $this->user['username'] = $row['username'];
                                $this->user['avatar'] = $row['avatar'];

                                if ($this->model->edit($this->user)) {
                                    $_SESSION['fb'] = 'Password reset successfully<br>Sign in here';
                                    header('location: /user/signin');
                                    die;
                                } else {
                                    $_SESSION['fb'] = 'Password reset error. Try again later';
                                    header('location: /user/reset');
                                    die;
                                }
                            }
                        } else {
                            $_SESSION['fb'] = 'User ' . $email . ' does not exist';
                            header('location: /user/reset');
                        }
                    } else {
                        $_SESSION['fb'] = $this->auth->fb;
                        header('location: /user/reset');
                    }
                } else {
                    $_SESSION['fb'] = $this->auth->fb;
                    header('location: /user/reset');
                }
            } else {
                $_SESSION['fb'] = $this->auth->fb;
                header('location: /user/reset');
            }
        } else {
            $this->view('auth/reset');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fields = [
                'avatar' => $this->user['avatar'],
                'name' => $this->user['name'],
                'email' => $this->user['email'],
                'username' => $this->user['username'],
                'password' => $this->user['password'],
                'confirm_password' => $this->user['confirm_password']
            ];

            if ($this->auth->fields($fields)) {
                if ($this->auth->email($this->user['email'])) {
                    $passwords = [$this->user['password'], $this->user['confirm_password']];

                    if ($this->auth->password($passwords)) {
                        $email = $this->user['email'];
                        $username = $this->user['username'];

                        $data = $this->model->read($this->user);

                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                                if ($email == $row['email'] || $username == $row['username']) {
                                    $user = $email == $row['email'] ? $email : $username;
                                    $_SESSION['fb'] = 'User ' . $user . ' already exists';
                                    header('location: /user/register');
                                    die;
                                }
                            }
                        } else {
                            if ($this->handler->upload_image($this->user['avatar'])) {
                                $this->user['avatar'] = $this->handler->fb;

                                if ($this->model->create($this->user)) {
                                    $_SESSION['fb'] = 'Successfully registered';

                                    $data = $this->model->read($this->user);

                                    if ($data->num_rows > 0) {
                                        while ($row = $data->fetch_assoc()) {
                                            $_SESSION['user'] = [
                                                'id' => $row['id'],
                                                'avatar' => $row['avatar'],
                                                'name' => $row['name'],
                                                'email' => $row['email'],
                                                'username' => $row['username']
                                            ];
                                            header('location: /');
                                            die;
                                        }
                                    }
                                } else {
                                    $_SESSION['fb'] = 'Error registering.';
                                    header('location: /user/register');
                                }
                            } else {
                                $_SESSION['fb'] = 'Error uploading image: ' . $this->handler->fb;
                                header('location: /user/register');
                            }
                        }
                    } else {
                        $_SESSION['fb'] = $this->auth->fb;
                        header('location: /user/register');
                    }
                } else {
                    $_SESSION['fb'] = $this->auth->fb;
                    header('location: /user/register');
                }
            } else {
                $_SESSION['fb'] = $this->auth->fb;
                header('location: /user/register');
            }
        } else {
            $this->view('auth/register');
        }
    }

    public function edit(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->auth->fields($this->user)) {
                if ($this->auth->email($this->user['email'])) {
                    $passwords = [$this->user['password'], $this->user['confirm_password']];

                    if ($this->auth->password($passwords)) {
                        $this->user['id'] = $id;
                        $data = $this->model->read($this->user);
                        $row = $data->fetch_assoc();

                        if (!empty($this->user['avatar']['tmp_name'])) {
                            $this->handler->remove_image($row['avatar']);

                            if ($this->handler->upload_image($this->user['avatar'])) {
                                $this->user['avatar'] = $this->handler->fb;

                                if ($this->model->edit($this->user)) {
                                    $_SESSION['fb'] = 'Profile successfully updated';

                                    $data = $this->model->read($this->user);

                                    if ($data->num_rows > 0) {
                                        while ($row = $data->fetch_assoc()) {
                                            $_SESSION['user'] = [
                                                'id' => $row['id'],
                                                'avatar' => $row['avatar'],
                                                'name' => $row['name'],
                                                'email' => $row['email'],
                                                'username' => $row['username']
                                            ];
                                            header('location: /');
                                            die;
                                        }
                                    } else {
                                        $_SESSION['fb'] = 'There was an error retrieving your data';
                                        unset($_SESSION['user']);
                                    }
                                } else {
                                    $_SESSION['fb'] = 'Error updating.';
                                    header('location: /user/edit/' . $id);
                                }
                            } else {
                                $_SESSION['fb'] = 'Error updating profile photo: ' . $this->handler->fb;
                            }
                        } else {
                            if ($data->num_rows > 0) {
                                $this->user['avatar'] = $row['avatar'];

                                if ($this->model->edit($this->user)) {
                                    $_SESSION['fb'] = 'Profile successfully updated';

                                    $data = $this->model->read($this->user);

                                    if ($data->num_rows > 0) {
                                        while ($row = $data->fetch_assoc()) {
                                            $_SESSION['user'] = [
                                                'id' => $row['id'],
                                                'avatar' => $row['avatar'],
                                                'name' => $row['name'],
                                                'email' => $row['email'],
                                                'username' => $row['username']
                                            ];
                                            header('location: /');
                                            die;
                                        }
                                    } else {
                                        $_SESSION['fb'] = 'There was an error retrieving your data';
                                        unset($_SESSION['user']);
                                    }
                                } else {
                                    $_SESSION['fb'] = 'Error updating.';
                                    header('location: /user/edit/' . $id);
                                }
                            }
                        }
                    } else {
                        $_SESSION['fb'] = $this->auth->fb;
                        header('location: /user/edit/' . $id);
                    }
                } else {
                    $_SESSION['fb'] = $this->auth->fb;
                    header('location: /user/edit/' . $id);
                }
            } else {
                $_SESSION['fb'] = $this->auth->fb;
                header('location: /user/edit/' . $id);
            }
        } else {
            $this->user['id'] = $id;

            $data = $this->model->read($this->user);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    $fb = $row;
                }
            }

            $this->view('auth/edit', $fb);
        }
    }

    public function delete(int $id)
    {
        $this->user['id'] = $id;
        $data = $this->model->read($this->user);
        $row = $data->fetch_assoc();

        if ($this->handler->remove_image($row['avatar'])) {
            if ($this->model->delete($id)) {
                $_SESSION['fb'] = 'Account deleted';
                unset($_SESSION['user']);
                header('location: /');
            } else {
                $_SESSION['fb'] = 'Error deleting account';
                header('location: /');
            }
        } else {
            $_SESSION['fb'] = 'Error deleting avatar: ' . $this->handler->fb;
            header('location: /');
        }
    }
}
