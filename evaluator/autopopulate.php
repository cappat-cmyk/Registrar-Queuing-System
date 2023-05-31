<?php
include "../DBConnect.php";


// Get the user id
$cstmr_fullname = $_REQUEST['searchfield'];

// Database connection


if ($cstmr_fullname !== "") {
	
	// Get corresponding first name and
	// last name for that user id	
	$query = "SELECT * FROM transactionhistory WHERE studentID='$cstmr_fullname' ORDER BY finishedAt DESC LIMIT 1";
    $query_run = mysqli_query($conn, $query); 

	$row = mysqli_fetch_array($query_run);

    
    $usertype = $row["client_type"];
    $studentid = $row["studentID"];
    $full_name = $row["fullname"];
	// Get the first name

	// Get the first name
    $ticketno = $row["ticketNumber"];
    $transactype = $row["transactionType"];
    $reqdocu = $row["requestedDocument"];
    $dept = $row["department"];
    $transactionstatus = $row["status"];
    $email = $row["email"];
    $additional_Info = $row["additional_Info"];
   
 




}

// Store it in a array
$result = array("$usertype", "$studentid", "$full_name", "$ticketno", "$transactype", "$dept", "$transactionstatus", "$reqdocu", "$email", "$additional_Info");

// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>
