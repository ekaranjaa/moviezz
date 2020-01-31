<?php

class Movie extends Model
{
    public function create(array $movie)
    {
        $cover_image = $movie['cover_image'];
        $name = $movie['name'];
        $genre = $movie['genre'];
        $price = $movie['price'];

        $query = "INSERT INTO `movies`(`cover_image`,`name`,`genre`,`price`) VALUES('$cover_image','$name','$genre','$price')";

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
        $name = $movie['name'];

        $query = "SELECT * FROM `movies` WHERE `id`='$id' OR `name`='$name'";

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
        $genre = $movie['genre'];
        $price = $movie['price'];

        $query = "UPDATE `movies` SET `cover_image`='$cover_image',`name`='$name',`genre`='$genre',`price`='$price' WHERE `id`='$id'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/error.log');
        }

        return $fb;
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM `movies` WHERE `id`='$id'";

        if ($this->sql()->query($query)) {
            $fb = true;
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error);
        }

        return $fb;
    }
}
