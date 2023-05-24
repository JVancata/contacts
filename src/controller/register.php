<?php

require_once __DIR__ . "/../model/user.php";
$userModel = new UserModel();
$error = $_GET["error"] ?? null;
$message = $_GET["message"] ?? null;

if (!empty($_SESSION["user"])) {
    header('Location: /dashboard');
    exit();
}

if ($action === "register") {
    $isOk = true;

    if (empty($_POST["username"])) {
        $error = "EMPTY_USERNAME";
        $isOk = false;
    }
    if (empty($_POST["email"])) {
        $error = "EMPTY_EMAIL";
        $isOk = false;
    }
    if (empty($_POST["password"])) {
        $error = "EMPTY_PASSWORD";
        $isOk = false;
    }

    if ($isOk) {
        $result = $userModel->registerUser($_POST["username"], $_POST["email"], $_POST["password"]);

        if (is_string($result)) {
            $error = $result;
            $isOk = false;
        } else {
            $_SESSION["user"] = serialize($result);
            header('Location: /dashboard');
            exit();
        }
    }

    if (!$isOk) {
        $_SESSION["last_form"] = $_POST;
        header('Location: /register?error=' . $error);
        exit();
    }
}

require __DIR__ . '/../view/register/register.php';
$_SESSION["last_form"] = [];
exit();
