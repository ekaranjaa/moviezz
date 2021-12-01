<?php

class Model
{
    protected function sql()
    {
        require_once __DIR__ . '/../config/Database.php';

        $sql = new Database([
            'host' => 'localhost',
            'username' => 'homestead',
            'password' => 'secret',
            'database' => 'moviezz'
        ]);

        return $sql->connect();
    }

    public function filter($value = '')
    {
        return $this->sql()->real_escape_string(htmlspecialchars($value));
    }
}
