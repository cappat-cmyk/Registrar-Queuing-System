<?php
include "DBConnect.php";


// Get the user id
$cstmr_fullname = $_REQUEST['searchfield'];

// Database connection


if ($cstmr_fullname !== "") {
	
	// Get corresponding first name and
	// last name for that user id	
	$query = "SELECT * FROM transactionhistory WHERE Fullname='$cstmr_fullname'";
    $query_run = mysqli_query($conn, $query); 

	$row = mysqli_fetch_array($query_run);

    $transac_id = $row["transac_id"];
    $full_name = $row["Fullname"];
	// Get the first name
    $usertype = $row["UserType"];
	$studentid = $row["StudentID"];

	// Get the first name
	

    
    $ticketno = $row["TicketNumber"];
    $transactype = $row["TransactionType"];
    $reqdocu = $row["RequestedDocument"];
    $dept = $row["Department"];
    $stdntstatus = $row["StudentStatus"];
    $claimdate = $row["ClaimDate"];
    $remarks = $row["Remarks"];
 




}

// Store it in a array
$result = array("$full_name", "$usertype", "$usertype", "$ticketno", "$transactype", "$reqdocu", "$dept", "$stdntstatus", "$claimdate", $remarks);

// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>
