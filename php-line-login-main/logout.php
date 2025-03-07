<?php
session_start();
require_once('LineLogin.php');

if (isset($_SESSION['line_profile'])) {
    $profile = $_SESSION['line_profile'];
    $line = new LineLogin();
    $line->revoke($profile->access_token);
    session_destroy();
}

header('location: ../index.php');
?>