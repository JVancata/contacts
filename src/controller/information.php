<?php

require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();

require_once __DIR__ . "/../model/information.php";
$informationModel = new InformationModel();

$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;
userGuard();

if ($action === "add") {
    $isOk = true;

    if (empty($_POST["value"]) || empty(trim($_POST["value"]))) {
        $error = "EMPTY_VALUE";
        $isOk = false;
    }

    if (!is_numeric($_POST["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
        header('Location: /dashboard');
        exit();
    }

    if (!is_numeric($_POST["informationTypeId"])) {
        $error = "INVALID_INFORMATION_TYPE_ID";
        $isOk = false;
    }

    // No error detected
    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_POST["contactId"]);
        if (!empty($contact)) {
            $informationModel->insertInformationForContact($contact["id"], $_POST["informationTypeId"], trim(htmlspecialchars($_POST["value"])));
            header('Location: /contact/detail/' . $contact["id"]);
            exit();
        }
    }

    if (!$isOk) {
        $_SESSION["last_form"] = $_POST;
        header('Location: /contact/detail/' . $_POST["contactId"]);
        exit();
    }

    header('Location: /dashboard');
    exit();
}
if ($action === "delete") {
    $isOk = true;

    if (!is_numeric($_GET["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
        header('Location: /dashboard');
        exit();
    }

    if (!is_numeric($_GET["informationId"])) {
        $error = "INVALID_INFORMATION_ID";
        $isOk = false;
    }

    // No error detected
    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["contactId"]);
        if (!empty($contact)) {
            $informationModel->deleteInformationFromContact($contact["id"], $_GET["informationId"]);
            header('Location: /contact/detail/' . $contact["id"]);
            exit();
        }
    }

    if (!$isOk) {
        header('Location: /contact/detail/' . $_GET["contactId"]);
        exit();
    }

    header('Location: /dashboard');
    exit();
}

$_SESSION["last_form"] = [];
exit();
