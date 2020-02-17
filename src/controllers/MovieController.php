<?php

class MovieController extends Controller
{
    private $model;
    private $movie;
    private $validate;
    private $imgHelper;

    public function __construct()
    {
        $this->model = $this->model('movie');
        $this->validate = $this->helper('validate');
        $this->imgHelper = $this->helper('ImageFileHandler');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->movie = [
                'id' => !empty($_POST['id']) ? $_POST['id'] : 0,
                'cover_image' => $_FILES['cover_image'],
                'name' => $_POST['name'],
                $array_name = explode(' ', $_POST['name']),
                'slug' => strtolower(implode('-', $array_name)),
                'type' => $_POST['type'],
                'price' => $_POST['price'],
                'description' => $_POST['description']
            ];
        }
    }

    public function add()
    {
        if ($this->userSession()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($this->validate->fields($this->movie)) {
                    $slug = $this->movie['slug'];
                    $data = $this->model->read($this->movie);

                    if ($data->num_rows > 0) {
                        while ($row = $data->fetch_assoc()) {
                            if ($slug == $row['slug']) {
                                $_SESSION['fb'] = 'Movie ' . $this->movie['name'] . ' already exists';
                                header('location: /');
                            }
                        }
                    } else {
                        if ($this->imgHelper->uploadImage($this->movie['cover_image'], $slug)) {
                            $this->movie['cover_image'] = $this->imgHelper->fb;

                            if ($this->model->create($this->movie)) {
                                $_SESSION['fb'] = 'Successfully added movie';
                                header('location: /');
                            } else {
                                $_SESSION['fb'] = 'Error adding movie';
                                header('location: /');
                            }
                        } else {
                            $_SESSION['form_input'] = $this->movie;
                            $_SESSION['fb'] = 'File upload error: ' . $this->imgHelper->fb;
                            header('location: /');
                        }
                    }
                } else {
                    $_SESSION['form_input'] = $this->movie;
                    $_SESSION['fb'] = $this->validate->fb;
                    header('location: /');
                }
            } else {
                exit('Invalid request');
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function edit(int $id)
    {
        if ($this->userSession()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if ($this->validate->fields($this->movie)) {

                    $this->movie['id'] = $id;
                    $data = $this->model->read($this->movie);

                    if ($data->num_rows > 0) {
                        while ($row = $data->fetch_assoc()) {
                            if (!empty($this->movie['cover_image']['tmp_name'])) {
                                $this->imgHelper->removeImage($row['cover_image']);

                                if ($this->imgHelper->uploadImage($this->movie['cover_image'], $this->movie['slug'])) {
                                    $this->movie['cover_image'] = $this->imgHelper->fb;
                                    if ($this->model->edit($this->movie)) {
                                        $_SESSION['fb'] = 'Updated movie successfully';
                                        header('location: /');
                                    } else {
                                        $_SESSION['fb'] = 'Error updating.';
                                        header('location: /movie/edit/' . $id);
                                    }
                                } else {
                                    $_SESSION['fb'] = 'Error updating profile photo: ' . $this->imgHelper->fb;
                                }
                            } else {
                                if ($this->imgHelper->renameImage($row['cover_image'], $this->movie['slug'])) {
                                    $this->movie['cover_image'] = $this->imgHelper->fb;

                                    if ($this->model->edit($this->movie)) {
                                        $_SESSION['fb'] = 'Updated movie successfully';
                                        header('location: /');
                                    } else {
                                        $_SESSION['fb'] = 'Error updating.';
                                        header('location: /movie/edit/' . $id);
                                    }
                                } else {
                                    $_SESSION['fb'] = $this->imgHelper->fb;
                                    header('location: /movie/edit/' . $id);
                                }
                            }
                        }
                    }
                } else {
                    $_SESSION['fb'] = $this->validate->fb;
                    header('location: /movie/edit/' . $id);
                }
            } else {
                $this->movie['id'] = $id;

                $data = $this->model->read($this->movie);

                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        $fb = $row;
                    }
                }

                $this->view('home', $fb);
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function delete(string $slug)
    {
        if ($this->userSession()) {
            $this->movie['slug'] = $slug;
            $data = $this->model->read($this->movie);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    if ($this->imgHelper->removeImage($row['cover_image'])) {
                        if ($this->model->delete($slug)) {
                            $_SESSION['fb'] = 'Movie deleted';
                            header('location: /');
                        } else {
                            $_SESSION['fb'] = 'Error deleting.';
                            header('location: /');
                        }
                    } else {
                        $_SESSION['fb'] = 'Error deleting cover image: ' . $this->imgHelper->fb;
                        header('location: /');
                    }
                }
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }
}
