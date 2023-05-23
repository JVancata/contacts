<?php

session_destroy();
header('Location: /login?message=SUCCESSFUL_LOGOUT');
exit();
