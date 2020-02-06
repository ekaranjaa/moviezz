<?php

class UserController extends Controller
{
    private $model;
    private $user;
    private $auth;
    private $helper;

    public function __construct()
    {
        $this->model = $this->model('user');
        $this->auth = $this->helper('auth');
        $this->helper = $this->helper('upload');

        $this->user = [
            'id' => !empty($_POST['id']) ? $_POST['id'] : 2,
            'avatar' => $_FILES['avatar'],
            'name' => $_POST['name'],
            'slug' => strtolower($_POST['username']),
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password'],
            'persist' => !empty($_POST['persist']) ? $_POST['persist'] : 2
        ];
    }

    public function login()
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
                                $_SESSION['fb'] = 'Successfully logged in';

                                $user = [
                                    'id' => $row['id'],
                                    'avatar' => $row['avatar'],
                                    'name' => $row['name'],
                                    'slug' => $row['slug'],
                                    'email' => $row['email'],
                                    'username' => $row['username']
                                ];

                                if ($this->user['persist'] == 1) {
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
                        die;
                    }
                } else {
                    $_SESSION['fb'] = 'User ' . $username . ' does not exist';
                    header('location: /user/login');
                }
            } else {
                $_SESSION['form_input'] = $this->user;
                $_SESSION['fb'] = $this->auth->fb;
                header('location: /user/login');
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function logout()
    {
        if (!empty($_SESSION['user']) || !empty($_COOKIE['user'])) {

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
                                    header('location: /user/login');
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
                        $_SESSION['form_input'] = $this->user;
                        $_SESSION['fb'] = $this->auth->fb;
                        header('location: /user/reset');
                    }
                } else {
                    $_SESSION['fb'] = $this->auth->fb;
                    header('location: /user/reset');
                }
            } else {
                $_SESSION['form_input'] = $this->user;
                $_SESSION['fb'] = $this->auth->fb;
                header('location: /user/reset');
            }
        } else {
            $this->view('auth/reset');
        }
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->auth->fields($this->user)) {
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
                                    header('location: /user/signup');
                                    die;
                                }
                            }
                        } else {
                            if ($this->helper->upload_image($this->user['avatar'], $this->user['slug'])) {
                                $this->user['avatar'] = $this->helper->fb;

                                if ($this->model->create($this->user)) {
                                    $_SESSION['fb'] = 'Successfully registered';

                                    $data = $this->model->read($this->user);

                                    if ($data->num_rows > 0) {
                                        while ($row = $data->fetch_assoc()) {
                                            $_SESSION['user'] = [
                                                'id' => $row['id'],
                                                'avatar' => $row['avatar'],
                                                'name' => $row['name'],
                                                'slug' => $row['slug'],
                                                'email' => $row['email'],
                                                'username' => $row['username']
                                            ];
                                            header('location: /');
                                            die;
                                        }
                                    }
                                } else {
                                    $_SESSION['fb'] = 'Error registering.';
                                    header('location: /user/signup');
                                }
                            } else {
                                $_SESSION['form_input'] = $this->user;
                                $_SESSION['fb'] = 'Error uploading image: ' . $this->helper->fb;
                                header('location: /user/signup');
                            }
                        }
                    } else {
                        $_SESSION['form_input'] = $this->user;
                        $_SESSION['fb'] = $this->auth->fb;
                        header('location: /user/signup');
                    }
                } else {
                    $_SESSION['fb'] = $this->auth->fb;
                    header('location: /user/signup');
                }
            } else {
                $_SESSION['form_input'] = $this->user;
                $_SESSION['fb'] = $this->auth->fb;
                header('location: /user/signup');
            }
        } else {
            $this->view('auth/signup');
        }
    }

    public function edit(string $slug)
    {
        if (!empty($_SESSION['user']) || !empty($_COOKIE['user'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $data = $this->model->read($this->user);
                if ($data->num_rows > 0) {
                    $row = $data->fetch_assoc();
                    $user = [
                        'id' => $row['id'],
                        'avatar' => $row['avatar'],
                        'name' => $row['name'],
                        'slug' => $row['slug'],
                        'email' => $row['email'],
                        'username' => $row['username']
                    ];
                } else {
                    $_SESSION['fb'] = 'There was an error retrieving your data';
                    unset($_SESSION['user']);
                    setcookie('user', '', time() - 3600, '/');
                }

                if ($this->auth->fields($this->user)) {
                    if ($this->auth->email($this->user['email'])) {
                        $passwords = [$this->user['password'], $this->user['confirm_password']];

                        if ($this->auth->password($passwords)) {
                            $this->user['slug'] = $slug;
                            $data = $this->model->read($this->user);
                            $row = $data->fetch_assoc();

                            if (!empty($this->user['avatar']['tmp_name'])) {
                                $this->helper->remove_image($row['avatar']);

                                if ($this->helper->upload_image($this->user['avatar'], $this->user['slug'])) {
                                    $this->user['avatar'] = $this->helper->fb;

                                    if ($this->model->edit($this->user)) {
                                        $_SESSION['fb'] = 'Profile successfully updated';

                                        if (!empty($_SESSION['user'])) {
                                            unset($_SESSION['user']);
                                            $_SESSION['user'] = $user;
                                        } else {
                                            setcookie('user', '', time() - 3600, '/');
                                            setcookie('user', $user, time() + (3600 * 24), '/');
                                        }

                                        header('location: /user/edit/' . $slug);
                                    } else {
                                        $_SESSION['fb'] = 'Error updating.';
                                        header('location: /user/edit/' . $slug);
                                    }
                                } else {
                                    $_SESSION['form_input'] = $this->user;
                                    $_SESSION['fb'] = 'Error updating profile photo: ' . $this->helper->fb;
                                }
                            } else {
                                if ($data->num_rows > 0) {
                                    $this->user['avatar'] = $row['avatar'];

                                    if ($this->model->edit($this->user)) {
                                        $_SESSION['fb'] = 'Profile successfully updated';

                                        $data = $this->model->read($this->user);

                                        if (!empty($_SESSION['user'])) {
                                            unset($_SESSION['user']);
                                            $_SESSION['user'] = $user;
                                        } else {
                                            setcookie('user', '', time() - 3600, '/');
                                            setcookie('user', $user, time() + (3600 * 24), '/');
                                        }

                                        header('location: /user/edit/' . $slug);
                                    } else {
                                        $_SESSION['fb'] = 'Error updating.';
                                        header('location: /user/edit/' . $slug);
                                    }
                                }
                            }
                        } else {
                            $_SESSION['fb'] = $this->auth->fb;
                            header('location: /user/edit/' . $slug);
                        }
                    } else {
                        $_SESSION['fb'] = $this->auth->fb;
                        header('location: /user/edit/' . $slug);
                    }
                } else {
                    $_SESSION['fb'] = $this->auth->fb;
                    header('location: /user/edit/' . $slug);
                }
            } else {
                $this->user['slug'] = $slug;

                $data = $this->model->read($this->user);

                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        $fb = $row;
                    }
                }

                $this->view('auth/edit', $fb);
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function delete(string $slug)
    {
        if (!empty($_SESSION['user']) || !empty($_COOKIE['user'])) {
            $this->user['slug'] = $slug;
            $data = $this->model->read($this->user);
            $row = $data->fetch_assoc();

            if ($this->helper->remove_image($row['avatar'])) {
                if ($this->model->delete($slug)) {
                    $_SESSION['fb'] = 'Account deleted';
                    unset($_SESSION['user']);
                    setcookie('user', '', time() - 3600, '/');
                    header('location: /');
                } else {
                    $_SESSION['fb'] = 'Error deleting account';
                    header('location: /');
                }
            } else {
                $_SESSION['fb'] = 'Error deleting avatar: ' . $this->helper->fb;
                header('location: /');
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }
}
