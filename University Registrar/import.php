<?php
session_start();

include "../DBConnect.php";

if (isset($_POST['submit2'])) {

// Get the uploaded file and open it for reading
$csv_file = $_FILES['csv_file']['tmp_name'];
$handle = fopen($csv_file, "r");

// Create an array to hold the parsed CSV data
$csv_data = array();

// Parse the CSV data into an array
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
  $csv_data[] = array_map(function($value) use ($conn) {
    return mysqli_real_escape_string($conn, $value);
  }, $data);
}

// Close the CSV file
fclose($handle);

// Loop through the CSV data and format it as SQL INSERT or UPDATE statements
foreach ($csv_data as $row) {
  $sql = "INSERT INTO studentinfo (stdnt_Course, stdnt_Major, stdnt_StudentNo, stdnt_Lastname, stdnt_Firstname, stdnt_MName) VALUES ('" . implode("', '",  $row) . "') ON DUPLICATE KEY UPDATE stdnt_Course = VALUES(stdnt_Course), stdnt_Major = VALUES(stdnt_Major), stdnt_StudentNo = VALUES(stdnt_StudentNo), stdnt_Lastname = VALUES(stdnt_Lastname), stdnt_Firstname = VALUES(stdnt_Firstname), stdnt_MName = VALUES(stdnt_MName); \n";
  mysqli_query($conn, $sql);
}

// Close the database connection
mysqli_close($conn);

echo'<script>alert("Data Import Successful");</script>';
echo("<script>window.location = 'ReportGeneration&Import.php';</script>");
}

?>