<?php

class UserController extends Controller
{
    private $model;
    private $user;
    private $validate;
    private $imgHelper;


    /**
     * Constructor method
     */
    public function __construct()
    {
        $this->model = $this->model('user');
        $this->validate = $this->helper('validate');
        $this->imgHelper = $this->helper('image', 'users');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user = [
                'id' => isset($_POST['id']) ? $_POST['id'] : null,
                'avatar' => $_FILES['avatar'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password'],
                'remember_me' => isset($_POST['remember_me']) ? $_POST['remember_me'] : null
            ];
        }
    }


    /**
     * Route methods
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->createUser();
        } else {
            $this->view('user/register');
        }
    }

    public function edit(string $username)
    {
        if ($this->userSession()) {
            $currentUser = isset($_SESSION['user']) ? $_SESSION['user']['username'] : unserialize($_COOKIE['user'])['username'];

            if ($username == $currentUser) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $this->updateUser($username);
                } else {
                    $this->user['username'] = $username;

                    $data = $this->model->read($this->user);

                    if ($data->num_rows > 0) {
                        while ($row = $data->fetch_assoc()) {
                            $fb = $row;
                        }
                    } else {
                        $_SESSION['fb'] = 'The specified user doesn\'t exist';
                        header('location: /');
                    }

                    $this->view('user/edit', $fb);
                }
            } else {
                $_SESSION['fb'] = 'Permission denied';
                header('location: /');
            }
        } else {
            header('location: /');
        }
    }

    public function remove(string $username)
    {
        if ($this->userSession()) {
            $this->deleteUser($username);
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fields = [
                'username' => $this->user['username'],
                'password' => $this->user['password']
            ];

            if ($this->validate->fields($fields)) {
                $username = $this->user['username'];
                $password = $this->user['password'];

                $data = $this->model->read($this->user);

                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        if ($username == $row['username']) {
                            if (password_verify($password, $row['password'])) {
                                $_SESSION['fb'] = 'Login success';

                                $user = [
                                    'id' => $row['id'],
                                    'avatar' => $row['avatar'],
                                    'name' => $row['name'],
                                    'email' => $row['email'],
                                    'username' => $row['username']
                                ];

                                if ($this->user['remember_me'] == 1) {
                                    setcookie('user', serialize($user), time() + (3600 * 24), '/');
                                } else {
                                    $_SESSION['user'] = $user;
                                }

                                header('location: /');
                            } else {
                                $_SESSION['form_input'] = $this->user;
                                $_SESSION['fb'] = 'Incorrect password for user ' . $username;
                                header('location: /user/login');
                            }
                        } else {
                            $_SESSION['fb'] = 'User ' . $username . ' does not exist';
                            header('location: /user/login');
                        }
                    }
                } else {
                    $_SESSION['fb'] = 'User ' . $username . ' does not exist';
                    header('location: /user/login');
                }
            } else {
                $_SESSION['form_input'] = $this->user;
                $_SESSION['fb'] = $this->validate->fb;
                header('location: /user/login');
            }
        } else {
            $this->view('user/login');
        }
    }

    public function logout()
    {
        if ($this->userSession()) {
            unset($_SESSION['user']);
            setcookie('user', '', time() - 3600, '/');
            $_SESSION['fb'] = 'Youv\'ve been logged out';
        } else {
            $_SESSION['fb'] = 'You\'re not logged in';
        }

        header('location: /');
    }

    public function reset()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->userSession()) {
                $fields = [
                    'email' => $this->user['email'],
                    'password' => $this->user['password'],
                    'confirm_password' => $this->user['confirm_password']
                ];

                if ($this->validate->fields($fields)) {
                    if ($this->validate->email($this->user['email'])) {
                        $passwords = [$this->user['password'], $this->user['confirm_password']];
                        if ($this->validate->password($passwords)) {
                            $email = $this->user['email'];
                            $data = $this->model->read($this->user);

                            if ($data->num_rows > 0) {
                                while ($row = $data->fetch_assoc()) {
                                    $this->user['name'] = $row['name'];
                                    $this->user['username'] = $row['username'];
                                    $this->user['avatar'] = $row['avatar'];

                                    if ($this->model->update($this->user)) {
                                        $_SESSION['fb'] = 'Password reset successfully. Login here';
                                        header('location: /user/login');
                                    } else {
                                        $_SESSION['fb'] = 'Password reset error. Try again in a few minutes.';
                                        header('location: /user/reset');
                                    }
                                }
                            } else {
                                $_SESSION['fb'] = 'User ' . $email . ' does not exist';
                                header('location: /user/reset');
                            }
                        } else {
                            $_SESSION['form_input'] = $this->user;
                            $_SESSION['fb'] = $this->validate->fb;
                            header('location: /user/reset');
                        }
                    } else {
                        $_SESSION['fb'] = $this->validate->fb;
                        header('location: /user/reset');
                    }
                } else {
                    $_SESSION['form_input'] = $this->user;
                    $_SESSION['fb'] = $this->validate->fb;
                    header('location: /user/reset');
                }
            } else {
                $_SESSION['fb'] = 'Permision denied. You must be logged out to perform this action';
                header('location: /');
            }
        } else {
            $this->view('user/reset');
        }
    }


    /**
     * Crud methods
     */
    public function createUser()
    {
        if ($this->validate->fields($this->user)) {
            if ($this->validate->email($this->user['email'])) {
                if ($this->validate->password([$this->user['password'], $this->user['confirm_password']])) {
                    $email = $this->user['email'];
                    $username = $this->user['username'];

                    $data = $this->model->read($this->user);

                    if ($data->num_rows > 0) {
                        while ($row = $data->fetch_assoc()) {
                            if ($email == $row['email'] || $username == $row['username']) {
                                $user = $email == $row['email'] ? $email : $username;
                                $_SESSION['fb'] = 'User ' . $user . ' already exists';
                                header('location: /user/register');
                            }
                        }
                    } else {
                        if ($this->imgHelper->uploadImage($this->user['avatar'], $this->user['username'])) {
                            $this->user['avatar'] = $this->imgHelper->fb;

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
                                    }
                                }
                            } else {
                                $_SESSION['fb'] = 'Error registering.';
                                header('location: /user/register');
                            }
                        } else {
                            $_SESSION['form_input'] = $this->user;
                            $_SESSION['fb'] = 'Error uploading image: ' . $this->imgHelper->fb;
                            header('location: /user/register');
                        }
                    }
                } else {
                    $_SESSION['form_input'] = $this->user;
                    $_SESSION['fb'] = $this->validate->fb;
                    header('location: /user/register');
                }
            } else {
                $_SESSION['fb'] = $this->validate->fb;
                header('location: /user/register');
            }
        } else {
            $_SESSION['form_input'] = $this->user;
            $_SESSION['fb'] = $this->validate->fb;
            header('location: /user/register');
        }
    }

    public function fetchUser()
    {
        $data = $this->model->read();

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $fb[] = $row;
            }
        } else {
            $fb = [];
        }

        return $fb;
    }

    public function updateUser(string $username)
    {
        $data = $this->model->read($this->user);
        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $user = [
                    'id' => $row['id'],
                    'avatar' => $row['avatar'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'username' => $row['username']
                ];
            }
        } else {
            $_SESSION['fb'] = 'There was an error retrieving your data';
            unset($_SESSION['user']);
            setcookie('user', '', time() - 3600, '/');
        }

        if ($this->validate->fields($this->user)) {
            if ($this->validate->email($this->user['email'])) {
                $passwords = [$this->user['password'], $this->user['confirm_password']];

                if ($this->validate->password($passwords)) {
                    $this->user['username'] = $username;
                    $data = $this->model->read($this->user);

                    if ($data->num_rows > 0) {
                        while ($row = $data->fetch_assoc()) {
                            if (!empty($this->user['avatar']['tmp_name'])) {
                                if ($this->imgHelper->uploadImage($this->user['avatar'], $this->user['username'])) {
                                    $this->user['avatar'] = $this->imgHelper->fb;

                                    if ($this->model->update($this->user)) {
                                        $_SESSION['fb'] = 'Profile successfully updated';

                                        if (isset($_SESSION['user'])) {
                                            $_SESSION['user'] = $user;
                                        } else {
                                            setcookie('user', $user, time() + (3600 * 24), '/');
                                        }

                                        header('location: /user/edit/' . $username);
                                    } else {
                                        $_SESSION['fb'] = 'Error updating.';
                                        header('location: /user/edit/' . $username);
                                    }
                                } else {
                                    $_SESSION['form_input'] = $this->user;
                                    $_SESSION['fb'] = 'Error updating profile photo: ' . $this->imgHelper->fb;
                                }
                            } else {
                                if ($this->imgHelper->renameImage($row['avatar'], $this->user['username'])) {
                                    $this->user['avatar'] = $this->imgHelper->fb;

                                    if ($this->model->update($this->user)) {
                                        $_SESSION['fb'] = 'Profile successfully updated';

                                        $data = $this->model->read($this->user);

                                        if (isset($_SESSION['user'])) {
                                            $_SESSION['user'] = $user;
                                        } else {
                                            setcookie('user', $user, time() + (3600 * 24), '/');
                                        }

                                        header('location: /user/edit/' . $username);
                                    } else {
                                        $_SESSION['fb'] = 'Error updating.';
                                        header('location: /user/edit/' . $username);
                                    }
                                } else {
                                    $_SESSION['fb'] = $this->imgHelper->fb;
                                    header('location: /user/edit/' . $username);
                                }
                            }
                        }
                    }
                } else {
                    $_SESSION['fb'] = $this->validate->fb;
                    header('location: /user/edit/' . $username);
                }
            } else {
                $_SESSION['fb'] = $this->validate->fb;
                header('location: /user/edit/' . $username);
            }
        } else {
            $_SESSION['fb'] = $this->validate->fb;
            header('location: /user/edit/' . $username);
        }
    }

    public function deleteUser(string $username)
    {
        $this->user['username'] = $username;
        $data = $this->model->read($this->user);

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                if ($this->imgHelper->removeImage($row['avatar'])) {
                    if ($this->model->delete($username)) {
                        $this->logout();
                        $_SESSION['fb'] = 'Account deleted';
                    } else {
                        $_SESSION['fb'] = 'Error deleting account';
                        header('location: /');
                    }
                } else {
                    $_SESSION['fb'] = 'Error deleting avatar: ' . $this->imgHelper->fb;
                    header('location: /');
                }
            }
        }
    }
}
