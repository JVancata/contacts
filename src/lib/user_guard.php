<?php

/**
 * If $_SESSION["unserializedUser"] is not an authenticated user, redirect to login and destroy session
 */
function userGuard() {
    if (empty($_SESSION["unserializedUser"]) || !$_SESSION["unserializedUser"]->isAuthenticated()) {
        header('Location: /login');
        session_destroy();
        exit();
    }
}
