<?php
include "../DBConnect.php";


// Get the user id
$call_onhold = $_REQUEST['onholdticket'];

// Database connection


if ($call_onhold !== "") {
	
	// Get corresponding first name and
	// last name for that user id	
	$query = "SELECT * FROM queue WHERE queue_id='$call_onhold'";
    $query_run = mysqli_query($conn, $query); 

	$row = mysqli_fetch_array($query_run);

 
    $usertype = $row["client_type"];
    $studentid = $row["client_id"];
    $full_name = $row["client_name"];
	// Get the first name
    
	

	// Get the first name
	

    
    $ticketno = $row["ticket_number"];
    $transactype = $row["transaction_type"];
    $reqdocu = $row["requestCredentials"];
    $dept = $row["course_name"];
    $transactionstatus = $row["status"];
    $email = $row["email"];
    $emailBody = $row["emailbody"];
 
 




}

// Store it in a array
$result = array("$usertype", "$studentid", "$full_name", "$ticketno", "$transactype", "$dept", "$transactionstatus", "$reqdocu", "$email", "$emailBody");

// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>
