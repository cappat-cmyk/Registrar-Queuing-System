<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('session.gc_maxlifetime', 86400);
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';
include "../DBConnect.php";    
include "../SessionTimeout.php"; 
// if user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Please Login");</script>';
    header('Location: ../loginForm.php');
    exit;
} 
// if (isset($_SESSION['id'])){ 
//     if($row['Role'] == "University Registrar") {
//     echo("<script>window.location = '../loginForm.php';</script>");
// }
// }
   
        $id=$_SESSION['id'];
        $query = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $email = $row['Email'];
        $username = $row['username'];
        $firstname = $row['First_Name'];
        $lastname = $row['Last_Name'];
        $role = $row['Role'];
        $counternumber = $row['CounterNumber'];


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


// For Sending Email
$emailAdd = $_POST['email'];
$date = $_POST['dateclaim'];
$name = $_POST['Name'];
$content = $_POST['emailBody'];
// $emailBody = "Good Day Mr./Ms. $fname, this is to inform you that you have requested $credential you can claim your document on $date";
$emailSubject = "Confirmation of Transaction";
if(isset($_POST["btn_save"]) && ($_POST['transactiontype'] == 'Request') && ($_POST['transactionstatus']) == 'finished') {
    
    function check_internet_connection() {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        }
        return false;
    }
    // Check if internet is available
    if (check_internet_connection()) {
        // Query the database for failed emails
        $sql = "SELECT * FROM failedemails WHERE eval_id=? AND status='pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); // assuming that eval_id is an integer column
        $stmt->execute();
        $failed_emails = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    
    // Loop through each failed email and try to send it
    foreach ($failed_emails as $failed_email) {
        $email_id = $failed_email['id'];
        $email_to = $failed_email['sendTo'];
        $email_body = $failed_email['body'];
    
        $mail = new PHPMailer(true);
        // Server settings
        $mail->SMTPDebug = 0; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        $mail->Username = 'noreply.uphslregistrar@gmail.com'; // YOUR gmail email
        $mail->Password = 'qazlohskyhmbogtz '; // YOUR gmail password
    
        // Sender and recipient settings
        $mail->setFrom('noreply.uphslregistrar@gmail.com', 'noreply-uphslregistrar');
        $mail->addAddress($email_to, $name);
    
        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = "$emailSubject";
        $mail->Body = $email_body;
        $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';
        
        try {
            $mail->send();
            // Delete the row from the failedemails table
           // Delete the row from the failedemails table
            $deleteSql = "DELETE FROM failedemails WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->execute([$email_id]);
    
        } catch (Exception $e) {
            // Leave the status of the email as pending
            echo "Email sending failed: " . $e->getMessage();
        }
    }
    }

        $content = $_POST['emailBody'];        
        $mail = new PHPMailer(true);
        // Server settings
        $mail->SMTPDebug = 0; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = 'noreply.uphslregistrar@gmail.com'; // YOUR gmail email
        $mail->Password = 'qazlohskyhmbogtz'; // YOUR gmail password

        // Sender and recipient settings
        $mail->setFrom('noreply.uphslregistrar@gmail.com', 'noreply-uphslregistrar');
        $mail->addAddress($emailAdd, $name);

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = "$emailSubject";
        $mail->Body = "$content, $date";
        $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';
        
        try {
            $mail->send();
            echo "Email message sent.";
            echo '<script>
            alert("Email Sent Successfully"); </script>';
            echo("<script>window.location = '../evaluator/EvaluatorPage.php';</script>");
        } catch (Exception $e) {
            // Save the email content in a file
            $sql="INSERT INTO failedemails (eval_id, sendTo, subject, body, status, created_At) VALUES ('$id','$emailAdd', '$emailSubject', '$content,$date','pending', NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            echo '<script>
                  alert("Email Sending failed, Saved the email to be sent later!"); </script>';
            echo("<script>window.location = '../evaluator/EvaluatorPage.php';</script>");
        }
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluator Page</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/jquery.min.js"></script>
    
    <script src="displayQueue.js"></script>
    <script src="nextCustomer.js"></script>
    <script src="callCustomer.js"></script>
    <script src="markAsServing.js"></script>
    <script src="saveTransaction.js"></script>
      <!--Updated3-1-22 eto yung JS -->
    <script src="callonhold.js"></script>


    <!-- Script -->
    
    
 
    <!-- jQuery UI -->
    <link rel="stylesheet" href="../jquery/jquery-ui.css" />
    <script src="../js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="../jquery/jquery-ui1.css">
    
    <script src="../js/jquery-1.12.4.js"></script>
    
    <script src="../js/jquery-ui.js"></script>
    
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap4.min.js"></script>
    
    

    
    <style>
        .nav {
            height: 80px;
            background-color: #012265;
            color:#FFDE00;
            text-align: center;
            font-size: 3rem;
        }
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
        .dis-none {
        display: none;
        }
        .select {
            text-align: center;
            cursor: pointer;
        }
        /* .class {
            border: solid black 1px;
        } */
        .claimingdate {
            text-align: center;
            cursor: pointer;
        }
        /* Queue list Table */
        .queuelist {
            text-align: center;
            width: 70%;
            height: 400px;
            border: solid black 1px;
        }
        .thead {
            background-color: #012265;
            color:#FFDE00;
        }
        .textarea {
            height: 200px;
        }
        #ReceiptNumber {
            display: none;
        }
        #Email {
            display: none;
        }
        tr {
            text-align: center;
        }
        td {
            cursor: pointer;
            font-size: 2rem;
            height:50px;
            text-align: center;
        }
        .counterButtonstyle {
            display: none;
        }
        .clienthistory {
            display: none;
        }
        .priority{
            background-color:red;
        }
        .non-priority{
            background-color:white;
        }
        #claimdate {
            display: none;
        }
        label{
            font-size:smaller;
        }
        .menu {
            width: 200px;
        }
        .menubtn {
            left: 10px;
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

        .card {
            background-color: whitesmoke; 
            border: none;
        }
        #on-hold {
            display: none;
        }
        #claim-table {
            display: none;
        }
        .navtext {
        position: absolute;
        left: 40%;
        }
    </style>
