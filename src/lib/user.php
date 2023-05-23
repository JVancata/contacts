<?php

class User {
    public $id;
    public $username;
    public $email;
    public $loginExpiration;
    private $sessionToken;

    public function __construct($id, $username, $email, $loginExpiration, $sessionToken) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->loginExpiration = $loginExpiration;
        $this->sessionToken = $sessionToken;
    }

    public function isAuthenticated() {
        if ($this->loginExpiration < time()) {
            return false;
        }

        if ($this->sessionToken !== SESSIONTOKEN) {
            return false;
        }

        return true;
    }
}
