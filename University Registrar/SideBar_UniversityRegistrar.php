<?php
error_reporting(E_ERROR | E_PARSE); 
// Start the session
session_start();
include "../DBConnect.php";

// include "../SessionTimeout.php";
//Required Login 
// if user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
  echo'<script>alert("Please login.");</script>';
  header('Location: ../loginForm.php');
  exit;
}

// if (isset($_SESSION['id'])){ 
//   if($row['Role'] == "Evaluator") {
//   echo '<script>alert("You cannot access this page");</script>';
//   echo("<script>window.location = '../loginForm.php';</script>");
// }
// }

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
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/SideBarStyle.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- this style comes from boxicons.com -->
    <link rel="stylesheet" href="../css/boxicons-2.0.7/css/boxicons.min.css">
    
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
        <div class="logo_name">UPHSL Registrar</div>
        <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="sidenav-list">
      <li>
        <a href="UniversityRegistrarDashboard.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
         <span class="tooltip">Dashboard</span>
      </li>
      <li>
       <a href="ManageUsers.php">
        <i class='bx bxs-user-account'></i>
         <span class="links_name">Add Users</span>
       </a>
       <span class="tooltip">Add Users</span>
     </li>
     <li>
       <a href="ManageCredentials.php">
        <i class='bx bxs-file-plus'></i>
         <span class="links_name">Manage Credentials</span>
       </a>
       <span class="tooltip">Manage Credentials</span>
     </li>
     <li>
     <a href="AddCourses.php">
     <i class='bx bxs-add-to-queue' ></i>
         <span class="links_name">Manage Departments</span>
       </a>
       <span class="tooltip">Manage Departments</span>
     </li>
     <li>
       <a href="Evaluator_courses.php">
       <i class='bx bxs-file' ></i>
         <span class="links_name">Manage Handled <br> Programs</span>
       </a>
       <span class="tooltip">Manage Handled Programs</span>
     </li>
     <li>
       <a href="transactionhistory.php">
        <i class='bx bx-history'></i>
         <span class="links_name">Transaction History</span>
       </a>
       <span class="tooltip">Transaction History</span>
     </li>
     <li>
     <a href="ReportGenerationimport.php">
        <i class='bx bxs-file-export'></i>
         <span class="links_name">Report Generation</span>
       </a>
       <span class="tooltip">Report Generation</span>
     </li>
     <li>
       <a href="ProfileSettings.php">
         <i class='bx bx-cog' ></i>
         <span class="links_name">Profile Settings</span>
       </a>
       <span class="tooltip">Profile Settings</span>
     </li>
    <form method='post'>
     <li class="profile">
      <div class="profile-details">
      <div class="name_job">
            
            <div class="name"><?php session_start(); echo $_SESSION['firstname']." ". $_SESSION['lastname'];?></div>
              <div class="job"><?php echo $_SESSION['role'];?></div>
            </div>
         <button type="submit" name="logout"><i class='bx bx-log-out' id="log_out"></i></button>
     </li>
     <!-- PROFILE DETAILS WITH PICTURE UNIVERSITYREGISTRAR - JEDDER GALDONEZ  -->
    </ul>
  </div>
  </form>

  <script>
  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();//calling the function(optional)
  });
  
  // logout.addEventListener("click", ()=>{
  //   window.location.href = "../HTML/loginPage.html";
  // });

  // following are the code to change sidebar button(optional)
  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
   }
  }
  </script>
</body>
</html>