</head>
<body>
    

<div class="container-fluid">
    
<!-- Dinagdag ko, eto yung dropdown menu and banner -->
<div class="row">
         
<nav class="navbar navbar-expand-lg nav">
        <button class="btn dropdown-toggle ms-3" data-bs-toggle="dropdown" aria-expanded="false">
           <img src="/Registrar Queuing System/images/menu.png" alt="Menu">
        </button>
            <span class="navtext">Evaluator Page</span>
            <ul class="dropdown-menu dropdown-menu-dark menu">
                <div class="icons">
            <!-- <li><a href="EvaluatorPage.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/dashboards.png" alt="Dashboard"><span class="text">Dashboard</span></a></li><br> -->
            <li><a href="" style="text-decoration:none"><img src="/Registrar Queuing System/images/add.png" alt="Queue"><span class="text">Queue</span></a></li><br>
            <!-- <li><a href="On-Hold.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/pause.png" alt="On-Hold"><span class="text">On-Hold</span></a></li><br> -->
            <li><a href="transactionhistory.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/history.png" alt="Transaction History"><span class="text">View History</span></a></li><br>
            <li><a href="../evaluator/ProfileSettings.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/settings.png" alt="Settings"><span class="text">Profile Settings</a></span></li><br>
            <form method="post">
            <li><img src="/Registrar Queuing System/images/logout.png" alt="Logout"><button class="btn link" id="btn_logout" name="logout" type="submit"><span class="text">Logout</span></button></li>
                </div>  
            </form>
            </ul> 
    </nav>
