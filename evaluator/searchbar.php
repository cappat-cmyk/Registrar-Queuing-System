<?php

// Connect to database
include "../DBConnect.php";

// Retrieve search query from POST parameter
// Retrieve search query from POST parameter
$query = $_POST['query'];

// Query database for matching results
$sql = "SELECT DISTINCT studentID, fullname, ticketNumber 
        FROM transactionhistory 
        WHERE studentID LIKE '%$query%' 
        OR fullname LIKE '%$query%' 
        ORDER BY finishedAt DESC
        LIMIT 1";

$result = $conn->query($sql);

// Return results as HTML list
while ($row = $result->fetch_assoc()) {
    echo '<li>' . $row['studentID'] . ' - ' . $row['fullname'].'</li>';
}


?>

