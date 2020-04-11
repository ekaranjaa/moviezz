<?php

class Movie extends Model
{
    public function create(array $movie)
    {
        $user_id = $this->filter($movie['user_id']);
        $thumbnail = $this->filter($movie['thumbnail']);
        $name = $this->filter($movie['name']);
        $slug = $this->filter($movie['slug']);
        $genre = $this->filter($movie['genre']);
        $price = $this->filter($movie['price']);
        $description = $this->filter($movie['description']);

        $query = "INSERT INTO `movies`(`user_id`,`thumbnail`,`name`,`slug`,`genre`,`price`,`description`) VALUES('$user_id','$thumbnail','$name','$slug','$genre','$price','$description')";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function read(array $movie)
    {
        $id = $this->filter($movie['id']);
        $user_id = $this->filter($movie['user_id']);
        $slug = $this->filter($movie['slug']);
        $genre = $this->filter($movie['genre']);

        if ($user_id > 0) {
            $query = "SELECT * FROM `movies` WHERE (`id`='$id') OR (`slug`='$slug') OR (`genre`='$genre') AND (`user_id`='$user_id')";
        } else {
            $query = "SELECT * FROM `movies` WHERE (`id`='$id') OR (`slug`='$slug') OR (`genre`='$genre')";
        }

        if ($this->sql()->query($query)) {
            $fb = $this->sql()->query($query);
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function update(array $movie)
    {
        $id = $this->filter($movie['id']);
        $thumbnail = $this->filter($movie['thumbnail']);
        $name = $this->filter($movie['name']);
        $slug = $this->filter($movie['slug']);
        $genre = $this->filter($movie['genre']);
        $price = $this->filter($movie['price']);
        $description = $this->filter($movie['description']);

        $query = "UPDATE `movies` SET `thumbnail`='$thumbnail',`name`='$name',`slug`='$slug',`genre`='$genre',`price`='$price', `description`='$description' WHERE `id`='$id'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function delete(string $slug)
    {
        $slug = $this->filter($slug);

        $query = "DELETE FROM `movies` WHERE `slug`='$slug'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error);
        }

        return $fb;
    }
}
