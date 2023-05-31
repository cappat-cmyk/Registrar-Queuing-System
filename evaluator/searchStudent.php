<?php
include "../DBConnect.php";
// Get the studentId parameter from the AJAX request

if($_GET['studentId']){
$studentId = $_GET['studentId'];

// Prepare the SQL query to retrieve the student information based on the studentId
$sql = "SELECT stdnt_StudentNo, CONCAT(stdnt_Firstname, ' ', stdnt_MName, ' ', stdnt_LastName) AS name FROM studentinfo WHERE stdnt_StudentNo = '$studentId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $data = $result->fetch_assoc();
  $response = array("success" => true, "data" => $data);
} else {
  $response = array("success" => false);
}

echo json_encode($response);

$conn->close();
}
?>
