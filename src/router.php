<?php

require_once 'autoload.php';

$controller = $_GET["controller"] ?? null;
$action = $_GET["action"] ?? null;

if (empty($controller)) {
    header('Location: /login');
}

$allowedControllers = array("login", "register", "dashboard", "logout", "contact", "404", "group", "note");

if (in_array($controller, $allowedControllers)) {
    require __DIR__ . "/controller/" . $controller . '.php';
} else {
    require __DIR__ . "/resources/html/404.html";
}
