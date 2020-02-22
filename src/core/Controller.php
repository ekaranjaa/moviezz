<?php

class Controller
{
    public function userSession()
    {
        $fb = $this->middleware('session');

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

    protected function middleware(string $middleware)
    {
        $middleware = ucwords($middleware) . 'Middleware';

        if (file_exists(__DIR__ . '/../middleware/' . $middleware . '.php')) {
            require_once __DIR__ . '/../middleware/' .  $middleware . '.php';

            if (class_exists($middleware)) {
                $fb = new $middleware;
            } else {
                $fb = 'Class ' . $middleware . ' doesn\'t exist';
            }
        } else {
            exit('This middleware (' . $middleware . ') doesn\'t exist');
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
