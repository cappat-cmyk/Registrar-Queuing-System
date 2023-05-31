<?php
session_start();
include "../DBConnect.php";

// Retrieve the data properties from the $_POST superglobal array
$customerId=$_POST['customerId'];
$counterId = $_POST['counterId'];
$evaluatedBy = $_POST['evaluated_By'];
$clientType = $_POST['client_type'];
$clientID = $_POST['client_id'];
$clientName = $_POST['client_name'];
$email = $_POST['email'];
$isPriority = $_POST['is_priority'];
$ticketNumber = $_POST['ticket_number'];
$transactionType = $_POST['transaction_type'];
$credential = $_POST['credential'];
$department = $_POST['department'];
$status = $_POST['status'];
$remarks = $_POST['remarksTextArea'];
$additionalInfo = $_POST['additonal_info'];
$arrivalTime = $_POST['arrivalTime'];
$servedAt = $_POST['servedAt'];
$finishedAt = $_POST['finishedAt'];
$claimDate = $_POST['claimDate'];
$isClaimed = $_POST['is_claimed'];
$mail = $_POST['emailbody'];

if($status == 'finished' || $status == 'incomplete'){
$sql = "INSERT INTO transactionhistory (counterNumber, handled_By, evaluated_By, client_type, studentID, fullname, email, is_priority, ticketNumber, transactionType, requestedDocument, department, status, remarksTextArea, additional_Info, arrivalTime, servedAt, finishedAt, claimDate, is_claimed) VALUES (?, (SELECT CONCAT(First_Name, ' ', Last_Name) AS Full_Name FROM users WHERE CounterNumber = ?), (SELECT CONCAT(First_Name, ' ', Last_Name) AS Full_Name FROM users WHERE CounterNumber = ?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssssssssss", $customerId, $counterId, $evaluatedBy, $clientType, $clientID, $clientName, $email, $isPriority, $ticketNumber, $transactionType, $credential, $department, $status, $remarks, $additionalInfo, $arrivalTime, $servedAt, $finishedAt, $claimDate, $isClaimed);

// Execute the SQL query
if ($stmt->execute()) {
    echo "Transaction saved successfully";
    $query = "UPDATE queue SET status='Served', evaluated_By='$evaluatedBy' WHERE arrivalTime='$arrivalTime'";
    $query_run = mysqli_query($conn, $query);

    $avgwaitime = "SELECT arrivalTime, finishedAt FROM transactionhistory ORDER BY transact_id DESC LIMIT 1";
    $resultavg = $conn->query($avgwaitime);
    if ($resultavg->num_rows > 0) {
        $row = $resultavg->fetch_assoc();
        $datetime1 = new DateTime($row['arrivalTime']);
        $datetime2 = new DateTime($row['finishedAt']);
    
        $interval = $datetime1->diff($datetime2);
    
        // Update the table with the calculated difference
        $sql3 = "UPDATE transactionhistory SET avgwaitingtime = '" . $interval->format('%h:%i:%s') . "' ORDER BY transact_id DESC LIMIT 1";
        $conn->query($sql3);

        $sql4 = "UPDATE transactionhistory SET is_claimed='yes' WHERE claimDate='0000-00-00' ORDER BY transact_id DESC LIMIT 1";
        $conn->query($sql4);
    }
    
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error: " . $errorInfo[2];
}

}
elseif($status == 'onhold'){
    $query = "UPDATE queue SET status='$status', evaluated_By='$evaluatedBy', emailbody='$mail' WHERE arrivalTime='$arrivalTime'";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        echo'<script>alert("Session Expired. Please Login Again.");</script>';
        echo("<script>window.location = '../loginForm.php';</script>");
       
    } else {

    }
    
}
?>

