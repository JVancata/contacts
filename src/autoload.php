<?php
session_start();

require_once "config.php";
require_once "lib/database.php";
require_once "lib/seo.php";
require_once "lib/user.php";
require_once "lib/user_guard.php";

if(!empty($_SESSION["user"])) {
    $_SESSION["unserializedUser"] = unserialize($_SESSION["user"]);
}

if (PRODUCTION) {
    // ini_set('display_errors', 0);
    // ini_set('display_startup_errors', 0);
    // error_reporting(0);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
