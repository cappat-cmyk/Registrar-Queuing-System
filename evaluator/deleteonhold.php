<?php
include "../DBConnect.php";

// Get the user id
$delete_onhold = $_REQUEST['delete_onholdticket'];

$query = "DELETE FROM queue WHERE queue_id='$delete_onhold'";
$query_run = mysqli_query($conn, $query); 

if ($query_run) {
    $response = array(
        'status' => 'success',
        'message' => 'Ticket deleted successfully'
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Error deleting ticket'
    );
}

// Send response back to the AJAX request
header('Content-Type: application/json');
echo json_encode($response);
?>
