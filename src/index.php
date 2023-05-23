<?php


require_once 'db.php';

$db = new Db();

print_r($db->getAllContacts());
