<?php

require_once 'base.php';

class UserModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }
    /**
     * @param string $username username or email
     * @param string $password plaintext password
     * @return User|null 
     */
    public function loginUser($username, $password) {
        $query = 'SELECT id,username, email FROM users WHERE username = :username OR email = :username';
        $parameters = array(":username" => $username);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }
}
