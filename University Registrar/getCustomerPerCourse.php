<?php
include "../DBConnect.php";

// Retrieve data from the database
$dateStr = $_POST['date'];
$dateParts = explode('/', $dateStr);

$day = '';
$month = '';
$year = '';

if(count($dateParts) == 1) {
  $year = intval($dateParts[0]);
} elseif (count($dateParts) >= 2) {
  $month = intval($dateParts[0]);
  $year = intval($dateParts[2]);

  if(count($dateParts) == 3) {
    $day = intval($dateParts[1]);
  }
}

// Retrieve data from the database
$sql = "SELECT c.course_id, c.Course, COUNT(q.course_id) AS count
        FROM courselist c
        LEFT JOIN queue q ON c.course_id = q.course_id ";

if ($year) {
  $sql .= "AND YEAR(q.arrivalTime) = '$year' ";
}

if ($month) {
  $sql .= "AND MONTH(q.arrivalTime) = '$month' ";
}

if ($day) {
  $sql .= "AND DAY(q.arrivalTime) = '$day' ";
}

$sql .= "GROUP BY c.course_id";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// Return the data in JSON format
header("Content-type: application/json");
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
