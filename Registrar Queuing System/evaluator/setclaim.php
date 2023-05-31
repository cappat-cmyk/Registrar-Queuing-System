<?php
     include "../DBConnect.php";

    $transact_id = $_POST['transact_id'];

    $query = "UPDATE transactionhistory SET is_claimed='yes' WHERE transact_id='$transact_id'  ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $response = array('status' => 'success');
    }
    else
    {
        $response = array('status' => 'error');
    }

    echo json_encode($response);
?>