</div>
 

 <!-- Hanggang dito yung dropwdown and banner -->
        <div class="row text-start">
            <!-- First Column (Search, Remarks, Save, Pull Out, Help Btns) -->
             <div class="col-sm-3 md-3 lg-3 offset-sm-1 offset-md-1 offset-lg-1 class mt-4">
                <label for="SearchField" id="SearchLbl">Search</label>
                 
 
                    <form id="myForm" method="POST">
                        <div class="input-group mb-3">               
                            <!-- this is for id and counter number  -->
                            <input type="hidden" name="select_id"id="select_id" value="<?php echo $id;?>">
                            <input type="hidden" name="select_counter"id="select_counter" value="<?php echo $counternumber;?>">

                            <input type="text" class="form-control shadow bg-body-tertiary rounded"  name="searchfield" id="searchfield"  placeholder="Search" aria-label="Search" aria-describedby="button-addon1">
                            <button class="btn btn-outline-primary shadow rounded" type="button" id="Searchbtn" onclick="GetDetail(searchfield.value)"><img src="../IMAGES/SearchIcon.png"></button>
                            
                            <!-- hidden input for voice -->
                            <input type="hidden" id="CounterNumber" value="<?php echo $counternumber ?>">
                         </div>
               
                    <label for="RemarksField" id="RemarksLbl">Remarks</label>
                    <div class="input-group mb-3">
                        <select name="transactionstatus"id="transactionstatus" class="form-select shadow bg-body-tertiary rounded select" disabled onchange="enable(this)">
                            <option value="" disabled selected>Choose Transaction Status</option>
                            <option value="finished">Finished</option>
                            <option value="incomplete">Incomplete</option>
                            <option value="onhold">On-Hold</option>
                        </select>
                        </div>
                        <div id="RemarksTxtArea" class="dis-none">
                                <textarea class="form-control shadow bg-body-tertiary rounded textarea" name="remarkstxtarea" id="remarkstxtarea"></textarea>
                        </div>

                    <div id="Email">
                        <label for="email" id="EmailLbl">Email</label>
                        <div class="input-group mb-3" id="emailcontainer">
                            <input type="email" class="form-control shadow bg-body-tertiary rounded" name="email" id="email" placeholder="Email" aria-label="Email">
                        </div>
                        <label for="emailSubject" id="EmailSubject">Email Subject</label>
                        <div class="input-group mb-3" id="email_Subject">
                            <input type="text" class="form-control shadow bg-body-tertiary rounded" name="emailSubject" id="emailSubject" placeholder="Email Subject" aria-label="Email Subject" value="<?php echo $emailSubject;?>">
                        </div>
                        <label for="emailBody" id="EmailBody">Email Body</label>
                        <div class="input-group mb-3" id="email_body">
                            <textarea class="form-control shadow bg-body-tertiary rounded textarea" name="emailBody" id="emailBody"></textarea>
                        </div>
                    </div>
<script>
    var name = document.getElementById("Name").value = "text";
</script>
        <!-- JS for Remarks Droplist -->
        <script>
            function enable(answer) {
            
            const type = document.getElementById('transactiontype');
            
            if (answer.value == 'incomplete' || answer.value == 'onhold') {
                document.getElementById('RemarksTxtArea').classList.remove('dis-none');
                document.getElementById('Email').style.display = 'none';
                
            }
            else if (answer.value == 'finished' && type.value == 'Request') {
                document.getElementById('RemarksTxtArea').classList.add('dis-none');
                document.getElementById('Email').style.display = 'block';
            }
            if (answer.value == 'transactionstatus') {
                document.getElementById('RemarksTxtArea').classList.add('dis-none');
                document.getElementById('Email').style.display = 'none';   

            }
        };
        </script>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
                <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary  shadow rounded"  disabled onclick="customer_saveTransaction()">Save</button>
                <button type="button" id="btn_claim" name="btn_claim" class="btn btn-primary  shadow rounded" onclick="claim('claim-table')">Claim</button>
                <!-- <button type ="button" id="codeBTN" class="btn btn-primary  shadow rounded" disabled onclick="generateCode()">Generate Code</button> -->
                <button type="button" id="btn_on-hold" name="btn_on-hold"  class="btn btn-primary  shadow rounded" onclick="show('on-hold')">On-Hold</button>
                <!-- <button type="submit" id="btn_email" name="btn_email"  class="btn btn-primary  shadow rounded">Send Email</button> -->
            </div>

        </div>
             
<!-- Javascript ng on-hold button (toggle show/hide then slide sa position nung on-hold table) -->
<script>
    
    

    function show() {
        const element = document.getElementById("on-hold");
        const claim = document.getElementById("claim-table");
      if (element.style.display === 'none') {
        element.style.display = 'block';
        element.scrollIntoView({behavior: 'smooth'});
        claim.style.display = 'none';
      } else {
        element.style.display = 'none';
        

      }
    }

    function claim() {
        const element = document.getElementById("on-hold");
        const claim = document.getElementById("claim-table");
      if (claim.style.display === 'none') {
        claim.style.display = 'block';
        claim.scrollIntoView({behavior: 'smooth'});
        element.style.display = 'none';
      } else {
        claim.style.display = 'none';
        
        
      }
    }
    
