<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Expire the session cookie by setting it to a past date
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect the user to the login page
header("Location: login.php");
exit();
?>
