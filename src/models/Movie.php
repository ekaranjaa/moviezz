<?php

class Movie extends Model
{
    public function create(array $movie)
    {
        $user_id = $movie['user_id'];
        $cover_image = $movie['cover_image'];
        $name = $movie['name'];
        $slug = $movie['slug'];
        $type = $movie['type'];
        $price = $movie['price'];
        $description = $movie['description'];

        $query = "INSERT INTO `movies`(`user_id`,`cover_image`,`name`,`slug`,`type`,`price`,`description`) VALUES('$user_id','$cover_image','$name','$slug','$type','$price','$description')";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function read(array $movie)
    {
        $id = $movie['id'];
        $slug = $movie['slug'];

        $query = "SELECT * FROM `movies` WHERE `id`='$id' OR `slug`='$slug'";

        if ($this->sql()->query($query)) {
            $fb = $this->sql()->query($query);
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function edit(array $movie)
    {
        $id = $movie['id'];
        $cover_image = $movie['cover_image'];
        $name = $movie['name'];
        $slug = $movie['slug'];
        $type = $movie['type'];
        $price = $movie['price'];
        $description = $movie['description'];

        $query = "UPDATE `movies` SET `cover_image`='$cover_image',`name`='$name',`slug`='$slug',`type`='$type',`price`='$price', `description`='$description' WHERE `id`='$id'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }

    public function delete(string $slug)
    {
        $query = "DELETE FROM `movies` WHERE `slug`='$slug'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error);
        }

        return $fb;
    }
}
