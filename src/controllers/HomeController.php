<?php

class HomeController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model('home');
    }

    public function index()
    {
        $user = $_SESSION['user'];
        $user_id = $user['id'] > 0 ? $user['id'] : 0;

        $data = $this->model->read($user_id);

        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                $fb[] = $row;
            }
        } else {
            $fb = [];
        }

        $this->view('home', $fb);
    }
}
