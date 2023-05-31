<?php
include "../DBConnect.php";

$course = $_POST['course'];
$evaluator = $_POST['evaluator'];
$replace = $_POST['replace'];

$query = "SELECT * FROM courselist WHERE course_id = '$course'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if($row['Evaluator_id'] = '0' || $replace == true){
    $query = "UPDATE courselist SET Evaluator_id = '$evaluator' WHERE course_id = '$course'";
    $result = mysqli_query($conn, $query);
    echo 1;
}else{
    echo 0;
}

?>