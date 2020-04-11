<?php

class User extends Model
{
    public function create(array $user)
    {
        $avatar = $this->filter($user['avatar']);
        $name = $this->filter($user['name']);
        $email = $this->filter($user['email']);
        $username = $this->filter($user['username']);
        $password = password_hash($this->filter($user['password']), PASSWORD_BCRYPT);

        $query = "INSERT INTO `users`(`avatar`,`name`,`email`,`username`,`password`) VALUES('$avatar','$name','$email','$username','$password')";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function read(array $user)
    {
        $id = $this->filter($user['id']);
        $email = $this->filter($user['email']);
        $username = $this->filter($user['username']);

        $query = "SELECT * FROM `users` WHERE (`id`='$id') OR (`email`='$email') OR (`username`='$username')";

        if ($this->sql()->query($query)) {
            $fb = $this->sql()->query($query);
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function update(array $user)
    {
        $id = $this->filter($user['id']);
        $avatar = $this->filter($user['avatar']);
        $name = $this->filter($user['name']);
        $email = $this->filter($user['email']);
        $username = $this->filter($user['username']);
        $password = password_hash($this->filter($user['password']), PASSWORD_BCRYPT);

        $query = "UPDATE `users` SET `avatar`='$avatar', `name`='$name',`email`='$email',`username`='$username',`password`='$password' WHERE (`id`='$id') OR (`email`='$email') OR (`username`='$username')";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function delete(string $username)
    {
        $username = $this->filter($username);

        $query = "DELETE FROM `users` WHERE `username`='$username'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }
}
