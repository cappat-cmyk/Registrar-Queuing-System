<?php  
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {



if(isset($_POST['password'])){

    include "db_conn.php";


    $pass = $_POST['password'];
    $password = password_hash($pass, PASSWORD_DEFAULT); 
    $id = $_SESSION['id'];

               $sql = "UPDATE users 
                       SET password=?
                       WHERE id=?";
               $stmt = $conn->prepare($sql);
               $stmt->execute([$password, $id]);
               $_SESSION['username'] = $password;
               header("Location: ../ProfileSettings.php?success=Your account has been updated successfully");
                exit;
       
 
}
}

