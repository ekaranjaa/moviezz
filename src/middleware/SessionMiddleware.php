<?php

class SessionMiddleware extends Middleware
{
    public function __construct()
    {
        if (empty($_SESSION['user']) && empty($_COOKIE['user'])) {
            $fb = false;
        } else {
            $fb = true;
        }

        return $fb;
    }
}
