<?php
include "../DBConnect.php";
include "../DBConnect.php";

$evaluator_id = $_POST['evaluatorId'];
$course = $_POST['course'];

$query = "SELECT Evaluator_id FROM courselist WHERE course_id = '$course'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$name = $row['Evaluator_id'];

$query2 = "SELECT CONCAT(First_Name, ' ', Last_Name) AS name FROM users WHERE id = '$name'";
$result2 = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_assoc($result2);

echo $row2['name'];

?>
