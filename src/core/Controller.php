<?php

class Controller
{
    public function userSession()
    {
        if (empty($_SESSION['user']) && empty($_COOKIE['user'])) {
            $fb = false;
        } else {
            $fb = true;
        }

        return $fb;
    }

    protected function model(string $model)
    {
        $model = ucwords($model);

        if (file_exists(__DIR__ . '/../models/' . $model . '.php')) {
            require_once __DIR__ . '/../models/' . $model . '.php';

            if (class_exists($model)) {
                $fb = new $model;
            } else {
                $fb = 'Class ' . $model . ' doesn\'t exist';
            }
        } else {
            exit('File ' . $model . ' doesn\'t exist.');
        }

        return $fb;
    }

    protected function helper(string $helper)
    {
        $helper = ucwords($helper);

        if (file_exists(__DIR__ . '/../helpers/' . $helper . '.php')) {
            require_once __DIR__ . '/../helpers/' .  $helper . '.php';

            if (class_exists($helper)) {
                $fb = new $helper;
            } else {
                $fb = 'Class ' . $helper . ' doesn\'t exist';
            }
        } else {
            exit('This helper (' . $helper . ') doesn\'t exist');
        }

        return $fb;
    }

    protected function view(string $view, array $data = [])
    {
        if (file_exists(__DIR__ . '/../views/' . $view . '.php')) {
            require_once __DIR__ . '/../views/' . $view . '.php';
        } else {
            exit('View doesn\'t exist.');
        }
    }
}
