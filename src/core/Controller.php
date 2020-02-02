<?php

class Controller
{
    protected function model(string $model)
    {
        if (file_exists(__DIR__ . '/../models/' . ucwords($model) . '.php')) {
            require_once __DIR__ . '/../models/' . ucwords($model) . '.php';
        } else {
            exit('Model doesn\'t exist.');
        }

        return new $model;
    }

    protected function helper(string $helper)
    {
        if (file_exists(__DIR__ . '/../helpers/' . ucwords($helper) . '.php')) {
            require_once __DIR__ . '/../helpers/' .  ucwords($helper) . '.php';
        } else {
            exit('This helper doesn\'t exist');
        }

        return new $helper;
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
