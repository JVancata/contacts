<?php

require_once __DIR__ . "/../model/user.php";
$userModel = new UserModel();

require_once __DIR__ . "/../model/password.php";
$passwordModel = new PasswordModel();

$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;

if (!empty($_SESSION["user"])) {
    header('Location: /dashboard');
    exit();
}

if ($action === "reset") {
    $isOk = true;

    if (empty($_POST["email"])) {
        $error = "EMPTY_EMAIL";
        $isOk = false;
        header('Location: /password?error=' . $error);
        exit;
    }

    // Check if the email is in database
    $user = $userModel->findUserByEmail($_POST["email"]);
    if (!empty($user) && !empty($user["id"])) {
        // Create the password reset token
        $token = $passwordModel->insertRandomTokenForUser($user["id"]);

        // Send the mail
        $status = sendMail($user["email"], "Obnovení hesla", '<p>Odkaz pro obnovení hesla: <a href="https://contacts.jakub.dev/password/token/' . $token . '">zde</a></p>');
    }

    $message = "PROCESS_COMPLETE";
    header('Location: /password?message=' . $message);
    exit;
}
//
else if ($action === "token") {
    require __DIR__ . '/../view/password/new_password.php';
    exit;
}
//
else if ($action === "new") {
    if (empty($_POST["resetToken"]) || empty($_POST["newPassword"])) {
        $error = "INVALID_DATA";
        header('Location: /password?error=' . $error);
        exit;
    }

    $user = $passwordModel->selectUserIdByValidToken($_POST["resetToken"]);
    if (!empty($user) && !empty($user["user_id"])) {
        // Change
        $userModel->updateUsersPassword($user["user_id"], $_POST["newPassword"]);
        header('Location: /login?message=PROCEED_WITH_LOGIN');
        exit;
    }
    
    header('Location: /password?error=INVALID_TOKEN');
    exit;
}

require __DIR__ . '/../view/password/reset.php';
$_SESSION["last_form"] = [];
exit();
