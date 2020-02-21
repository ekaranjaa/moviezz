<?php

namespace App\Interfaces\RouterInterface;

interface RouterInterface
{
    public function get(string $path, string $object = null, object $callback);

    public function post(string $path, string $object = null, object $callback);

    public function getObject(string $object);

    public function getParam(string $path);
}
