
<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

include "../DBConnect.php";
include "../SessionTimeout.php";
$getID = $_SESSION['id'];
$getRole = $_SESSION['role'];



if (!isset($_SESSION['id'])) {
    echo '<script>alert("Please Login");</script>';
    header('Location: ../loginForm.php');
    exit;
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
            <title>Transaction History</title>
        </head>
    <style>
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
        .icon-size{
        height: 2em;
        width: 2em;
        }
    </style>
<body>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/jquery.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap4.min.js"></script>


   



<div class="jumbotron">
<button class="btn dropdown-toggle ms-3" data-bs-toggle="dropdown" aria-expanded="false">
           <img src="/Registrar Queuing System/images/menu-blk.png" alt="Menu">
        </button>
            <ul class="dropdown-menu dropdown-menu-dark menu">
                <div class="icons">
            <!-- <li><a href="EvaluatorPage.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/dashboards.png" alt="Dashboard"><span class="text">Dashboard</span></a></li><br> -->
            <li><a href="../evaluator/EvaluatorPage.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/add.png" alt="Queue"><span class="text">Queue</span></a></li><br>
            <!-- <li><a href="On-Hold.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/pause.png" alt="On-Hold"><span class="text">On-Hold</span></a></li><br> -->
            <li><a href="transactionhistory.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/history.png" alt="Transaction History"><span class="text">View History</span></a></li><br>
            <li><a href="../evaluator/ProfileSettings.php" style="text-decoration:none"><img src="/Registrar Queuing System/images/settings.png" alt="Settings"><span class="text">Profile Settings</a></span></li><br>
            <form method="post">
            <li><img src="/Registrar Queuing System/images/logout.png" alt="Logout"><button class="btn link" id="btn_logout" name="logout" type="submit"><span class="text">Logout</span></button></li>
                </div>  
            </form>
            </ul> 
    <div class="card align-items-center" style=" width: 100%">
        <div class="card-body border border-1" style="width: 90%">
                <!-- <a href="EvaluatorPage.php"><img role="button" src="../IMAGES/back-arrow logo.png" class="mt-2 img-fluid img-circle rounded float-start icon-size"></a> -->
        <h2 style="color: #012265; margin-left:1em;" class="h1 "> Transaction History </h2>
     
           <?php
if ($getRole == "Evaluator"){

    $query = "SELECT COUNT(*) as total FROM transactionhistory";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total_rows = $row['total'];
    $per_page =1000;
    $total_pages = ceil($total_rows / $per_page);

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    $start = ($current_page - 1) * $per_page;
    $query = "SELECT * FROM transactionhistory WHERE counterNumber='$getID' LIMIT $start, $per_page";
    $query_run = mysqli_query($conn, $query);
 

?> 
<input type="search" placeholder="Search..." class="form-control search-input" data-table="datatableid"/><br>
<form id="filterForm" method="post" action="../University Registrar/export.php">
<button type="submit"  name="exportbyeval" class="btn btn-success exportall" data-toggle="modal">
                        Export All
                    </button>
</form>
<br>
<div class="float-right">

       </div>



                    <table id="datatableid" class="table table-sm datatableid table-responsive">
                        <thead class="fixed-header" sty="">
                            <tr style="background-color: #012265; color: #FFDE00">
                             
                               
                                <th scope="col"> Client Type </th>
                                <th scope="col"> Student ID </th>
                                <th scope="col"> Name </th>
                                <th scope="col"> Email </th>
                                <th scope="col"> Ticket Number</th>
                                <th scope="col"> Transaction Type </th>
                                <th scope="col"> Requested Document </th>
                                <th scope="col"> Department </th>
                                <th scope="col"> Status </th>
                                <th scope="col"> Remarks </th>
                                <th scope="col"> Additional Info. </th>
                               
                                <th scope="col"> Claim Date </th>
                                <th scope="col"> Is Claimed </th>
            
           
                            </tr>
                        </thead>
                        <?php

                        while ($row = mysqli_fetch_assoc($query_run)) {
          
            ?>
                        <tbody>
                            <tr>
                                  
                                <td> <?php echo $row['client_type']; ?> </td>
                                <td> <?php echo $row['studentID']; ?> </td>
                                <td> <?php echo $row['fullname']; ?> </td>
                                <td> <?php echo $row['email']; ?> </td>
                                <td> <?php echo $row['ticketNumber']; ?> </td>
                                <td> <?php echo $row['transactionType']; ?> </td>
                                <td> <?php echo $row['requestedDocument']; ?> </td>
                                <td> <?php echo $row['department']; ?> </td>
                                <td> <?php echo $row['status']; ?> </td>
                                <td> <?php echo $row['remarksTextArea']; ?> </td>
                                <td> <?php echo $row['additional_Info']; ?> </td>
                                
                                <td> <?php echo $row['claimDate']; ?> </td>
                                <td> <?php echo $row['is_claimed']; ?> </td>
                
                                
                                
                            </tr>
                        </tbody>
                        <?php           
                    }
              
                
            ?>

          
                    </table>
                    <?php 
                                
                                echo '<ul class="pagination">';
                                if ($current_page > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '">Previous</a></li>';
                                }
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo '<li class="page-item';
                                    if ($i == $current_page) {
                                        echo ' active';
                                    }
                                    echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                }
                                if ($current_page < $total_pages) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a></li>';
                                }
                                echo '</ul>';
                        ?>
                        <?php
                        }
                        ?>
                           
                </div>
            </div>

           
        </div>
    </div>
    </div>
    
   




    <script>
var searchInput = document.querySelector(".search-input");
searchInput.addEventListener("keyup", filterTable);
var tablePagination = document.querySelector(".pagination");
  var paginationButtons = tablePagination.querySelectorAll("li.page-item");
function filterTable() {
  var input = this.value.toLowerCase();
  var table = document.getElementById("datatableid");
  var rows = table.getElementsByTagName("tr");
  var visibleRows = [];

  // filter rows
  for (var i = 1; i < rows.length; i++) {
    var row = rows[i];
    var cells = row.getElementsByTagName("td");
    var shouldHideRow = true;

    for (var j = 0; j < cells.length; j++) {
      var cellText = cells[j].textContent.toLowerCase();
      if (cellText.indexOf(input) > -1) {
        shouldHideRow = false;
        break;
      }
    }

    if (shouldHideRow) {
      row.style.display = "none";
    } else {
      row.style.display = "";
      visibleRows.push(row);
    }
  }

  // update pagination buttons


  var numRows = visibleRows.length;
  var numPages = Math.ceil(numRows / 5);

  for (var i = 0; i < paginationButtons.length; i++) {
    var button = paginationButtons[i];
    var startIndex = i * 5;
    var endIndex = startIndex + 5;
    var pageRows = visibleRows.slice(startIndex, endIndex);

    if (pageRows.length > 0) {
      pageRows.forEach(function (row) {
        row.style.display = "";
      });
      button.disabled = false;
    } else {
      button.disabled = true;
    }
  }
}


</script>
  
  
</body>
            </html>
