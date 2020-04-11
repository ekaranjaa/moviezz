<?php

class Home extends Model
{
    public function read(int $user_id)
    {
        $user_id = $this->filter($user_id);

        if ($user_id > 0) {
            $query = "SELECT * FROM `movies` WHERE `user_id`='$user_id' ORDER BY `created_at` DESC";
        } else {
            $query = "SELECT * FROM `movies` ORDER BY `created_at` DESC";
        }

        if ($this->sql()->query($query)) {
            $fb = $this->sql()->query($query);
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error);
        }

        return $fb;
    }
}
