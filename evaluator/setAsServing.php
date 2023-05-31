<?php
include "../DBConnect.php";

$ticketnumber = $_POST["ticketnumber"];
$servedBy = $_POST["servedBy"];
$current_date = date('Y-m-d');

$query = "UPDATE queue SET status='Serving', evaluated_by='$servedBy' WHERE ticket_number='$ticketnumber' AND DATE(arrivalTime)='$current_date'";
$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>
