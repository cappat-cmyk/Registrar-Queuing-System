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
                            <select class="form-select form-control" aria-label=".form-select-sm example" id="EvaluatorsOption" name="EvaluatorsOption">
        <?php
       

                $result = $conn->query("SELECT First_Name, Last_Name, CounterNumber, Role FROM users where Role='Evaluator' ORDER BY First_Name ASC");

                // Get the selected item
                $selected = isset($_POST['First_Name']) ? $_POST['First_Name'] : '';
                
                // Generate the option elements
                while ($row = $result->fetch_assoc()) {
                  $id = $row['CounterNumber'];
                  $name = $row['First_Name'].' '.$row['Last_Name'];
                  $selectedAttr = $id == $selected ? 'selected' : '';
                  echo "<option value='$id' $selectedAttr>$name</option>";
                }

               ?>
    </select>
    
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
                            <input type="datetime-local" class="form-control" id="start-date" name="start-date">
                        </div>

                        <div class="form-group col">
                            <label for="end-date">End Date:</label>
                            <input type="datetime-local" class="form-control" id="end-date" name="end-date">
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
        <form method="post" action="import.php" enctype="multipart/form-data">
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
    window.location = 'UniversityRegistrarDashboard.php';;
  });
});

</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    
    
</body>
</html>