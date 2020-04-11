<?php

class MovieController extends Controller
{
    private $model;
    private $movie;
    private $validate;
    private $imgHelper;


    /**
     * Constructor method
     */
    public function __construct()
    {
        $this->model = $this->model('movie');
        $this->validate = $this->helper('validate');
        $this->imgHelper = $this->helper('image', 'thumbnails');

        $this->movie = [
            'id' => !empty($_POST['id']) ? $_POST['id'] : null,
            'user_id' => !empty($_SESSION['user']) ? $_SESSION['user']['id'] : unserialize($_COOKIE['user'])['id'],
            'thumbnail' => $_FILES['thumbnail'],
            'name' => $_POST['name'],
            $array_name = explode(' ', $_POST['name']),
            'slug' => strtolower(implode('-', $array_name)),
            'genre' => $_POST['genre'],
            'price' => $_POST['price'],
            'description' => $_POST['description']
        ];
    }


    /**
     * Route methods 
     */
    public function add()
    {
        if ($this->userSession()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->createMovie();
            } else {
                $_SESSION['fb'] = 'Request must be post';
                header('location: /');
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function display(string $slug)
    {
        $this->movie['slug'] = $slug;
        $data = $this->fetchMovie();
        $this->view('movie/view', $data[0]);
    }

    public function genre(string $genre)
    {
        $this->movie['genre'] = $genre;
        $data = $this->fetchMovie();
        $this->view('movie/genre', $data);
    }

    public function edit(int $id)
    {
        if ($this->userSession()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->updateMovie($id);
            } else {
                $this->movie['id'] = $id;

                $data = $this->model->read($this->movie);

                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        $fb = $row;
                    }
                }

                $this->view('movie/edit', $fb);
            }
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }

    public function remove(string $slug)
    {
        if ($this->userSession()) {
            $this->deleteMovie($slug);
        } else {
            $_SESSION['fb'] = 'You need to be logged in to perform this action';
            header('location: /');
        }
    }


    /**
     * Crud methods
     */
    public function createMovie()
    {
        if ($this->validate->fields($this->movie)) {
            $slug = $this->movie['slug'];
            $data = $this->model->read($this->movie);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    if ($slug == $row['slug']) {
                        $_SESSION['fb'] = 'Movie ' . $this->movie['name'] . ' already exists';
                        header('location: /');
                    } else {
                        if ($this->imgHelper->uploadImage($this->movie['thumbnail'], $slug)) {
                            $this->movie['thumbnail'] = $this->imgHelper->fb;

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
                }
            } else {
                if ($this->imgHelper->uploadImage($this->movie['thumbnail'], $slug)) {
                    $this->movie['thumbnail'] = $this->imgHelper->fb;

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
    }

    public function fetchMovie()
    {
        $data = $this->model->read($this->movie);

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

    public function updateMovie(int $id)
    {
        if ($this->validate->fields($this->movie)) {

            $this->movie['id'] = $id;
            $data = $this->model->read($this->movie);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    if ($this->movie['user_id'] == $row['user_id']) {
                        if (!empty($this->movie['thumbnail']['tmp_name'])) {
                            if ($this->imgHelper->uploadImage($this->movie['thumbnail'], $this->movie['slug'])) {
                                $this->movie['thumbnail'] = $this->imgHelper->fb;
                                if ($this->model->update($this->movie)) {
                                    $_SESSION['fb'] = 'Updated movie successfully';
                                    header('location: /');
                                } else {
                                    $_SESSION['fb'] = 'Error updating.';
                                    header('location: /movie/edit/' . $id);
                                }
                            } else {
                                $_SESSION['fb'] = 'Error updating thumbnail: ' . $this->imgHelper->fb;
                            }
                        } else {
                            if ($this->imgHelper->renameImage($row['thumbnail'], $this->movie['slug'])) {
                                $this->movie['thumbnail'] = $this->imgHelper->fb;

                                if ($this->model->update($this->movie)) {
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
                    } else {
                        $_SESSION['fb'] = 'Permission denied';
                        header('location: /');
                    }
                }
            }
        } else {
            $_SESSION['fb'] = $this->validate->fb;
            header('location: /movie/edit/' . $id);
        }
    }

    public function deleteMovie(string $slug)
    {
        $this->movie['slug'] = $slug;
        $data = $this->model->read($this->movie);

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                if ($this->movie['user_id'] == $row['user_id']) {
                    if ($this->imgHelper->removeImage($row['thumbnail'])) {
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
                } else {
                    $_SESSION['fb'] = 'Permission denied';
                    header('location: /');
                }
            }
        }
    }
}
