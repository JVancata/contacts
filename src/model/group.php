<?php

require_once 'base.php';

class GroupModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }
    /**
     * @param string $userId id of the user
     * @return integer ID of the inserted group
     */
    public function createGroupForUser($userId, $groupName, $textColor, $backgroundColor) {
        $query = 'INSERT INTO groups (user_id, name, text_color, background_color) VALUES (:user_id, :group_name, :text_color, :background_color)';
        $parameters = array(":user_id" => $userId, ":group_name" => $groupName, ":text_color" => $textColor, ":background_color" => $backgroundColor);
        $id = self::$database->insert($query, $parameters);

        return $id;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of contact
     * @param string $groupId id of group
     * @return integer result of the DB query
     */
    public function assignGroupToContact($contactId, $groupId) {
        $query = 'INSERT INTO contact_groups (contact_id, group_id) VALUES (:contact_id, :group_id)';
        $parameters = array(":contact_id" => $contactId, ":group_id" => $groupId);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * @param string $userId id of the user
     * @param string $groupId id of the group
     * @return Group
     */
    public function getOneGroupForUser($userId, $groupId) {
        $query = 'SELECT id, name, text_color, background_color FROM groups WHERE user_id = :user_id AND id = :group_id';
        $parameters = array(":user_id" => $userId, ":group_id" => $groupId);
        $result = self::$database->fetchOne($query, $parameters);

        return $result;
    }

    /**
     * @param string $userId id of the user
     * @return Group[]
     */
    public function getGroupsForUser($userId) {
        $query = 'SELECT id, name, text_color, background_color FROM groups WHERE user_id = :user_id';
        $parameters = array(":user_id" => $userId);
        $result = self::$database->fetchAll($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of the contact
     * @return Contact[]
     */
    public function getGroupsForContact($contactId) {
        $query = 'SELECT groups.id, groups.name, groups.text_color, groups.background_color FROM groups 
        INNER JOIN contact_groups ON contact_groups.group_id = groups.id
        WHERE contact_groups.contact_id = :contact_id';
        $parameters = array(":contact_id" => $contactId);
        $result = self::$database->fetchAll($query, $parameters);

        return $result;
    }
}
