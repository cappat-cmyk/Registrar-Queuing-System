<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include "../DBConnect.php";

//   if (isset($_SESSION['id'])){ 
//     if($row['Role'] == "Evaluator") {
//     echo '<script>alert("You cannot access this page");</script>';
//     echo("<script>window.location = '../loginForm.php';</script>");
// }
// }
$getID = $_SESSION['id'];
$getCN = $_SESSION['CounterNumber'];

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
    if (!empty($start_date) && !empty($end_date)) {
        $sql .= " AND arrivalTime BETWEEN ? AND ?";
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
        mysqli_stmt_bind_param($stmt, "s", $end_date,);
    }
    
    // Execute statement
    mysqli_stmt_execute($stmt);
    
    // Get result set from statement
    $result = mysqli_stmt_get_result($stmt);
ob_end_clean();
// Set response headers for Excel file download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Filtered Transaction Details of Registrar Queuing System.xls"');

// Open file pointer to output stream
$output = fopen('php://output', 'w');

// Write headers to Excel file
fputcsv($output, array('ID', 'Counter Number', 'Handled By', 'Evaluated By', 'Client Type', 'Student ID', 'Full Name', 'Email', 'Is Priority', 'Ticket Number', 'Transaction Type', 'Requested Document', 'Department', 'Status', 'Remarks Text Area', 'Additional Info', 'Arrival Time', 'Served At', 'Finished At', 'Average Waiting Time', 'Claim Date', 'Is Claimed'), "\t");

// Write rows to Excel file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row, "\t");
}

// Close file pointer
fclose($output);


}

elseif(isset($_POST['exportall']))
{ ob_end_clean();
    $sql = "SELECT * FROM transactionhistory";
    $result = mysqli_query($conn, $sql);
    
    // Set response headers for file download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Transaction Details of Registrar Queuing System.xls"');
    
    // Open file pointer to output stream
    $output = fopen('php://output', 'w');
    
    // Write headers to Excel file
    $header = array('ID', 'Counter Number', 'Handled By', 'Evaluated By', 'Client Type', 'Student ID', 'Full Name', 'Email', 'Is Priority', 'Ticket Number', 'Transaction Type', 'Requested Document', 'Department', 'Status', 'Remarks Text Area', 'Additional Info', 'Arrival Time', 'Served At', 'Finished At', 'Average Waiting Time', 'Claim Date', 'Is Claimed');
    fputcsv($output, $header, "\t");
    
    // Write rows to Excel file
    while ($row = mysqli_fetch_assoc($result)) {
    $row = array_map('utf8_decode', $row);
    fputcsv($output, $row, "\t");
    }
    
    // Close file pointer
    fclose($output);
    
    // Close database connection
    mysqli_close($conn);
    
}

elseif(isset($_POST['exportbyeval']))
{ ob_end_clean();
    $sql = "SELECT * FROM transactionhistory where counterNumber='$getID'";
    $result = mysqli_query($conn, $sql);
    
    // Set response headers for file download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Transaction Details of Counter Number ' . $getCN . '.xls"');

    
    // Open file pointer to output stream
    $output = fopen('php://output', 'w');
    
    // Write headers to Excel file
    $header = array('ID', 'Counter Number', 'Handled By', 'Evaluated By', 'Client Type', 'Student ID', 'Full Name', 'Email', 'Is Priority', 'Ticket Number', 'Transaction Type', 'Requested Document', 'Department', 'Status', 'Remarks Text Area', 'Additional Info', 'Arrival Time', 'Served At', 'Finished At', 'Average Waiting Time', 'Claim Date', 'Is Claimed');
    fputcsv($output, $header, "\t");
    
    // Write rows to Excel file
    while ($row = mysqli_fetch_assoc($result)) {
    $row = array_map('utf8_decode', $row);
    fputcsv($output, $row, "\t");
    }
    
    // Close file pointer
    fclose($output);
    
    // Close database connection
    mysqli_close($conn);
}
?>
