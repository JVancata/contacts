<?php

require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();

require_once __DIR__ . "/../model/group.php";
$groupModel = new GroupModel();

$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;
userGuard();

if ($action === "add") {
    $isOk = true;

    if (empty($_POST["name"]) || empty(trim($_POST["name"]))) {
        $error = "EMPTY_NAME";
        $isOk = false;
    }
    // https://stackoverflow.com/questions/1636350/how-to-identify-a-given-string-is-hex-color-format
    if (empty($_POST["backgroundColor"]) || !preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $_POST["backgroundColor"])) {
        $error = "INVALID_BG_COLOR";
        $isOk = false;
    }
    if (empty($_POST["textColor"])) {
        $error = "EMPTY_TEXT_COLOR";
        $isOk = false;
    }

    /*if (!is_numeric($_POST["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }*/

    // No error detected
    if ($isOk) {
        // Insert the group
        $textColor = $_POST["textColor"] === "white" ? "#FFFFFF" : "#000000";
        $groupId = $groupModel->createGroupForUser($_SESSION["unserializedUser"]->id, htmlspecialchars($_POST["name"]), $textColor, $_POST["backgroundColor"]);

        // If the form has contact ID, we have to assign it as well
        if (is_numeric($_POST["contactId"])) {
            // Check if the contact belongs to the user
            $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_POST["contactId"]);
            if (!empty($contact)) {
                // then assign the contact to the new group
                $groupModel->assignGroupToContact($contact["id"], $groupId);
                header('Location: /contact/detail/' . $contact["id"]);
                exit();
            }
        }
    }

    if (!$isOk) {
        $_SESSION["last_form"] = $_POST;
        header('Location: /dashboard?error=' . $error);
        exit();
    }

    header('Location: /dashboard');
    exit();
}

if ($action === "assign") {
    $isOk = true;

    if (!is_numeric($_POST["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }

    if (!is_numeric($_POST["groupId"])) {
        $error = "INVALID_GROUP_ID";
        $isOk = false;
    }

    // No error detected
    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_POST["contactId"]);
        if (!empty($contact)) {
            // Check if the group belongs to the user
            $group = $groupModel->getOneGroupForUser($_SESSION["unserializedUser"]->id, $_POST["groupId"]);

            // Then assign the group
            if (!empty($group)) {
                $groupModel->assignGroupToContact($contact["id"], $group["id"]);
                header('Location: /contact/detail/' . $contact["id"]);
                exit();
            }
        }
    }

    if (!$isOk) {
        $_SESSION["last_form"] = $_POST;
        header('Location: /dashboard?error=' . $error);
        exit();
    }

    header('Location: /dashboard');
    exit();
}

if ($action === "unassign") {
    $isOk = true;

    if (!is_numeric($_GET["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }

    if (!is_numeric($_GET["groupId"])) {
        $error = "INVALID_GROUP_ID";
        $isOk = false;
    }

    // No error detected
    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["contactId"]);
        if (!empty($contact)) {
            // Check if the group belongs to the user
            $group = $groupModel->getOneGroupForUser($_SESSION["unserializedUser"]->id, $_GET["groupId"]);

            // Then unassign the group
            if (!empty($group)) {
                $groupModel->unassignGroupFromContact($contact["id"], $group["id"]);
                header('Location: /contact/detail/' . $contact["id"]);
                exit();
            }
        }
    }

    if (!$isOk) {
        $_SESSION["last_form"] = $_POST;
        header('Location: /dashboard?error=' . $error);
        exit();
    }

    header('Location: /dashboard');
    exit();
}

$_SESSION["last_form"] = [];
exit();
