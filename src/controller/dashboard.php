<?php

require_once __DIR__ . "/../model/user.php";
$userModel = new UserModel();
require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();
$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;

userGuard();

$contacts = $contactModel->getAllContactsForUser($_SESSION["unserializedUser"]->id);

require __DIR__ . '/../view/dashboard/dashboard.php';

$_SESSION["last_form"] = [];

exit();
