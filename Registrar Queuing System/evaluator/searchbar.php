<?php

include "../DBConnect.php";

$searchTerm = $_GET['term'];

$sql = "SELECT * FROM transactionhistory WHERE fullname LIKE '%".$searchTerm."%'"; 
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  $tutorialData = array(); 
  while($row = $result->fetch_assoc()) {


   $data['id']    = $row['fullname']; 
   $data['value'] = $row['fullname'];
   
   array_push($tutorialData, $data);
} 
}
 echo json_encode($tutorialData);
?>