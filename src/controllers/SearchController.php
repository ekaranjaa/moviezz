<?php

class SearchController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('search');

        $query = $_GET['query'];
        $currentUser = !empty($_SESSION['user']) ? $_SESSION['user']['id'] : unserialize($_COOKIE['user'])['id'];

        if ($this->userSession()) {
            $data = $this->model->read($query, $currentUser);
        } else {
            $data = $this->model->read($query);
        }

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $fb[] =  $row;
            }
        } else {
            $fb = [];
        }

        $this->view('search', $fb);
    }
}
