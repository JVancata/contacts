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
        $query = 'SELECT contacts.id, contacts.first_name, contacts.last_name, contacts.nickname, contacts.birth_date, contacts.created_at, contacts.profile_photo, photos.path AS profile_photo_path FROM contacts 
        LEFT JOIN photos ON photos.id = contacts.profile_photo
        WHERE contacts.user_id = :user_id AND contacts.id = :contact_id';
        $parameters = array(":user_id" => $userId, ":contact_id" => $contactId);
        $result = self::$database->fetchOne($query, $parameters);

        return $result;   
    }
    
    /**
     * @param string $userId id of the user
     * @param string $contactId id of the contact
     * @return Contact[]
     */
    public function deleteContactFromUser($userId, $contactId) {
        $query = 'DELETE FROM contacts 
        WHERE user_id = :user_id AND id = :contact_id';
        $parameters = array(":user_id" => $userId, ":contact_id" => $contactId);
        $result = self::$database->execute($query, $parameters);

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

    /**
     * @param int $userId ID of the contact owner
     * @param int $userId ID of the contact
     * @param int $firstName
     * @param int $lastName
     * @param int $nickname
     * @param string $birthDate YYYY-MM-DD 
     * @return int result
     */
    public function updateContactForUser($userId, $contactId, $firstName, $lastName, $nickname, $birthDate) {
        $query = 'UPDATE contacts SET first_name = :first_name, last_name = :last_name, nickname = :nickname, birth_date = :birth_date WHERE user_id = :user_id AND id = :contact_id';
        $parameters = array(":user_id" => $userId, ":contact_id" => $contactId, ":first_name" => $firstName, ":last_name" => $lastName, ":nickname" => $nickname, ":birth_date" => $birthDate);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the photo belongs to the contact
     * @param int $contactId ID of the contact
     * @param int $photoId ID of the photo
     * @return int result
     */
    public function updateContactProfilePhoto($contactId, $photoId) {
        $query = 'UPDATE contacts SET profile_photo = :photo_id WHERE id = :contact_id';
        $parameters = array(":contact_id" => $contactId, ":photo_id" => $photoId);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }
}
