<?php
header('Content-Type: application/json');

// Connect to the database
include "../DBConnect.php";

// Retrieve the customer information
$result = $conn->query("SELECT evaluated_by, ticket_number FROM queue WHERE status='Serving'");
$counters = [];
while ($row = $result->fetch_assoc()) {
    $counters[] = [
        'counter_id' => $row['evaluated_by'],
        'ticket_number' => $row['ticket_number']
    ];
}

// Output the customer information as a JSON object
echo json_encode($counters);
?>
