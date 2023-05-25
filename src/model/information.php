<?php

require_once 'base.php';

class InformationModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }
    /**
     * @param string $userId id of the user
     * @return integer ID of the inserted group
     */
    public function insertInformationForContact($contactId, $typeId, $value) {
        $query = 'INSERT INTO contact_information (contact_id, type_id, value) VALUES (:contact_id, :type_id, :value)';
        $parameters = array(":contact_id" => $contactId, ":type_id" => $typeId, ":value" => $value);
        $id = self::$database->insert($query, $parameters);

        return $id;
    }

    /**
     * @param string $userId id of the user
     * @return Information[]
     */
    public function getInformationForContact($contactId) {
        $query = 'SELECT contact_information.id, contact_information.value, information_types.name, information_types.icon_class_name FROM contact_information
        INNER JOIN information_types ON contact_information.type_id = information_types.id
        WHERE contact_information.contact_id = :contact_id
        ';
        $parameters = array(":contact_id" => $contactId);
        $id = self::$database->fetchAll($query, $parameters);

        return $id;
    }

    /**
     * @param string $userId id of the user
     * @return Information[]
     */
    public function deleteInformationFromContact($contactId, $informationId) {
        $query = 'DELETE FROM contact_information WHERE contact_id = :contact_id AND id = :information_id';
        $parameters = array(":contact_id" => $contactId, ":information_id" => $informationId);
        $id = self::$database->insert($query, $parameters);

        return $id;
    }

    /**
     * @return InformationType[]
     */
    public function getInformationTypes() {
        $query = 'SELECT id, name, icon_class_name FROM information_types';
        $parameters = array();
        $result = self::$database->fetchAll($query, $parameters);

        return $result;
    }
}
