<?php

class Model
{
    protected function sql()
    {
        require_once __DIR__ . '/../config/db.php';

        $sql = new Db([
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'password',
            'database' => 'loginsys'
        ]);

        return $sql->connect();
    }
}
