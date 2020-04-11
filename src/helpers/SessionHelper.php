<?php

class SessionHelper extends Helper
{
    public function validate()
    {
        if (empty($_SESSION['user']) && empty($_COOKIE['user'])) {
            $fb = false;
        } else {
            $fb = true;
        }

        return $fb;
    }
}
