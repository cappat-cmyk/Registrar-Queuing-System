<?php
include "../DBConnect.php";

$id = $_GET['id'];
$counternumber = $_GET['counternumber'];
$value = $_GET['value'];

$current_date = date('Y-m-d');

if ($value == "next") {
    
    if($counternumber=="all"){
        $query = "SELECT q.*, u.*, s.*, c.* FROM queue AS q
        LEFT JOIN users AS u ON q.counter_id = u.CounterNumber
        LEFT JOIN studentinfo AS s ON q.client_id = s.stdnt_StudentNo
        LEFT JOIN credentials AS c ON q.requestCredentials = c.id
        WHERE q.status = 'Waiting'
        AND DATE(q.arrivalTime) = '$current_date'
        ORDER BY q.arrivalTime ASC LIMIT 1";
    }else{
        $query = "SELECT q.*, u.*, s.*, c.* FROM queue AS q
                  LEFT JOIN users AS u ON q.counter_id = u.CounterNumber
                  LEFT JOIN studentinfo AS s ON q.client_id = s.stdnt_StudentNo
                  LEFT JOIN credentials AS c ON q.requestCredentials = c.id
                  WHERE q.status = 'Waiting'
                  AND q.counter_id = '$counternumber'
                  AND DATE(q.arrivalTime) = '$current_date'
                  ORDER BY q.arrivalTime ASC LIMIT 1";
    }
}else{
    if($counternumber=="all"){
        $query = "SELECT q.*, u.*, s.*, c.* FROM queue AS q
        LEFT JOIN users AS u ON q.counter_id = u.CounterNumber
        LEFT JOIN studentinfo AS s ON q.client_id = s.stdnt_StudentNo
        LEFT JOIN credentials AS c ON q.requestCredentials = c.id
        WHERE q.status = 'Waiting'
        AND DATE(q.arrivalTime) = '$current_date'
        AND q.is_priority = 'yes'
        ORDER BY q.arrivalTime ASC LIMIT 1";
    }else{
    $query = "SELECT q.*, u.*, s.*, c.* FROM queue AS q
              LEFT JOIN users AS u ON q.counter_id = u.CounterNumber
              LEFT JOIN studentinfo AS s ON q.client_id = s.stdnt_StudentNo
              LEFT JOIN credentials AS c ON q.requestCredentials = c.id
              WHERE q.status = 'Waiting'
              AND q.counter_id = '$counternumber'
              AND DATE(q.arrivalTime) = '$current_date'
              AND q.is_priority = 'yes'
              ORDER BY q.arrivalTime ASC LIMIT 1";
    }
}
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);
    
    echo json_encode($customer);

mysqli_close($conn);
?>

