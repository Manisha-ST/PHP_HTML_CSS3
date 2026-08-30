<?php

session_start();


/*
 * Remove all session variables.
 */

$_SESSION = [];


/*
 * Destroy the current session.
 */

session_destroy();


/*
 * Redirect to login page.
 */

header("Location: index.php");

exit();

?>