</script>
             <!-- Second Column (Firstname -> Claiming Date) -->
             
             <div class="col-sm-3 md-3 lg-3 class mt-4 form">
        
                <label for="usertype">User type</label>
                <input type="text" class="form-control shadow bg-body-tertiary rounded" name="usertype" id="usertype" placeholder="Student, Faculty, Others" readonly>

                <label for="studentId" id="lbl_studentid" >Student ID</label>
                <input type="text" class="form-control shadow bg-body-tertiary rounded" name="studentId" id="studentId" placeholder="studentId">
                
                <label for="Name" id="lbl_name">Name</label>
                <input type="text" class="form-control shadow bg-body-tertiary rounded" name="Name" id="Name" placeholder="Name">
                
                <label for="ticketnumber" id="lbl_ticketnumber">Ticket Number</label>
                <input type="text" class="form-control shadow bg-body-tertiary rounded" name="ticketnumber" id="ticketnumber" placeholder="Ticket number" readonly>
                
                <label for="transactiontype" id="lbl_transactiontype">Transaction Type</label>
                <select name="transactiontype"id="transactiontype" class="form-select shadow bg-body-tertiary text-left rounded">
                            <option class="text-left" value="Request">Request</option>
                            <option value="Claim">Claim</option>
                         
                        </select>
               
                <label for="document" id="lbl_document">Requested Document</label>
                <select id="document" name="document" class="form-select form-select-md" aria-label=".form-select-sm example">
            
                <?php
                    $result = $conn->query("SELECT * FROM credentials ORDER BY credential ASC");

                    // Get the selected item
                    $selected = isset($_POST['credential']) ? $_POST['credential'] : '';
                    
                    // Generate the option elements
                    while ($row = $result->fetch_assoc()) {
                      $id = $row['id'];
                      $name = $row['credential'];
                      $selectedAttr = $id == $selected ? 'selected' : '';
                      echo "<option value='$name' $selectedAttr>$name</option>";
                    }

                   ?>
                </select>        
    
                <label for="department" id="lbl_course">Department / Course</label>
                <input type="text"  class="form-control shadow bg-body-tertiary rounded" name="department" id="department" placeholder="Department" readonly>
                
                <label>Claim Date</label>
                <input type="date" name="dateclaim" id="dateclaim" class="form-control shadow bg-body-tertiary rounded">
            
                <label for="faculty_transactinfo" id="lbl_faculty_transactinfo">Additional Information </label>
                <textarea class="form-control" id="faculty_transactinfo" rows="3"></textarea>
             </div>

            
             <div class="col-sm-3 md-3 lg-3 class mt-5"> 
                    
                    <!-- Select Counter to display -->
                    <select class="form-select d-flex justify-content-center" aria-label=".form-select-sm example" id="drpdwn_counter" name="drpdwn_counter" style="width: 70%; margin-left:15%">
                        <?php
                            // Define the query
                            $query = "SELECT DISTINCT id, CounterNumber FROM users WHERE CounterNumber != 0 ORDER BY CounterNumber ASC";
                            // Execute the query
                            $result = mysqli_query($conn, $query);

                            // Generate the option elements
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['id'];
                                $name = $row['CounterNumber'];
                                // Use json_encode() to convert the values to a JSON string
                                $jsonValue = json_encode(['id' => $id, 'counter' => $name]);
                                echo "<option id='counternumber' value='$jsonValue' counter='$name'>Counter $name</option>";
                            }
                        ?>
                    </select>

                  
                    <div class="table-responsive d-flex justify-content-center" style="width: 100%;margin-top: 20px;">
                        <table id="queue-table" class="table table-hover shadow rounded queuelist">
                            <thead class="thead">
                              <tr>
                                <th scope="col">Queue List</th>
                              </tr>
                            </thead>
                        </table>
                    </div>
                
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
                        <button type="button" id="call" disabled onclick="callCustomer(); markAsServing()" class="btn btn-primary shadow rounded tt" data-bs-placement="top">Call</button>
                        <button type="button" id="recall" disabled onclick="callCustomer()" class="btn btn-secondary shadow rounded text-nowrap tt" data-bs-placement="top" >Re-Call</button>
                        <button type="button" id="pwd" onclick="nextCustomer('pwd')" class="btn btn-danger shadow rounded tt" data-bs-placement="top" >PWD</button>
                        <button type="button" id="next" class="btn btn-primary shadow rounded tt" data-bs-placement="top" onclick="nextCustomer('next');">Next</button>
                    </div>
                
                </div>
                

    </form>
