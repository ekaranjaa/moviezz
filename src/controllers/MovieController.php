<?php

class MovieController extends Controller
{
    private $model;
    private $movie;
    private $handler;

    public function __construct()
    {
        $this->model = $this->model('movie');
        $this->handler = $this->extension('upload/upload');

        $this->movie = [
            'id' => $_POST['id'],
            'cover_image' => $_FILES['cover_image'],
            'name' => $_POST['name'],
            'genre' => $_POST['genre'],
            'price' => $_POST['price']
        ];
    }

    public function display(int $id)
    {
        $this->movie['id'] = $id;
        $data = $this->model->read($this->movie);

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $fb = $row;
            }
        } else {
            $fb = [];
            $_SESSION['fb'] = 'The selected movie doesn\'t exist';
        }

        $this->view('movie', $fb);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $this->movie['name'];
            $data = $this->model->read($this->movie);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    if ($name == $row['name']) {
                        $_SESSION['fb'] = 'Movie ' . $name . ' already exists';
                        header('location: /');
                    }
                }
            } else {
                if ($this->handler->upload_image($this->movie['cover_image'])) {
                    $this->movie['cover_image'] = $this->handler->fb;

                    if ($this->model->create($this->movie)) {
                        $_SESSION['fb'] = 'Successfully added movie';
                        header('location: /');
                    } else {
                        $_SESSION['fb'] = 'Error adding movie';
                        header('location: /');
                    }
                } else {
                    $_SESSION['fb'] = 'File upload error: ' . $this->handler->fb;
                    header('location: /');
                }
            }
        } else {
            exit('Invalid request');
        }
    }

    public function edit(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->movie['id'] = $id;
            $data = $this->model->read($this->movie);
            $row = $data->fetch_assoc();

            if (!empty($this->movie['cover_image']['tmp_name'])) {
                $this->handler->remove_image($row['cover_image']);

                if ($this->handler->upload_image($this->movie['cover_image'])) {
                    $this->movie['cover_image'] = $this->handler->fb;
                    if ($this->model->edit($this->movie)) {
                        $_SESSION['fb'] = 'Updated movie successfully';
                        header('location: /');
                    } else {
                        $_SESSION['fb'] = 'Error updating.';
                        header('location: /movie/edit/' . $id);
                    }
                } else {
                    $_SESSION['fb'] = 'Error updating profile photo: ' . $this->handler->fb;
                }
            } else {
                $this->movie['cover_image'] = $row['cover_image'];

                if ($this->model->edit($this->movie)) {
                    $_SESSION['fb'] = 'Updated movie successfully';
                    header('location: /');
                } else {
                    $_SESSION['fb'] = 'Error updating.';
                    header('location: /movie/edit/' . $id);
                }
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
    }

    public function delete(int $id)
    {
        $this->movie['id'] = $id;
        $data = $this->model->read($this->movie);
        $row = $data->fetch_assoc();

        if ($this->handler->remove_image($row['cover_image'])) {
            if ($this->model->delete($id)) {
                $_SESSION['fb'] = 'Movie deleted';
                header('location: /');
            } else {
                $_SESSION['fb'] = 'Error deleting.';
                header('location: /');
            }
        } else {
            $_SESSION['fb'] = 'Error deleting cover image: ' . $this->handler->fb;
            header('location: /');
        }
    }
}
