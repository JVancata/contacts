<?php

require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();

require_once __DIR__ . "/../model/group.php";
$groupModel = new GroupModel();

require_once __DIR__ . "/../model/note.php";
$noteModel = new NoteModel();

require_once __DIR__ . "/../model/photo.php";
$photoModel = new PhotoModel();

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
//
else if ($action === "edit") {
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

    if (!is_numeric($_POST["contactId"])) {
        $isOk = false;
        $error = "INVALID_CONTACT_ID";
    }

    if ($isOk) {
        $result = $contactModel->updateContactForUser($_SESSION["unserializedUser"]->id, $_POST["contactId"], htmlspecialchars($_POST["first_name"]), htmlspecialchars($_POST["last_name"]), htmlspecialchars($_POST["nickname"]), $_POST["birth_date"]);

        if (!$result) {
            $error = "CONTACT_UPDATE_ERROR";
            $isOk = false;
        }
        //
        else {
            header('Location: /contact/detail/' . $_POST["contactId"] . '?message=CONTACT_UPDATED');
            exit();
        }
    }

    if (!$isOk) {
        header('Location: /dashboard?error=' . $error);
        exit();
    }
}
//
else if ($action === "profilephoto") {
    $isOk = true;

    if (!is_numeric($_GET["contactId"])) {
        $isOk = false;
        $error = "INVALID_CONTACT_ID";
    }

    if (!is_numeric($_GET["photoId"])) {
        $isOk = false;
        $error = "INVALID_PHOTO_ID";
    }

    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["contactId"]);

        if (!empty($contact)) {
            // Check if the picture belongs to the contact
            $photo = $photoModel->getPhotoForContact($contact["id"], $_GET["photoId"]);

            if (!empty($photo)) {
                $contactModel->updateContactProfilePhoto($contact["id"], $photo["id"]);
            }
            //
            else {
                $error = "INVALID_PHOTO";
                $isOk = false;
            }
        }
        //
        else {
            $error = "INVALID_CONTACT";
            $isOk = false;
        }
    }

    if (!$isOk) {
        header('Location: /dashboard?error=' . $error);
        exit();
    }

    header('Location: /contact/detail/' . $_GET["contactId"] . '?message=PHOTO_UPDATED');
    exit();
}
//
else if ($action === "detail") {
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

            $photos = $photoModel->getPhotosForContact($contact["id"]);
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
