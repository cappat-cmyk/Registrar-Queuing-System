<?php
include "../DBConnect.php";

$course = $_POST['course'];

// Search for the name of the course, courseAbbr for ticket, Evaluatorid who handles it
$query = "SELECT * FROM courselist WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $course);
$stmt->execute();
$result = $stmt->get_result();
$course1 = $result->fetch_assoc();
$coursename = $course1['Course'];
$courseAbbr = $course1['CourseAbbr'];
$evaluatorId = $course1['Evaluator_id'];

// Find the counter it should go
$counterId = searchCounterId($evaluatorId);

$ticket_prefix = $courseAbbr;
$query = "SELECT * FROM queue WHERE ticket_number LIKE ? ORDER BY arrivalTime DESC LIMIT 1";
$stmt = $conn->prepare($query);
$search_param = $ticket_prefix . '%'; // define a variable to hold the value of the parameter
$stmt->bind_param("s", $search_param); // pass the variable to the bind_param method
$stmt->execute();
$result = $stmt->get_result();
$last_ticket = $result->fetch_assoc();

@$timestamp = $last_ticket['arrivalTime'];

if (empty($last_ticket) || $timestamp < date("Y-m-d")) {
    $incrementable_number = 1;
} else {
    $incrementable_number = (int) substr($last_ticket['ticket_number'], -3) + 1;
}

$ticket_number = $ticket_prefix . sprintf("%03d", $incrementable_number);

// Checking the role to add to the database
$usertype = $_POST['usertype'];

//applicable for all
$pwdornot = $_POST['pwdornot'];


// Initialize variables to empty strings
$studentId = '';
$studentname = '';
$email = '';
$requesttype = '';
$requestCredentials = '';

if ($usertype == "Student") {
    $requesttype = $_POST['requesttype'];
    if($requesttype=="Request"){
        $studentId = $_POST['studentid'];
        if($studentId!=''){
            $studentname = searchforName($studentId,$conn);
        }
        $email = $_POST['emailAddress'];
        $requestCredentials = $_POST['requestCredentials'];
    }
}
elseif ($usertype == "Faculty" || $usertype == "Others") {
    // No need to set any values for these user types
}

$mail = "asd";
 // Prepare the SQL query with placeholders for the values
 $query = "INSERT INTO queue (ticket_number, client_type, client_id, client_name, email, is_priority, transaction_type, requestCredentials, course_id, course_name, counter_id, Handled_by, evaluated_by, status, emailbody, arrivalTime) 
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
 $stmt = $conn->prepare($query);

 // Set default values for variables
 $handledBy = '';
 $status = 'Waiting';
 // set the time zone to Manila time
date_default_timezone_set('Asia/Manila');

// get the current date and time in Manila time
$current_date = date('Y-m-d H:i:s');

 // Bind the parameters to the prepared statement
 $stmt->bind_param("ssssssssssssssss", $ticket_number, $usertype, $studentId, $studentname, $email, $pwdornot, $requesttype, $requestCredentials, $course, $coursename, $counterId, $evaluatorId, $handledBy, $status, $mail, $current_date);

 // Execute the prepared statement to insert the new row into the queue table
 $stmt->execute();
function searchCounterId($evaluatorId)
{
    global $conn;
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $evaluatorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
   @ $counterId = $course['CounterNumber'];

    return $counterId;
}

function searchforName($studentId, $conn){
    $query = "SELECT stdnt_Firstname, stdnt_Mname, stdnt_Lastname FROM studentinfo WHERE stdnt_StudentNo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $studentFirstName = $course['stdnt_Firstname'];
    $studentLastName = $course['stdnt_Lastname'];
    $studentMName = $course['stdnt_Mname'];

    $fullName = $studentFirstName . ' ' . $studentMName . ' ' . $studentLastName;

    return $fullName;
}

echo json_encode($ticket_number);
?>