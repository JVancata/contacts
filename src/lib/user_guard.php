<?php

function userGuard() {
    if (!$_SESSION["unserializedUser"]->isAuthenticated()) {
        header('Location: /login');
        session_destroy();
        exit();
    }
}
