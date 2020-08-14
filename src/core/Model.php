<?php

class Model
{
    protected function sql()
    {
        require_once __DIR__ . '/../config/Db.php';

        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $sql = new Db([
            'host' => $url["host"],
            'username' => $url["user"],
            'password' => $url["pass"],
            'database' => substr($url["path"], 1)
        ]);

        return $sql->connect();
    }

    public function filter($value = '')
    {
        return $this->sql()->real_escape_string(htmlspecialchars($value));
    }
}
