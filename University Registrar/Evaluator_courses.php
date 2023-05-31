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
                <h2 class="d-flex justify-content-center"> Manage Handled Programs/Strands </h2>
        </div>   
 
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
        <input type="button" name="submit" id="sendEvaluatorCourse" onclick="assignCourse()" class="btn btn-primary" value="Submit">
            </div>
            <?php
include "../DBConnect.php";

// Fetch all rows from courselist table and sort by course_id
$query = "SELECT * FROM courselist ORDER BY course_id ASC";
$result = mysqli_query($conn, $query);

// Create an array to store the evaluator names
$evaluator_names = [];

// Loop over the result set and retrieve the evaluator name for each row
while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['Evaluator_id'];
    if ($name) {
        $query2 = "SELECT CONCAT(First_Name, ' ', Last_Name) AS name FROM users WHERE id = '$name'";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_assoc($result2);
        $evaluator_name = $row2['name'];
    } else {
        $evaluator_name = "";
    }
    $evaluator_names[$row['course_id']] = $evaluator_name;
}

?>

<table id="datatableid" class="table table-bordered table-striped datatableid">
    <thead>
        <tr style="background-color: #012265; color: #FFDE00">
            <th scope="col" hidden>id</th>
            <th scope="col">Credential</th>
            <th scope="col"> Evaluator </th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop over the result set again and output each row in a table
        if ($result->num_rows > 0) {
            mysqli_data_seek($result, 0); // Move the result pointer to the beginning of the set
            while ($row = mysqli_fetch_assoc($result)) {
                $evaluator_name = $evaluator_names[$row['course_id']];
        ?>
        <tr>
            <td hidden> <?php echo $row['course_id']; ?> </td>
            <td> <?php echo $row['Course']; ?> </td>
            <td> <?php echo $evaluator_name; ?> </td>
        </tr>
        <?php
            }
        } else {
            echo "No Record Found";
        }
        ?>
    </tbody>
</table>
        </div>

        
  

    </div>
    </div>
</div>
    <script>
  
    function assignCourse() {
  var course = document.getElementById("CourseOption").value;
  var evaluator = document.getElementById("EvaluatorsOption").value;
  
  // Make an AJAX request to get the name of the selected evaluator
  $.ajax({
    type: "POST",
    url: "getevalname.php",
    data: { evaluatorId: evaluator, course: course },
    success: function(response) {
      var evaluatorName = response;
      
      // Show a confirmation message with the name of the evaluator
      var message = "Program already assigned to " + evaluatorName + ", do you want to replace it?";
      var replace = confirm(message);
      
      if(replace){
        $.ajax({
          type: "POST",
          url: "Evaluators_verify.php",
          data: { course: course, evaluator: evaluator, replace: true },
          success: function(response) {
            if(response == 1){
              alert("Course assigned successfully!");
            } else {
              alert("An error occurred while assigning the course. Please try again later.");
            }
          }
        });
      }
    }
  });
}




     
  
    </script>

</body>
</html>