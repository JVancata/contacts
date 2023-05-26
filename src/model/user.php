<?php

require_once 'base.php';

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @param string $username username or email
     * @param string $password plaintext password
     * @return User|boolean 
     */
    public function loginUser($username, $password)
    {
        $query = 'SELECT id, username, email, password FROM users WHERE username = :username OR email = :username';
        $parameters = array(":username" => $username);
        $result = self::$database->fetchOne($query, $parameters);

        $hashFromDatabase = $result["password"];

        if (password_verify($password, $hashFromDatabase)) {
            $user = new User($result["id"], $result["username"], $result["email"], time() + 60 * 60 * 72, SESSIONTOKEN);
            return $user;
        }

        return false;
    }
    /**
     * @param string $username username
     * @param string $email email
     * @param string $password plaintext password
     * @return User|string contains either the user or error message
     */
    public function registerUser($username, $email, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $query = 'SELECT id, username, email, password FROM users WHERE username = :username OR email = :username';
        $parameters = array(":username" => $username);
        $result = self::$database->fetchOne($query, $parameters);

        if (!empty($result)) {
            return "LOGIN_ALREADY_EXISTS";
        }

        $query = 'INSERT INTO users (username, password, email) VALUES (:username, :password, :email)';
        $parameters = array(":username" => $username, ":password" => $passwordHash, ":email" => $email);
        $result = self::$database->execute($query, $parameters);

        if ($result) {
            $user = $this->loginUser($username, $password);
            return $user;
        } else {
            return "REGISTRATION_FAIL";
        }
    }

    /**
     * !!!Warning - This does not check anything!!! You could change any users password!
     * @param string $userId
     * @param string $newPassword new plaintext password
     * @return User|string contains either the user or error message
     */
    public function updateUsersPassword($userId, $newPassword)
    {
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

        $query = 'UPDATE users SET password = :password WHERE id = :user_id';
        $parameters = array(":user_id" => $userId, "password" => $passwordHash);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * @param string $email email
     * @return User|string contains either the user or error message
     */
    public function findUserByEmail($email)
    {
        $query = 'SELECT id, username, email, password FROM users WHERE email = :email';
        $parameters = array(":email" => $email);
        $result = self::$database->fetchOne($query, $parameters);

        return $result;
    }
}
