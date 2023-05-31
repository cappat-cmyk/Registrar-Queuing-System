<?php
// this is for the next button
include "../DBConnect.php";
$id = $_GET['id'];
$counternumber = $_GET['counternumber'];
date_default_timezone_set('Asia/Manila');
$value=$_GET['value'];

if ($value=="next") {
      $current_date = date('Y-m-d');
      $counternumber = $_GET['counternumber'];
      
      $query = "SELECT * FROM queue WHERE queue.status = 'Waiting'
              AND queue.counter_id = '$counternumber'
              AND DATE(queue.arrivalTime) = '$current_date'
              ORDER BY queue.arrivalTime ASC LIMIT 1";

  $result = mysqli_query($conn, $query);
  $customer = mysqli_fetch_assoc($result);

        if ($customer['client_type'] == "Student" && $customer['transaction_type'] == "Request") {
            $join_tables = array();
            if (!is_null($customer['counter_id'])) {
                $join_tables[] = "JOIN users ON queue.counter_id = users.CounterNumber";
            }
            if (!is_null($customer['client_id'])) {
                $join_tables[] = "JOIN studentinfo ON queue.client_id = studentinfo.stdnt_StudentNo";
            }
            if (!is_null($customer['requestCredentials'])) {
                $join_tables[] = "JOIN credentials ON queue.requestCredentials = credentials.id";
            }
            $join_clause = implode(" ", $join_tables);

            $query = "SELECT queue.*, users.*, studentinfo.*, credentials.* FROM queue
                      $join_clause
                      WHERE queue.queue_id = ".$customer['queue_id'];

            $result = mysqli_query($conn, $query);
            $customer = mysqli_fetch_assoc($result);
        }
        echo json_encode($customer);
        mysqli_close($conn);
}
elseif ($value=="pwd"){
    $current_date = date('Y-m-d');
      $counternumber = $_GET['counternumber'];
      
      $query = "SELECT * FROM queue WHERE queue.status = 'Waiting'
              AND queue.counter_id = '$counternumber'
              AND DATE(queue.arrivalTime) = '$current_date'
              AND queue.is_priority='yes'
              ORDER BY queue.arrivalTime ASC LIMIT 1";

            $result = mysqli_query($conn, $query);
            $customer = mysqli_fetch_assoc($result);

        if ($customer['client_type'] == "Student" && $customer['transaction_type'] == "Request") {
            $join_tables = array();
            if (!is_null($customer['counter_id'])) {
                $join_tables[] = "JOIN users ON queue.counter_id = users.CounterNumber";
            }
            if (!is_null($customer['client_id'])) {
                $join_tables[] = "JOIN studentinfo ON queue.client_id = studentinfo.stdnt_StudentNo";
            }
            if (!is_null($customer['requestCredentials'])) {
                $join_tables[] = "JOIN credentials ON queue.requestCredentials = credentials.id";
            }
            $join_clause = implode(" ", $join_tables);

            $query = "SELECT queue.*, users.*, studentinfo.*, credentials.* FROM queue
                      $join_clause
                      WHERE queue.queue_id = ".$customer['queue_id'];

            $result = mysqli_query($conn, $query);
            $customer = mysqli_fetch_assoc($result);
        }
        echo json_encode($customer);
        mysqli_close($conn);
}

?>
