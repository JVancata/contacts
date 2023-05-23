<?php

require_once __DIR__ . "/../model/user.php";
$userModel = new UserModel();
$error = $_GET["error"] ?? null;

if ($action === "login") {
    $isOk = true;

    if (empty($_POST["username"])) {
        $error = "EMPTY_USERNAME";
        $isOk = false;
    }
    if (empty($_POST["password"])) {
        $error = "EMPTY_PASSWORD";
        $isOk = false;
    }

    if (!$isOk) {
        header('Location: /login?error=' . $error);
        exit();
    }

    $user = $userModel->loginUser($_POST["username"], $_POST["password"]);
    print_r($user);
}

require __DIR__ . '/../view/login/login.php';
exit();
