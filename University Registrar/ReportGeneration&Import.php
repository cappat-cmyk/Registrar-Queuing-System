<?php
session_start();

include "../DBConnect.php";
include "SideBar_UniversityRegistrar.php";
include "../SessionTimeout.php";

//Required Login
if (!isset($_SESSION['id'])) {
  echo'<script>alert("Please login.");</script>';
  header('Location: ../loginForm.php');
  exit();
}

// if (isset($_SESSION['id'])){ 
//   if($row['Role'] == "Evaluator") {
//   echo '<script>alert("You cannot access this page");</script>';
//   echo("<script>window.location = '../loginForm.php';</script>");
// }
// }

//Session Time Out
// Set session timeout to 30 minutes
ini_set('session.gc_maxlifetime', 1800);

// Set session cookie lifetime to 30 minutes
session_set_cookie_params(1800);

// Check if session is expired
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // Session expired, destroy session and redirect to login page
    $update_query = "UPDATE users SET is_logged_in=0 WHERE id='$id'";
    mysqli_query($conn, $update_query);
    session_unset();    
    session_destroy();
    echo'<script>alert("Session Expired. Please Login Again.");</script>';
    echo("<script>window.location = '../loginForm.php';</script>");
    exit;
}
// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();

if (isset($_POST['submit2'])) {

  // Get the uploaded file and open it for reading
  $csv_file = $_FILES['csv_file']['tmp_name'];
  $handle = fopen($csv_file, "r");

  // Create an array to hold the parsed CSV data
  $csv_data = array();

  // Parse the CSV data into an array
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $csv_data[] = array_map(function($value) use ($conn) {
      return mysqli_real_escape_string($conn, $value);
    }, $data);
  }

  // Close the CSV file
  fclose($handle);

  // Loop through the CSV data and format it as SQL INSERT or UPDATE statements
  foreach ($csv_data as $row) {
    $sql = "INSERT INTO studentinfo (stdnt_Course, stdnt_Major, stdnt_StudentNo, stdnt_Lastname, stdnt_Firstname, stdnt_MName) VALUES ('" . implode("', '",  $row) . "') ON DUPLICATE KEY UPDATE stdnt_Course = VALUES(stdnt_Course), stdnt_Major = VALUES(stdnt_Major), stdnt_StudentNo = VALUES(stdnt_StudentNo), stdnt_Lastname = VALUES(stdnt_Lastname), stdnt_Firstname = VALUES(stdnt_Firstname), stdnt_MName = VALUES(stdnt_MName); \n";
    mysqli_query($conn, $sql);
  }

  // Close the database connection
  mysqli_close($conn);

  echo '<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">';
  echo '  <div class="modal-dialog" role="document">';
  echo '    <div class="modal-content">';
  echo '      <div class="modal-header">';
  echo '        <h5 class="modal-title" id="successModalLabel">CSV Import Success</h5>';
  echo '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
  echo '          <span aria-hidden="true">&times;</span>';
  echo '        </button>';
  echo '      </div>';
  echo '      <div class="modal-body">';
  echo '        <p>Your CSV file has been imported successfully.</p>';
  echo '      </div>';
  echo '      <div class="modal-footer">';
  echo '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
  echo '      </div>';
  echo '    </div>';
  echo '  </div>';
  echo '</div>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Document</title>
</head>
<body>
<div class="container">
        <div class="jumbotron">
        <div class="card">
                <h2 class="mx-3"> Import Student Data </h2>
            </div>
            <div class="card">
                <div class="card-body">
                <button type="button" data-toggle="modal" class="btn btn-outline-success" data-target="#importModal">
                     Import CSV
                </button>
                </div>
            </div>
<br>
            <div class="card">
                <h2 class="mx-3"> Report Generation </h2>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form id="filterForm" method="post" action="export.php">
                    <div class="row">
                        <div class="form-group col">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <div class="form-group col">
                            <label for="">TransactionType:</label>
                            <select id="TransacType" class="form-control" name="TransacType">
                                <option value="request">Request</option>
                                <option value="claim">Claim</option>
                            </select>
                        </div>  
                    </div>

                    <div class="row">
                        <div class="form-group col">
                            <label for="start-date">Start Date:</label>
                            <input type="date" class="form-control" id="start-date" name="start-date">
                        </div>

                        <div class="form-group col">
                            <label for="end-date">End Date:</label>
                            <input type="date" class="form-control" id="end-date" name="end-date">
                        </div>  
                    </div>


                    <button type="submit" name="filterexport" class="btn btn-primary filterexport" data-toggle="modal">
                        Filter & Export
                    </button>

                    <button type="submit"  name="exportall" class="btn btn-primary exportall" data-toggle="modal">
                        Export All
                    </button>
                </form>
                </div>
            </div>
<br>
           

           


        </div>
    </div>
<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import CSV File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <sp class="text-danger"><i>Important Reminder: This import function is only intended for updating or inserting new student data</i></p>
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            
            <label for="csv_file">Choose CSV File:</label>
            <input type="file" class="form-control-file" name="csv_file" id="csv_file">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="submit2" class="btn btn-primary">Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2">Importing CSV file...</p>
      </div>
    </div>
  </div>
</div>

<script>
 $(document).ready(function() {
  // When the form is submitted, show the loading modal
  $('#importModal').submit(function() {
    $('#loadingModal').modal('show');
  });

  // When the modal is hidden, reload the page
  $('#loadingModal').on('hidden.bs.modal', function() {
    location.reload();
  });
});

</script>

    <!-- <script>
document.getElementById("filterForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var name = document.getElementById("name").value;
    var startDate = document.getElementById("start-date").value;
    var endDate = document.getElementById("end-date").value;
    var TransacType = document.getElementById("TransacType").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "export.php?name=" + name + "&start-date=" + startDate + "&end-date=" + endDate + "&TransacType=" + TransacType, true);
    xhr.responseType = "blob";
    xhr.onload = function() {
        if (this.status === 200) {
            var blob = new Blob([this.response], {type: "text/csv"});
            var link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "data.csv";
            link.click();
            displayPreviewTable(name, startDate, endDate, TransacType);
        }
    };
    xhr.send();
});
</script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <?php
  // If the CSV file was imported successfully, display the success modal
  if(isset($_POST['submit2'])) {
    echo '<script>$("#successModal").modal("show");</script>';
  }
?>
</body>
</html>