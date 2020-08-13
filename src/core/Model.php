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
            'database' => 'moviezz'
        ]);

        return $sql->connect();
    }

    public function filter($value = '')
    {
        return $this->sql()->real_escape_string(htmlspecialchars($value));
    }
}
