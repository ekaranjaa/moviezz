<?php

class Controller
{
    public function __construct()
    {
        $_SESSION['fb'] = $this->fb;
    }

    protected function model(string $model)
    {
        $model = ucwords($model);

        if (file_exists(__DIR__ . '/../models/' . $model . '.php')) {
            require_once __DIR__ . '/../models/' . $model . '.php';
        } else {
            exit('Model doesn\'t exist.');
        }

        return new $model;
    }

    protected function view(string $view, array $data = [])
    {
        if (file_exists(__DIR__ . '/../views/' . $view . '.php')) {
            require_once __DIR__ . '/../views/' . $view . '.php';
        } else {
            exit('View doesn\'t exist.');
        }
    }

    protected function extension(string $extension)
    {
        $extension = explode('/', $extension);

        if (file_exists(__DIR__ . '/../controllers/' . $extension[0] . '/' . ucwords($extension[1]) . '.php')) {
            require_once __DIR__ . '/../controllers/' . $extension[0] . '/' . ucwords($extension[1]) . '.php';
        } else {
            exit('This extension doesn\'t exist');
        }

        return new $extension[1];
    }
}
