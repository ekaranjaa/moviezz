<?php

namespace App\Interfaces\RouterInterface;

interface RouterInterface
{
    public function get(string $path, object $class = null);

    public function post(string $path, object $class = null);

    public function getObject(string $object);

    public function getParam(string $path);
}
