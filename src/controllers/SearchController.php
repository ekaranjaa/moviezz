<?php

class SearchController extends Controller
{
    private $model;
    private $user;
    private $query;
    private $fb;

    public function __construct()
    {
        $this->model = $this->model('search');
        $this->user = !empty($_SESSION['user']) ? $_SESSION['user']['id'] : unserialize($_COOKIE['user'])['id'];
        $this->query = $_GET['query'];

        if ($this->userSession()) {
            $data = $this->model->read($this->query, $this->user);
        } else {
            $data = $this->model->read($this->query);
        }

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $this->fb[] =  $row;
            }
        } else {
            $this->fb = [];
        }
    }

    public function index()
    {
        $this->view('search', $this->fb);
    }

    public function api()
    {
        return print_r(json_encode($this->fb, JSON_PRETTY_PRINT));
    }

    public function genres(string $field)
    {
        $this->fb = [];

        if ($this->userSession()) {
            $data = $this->model->read(null, $this->user, $field);
        } else {
            $data = $this->model->read(null, null, $field);
        }

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $this->fb[] =  $row;
            }
        } else {
            $this->fb = [];
        }

        return print_r(json_encode($this->fb, JSON_PRETTY_PRINT));
    }
}
