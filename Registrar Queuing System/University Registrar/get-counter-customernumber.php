<?php

include "../DBConnect.php";

// Retrieve data from the database
$dateStr = $_POST['date'];
$dateParts = explode('/', $dateStr);

if(count($dateParts) >= 2) {
  $month = ($dateParts[0] == '') ? null : intval($dateParts[0]);
  $day = ($dateParts[1] == '00') ? null : intval($dateParts[1]);
  $year = intval($dateParts[2]);
  
  // Retrieve data from the database
  $sql="SELECT 
    u.CounterNumber, 
    q.client_type,
    COUNT(q.counter_id) AS count,
    SUM(q.status = 'Waiting') AS waiting_count,
    SUM(q.status = 'Served') AS served_count,
    SUM(q.status = 'Hold') AS hold_count,
    COALESCE(th.incompleteCount, 0) AS incompleteCount,
    COALESCE(th.completeCount, 0) AS completeCount
  FROM users u
  LEFT JOIN queue q ON u.CounterNumber = q.counter_id 
    AND YEAR(q.arrivalTime) = '$year' 
    ".(($month != null) ? "AND MONTH(q.arrivalTime) = '$month'" : "")."
    ".(($day != null) ? "AND DAY(q.arrivalTime) = '$day'" : "")."
    AND q.client_type IN ('Student', 'Faculty', 'Others')
  LEFT JOIN (
    SELECT 
      handled_By, 
      COALESCE(SUM(th.status = 'incomplete'), 0) AS incompleteCount,
      COALESCE(SUM(th.status = 'finished'), 0) AS completeCount
    FROM transactionhistory th
    WHERE YEAR(th.arrivalTime) = '$year'
      ".(($month != null) ? "AND MONTH(th.arrivalTime) = '$month'" : "")."
      ".(($day != null) ? "AND DAY(th.arrivalTime) = '$day'" : "")."
    GROUP BY handled_By
  ) th ON q.counter_id = th.handled_By
  WHERE u.CounterNumber != 0
  GROUP BY u.CounterNumber, q.client_type";

  $result = mysqli_query($conn, $sql);

  $data = array();

  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
      'counterNumber' => 'Counter '.$row['CounterNumber'],
      'clientType' => $row['client_type'],
      'count' => $row['count'],
      'waitingCount' => $row['waiting_count'],
      'holdCount'=>$row['hold_count'],
      'servedCount' => $row['served_count'],
      'incompleteCount' => $row['incompleteCount'],
      'completeCount' => $row['completeCount']
    );
  }

  // Return the data in JSON format
  header("Content-type: application/json");
  echo json_encode($data);

  // Close the database connection
  mysqli_close($conn);
}
