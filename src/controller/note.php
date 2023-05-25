<?php

require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();

require_once __DIR__ . "/../model/note.php";
$noteModel = new NoteModel();

$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;
userGuard();

if ($action === "insert") {
    $isOk = true;

    if (empty($_POST["note"]) || empty(trim($_POST["note"]))) {
        $error = "EMPTY_NOTE";
        $isOk = false;
    }

    $allowedHiddenValues = array("true", "false");
    if (empty($_POST["hidden"]) || !in_array($_POST["hidden"], $allowedHiddenValues)) {
        $error = "INVALID_HIDDEN";
        $isOk = false;
    }

    if (!is_numeric($_POST["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }


    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_POST["contactId"]);
        if (!empty($contact)) {
            // Insert the note
            $note = htmlspecialchars($_POST["note"]);
            $note = trim($note);
            $note = str_replace("\n", "<br>", $note);

            $hidden = $_POST["hidden"] === "true" ? 1 : 0;

            $result = $noteModel->createNoteForContact($contact["id"], $note, $hidden);
        }

        if (!$result) {
            $error = "NOTE_INSERT_ERROR";
            $isOk = false;
        }
    }

    // Redirect if everything was ok
    if ($isOk) {
        header('Location: /contact/detail/' . $contact["id"]);
        exit();
    }
    // Redirect if any error occured but the contact was found
    else if (!empty($contact)) {
        header('Location: /contact/detail/' . $contact["id"] . '?error=' . $error);
        exit();
    }
    // If there was another failure
    else {
        header('Location: /contact/detail/' . $_POST["contactId"]);
        exit();
    }
}
//
else if ($action === "edit") {
    $isOk = true;

    if (empty($_POST["note"]) || empty(trim($_POST["note"]))) {
        $error = "EMPTY_NOTE";
        $isOk = false;
    }

    if (!is_numeric($_POST["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }
    
    if (!is_numeric($_POST["noteId"])) {
        $error = "INVALID_NOTE_ID";
        $isOk = false;
    }

    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_POST["contactId"]);
        if (!empty($contact)) {
            // Update the note
            $note = htmlspecialchars($_POST["note"]);
            $note = trim($note);
            $note = str_replace("\n", "<br>", $note);

            $result = $noteModel->updateNoteForContact($contact["id"], $_POST["noteId"], $note);
        }

        if (!$result) {
            $error = "NOTE_INSERT_ERROR";
            $isOk = false;
        }
    }

    // Redirect if everything was ok
    if ($isOk) {
        header('Location: /contact/detail/' . $contact["id"]);
        exit();
    }
    // Redirect if any error occured but the contact was found
    else if (!empty($contact)) {
        header('Location: /contact/detail/' . $contact["id"] . '?error=' . $error);
        exit();
    }
    // If there was another failure
    else {
        header('Location: /contact/detail/' . $_POST["contactId"]);
        exit();
    }
}
//
else if ($action === "delete") {
    $isOk = true;

    if (!is_numeric($_GET["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }

    if (!is_numeric($_GET["noteId"])) {
        $error = "INVALID_NOTE_ID";
        $isOk = false;
    }

    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["contactId"]);

        if (!empty($contact)) {
            // Delete the note
            $result = $noteModel->deleteNoteFromContact($contact["id"], $_GET["noteId"]);
        }


        if (!$result) {
            $error = "CONTACT_INSERT_ERROR";
            $isOk = false;
        } else {
            header('Location: /contact/detail/' . $contact["id"]);
            exit();
        }
    }

    if (!$isOk) {
        header('Location: /dashboard?error=' . $error);
        exit();
    }
} else if ($action === "hide") {
    $isOk = true;

    if (!is_numeric($_GET["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }

    if (!is_numeric($_GET["noteId"])) {
        $error = "INVALID_NOTE_ID";
        $isOk = false;
    }

    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["contactId"]);

        if (!empty($contact)) {
            // Hide the note
            $result = $noteModel->hideNoteForContact($contact["id"], $_GET["noteId"]);
        }


        if (!$result) {
            $error = "CONTACT_HIDE_ERROR";
            $isOk = false;
        } else {
            header('Location: /contact/detail/' . $contact["id"]);
            exit();
        }
    }

    if (!$isOk) {
        header('Location: /dashboard?error=' . $error);
        exit();
    }
} else if ($action === "unhide") {
    $isOk = true;

    if (!is_numeric($_GET["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }

    if (!is_numeric($_GET["noteId"])) {
        $error = "INVALID_NOTE_ID";
        $isOk = false;
    }

    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["contactId"]);

        if (!empty($contact)) {
            // Unhide the note
            $result = $noteModel->unhideNoteForContact($contact["id"], $_GET["noteId"]);
        }


        if (!$result) {
            $error = "CONTACT_UNHIDE_ERROR";
            $isOk = false;
        } else {
            header('Location: /contact/detail/' . $contact["id"]);
            exit();
        }
    }

    if (!$isOk) {
        //header('Location: /dashboard?error=' . $error);
        exit();
    }
}

$_SESSION["last_form"] = [];

exit();
