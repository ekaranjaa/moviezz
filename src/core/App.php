<?php

class App
{
    private $controller = 'home';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $url = $this->getUri();

        if (!empty($url[0])) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        $this->controller = ucfirst($this->controller) . 'Controller';

        if (file_exists(__DIR__ . '/../controllers/' . $this->controller . '.php')) {
            require_once __DIR__ . '/../controllers/' . $this->controller . '.php';

            if (class_exists($this->controller)) {
                if (!empty($url[1])) {
                    if (method_exists($this->controller, $url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    } else {
                        exit('Invalid method ' . $this->method);
                    }
                }

                $this->controller = new $this->controller;

                $this->params = array_values($url);

                call_user_func_array([$this->controller, $this->method], $this->params);
            } else {
                exit('Class ' . $this->controller . ' doesn\'t exist');
            }
        } else {
            exit($this->controller . ' doesn\'t exist.');
        }
    }


    /**
     * Get the URI passed by the user
     */
    public function getUri()
    {

        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        // Remove GET params from the URL
        if (($strpos = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $strpos);
        }

        // Remove first slash
        $url = substr($url, 1);
        $url = explode('/', $url);

        return $url;
    }
}
