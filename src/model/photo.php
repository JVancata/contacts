<?php

require_once 'base.php';

class PhotoModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }
    /**
     * * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of the contact
     * @param string $path path of the img
     * @return integer result
     */
    public function insertPhotoForContact($contactId, $path) {
        $query = 'INSERT INTO photos (contact_id, path) VALUES (:contact_id, :path)';
        $parameters = array(":contact_id" => $contactId, ":path" => $path);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }
    /**
     * * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of the contact
     * @param string $photoId id of the contact
     * @return integer result
     */
    public function deletePhotoFromContact($contactId, $photoId) {
        $query = 'DELETE FROM photos WHERE contact_id = :contact_id AND id = :photo_id';
        $parameters = array(":contact_id" => $contactId, ":photo_id" => $photoId);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of the contact
     * @return Contact[]
     */
    public function getPhotosForContact($contactId) {
        $query = 'SELECT id, path FROM photos WHERE contact_id = :contact_id';
        $parameters = array(":contact_id" => $contactId);
        $result = self::$database->fetchAll($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of the contact
     * @param string $contactId id of the photo
     * @return Contact[]
     */
    public function getPhotoForContact($contactId, $photoId) {
        $query = 'SELECT id, path FROM photos WHERE contact_id = :contact_id AND id = :photo_id';
        $parameters = array(":contact_id" => $contactId, ":photo_id" => $photoId);
        $result = self::$database->fetchOne($query, $parameters);

        return $result;
    }
}
