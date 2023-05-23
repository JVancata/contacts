<?php

class User {
    public $id;
    public $username;
    public $email;
    public $loginExpiration;

    public function __construct($id, $username, $email, $loginExpiration) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->loginExpiration = $loginExpiration;
    }

    public function isAuthenticated() {
        if ($this->loginExpiration < time()) {
            return false;
        }

        return true;
    }
}
