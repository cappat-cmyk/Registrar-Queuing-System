<?php
session_set_cookie_params(35840000000);
// Set the encrypted session ID as a cookie
session_start();

include "DBConnect.php";
error_reporting(E_ERROR | E_PARSE);

$username= $_POST['username'];
$password= $_POST['password'];

$query="Select id, username, password, First_Name, Last_Name, Role, counternumber, is_logged_in FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$hash=password_verify($password, $row['password']);

// empty username input field
if(empty($_POST['username'])) {
    // echo '<script>alert("Please enter your username.")</script>';
    echo '<script>alert("Please Login.")</script>';
    echo("<script>window.location = 'loginForm.php';</script>");    
}
// empty password field
else if(empty($_POST['password'])) {
    echo '<script>alert("Please enter your password.")</script>';
    echo("<script>window.location = 'loginForm.php';</script>");
}
// username is not in the database
else if (mysqli_num_rows($result) == 0) {
    echo '<script>alert("User does not exist")</script>';
    echo("<script>window.location = 'loginForm.php';</script>");
}
else if(mysqli_num_rows($result) > 0){
    // if encrypted password
   if ($hash){
        if ($row['Role'] == "University Registrar") {
            if ($row['is_logged_in'] == 0) {
                // Set logged in value to true in the database
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['firstname'] = $row['First_Name'];
                $_SESSION['lastname'] = $row['Last_Name'];
                $_SESSION['role'] = $row['Role'];
                $_SESSION['CounterNumber'] = $row['counternumber']; 

                if ($row['Role'] == "University Registrar") {
                    if ($row['is_logged_in'] == 0) {
                        // Set logged in value to true in the database
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['firstname'] = $row['First_Name'];
                        $_SESSION['lastname'] = $row['Last_Name'];
                        $_SESSION['role'] = $row['Role'];
                        $_SESSION['CounterNumber'] = $row['counternumber']; 
                        

                
                
                        $id = $row['id'];
                        $update_query = "UPDATE users SET is_logged_in= 1 WHERE id='$id'";
                        mysqli_query($conn, $update_query);
                        header ("location: /Registrar Queuing System/University Registrar/UniversityRegistrarDashboard.php");
                    } else {
                        echo '<script>alert("User is already logged in.");</script>';
                        echo ("<script>window.location = 'loginForm.php';</script>");
                    }
                }

                $id = $row['id'];
                $update_query = "UPDATE users SET is_logged_in= 1 WHERE id='$id'";
                mysqli_query($conn, $update_query);
                header ("location: /Registrar Queuing System/University Registrar/UniversityRegistrarDashboard.php");
            } else {
                echo '<script>alert("User is already logged in.");</script>';
                echo ("<script>window.location = 'loginForm.php';</script>");
            }


            // $_SESSION['id'] = $row['id'];
            // $_SESSION['email'] = $row['Email'];
               
            }          
    else if ($row['Role'] == "Evaluator") {
            if ($row['is_logged_in'] == 0) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['firstname'] = $row['First_Name'];
                $_SESSION['lastname'] = $row['Last_Name'];
                $_SESSION['role'] = $row['Role'];
                $_SESSION['CounterNumber'] = $row['counternumber'];

         

                $id2 = $row['id'];
                $update_query2 = "UPDATE users SET is_logged_in= 1 WHERE id='$id2'";
                mysqli_query($conn, $update_query2);
                header("location: /Registrar Queuing System/evaluator/EvaluatorPage.php"); 
    }
        else {
            echo '<script>alert("User is already logged in.");</script>';
            echo ("<script>window.location = 'loginForm.php';</script>");
        }
    }
} 


else {
   // Invalid login credentials
echo '<script>alert("Invalid username or password. Please try again.")</script>';
echo("<script>window.location = 'loginForm.php';</script>");
}
}
mysqli_close($conn);
?>
