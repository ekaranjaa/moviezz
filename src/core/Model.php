<?php

class Model
{
    protected function sql()
    {
        require_once __DIR__ . '/../config/Db.php';

        $sql = new Db([
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'password',
            'database' => 'moviezzz'
        ]);

        return $sql->connect();
    }
}
