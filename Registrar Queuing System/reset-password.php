<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="jquery/jquery.min.js"></script>
    </head>
</html>
<body>


<div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
              <div class="border border-3 border-primary"></div>
              <div class="card bg-white shadow-lg">
                <div class="card-body p-5">
<?php
session_start();

include "DBConnect.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    // check if the token is valid and exists in the database
    $result = $conn->query("SELECT * FROM users WHERE reset_password = '$token'");
    if ($result->num_rows > 0) {
        // display the password reset form
        echo '<form class="mb-3 mt-md-4" method="post" action="reset-password.php">';
        echo '<h4 class="fw-bold mb-2 ">Reset Password</h4><br>';
        echo '<input class=" mb-5 form-control" type="password" name="password" placeholder="New Password">';
        echo '<input class="mb-5 form-control" type="password" name="confirm_password" placeholder="Confirm New Password">';
        echo '<input type="hidden" name="token" value="'.$token.'">';
        echo '<input class="btn btn-outline-dark" type="submit" name="submit" value="Reset Password">';
        echo '</form>';
    } else {
        echo 'Invalid or expired token.';
    }
}

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    // check if the passwords match
    if ($password == $confirm_password) {
        // hash the new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // update the password in the database
        $conn->query("UPDATE users SET password = '$hashedPassword', reset_password = '' WHERE reset_password = '$token'");
        echo '<script> 
        alert("Your password has been reset successfully."); </script>';
        header("location: Loginform.php");
    } else {
        echo '<script> 
        alert("Passwords do not match."); </script>';
    }
}

?>

                </div>
            </div>
          </div>
        </div>
      </div>
</body>
