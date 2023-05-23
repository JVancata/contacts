<?php

require_once __DIR__ . "/../model/user.php";
$userModel = new UserModel();
$error = $_GET["error"] ?? null;

userGuard();

require __DIR__ . '/../view/dashboard/dashboard.php';

$_SESSION["last_form"] = [];

exit();
