<?php

use App\Interfaces\RouterInterface\RouterInterface;

class Router implements RouterInterface
{
    private $uri;
    private $object;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function get(string $path, string $object = null, $callback = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $fb = $this->action($path, $object, $callback);
        }

        return $fb;
    }

    public function post(string $path, string $object = null, $callback = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fb = $this->action($path, $object, $callback);
        }

        return $fb;
    }

    public function action(string $path, string $object = null, $callback = null)
    {
        if ($path === $this->uri) {
            if (!empty($object)) {
                $this->object = $object;
                $param = $this->getParam($path);

                if (!empty($param)) {
                    $fb = $this->getObject($this->object)($param);
                } else {
                    $this->getObject($this->object);
                }
            } else if (!empty($callback)) {
                $callback();
            }
        }

        return $fb;
    }

    public function getObject(string $object)
    {
        $object = explode('@', $object);
        $class = $object[0];
        $method = $object[1];

        if (class_exists($class)) {
            if (method_exists($class, $method)) {
                $instance = new $class;
                $fb = $instance::$method;
            }
        }

        return $fb;
    }

    public function getParam(string $path)
    {
        $regex = '/{(.*?)}/';

        if (preg_match($regex, $path, $match)) {
            if (!empty($match)) {
                $fb = $match;
            }
        }

        return $fb;
    }
}
