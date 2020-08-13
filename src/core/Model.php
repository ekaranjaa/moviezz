<?php

class Model
{
    protected function sql()
    {
        require_once __DIR__ . '/../config/Db.php';

        $sql = new Db([
            'host' => 'ec2-54-224-124-241.compute-1.amazonaws.com',
            'username' => 'chgrosxndsqoej',
            'password' => 'dd5192c18c396a6a5388a67ec26a3bd1aaecdce381402662d9ebfecbf325de5f',
            'database' => 'd92ppr0v3rsujh'
        ]);

        return $sql->connect();
    }

    public function filter($value = '')
    {
        return $this->sql()->real_escape_string(htmlspecialchars($value));
    }
}
