<?php

require_once 'base.php';

class PasswordModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @param string $userId id of the user
     * @return integer inserted id
     */
    public function insertRandomTokenForUser($userId)
    {
        $token = bin2hex(random_bytes(16));
        $expireAt = date("Y-m-d H:i:s", time() + 60 * 10);

        $query = 'INSERT INTO password_reset_tokens (users_id, token, expiration) VALUES (:user_id, :token, :expiration)';
        $parameters = array(":user_id" => $userId, ":token" => $token, ":expiration" => $expireAt);
        self::$database->execute($query, $parameters);
        return $token;
    }

    /**
     * @param string $token password reset token
     * @return int user_id
     */
    public function selectUserIdByValidToken($token)
    {
        $query = 'SELECT users.id AS user_id FROM password_reset_tokens
        INNER JOIN users ON users.id = password_reset_tokens.users_id
        WHERE password_reset_tokens.token = :token AND NOW() < password_reset_tokens.expiration';

        $parameters = array(":token" => $token);
        $result = self::$database->fetchOne($query, $parameters);

        return $result;
    }
}
