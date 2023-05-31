<?php
session_start();
include "../DBConnect.php";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $update_query = "UPDATE users SET is_logged_in=0 WHERE id='$id'";
    mysqli_query($conn, $update_query);
}
?>
