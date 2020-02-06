<?php

class Movie extends Model
{
    public function create(array $movie)
    {
        $cover_image = $movie['cover_image'];
        $name = $movie['name'];
        $slug = $movie['slug'];
        $genre = $movie['genre'];
        $price = $movie['price'];

        $query = "INSERT INTO `movies`(`cover_image`,`name`,`slug`,`genre`,`price`) VALUES('$cover_image','$name','$slug','$genre','$price')";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
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
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
        }

        return $fb;
    }

    public function edit(array $movie)
    {
        $id = $movie['id'];
        $cover_image = $movie['cover_image'];
        $name = $movie['name'];
        $slug = $movie['slug'];
        $genre = $movie['genre'];
        $price = $movie['price'];

        $query = "UPDATE `movies` SET `cover_image`='$cover_image',`name`='$name',`slug`='$slug',`genre`='$genre',`price`='$price' WHERE `id`='$id'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
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
