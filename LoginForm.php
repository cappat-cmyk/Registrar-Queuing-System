<?php 
error_reporting(E_ERROR | E_PARSE);
session_set_cookie_params(35840000000);
session_start();
include "DBConnect.php";
include "SessionTimeout.php";
if (isset($_SESSION['id']) && ($_SESSION['role']) == 'Evaluator'){ 
      header('Location: evaluator/EvaluatorPage.php');
    } else if (isset($_SESSION['id']) && ($_SESSION['role']) == 'University Registrar'){
      header('Location: University Registrar/SideBar_UniversityRegistrar.php');
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPHSL REGISTRAR QUEUING SYSTEM - Sign in</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="jquery/jquery.min.js"></script>
</head>
<body>
  
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
              <div class="border border-3 border-primary"></div>
              <div class="card bg-white shadow-lg">
                <div class="card-body p-5">
                  <form action="login.php" method="post" class="mb-3 mt-md-4">
                    <h3 class="fw-bold mb-2 text-uppercase ">UPHSL Registrar Queuing System</h3>
                    <p class=" mb-5">Please enter your username and password!</p>
                    <div class="mb-3">
                      <label for="email" class="form-label ">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="uphsl123">
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label ">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="*******">
                    </div>
                    <p class="small"><a class="text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" >Forgot password?</a></p>
                    <div class="d-grid">
                      <button class="btn btn-outline-dark" type="submit">Login</button>
                    </div>
                  </form>
                  <!-- <div>
                    <p class="mb-0  text-center">Don't have an account? <a href="signup.html"
                        class="text-primary fw-bold">Sign
                        Up</a></p>
                  </div> -->
      
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Forgot Password? Don't worry</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="forgot.php" method="post" id="form_forgot">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label" >Enter Email Address</label>
            <input type="text" class="form-control" name="Email" id="recipient-name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btn_forgot_submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
      <script>
        var passwordInput = document.getElementById("password");
        var passwordValue = passwordInput.value;
        console.log(passwordValue);

        $("#btn_forgot_submit").click(function() {
          $("#form_forgot").submit();
        });


      </script>
</body>
</html>