</div>
<!-- Eto yung on-hold na section -->
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="jumbotron" id="on-hold">
            <div class="card">
                <h2> On-Hold Transactions </h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <!--Updated3-1-22 eto yung pinalit ko sa table ng onhold transactions -->
                       <?php

               
                            $query = "SELECT * FROM queue WHERE status='onhold'";
                            $query_run = mysqli_query($conn, $query);

                        ?>
                    <table id="datatableid" class="table datatableid">
                        <thead>
                            <tr style="background-color: #012265; color: #FFDE00">
                                <th scope="col" >ID</th>
                                <th scope="col">Ticket Number</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                if($query_run)
                {
                    foreach($query_run as $row)
                    {
            ?>
                        <tbody>
                            <tr>
                                <td> <?php echo $row['queue_id']; ?> </td>
                                <td> <?php echo $row['ticket_number']; ?> </td>
                                    
                                <td>
                                <button type="button" id="callonholdbtn" class="btn btn-success btn-rounded btn-sm fw-bold callbtn" onclick="CallOnHold('<?php echo $row['queue_id']; ?>'); deleteRow(this.parentNode.parentNode);nextCustomer('callonholdbtn'); enableBTN();"> Call </button>
                                <button type="button" class="btn btn-danger btn-rounded btn-sm fw-bold deletebtn" onclick="deleteRow(this.parentNode.parentNode);"> Remove </button>
                                </td>   
                            </tr>
                        </tbody>
                        <?php        
                           
                }
            }
               
                
            ?>
                    </table>
                    <!-- eto yung end ng table ng onhold transactions -->
                </div>
            </div>
        </div>
<!-- Confirmation Modal for Claim Table -->
    <div class="modal fade" id="updatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Set to Claimed? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <h4> Are you sure you want to mark this transaction as claimed?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> No </button>
                        <button type="button" name="updatedata" id="updatedata" class="btn btn-primary updatedata"> Yes </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
            <!-- Claim Table -->
<div class="jumbotron" id="claim-table">
            <div class="card">
                <h2> Pending for Claiming </h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <!--Updated3-1-22 eto yung pinalit ko sa table ng onhold transactions -->
                       <?php


               
                            $query = "SELECT * FROM transactionhistory WHERE is_claimed='no'";
                            $query_run = mysqli_query($conn, $query);
             

                        ?>
                    <table id="datatableid" class="table datatableid">
                        <thead>
                            <tr style="background-color: #012265; color: #FFDE00">
                                <th scope="col" hidden>ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Request Date</th>
                                <th scope="col">Claim Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                if($query_run)
                {
                    foreach($query_run as $row)
                    {$dateString = date('Y-m-d', strtotime($row['finishedAt']));
            ?>
                        <tbody>
                            <tr>
                                <td hidden> <?php echo $row['transact_id']; ?> </td>
                                <td> <?php echo $row['fullname']; ?> </td>
                                <td> <?php echo $dateString; ?> </td>
                                <td> <?php echo $row['claimDate']; ?> </td>
                                    
                                <td>
                                <button type="button" class="btn-primary btn-rounded btn-sm fw-bold updatebtn"> Mark as Claimed </button>
                      
                                </td>   
                            </tr>
                        </tbody>
                        <?php        
                           
                }
            }
               
                
            ?>
                    </table>
                    <!-- eto yung end ng table ng onhold transactions -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Closing div ng container-fluid -->
</div>
<!-- Hanggang dito yung on-hold na section -->

<!-- Mark as Claimed for Claim Table -->

<!-- Script for on-hold call button -->
<script>
    function enableBTN() {
    document.getElementById("call").disabled = false;
    document.getElementById("transactionstatus").disabled = false;
    document.getElementById("btn_save").disabled=false;
  }
