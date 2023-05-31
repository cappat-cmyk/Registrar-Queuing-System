<?php
include "../DBConnect.php";

$customerId = $_POST["customerId"];
$servedBy = $_POST["servedBy"];

$query = "UPDATE queue SET status='Serving', evaluated_by='$servedBy' WHERE queue_id='$customerId'";
$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>
