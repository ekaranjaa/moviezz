<?php

class User extends Model
{
    public function create(array $user)
    {
        $avatar = $user['avatar'];
        $name = $user['name'];
        $slug = $user['slug'];
        $email = $user['email'];
        $username = $user['username'];
        $password = password_hash($user['password'], PASSWORD_BCRYPT);

        $query = "INSERT INTO `users`(`avatar`,`name`,`slug`,`email`,`username`,`password`) VALUES('$avatar','$name','$slug','$email','$username','$password')";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
        }

        return $fb;
    }

    public function read(array $user)
    {
        $id = $user['id'];
        $slug = $user['slug'];
        $email = $user['email'];
        $username = $user['username'];

        $query = "SELECT * FROM `users` WHERE `id`='$id' OR `email`='$email' OR `username`='$username' OR `slug`='$slug'";

        if ($this->sql()->query($query)) {
            $fb = $this->sql()->query($query);
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
        }

        return $fb;
    }

    public function edit(array $user)
    {
        $id = $user['id'];
        $avatar = $user['avatar'];
        $name = $user['name'];
        $slug = $user['slug'];
        $email = $user['email'];
        $username = $user['username'];
        $password = password_hash($user['password'], PASSWORD_BCRYPT);

        $query = "UPDATE `users` SET `avatar`='$avatar', `name`='$name',`slug`='$slug',`email`='$email',`username`='$username',`password`='$password' WHERE `id`='$id' OR `email`='$email' OR `username`='$username' OR `slug`='$slug'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
        }

        return $fb;
    }

    public function delete(string $slug)
    {
        $query = "DELETE FROM `users` WHERE `slug`='$slug'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
        }

        return $fb;
    }
}