</script>
<!-- Script for confirmation modal in claim table -->
<script>
        $(document).ready(function () {

            $('.updatebtn').on('click', function () {

                $('#updatemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);

            });
        });
</script>
<!-- // Update Button in Modal  -->
    <script>
   $('#updatedata').on('click', function () {

var transact_id = document.getElementById("update_id").value;

$.ajax({
    url: 'setclaim.php',
    type: 'POST',
    data: { transact_id: transact_id },
    dataType: 'json',
    success: function(response) {
        if (response.status === 'success') {
            
            // remove the row from the table
            $(this).closest('tr').remove();
            location.reload();
        } else {
            alert('Error: could not update transaction');
        }
    },
    error: function() {
        alert('Error: could not update transaction');
    }
});
});

    </script>
 <!-- Autocomplete search bar -->
 
    <script>
     $( function() {
    $( "#searchfield" ).autocomplete({
    source: 'searchbar.php'  
    });
});
  </script>
 
 <script>

function GetDetail(str) {
    if (str.length == 0) {
      // document.getElementById("id").value = "";
        
        document.getElementById("usertype").value = "";
        document.getElementById("studentId").value = "";
        document.getElementById("Name").value = "";

        //subject to change
        
        document.getElementById("ticketnumber").value = "";

        document.getElementById("transactiontype").value = "";
        
        document.getElementById("department").value = "";
        document.getElementById("dateclaim").value = "";
        document.getElementById("faculty_transactinfo").value = "";
        document.getElementById("remarkstxtarea").value = "";
        document.getElementById("transactionstatus").value = ""; 
        document.getElementById("document").value = "";
        document.getElementById("email").value = "";
        return;
    }
    else {

        // Creates a new XMLHttpRequest object
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);

                document.getElementById
                    ("usertype").value = myObj[0];

                document.getElementById
                    ("studentId").value = myObj[1];
                 
               
                document.getElementById(
                    "Name").value = myObj[2];
                      
                document.getElementById(
                    "ticketnumber").value = myObj[3];

                document.getElementById(
                    "transactiontype").value = myObj[4];

                document.getElementById(
                    "department").value = myObj[5];
                   
               
                document.getElementById(
                    "dateclaim").value =  myObj[6];

                document.getElementById(
                    "faculty_transactinfo").value = myObj[7];

                document.getElementById(
                    "remarkstxtarea").value =  myObj[8];

                document.getElementById(
                    "transactionstatus").value =  myObj[9];
                    document.getElementById("transactionstatus").dispatchEvent(new Event("change"));

                    document.getElementById(
                    "document").value = myObj[10];
                    document.getElementById("document").dispatchEvent(new Event("change"));
           

                document.getElementById(
                    "email").value = myObj[11];
                
                    console.log("no wat");
                   
                   
            }
        };

        // xhttp.open("GET", "filename", true);
        xmlhttp.open("GET", "autopopulate.php?searchfield=" + str, true);
          
        // Sends the request to the server
        xmlhttp.send();
    }
}
</script>

<!-- Set the value -->
<script>
    // Pass the PHP variables to JavaScript
    const id="<?php echo $id; ?>";
    const email = "<?php echo $email; ?>";
    const username = "<?php echo $username; ?>";
    const firstname = "<?php echo $firstname; ?>";
    const lastname = "<?php echo $lastname; ?>";
    const role = "<?php echo $role; ?>";
    const counternumber = "<?php echo $counternumber; ?>";

    // Store the variables in the Session Storage
    localStorage.setItem("id", id);
    localStorage.setItem("email", email);
    localStorage.setItem("username", username);
    localStorage.setItem("firstname", firstname);
    localStorage.setItem("lastname", lastname);
    localStorage.setItem("role", role);
    localStorage.setItem("counternumber", counternumber);
</script>

<!-- //Eto yung auto  populate ng js kumukuha sya ng data sa autopopulate.php na naka array tapos dinidistribute nya sa textfields   -->


<!-- End of all related in search function -->
<script>
// Capture the values of the text fields and store them in Local Storage on page load
document.addEventListener("DOMContentLoaded", function() {
  var usertypeTextField = document.getElementById("usertype");
  var studentIdTextField = document.getElementById("studentId");
  
  localStorage.setItem("usertypevalue", usertypeTextField.value);
  localStorage.setItem("studentIdvalue", studentIdTextField.value);
});

// Set the values of the text fields from Local Storage on page load
document.addEventListener("DOMContentLoaded", function() {
  var usertypeTextField = document.getElementById("usertype");
  var studentIdTextField = document.getElementById("studentId");
  
  usertypeTextField.value = localStorage.getItem("usertypevalue") || "";
  studentIdTextField.value = localStorage.getItem("studentIdvalue") || "";
});

// Clear the saved text field values from Local Storage
localStorage.removeItem("usertypevalue");
localStorage.removeItem("studentIdvalue");


</script>

<script>
    const tooltips = document.querySelectorAll('.tt')
    tooltips.forEach(t => {
    new bootstrap.Tooltip(t)
    })


