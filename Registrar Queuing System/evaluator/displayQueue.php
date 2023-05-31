<?php
include "../DBConnect.php";

$counternumber = $_GET['counternumber'];
$id = $_GET['id'];
date_default_timezone_set('Asia/Manila');
$current_date = date('Y-m-d');


    $query = "SELECT * FROM queue WHERE Status='Waiting' AND counter_id='$counternumber' AND DATE(queue.arrivalTime) = '$current_date' ORDER BY DATE(queue.arrivalTime) ASC LIMIT 5";
    $result = mysqli_query($conn, $query);
    $queue = array();
    while($row = mysqli_fetch_assoc($result)) {
        $queue[] = $row;
    }
    echo json_encode($queue);
    mysqli_close($conn);

?>
