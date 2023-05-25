<?php

require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();

require_once __DIR__ . "/../model/group.php";
$groupModel = new GroupModel();

require_once __DIR__ . "/../model/note.php";
$noteModel = new NoteModel();

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

    if (!$hasIdentifyingName) {
        $isOk = false;
        $error = "NO_IDENTIFYING_NAME";
    }

    if (!empty($_POST["birth_date"])) {
        $timestamp = strtotime($_POST["birth_date"]);
        if ($_POST["birth_date"] !== date("Y-m-d", $timestamp)) {
            $isOk = false;
            $error = "INVALID_BIRTH_DATE";
        }
    }
    //
    else {
        $_POST["birth_date"] = null;
    }

    if ($isOk) {
        $result = $contactModel->createContactForUser($_SESSION["unserializedUser"]->id, htmlspecialchars($_POST["first_name"]), htmlspecialchars($_POST["last_name"]), htmlspecialchars($_POST["nickname"]), $_POST["birth_date"]);

        if (!$result) {
            $error = "CONTACT_INSERT_ERROR";
            $isOk = false;
        }
        //
        else {
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
        // Otherwise load the data
        else {
            $contactGroups = $groupModel->getGroupsForContact($contact["id"]);
            $allGroups = $groupModel->getGroupsForUser($_SESSION["unserializedUser"]->id);

            $notes = $noteModel->getNotesForContact($contact["id"]);
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
