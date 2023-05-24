<?php

require_once 'base.php';

class ContactModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }
    /**
     * @param string $userId id of the user
     * @return Contact[]
     */
    public function getAllContactsForUser($userId) {
        $query = 'SELECT id, first_name, last_name, nickname, birth_date, created_at, profile_photo FROM contacts WHERE user_id = :user_id';
        $parameters = array(":user_id" => $userId);
        $result = self::$database->fetchAll($query, $parameters);

        return $result;
    }

    /**
     * @param string $userId id of the user
     * @param string $contactId id of the contact
     * @return Contact[]
     */
    public function getOneContactForUser($userId, $contactId) {
        $query = 'SELECT id, first_name, last_name, nickname, birth_date, created_at, profile_photo FROM contacts WHERE user_id = :user_id AND id = :contact_id';
        $parameters = array(":user_id" => $userId, ":contact_id" => $contactId);
        $result = self::$database->fetchOne($query, $parameters);

        return $result;
    }

    /**
     * @param int $userId ID of the contact owner
     * @param int $firstName
     * @param int $lastName
     * @param int $nickname
     * @param string $birthDate YYYY-MM-DD 
     * @return int result
     */
    public function createContactForUser($userId, $firstName, $lastName, $nickname, $birthDate) {
        $query = 'INSERT INTO contacts (user_id, first_name, last_name, nickname, birth_date) VALUES (:user_id, :first_name, :last_name, :nickname, :birth_date)';
        $parameters = array(":user_id" => $userId, ":first_name" => $firstName, ":last_name" => $lastName, ":nickname" => $nickname, ":birth_date" => $birthDate);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }
}
