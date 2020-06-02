<?php

class Search extends Model
{
    public function read(string $param, int $user_id = null)
    {
        $param = $this->filter(strtolower($param));
        $param = '%' . $param . '%';

        if (!empty($user_id)) {
            $query = "SELECT * FROM `movies` WHERE (`name` LIKE '$param') OR (`slug` LIKE '$param') OR (`genre` LIKE '$param') AND (`user_id`='$user_id')";
        } else {
            $query = "SELECT * FROM `movies` WHERE (`name` LIKE '$param') OR (`slug` LIKE '$param') OR (`genre` LIKE '$param')";
        }

        if ($this->sql()->query($query)) {
            $fb = $this->sql()->query($query);
        } else {
            error_log($this->sql()->errno . ': ' . $this->sql()->error, 3, __DIR__ . '/../logs/errors.log');
        }

        return $fb;
    }
}
