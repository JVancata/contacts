<?php

require_once __DIR__ . "/../model/user.php";
$userModel = new UserModel();

require_once __DIR__ . "/../model/contact.php";
$contactModel = new ContactModel();

require_once __DIR__ . "/../model/photo.php";
$photoModel = new PhotoModel();

$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;
userGuard();

if ($action === "upload") {
    print_r($_FILES);

    if (!is_numeric($_POST["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        header('Location: /dashboard?error=' . $error);
        exit;
    }

    if (empty($_FILES) || empty($_FILES["photoFile"])) {
        $error = "FILE_EMPTY";
        header('Location: /contact/detail/' . $_POST["contactId"] . '?error=' . $error);
        exit;
    }


    // Check if the contact belongs to the user
    $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_POST["contactId"]);
    if (empty($contact)) {
        header('Location: /dashboard');
        exit;
    }


    //https://www.w3schools.com/php/php_file_upload.asp
    $target_dir = __DIR__ . "/../../uploads/";

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["photoFile"]["name"], PATHINFO_EXTENSION));
    $targetFileName = sha1(microtime()) . '.' . $imageFileType;
    $target_file = $target_dir . $targetFileName;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["photoFile"]["tmp_name"]);
    if ($check == false) {
        $error = "FILE_NOT_IMAGE";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $error = "FILE_EXISTS";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["photoFile"]["size"] > 10 * 1000 * 1000) {
        $error = "FILE_TOO_LARGE";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error = "FILE_UNSUPORTED_EXTENSION";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header('Location: /contact/detail/' . $_POST["contactId"] . '?error=' . $error);
        exit;
    }
    //
    else {
        if (move_uploaded_file($_FILES["photoFile"]["tmp_name"], $target_file)) {
            // Insert it into the database
            $photoModel->insertPhotoForContact($contact["id"], htmlspecialchars($targetFileName));
            header('Location: /contact/detail/' . $_POST["contactId"]);
            exit;
        }
        //
        else {
            $error = "UNKNOWN_ERROR";
            header('Location: /contact/detail/' . $_POST["contactId"] . '?error=' . $error);
            exit;
        }
    }
}
//
else if ($action === "delete") {
    $isOk = true;

    if (!is_numeric($_GET["contactId"])) {
        $error = "INVALID_CONTACT_ID";
        $isOk = false;
    }

    if (!is_numeric($_GET["photoId"])) {
        $error = "INVALID_PHOTO_ID";
        $isOk = false;
    }

    if ($isOk) {
        // Check if the contact belongs to the user
        $contact = $contactModel->getOneContactForUser($_SESSION["unserializedUser"]->id, $_GET["contactId"]);

        if (!empty($contact)) {
            // Delete the photo
            $result = $photoModel->deletePhotoFromContact($contact["id"], $_GET["photoId"]);
        }

        if (!$result) {
            $error = "PHOTO_DELETE_ERROR";
            $isOk = false;
        }
        //
        else {
            header('Location: /contact/detail/' . $contact["id"]);
            exit();
        }
    }

    if (!$isOk) {
        header('Location: /contact/detail/' . $contact["id"] . '?error=' . $error);
        exit();
    }
}

exit();
