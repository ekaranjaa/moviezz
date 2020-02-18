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
        $data = $this->model->read();

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
