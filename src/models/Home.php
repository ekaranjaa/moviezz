<?php

class Home extends Model
{
    public function read()
    {
        $query = "SELECT * FROM `movies` ORDER BY `created_at` DESC";

        if ($this->sql()->query($query)) {
            $fb = $this->sql()->query($query);
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error);
        }

        return $fb;
    }
}
