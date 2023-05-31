<?php
ob_start();
session_start();
include "../DBConnect.php";

//   if (isset($_SESSION['id'])){ 
//     if($row['Role'] == "Evaluator") {
//     echo '<script>alert("You cannot access this page");</script>';
//     echo("<script>window.location = '../loginForm.php';</script>");
// }
// }
$getID = $_SESSION['id'];

// PHP code to export the filtered table
if(isset($_POST['filterexport']))
{// Set default values
$name = '';
$start_date = '';
$end_date = '';
$column1 = '';

// Check if input fields are set and not empty
if (isset($_POST['TransacType']) && !empty($_POST['TransacType'])) {
    $name = $_POST['TransacType'];
}
if (isset($_POST['start-date']) && !empty($_POST['start-date'])) {
    $start_date = $_POST['start-date'];
}
if (isset($_POST['end-date']) && !empty($_POST['end-date'])) {
    $end_date = $_POST['end-date'];
}
if (isset($_POST['EvaluatorsOption']) && !empty($_POST['EvaluatorsOption'])) {
    $column1 = $_POST['EvaluatorsOption'];
}

// Create SQL query with optional filters
$sql = "SELECT handled_By, client_type, studentID, fullname, email, is_priority, ticketNumber, transactionType, requestedDocument, department, status, remarksTextArea, additional_Info, arrivalTime, servedAt, finishedAt, avgwaitingtime, claimDate, is_claimed FROM transactionhistory WHERE 1=1";

if (!empty($name)) {
    $sql .= " AND TransactionType = ?";
}
if (!empty($start_date)) {
    $sql .= " AND arrivalTime >= ?";
}
if (!empty($end_date)) {
    $sql .= " AND arrivalTime <= ?";
}
if (!empty($column1)) {
    $sql .= " AND handled_By = ?";
}

// Prepare statement
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to statement
if (!empty($name) && !empty($start_date) && !empty($end_date) && !empty($column1)) {
    mysqli_stmt_bind_param($stmt, "ssss", $name, $start_date, $end_date, $column1);
} else if (!empty($name) && !empty($start_date) && !empty($end_date)) {
    mysqli_stmt_bind_param($stmt, "sss", $name, $start_date, $end_date);
} else if (!empty($name) && !empty($column1)) {
    mysqli_stmt_bind_param($stmt, "ss", $name, $column1);
} else if (!empty($start_date) && !empty($end_date)) {
    mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
} else if (!empty($name)) {
    mysqli_stmt_bind_param($stmt, "s", $name);
} else if (!empty($column1)) {
    mysqli_stmt_bind_param($stmt, "s", $column1);
} else if (!empty($start_date)) {
    mysqli_stmt_bind_param($stmt, "s", $start_date);
} else if (!empty($end_date)) {
    mysqli_stmt_bind_param($stmt, "s", $end_date);
}

// Execute statement
mysqli_stmt_execute($stmt);

// Get result set from statement
$result = mysqli_stmt_get_result($stmt);
ob_end_clean();
// Set response headers for file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="data.csv"');

// Open file pointer to output stream
$output = fopen('php://output', 'w');

// Write headers to CSV file
fputcsv($output, array('Handled By', 'Client Type', 'Student ID', 'Name', 'Email', 'Priority', 'Ticket Number', 'Transaction Type', 'Requested Document', 'Department', 'Status', 'Remarks', 'Additional Info', 'Arrival Time', 'Served At', 'Finished At', 'Avg Waiting Time', 'Claim Date', 'Is Claimed'));

// Write rows to CSV file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close file pointer
fclose($output);

// Close database connection
mysqli_stmt_close($stmt);


}

elseif(isset($_POST['exportall']))
{ ob_end_clean();
    $sql = "SELECT * FROM transactionhistory";
    $result = mysqli_query($conn, $sql);

    // Set response headers for file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="data.csv"');
    
    // Open file pointer to output stream
    $output = fopen('php://output', 'w');
    
    // Write headers to CSV file
    fputcsv($output, array('ID', 'Full Name', 'Ticket Number', 'Transaction Type', 'Requested Document', 'Department', 'Student Type', 'Transaction Status', 'Remarks TextArea', 'Claim Date', 'Email', 'ClaimCode', 'Remarks', 'Evaluated By', 'Counter Number'));
    
    // Write rows to CSV file
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
  
    // Close file pointer
    fclose($output);
    
    // Close database connection
    mysqli_close($conn); 
    
}

elseif(isset($_POST['exportbyeval']))
{ ob_end_clean();
    $sql = "SELECT * FROM transactionhistory  WHERE counterNumber='$getID'";
    $result = mysqli_query($conn, $sql);

    // Set response headers for file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="data.csv"');
    
    // Open file pointer to output stream
    $output = fopen('php://output', 'w');
    
    // Write headers to CSV file
    fputcsv($output, array('ID', 'Full Name', 'Ticket Number', 'Transaction Type', 'Requested Document', 'Department', 'Student Type', 'Transaction Status', 'Remarks TextArea', 'Claim Date', 'Email', 'ClaimCode', 'Remarks', 'Evaluated By', 'Counter Number'));
    
    // Write rows to CSV file
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
  
    // Close file pointer
    fclose($output);
    
    // Close database connection
    mysqli_close($conn); 
    
}
?>
