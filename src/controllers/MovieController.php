<?php

class MovieController extends Controller
{
    private $model;
    private $movie;
    private $validate;
    private $imgMiddleware;


    /**
     * Constructor method
     */
    public function __construct()
    {
        $this->model = $this->model('movie');
        $this->validate = $this->middleware('validate');
        $this->imgMiddleware = $this->middleware('image');

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


    /**
     * Route methods 
     */
    public function add()
    {
        if ($this->userSession()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->create();
            } else {
                $_SESSION['fb'] = 'Request must be post';
                header('location: /');
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function display()
    {
        if ($this->userSession()) {
            $this->read();
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function edit(int $id)
    {
        if ($this->userSession()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->update($id);
            } else {
                $_SESSION['fb'] = 'Request method must be post';

                $this->movie['id'] = $id;

                $data = $this->model->read($this->movie);

                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        $fb = $row;
                    }
                }

                $this->view('edit', $fb);
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function remove(string $slug)
    {
        if ($this->userSession()) {
            $this->delete($slug);
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }


    /**
     * Crud methods
     */
    public function create()
    {
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
                if ($this->imgMiddleware->uploadImage($this->movie['cover_image'], $slug)) {
                    $this->movie['cover_image'] = $this->imgMiddleware->fb;

                    if ($this->model->create($this->movie)) {
                        $_SESSION['fb'] = 'Successfully added movie';
                        header('location: /');
                    } else {
                        $_SESSION['fb'] = 'Error adding movie';
                        header('location: /');
                    }
                } else {
                    $_SESSION['form_input'] = $this->movie;
                    $_SESSION['fb'] = 'File upload error: ' . $this->imgMiddleware->fb;
                    header('location: /');
                }
            }
        } else {
            $_SESSION['form_input'] = $this->movie;
            $_SESSION['fb'] = $this->validate->fb;
            header('location: /');
        }
    }

    public function read()
    {
        $data = $this->model->read();

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $fb[] = $row;
            }
        } else {
            $_SESSION['fb'] = 'No movies here yet';
            header('location: /');
        }

        return $fb;
    }

    public function update(int $id)
    {
        if ($this->validate->fields($this->movie)) {

            $this->movie['id'] = $id;
            $data = $this->model->read($this->movie);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    if (!empty($this->movie['cover_image']['tmp_name'])) {
                        if ($this->imgMiddleware->uploadImage($this->movie['cover_image'], $this->movie['slug'])) {
                            $this->movie['cover_image'] = $this->imgMiddleware->fb;
                            if ($this->model->edit($this->movie)) {
                                $_SESSION['fb'] = 'Updated movie successfully';
                                header('location: /');
                            } else {
                                $_SESSION['fb'] = 'Error updating.';
                                header('location: /movie/edit/' . $id);
                            }
                        } else {
                            $_SESSION['fb'] = 'Error updating profile photo: ' . $this->imgMiddleware->fb;
                        }
                    } else {
                        if ($this->imgMiddleware->renameImage($row['cover_image'], $this->movie['slug'])) {
                            $this->movie['cover_image'] = $this->imgMiddleware->fb;

                            if ($this->model->edit($this->movie)) {
                                $_SESSION['fb'] = 'Updated movie successfully';
                                header('location: /');
                            } else {
                                $_SESSION['fb'] = 'Error updating.';
                                header('location: /movie/edit/' . $id);
                            }
                        } else {
                            $_SESSION['fb'] = $this->imgMiddleware->fb;
                            header('location: /movie/edit/' . $id);
                        }
                    }
                }
            }
        } else {
            $_SESSION['fb'] = $this->validate->fb;
            header('location: /movie/edit/' . $id);
        }
    }

    public function delete(string $slug)
    {
        $this->movie['slug'] = $slug;
        $data = $this->model->read($this->movie);

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                if ($this->imgMiddleware->removeImage($row['cover_image'])) {
                    if ($this->model->delete($slug)) {
                        $_SESSION['fb'] = 'Movie deleted';
                        header('location: /');
                    } else {
                        $_SESSION['fb'] = 'Error deleting.';
                        header('location: /');
                    }
                } else {
                    $_SESSION['fb'] = 'Error deleting cover image: ' . $this->imgMiddleware->fb;
                    header('location: /');
                }
            }
        }
    }
}
