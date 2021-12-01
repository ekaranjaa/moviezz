<?php

class Database
{
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct(array $dbconfig)
    {
        $this->host = $dbconfig['host'];
        $this->username = $dbconfig['username'];
        $this->password = $dbconfig['password'];
        $this->database = $dbconfig['database'];
    }

    public function connect()
    {
        $sql = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($sql->error) {
            exit('There was an error connecting to the database: ' . $sql->errno . ': ' . $sql->error);
        }

        return $sql;
    }
}
