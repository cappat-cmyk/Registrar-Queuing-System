<?php
session_start();
include "DBConnect.php";
$id = $_SESSION['id'];
// Session Time Out
// Set session timeout to 1 Hour
ini_set('session.gc_maxlifetime', 3600);

// Set session cookie lifetime to 1 Hour minutes
session_set_cookie_params(3600);

// Check if session is expired
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // Session expired, destroy session and redirect to login page
    $id = $_SESSION['id'];
    $update_query = "UPDATE users SET is_logged_in=0 WHERE id='$id'";
    mysqli_query($conn, $update_query);
    session_unset();    
    session_destroy();

// Destroy the cookies by setting their expiration time to a past time
  setcookie('user_id', '', time() - 3600, '/');
  setcookie('username', '', time() - 3600, '/');
  setcookie('firstname', '', time() - 3600, '/');
  setcookie('lastname', '', time() - 3600, '/');
  setcookie('role', '', time() - 3600, '/');
  setcookie('counternumber', '', time() - 3600, '/');
  
    echo'<script>alert("Session Expired. Please Login Again.");</script>';
    echo("<script>window.location = 'LoginForm.php';</script>");
    exit;
}
// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();
?>