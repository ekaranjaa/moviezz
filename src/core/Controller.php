<?php

class Controller
{
    public function userSession()
    {
        $fb = $this->helper('session');

        return $fb->validate();
    }

    protected function model(string $model)
    {
        $model = ucfirst($model);

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

    protected function helper(string $helper, string $destination = '')
    {
        $helper = ucfirst($helper) . 'Helper';

        if (file_exists(__DIR__ . '/../helpers/' . $helper . '.php')) {
            require_once __DIR__ . '/../helpers/' .  $helper . '.php';

            if (class_exists($helper)) {
                $fb = new $helper($destination);
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
