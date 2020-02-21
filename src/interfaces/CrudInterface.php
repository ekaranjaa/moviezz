<?php

namespace App\Interfaces\CrudInterface;

interface CrudInterface
{
    public function create();

    public function read();

    public function update(string $slug);

    public function delete(string $slug);
}
