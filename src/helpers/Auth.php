<?php

class Auth
{
    public $fb;

    public function fields(array $fields)
    {
        foreach ($fields as $field => $value) {
            if (isset($field) && !empty($value)) {
                $fb = true;
            } else {
                $fb = false;
                $this->fb = 'Make sure you\'ve filled in all the fields';
            }
        }

        return $fb;
    }

    public function email(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fb = true;
        } else {
            $fb = false;
            $this->fb = 'Invalid email address';
        }

        return $fb;
    }

    public function password(array $password)
    {
        if (strlen($password[0]) > 6) {
            if ($password[0] === $password[1]) {
                $fb = true;
            } else {
                $fb = false;
                $this->fb = 'Make sure both passwords match';
            }
        } else {
            $this->fb = 'Password must be a minimum of 6 characters';
        }

        return $fb;
    }
}
