<?php

require_once 'base.php';

class NoteModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of contact
     * @param string $note note - must be already escaped
     * @param boolean $hidden hidden
     * @return integer result of the DB query
     */
    public function createNoteForContact($contactId, $note, $hidden) {
        $query = 'INSERT INTO contact_notes (contact_id, note, hidden) VALUES (:contact_id, :note, :hidden)';
        $parameters = array(":contact_id" => $contactId, ":note" => $note, ":hidden" => $hidden);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of contact
     * @param string $noteId id of note
     * @return integer result of the DB query
     */
    public function deleteNoteFromContact($contactId, $noteId) {
        $query = 'DELETE FROM contact_notes WHERE id = :note_id AND contact_id = :contact_id';
        $parameters = array(":note_id" => $noteId, ":contact_id" => $contactId);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of contact
     * @param string $noteId id of note
     * @return integer result of the DB query
     */
    public function hideNoteForContact($contactId, $noteId) {
        $query = 'UPDATE contact_notes SET hidden = 1 WHERE id = :note_id AND contact_id = :contact_id';
        $parameters = array(":note_id" => $noteId, ":contact_id" => $contactId);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * * @param string $contactId id of contact
     * @param string $noteId id of note
     * @return integer result of the DB query
     */
    public function unhideNoteForContact($contactId, $noteId) {
        $query = 'UPDATE contact_notes SET hidden = 0 WHERE id = :note_id AND contact_id = :contact_id';
        $parameters = array(":note_id" => $noteId, ":contact_id" => $contactId);
        $result = self::$database->execute($query, $parameters);

        return $result;
    }

    /**
     * Warning!!! This does not check that the user owns the contact!
     * @param string $contactId id of the contact
     * @return Note[]
     */
    public function getNotesForContact($contactId) {
        $query = 'SELECT id, note, hidden FROM contact_notes WHERE contact_id = :contact_id ORDER BY inserted_at DESC';
        $parameters = array(":contact_id" => $contactId);
        $result = self::$database->fetchAll($query, $parameters);

        return $result;
    }
}