// On page load (cannot be separated)
window.addEventListener('load', function() {
  var select = document.getElementById("drpdwn_counter");
  var options = select.options;

  var counterNumber = <?php echo $counternumber; ?> 
  for (var i = 0; i < options.length; i++) {
    var option = options[i];
    var jsonValue = option.value;
    var values = JSON.parse(jsonValue);
    var optionCounter = values.counter;
    if (optionCounter == counterNumber) {
      // Select the option
      option.selected = true;
      var selectedId = values.id;
      var selectedCounter = values.counter;
      document.getElementById("select_id").value=selectedId;
      document.getElementById("select_counter").value=selectedCounter;

      // Set a value in the Session Storage
      localStorage.setItem("selected_id", selectedId);
      localStorage.setItem("selected_counter", selectedCounter);

      // Call the displayQueue function
      displayQueue(selectedId, selectedCounter);
      break;
    }
  }

  // Call the displayQueue function every 3 seconds
  setInterval(function() {
    var selectedId = localStorage.getItem("selected_id");
    var selectedCounter = localStorage.getItem("selected_counter");
    displayQueue(selectedId, selectedCounter);
  }, 3000);
});
// this is the end of on page load of evaluator


//when selection changes of the dropdown counter

var intervalId;

var select = document.getElementById("drpdwn_counter");
select.addEventListener("change", function() {
    clearInterval(intervalId);

    var selectedOption = select.options[select.selectedIndex];
    var jsonValue = selectedOption.value;
    var values = JSON.parse(jsonValue);
    var selectedId = values.id;
    var selectedCounter = values.counter;
    var selectedFirstname = values.fname;
    document.getElementById("select_id").value=selectedId;
    document.getElementById("select_counter").value=selectedCounter;

    // Set a value in the Session Storage
    localStorage.setItem("selected_id", selectedId);
    localStorage.setItem("selected_counter", selectedCounter);


    intervalId = setInterval(function() {
        displayQueue(selectedId, selectedCounter);
    }, 1000);
});
// changes of drop down for counter ends here (done)


// This is a search function that automatically retrieves the name of student when entered student id
document.getElementById("studentId").addEventListener('input', function() {
    var studentId = this.value;

    if (studentId == "") {
    return;
  }

  // Send AJAX request to search for student info based on inputted studentId
  $.ajax({
    type: "GET",
    data: { studentId: studentId },
    url: "searchStudent.php",
    dataType: "json",
    success: function(result) {
      console.log(result);

      if (result.success) {
        document.getElementById("Name").value = result.data.name;
        document.getElementById("usertype").value = "Student";

      } else {
        document.getElementById("Name").value = "No matching student found.";
        document.getElementById("usertype").value = "Others";
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
});
</script>
<script>
    // RETAIN VALUE ON RELOAD
      window.onload = function() {
        document.getElementById("btn_save").disabled=false;
        document.getElementById("call").disabled=false;
        document.getElementById("recall").disabled=false;
        document.getElementById("transactionstatus").disabled=false;
        if (customer.client_type) {
              document.getElementById("usertype").setAttribute("placeholder", "no value inputted");
              document.getElementById("usertype").value = customer.client_type;
          }

          if (customer.ticket_number) {
              document.getElementById("ticketnumber").setAttribute("placeholder", "no value inputted");
              document.getElementById("ticketnumber").value = customer.ticket_number;
          }

          if (customer.client_id ) {
              document.getElementById("studentId").setAttribute("placeholder", "no value inputted");
              document.getElementById("studentId").value = customer.client_id;
          }

          if (customer.client_name ) {
              document.getElementById("Name").setAttribute("placeholder", "no value inputted");
              document.getElementById("Name").value = customer.client_name;
          }

          if (customer.transaction_type ) {
              document.getElementById("transactiontype").setAttribute("placeholder", "no value inputted");
              document.getElementById("transactiontype").value = customer.transaction_type;
          }

          if (customer.credential) {
              document.getElementById("document").setAttribute("placeholder", "no value inputted");
              document.getElementById("document").value = customer.credential;
          }

          if (customer.course_name) {
            document.getElementById("department").setAttribute("placeholder", "no value inputted");
            document.getElementById("department").value = customer.course_name;
          }
          
      }
</script>
<script src="emailContent.js"></script>
</body>
</html>
