

<?php 
// include "../DBConnect.php";
session_start();
include "SideBar_UniversityRegistrar.php";
include "../SessionTimeout.php";

if (!isset($_SESSION['id'])) {
  echo '<script>alert("Please Login");</script>';
  header('Location: ../loginForm.php');
  exit;
} 

// For Logout
if (isset($_POST['logout']))
{ 
  
  $id = $_SESSION['id'];

  $update_query = "UPDATE users SET is_logged_in=0 WHERE id='$id'";
  mysqli_query($conn, $update_query);
  
  // Destroy the session.
  session_unset();
  session_destroy();
  echo '<script>alert("Logged out Successfully.")</script>';
  echo("<script>window.location = '../loginForm.php';</script>");
  // Redirect to login page
  exit;
}


if (isset($_SESSION['id']) && isset($_SESSION['username'])){
include "ProfileSettings/db_conn.php";
include 'ProfileSettings/User_Settings.php';
$user = getUserById($_SESSION['id'], $conn);
 ?> 



  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Profile Settings</title>
      <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="jquery/jquery.min.js"></script>
      <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/jquery.min.js"></script>
      <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
      <link href="https://cdn.usebootstrap.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
        body {
            background-color: whitesmoke;
        }
        /* Custom CSS for Columns */
        .class {
            font-size: 2rem;
            margin-left: 10;
        }
        .form-control {
            max-width: 100%;
        }
        .menu {
          background-color: black;
          width: 200px;
        }
        .menubtn {
            background-color: black;
        }
        .icons {
            position: relative;
            left: 10px;
        }
        .text {
            position: relative;
            left: 15px;
            color: #ffffff;
        }
        li:hover {
            width: 180px;
            background-color: gray;
            border-radius: 10px;
        }
        #btn_history {
            color: #ffffff;   
        }
       
    </style> 
  </head>
  <body>
  <div class="container mt-5">
      <div class="row">
          <div class="col-lg-4 pb-5">
              <!-- Account Sidebar-->
                  <div class="author-card-profile">
                      </div>
                      <div class="author-card-details">
                      </div>
                  </div>
              </div>
              <div class="wizard">
                      </a><a class="list-group-item active" href="#"><i class="fe-icon-user text-muted" ></i>Profile Settings</a><a class="list-group-item" href="#"><i class="fe-icon-map-pin text-muted">
                      </a>
                          <div class="d-flex justify-content-between align-items-center">
                              <div><i class="fe-icon-tag mr-1 text-muted"></i>
                          </div>
                      </a>
              </div>
          <!-- Profile Settings-->
              
                    
              <form  action="ProfileSettings/edit.php" 
              method="post"
              enctype="multipart/form-data">

              <?php if(isset($_GET['error'])){ ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $_GET['error']; ?>
              </div>
              <?php } ?>

              <div class="col-md-12">
                      <div class="form-group">
                          
                          <img src="upload/<?=$user['pp']?>" class="rounded-circle float-right" style="width:140px;height:140px;"  alt="avatar">
                      </div>
                  </div>
                  
              
                  <div class ="row">
                
                  <div class="col-md-6">
                      <div class="form-group">
                          <label style="color: #050504;" for="account-fn">First Name</label>
                          <input class="form-control" type="text" id="fname" name= "fname" value = "<?php echo $user['First_Name']?>" >
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label style="color: #050504;" for="account-ln">Last Name</label>
                          <input class="form-control" type="text" id="lname" name = "lname" value = "<?php echo $user['Last_Name']?>" >
                      </div>
                  </div>


                
  </div>
                  <div class ="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label style="color: #050504;" for="account-email">Username</label>
                          <input class="form-control" type="text" id="uname" name = "uname" value = "<?php echo $user['username']?>" >
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label style="color: #050504;" for="account-phone">Email</label>
                          <input class="form-control" type="email" id="mail" name="mail" value = "<?php echo $user['Email']?>" >
                      </div>
                  </div> 
                  </div>
                  <div class="col-md-3">
                      <div class="d-flex flex-wrap justify-content-between align-items-center">
                          <div class="custom-control custom-checkbox d-block">
                          </div>
                          <input type="file" 
                   class="form-control"
                   name="pp">
         
            <input type="text"
                   hidden="hidden" 
                   name="old_pp"
                   value="<?=$user['pp']?>" >
                  
                      </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="d-flex flex-wrap justify-content-between align-items-center">
                          <div class="custom-control custom-checkbox d-block">
                          </div>
                          <button type="submit" class="btn btn-style-1 btn btn-primary" onclick="alert('Updated Successfully')">Update</button>
                      </div>
                      </div>
              </form>
            <hr>
            <div class ="row">
            <div class="col-md-6">
                      <div class="form-group">
                      <p class="small"><a class="text-primary"  data-toggle="modal" data-target="#myModal">Change Password</a></p>
                      </div>
                  </div> 
                  </div> 
                  </div> 
                  
                
          </div>
      </div>
                      </div>
                      
           
        
                  </div>
                </div>  
              </div>
            </div>
          </div>
        </div>
               
   


  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Password</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form  action="ProfileSettings/change_pass.php" 
              method="post"
              enctype="multipart/form-data">
            <div class="col-md-12">
              <label for="recipient-name" class="col-form-label" required>New Password :</label>
              <input type="password" class="form-control" name="password" id="password" >
            </div>
            <div class="col-md-12">
              <label for="recipient-name" class="col-form-label" required>Repeat New Password :</label>
              <input type="password" class="form-control" name="password" id="password" >
            </div>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-style-1 btn btn-primary" onclick="alert('Change Password Successfully')">Update</button>

        </div>
        </form>
        
      </div>
    </div>
  </div>
  
</div>


        </div>
      
      </div>
    </div>
  </div>
  
  <!--  -->
</body>

</html>

<?php }
else {
	header("Location: ProfileSettings.php");
	exit;
} ?>
