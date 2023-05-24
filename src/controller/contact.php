<?php

require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();
$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;
userGuard();

if ($action === "add") {
    $isOk = true;

    // Contact must have either a nickname or first + last name
    $hasIdentifyingName = false;

    if (!empty($_POST["nickname"])) {
        $hasIdentifyingName = true;
    }

    if (!empty($_POST["first_name"]) && !empty($_POST["last_name"])) {
        $hasIdentifyingName = true;
    }

    if ($hasIdentifyingName) {
        $result = $contactModel->createContactForUser($_SESSION["unserializedUser"]->id, $_POST["first_name"], $_POST["last_name"], $_POST["nickname"], $_POST["birth_date"]);

        if (!$result) {
            $error = "CONTACT_INSERT_ERROR";
            $isOk = false;
        } else {
            header('Location: /dashboard?message=CONTACT_INSERTED');
            exit();
        }
    }

    if (!$isOk) {
        header('Location: /dashboard?error=' . $error);
        exit();
    }
}

if ($action === "detail") {
    $isOk = true;
    $result = null;

    if (!is_numeric($_GET["parameter"])) {
        $isOk = false;
    }

    if ($isOk) {
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["parameter"]);

        if (empty($contact)) {
            $isOk = false;
        }
    }

    if (!$isOk) {
        header('Location: /404');
        exit();
    }

    require __DIR__ . '/../view/contact/detail.php';
}


$_SESSION["last_form"] = [];

exit();
