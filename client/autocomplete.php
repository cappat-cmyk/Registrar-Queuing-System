<?php

// Connect to database
include "../DBConnect.php";

// Retrieve search query from POST parameter
// Retrieve search query from POST parameter
$query = $_POST['query'];

// Query database for matching results
$sql = "SELECT * FROM studentinfo 
        WHERE stdnt_StudentNo LIKE '%$query%' 
        OR CONCAT(stdnt_Lastname, ', ', stdnt_Firstname) LIKE '%$query%'
        LIMIT 10";
$result = $conn->query($sql);

// Return results as HTML list
while ($row = $result->fetch_assoc()) {
    echo '<li>' . $row['stdnt_StudentNo'] . ' - ' . $row['stdnt_Lastname'] . ', ' . $row['stdnt_Firstname'] . '</li>';
}


?>

