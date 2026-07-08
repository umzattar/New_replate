<?php
//Start session
session_start();
include_once 'dbcon.php';
$db = new Conn();
$db->getConnection();
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['Id']) || ($_SESSION['Id'] == '')) {
} else {
    $now = time(); // Checking the time now when home page starts.
    if ($now > $_SESSION['expire']) {
        header("location: logout.php");
        exit();
    }
}
