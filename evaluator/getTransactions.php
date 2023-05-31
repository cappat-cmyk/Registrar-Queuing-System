<?php

include "../DBConnect.php";
// Get the studentID from the AJAX call
$studentID = $_POST['studentID'];

// Retrieve the transaction details for the studentID
$sql = "SELECT fullname, arrivalTime, requestedDocument FROM transactionhistory WHERE studentID = '$studentID' order by arrivalTime DESC LIMIT 3 ";
$result = mysqli_query($conn, $sql);

// Create an array to store the transaction details
$transactions = array();
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}

// Return the transaction details as JSON data
echo json_encode($transactions);

// Close the database connection
mysqli_close($conn);
?>
