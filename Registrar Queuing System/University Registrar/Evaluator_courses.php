<?php 
session_start();
include "SideBar_UniversityRegistrar.php";
include "../SessionTimeout.php";
if (!isset($_SESSION['id'])) {
  header('Location: ../loginForm.php');
  exit();
}

//For logout
if (isset($_POST['logout']))
{ 
  session_start();
  $id = $_SESSION['id'];

  $update_query = "UPDATE users SET is_logged_in=0 WHERE id='$id'";
  mysqli_query($conn, $update_query);
  
  // Destroy the session.
  session_unset();
  session_destroy();

  // Destroy the cookies by setting their expiration time to a past time
  setcookie('user_id', '', time() - 3600, '/');
  setcookie('username', '', time() - 3600, '/');
  setcookie('firstname', '', time() - 3600, '/');
  setcookie('lastname', '', time() - 3600, '/');
  setcookie('role', '', time() - 3600, '/');
  setcookie('counternumber', '', time() - 3600, '/');

  // Redirect to login page
  echo '<script>alert("Logged out Successfully.")</script>';
  echo("<script>window.location = '../loginForm.php';</script>");
  
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding Courses to Evaluator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="jumbotron">
    <div class="card">
                <h2 class="d-flex justify-content-center"> Manage Handled Courses </h2>
        </div>   
  <form method="post">  
    <div class="card">
        <div class="card-body d-flex justify-content-center">
  <select class="form-select form-select-md text-center shadow bg-body-tertiary rounded select mx-3" aria-label=".form-select-sm example" id="EvaluatorsOption" name="EvaluatorsOption">
        <?php
        include "../DBConnect.php";

                $result = $conn->query("SELECT id, First_Name, Last_Name, Role FROM users where Role='Evaluator' ORDER BY First_Name ASC");

                // Get the selected item
                $selected = isset($_POST['First_Name']) ? $_POST['First_Name'] : '';
                
                // Generate the option elements
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $name = $row['First_Name'].' '.$row['Last_Name'];
                  $selectedAttr = $id == $selected ? 'selected' : '';
                  echo "<option value='$id' $selectedAttr>$name</option>";
                }

               ?>
    </select>
    
    <!-- Select Courses Credentials -->
    <select class="form-select form-select-md text-center shadow bg-body-tertiary rounded select" aria-label=".form-select-sm example" id="CourseOption" name="CourseOption">
        <?php

                $result = $conn->query("SELECT course_id, Course FROM courselist ORDER BY Course ASC");

                // Get the selected item
                $selected = isset($_POST['Course']) ? $_POST['Course'] : '';
                
                // Generate the option elements
                while ($row = $result->fetch_assoc()) {
                  $id = $row['course_id'];
                  $name = $row['Course'];
                  $selectedAttr = $id == $selected ? 'selected' : '';
                  echo "<option value='$id' $selectedAttr>$name</option>";
                }

                
               ?>

            </select>
            </div>
        </div>
        <div class="card">
            <div class="card-body d-flex justify-content-center">
        <input type="submit" name="submit" id="sendEvaluatorCourse" onclick="assignCourse()" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </form>
    </div>
    </div>
</div>
    <script>
    function assignCourse() {
    var course = document.getElementById("CourseOption").value;
    var evaluator = document.getElementById("EvaluatorsOption").value;
    alert(evaluator);
    $.ajax({
        type: "POST",
        url: "Evaluators_verify.php",
        data: {course: course, evaluator: evaluator},
        success: function(response) {
            if(response == 1){
                alert("Course assigned successfully!");
            }else{
                var conf = confirm("Evaluator already assigned to another course, do you want to replace it?");
                if(conf == true){
                    $.ajax({
                        type: "POST",
                        url: "Evaluators_verify.php",
                        data: {course: course, evaluator: evaluator, replace: true},
                        success: function(response) {
                          if(response == 1){
                                alert("Course assigned successfully!");
                            }else{
                                alert("An error occurred while assigning the course. Please try again later.");
                            }
                        }
                    });
                }
            }
        }
    });
}


     
  
    </script>

</body>
</html>