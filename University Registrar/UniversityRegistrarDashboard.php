<?php 
session_start();
include "SideBar_UniversityRegistrar.php";
include "../SessionTimeout.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Queue Count Bar Chart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../jquery/jquery.min.js"></script>
  <style>
    #myPieChart {
      width: 450px;
      height: 450px;
    }

    .myChart{
      width:90%;
    }
    .customer-count {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
        padding: 20px;
        border-radius: 10px;
      }

      .label {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
      }

      .count {
        font-size: 36px;
        font-weight: bold;
        color: #007bff;
      }

      .count1 {
        font-size: 36px;
        font-weight: bold;
        color: #007bff;
      }
      .container, .counterStatus{
        width:100%;
      }
      .chartContainer{
        width:600px;
      }
  </style>
</head>
<body>
<div class="mt-5"></div>
  <div class="mt-7 customer-count">
    <h1>Dashboard</h1>
    <span id="date"></span>
</div>

<!-- filter for the date of want to revealed -->
<div>
<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-3">
      <select id="dayFilter" class="form-select">
          <option value="">Select Day</option>
            <!-- Add options for all days in a month -->
            <?php for ($i=1; $i<=31; $i++) { ?>
              <?php $day = str_pad($i, 2, '0', STR_PAD_LEFT); ?>
              <option value="<?= $day ?>"><?= $day ?></option>
            <?php } ?>
    </select>
    </div>
    <div class="col-md-3">
            <select id="monthFilter" class="form-select">
        <option value="">Select Month</option>
        <!-- Add options for all months in a year -->
        <?php for ($i=1; $i<=12; $i++) { ?>
          <option value="<?= $i ?>"><?= date('F', strtotime("2023-$i-01")) ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-3">
        <select id="yearFilter" class="form-select">
            <option value="">Select Year</option>
            <!-- Add options for the past 2 years and the current year -->
            <?php $current_year = date('Y'); ?>
            <?php for ($i=0; $i<3; $i++) { ?>
              <option value="<?= $current_year - $i ?>"><?= $current_year - $i ?></option>
            <?php } ?>
      </select>
    </div>
    <div class="col-md-3">
      <button id="applyFilter" class="btn btn-primary">Apply Filter</button>
      <button id="clearFilter" class="btn btn-secondary">Clear Filter</button>
    </div>
  </div>
</div>

<!-- For Pie Chart -->
<div class="mt-5"></div>
<div class="container">
  <div class="row">
    <div class="col">
      <div id="chartcontainer">
        <canvas id="myPieChart"></canvas>
      </div>
    </div>
    <div class="col-3" id="totalnumberofusers">
      <div class="customer-count my-3">
        <span class="label text-center" id="numofcustomers">Total Number of Customers</span>
        <span class="count"></span>
      </div>
      
      <div class="customer-count" id="numofcounters" id="totalnumberofcounters">
        <span class="label">Total Number of Counters</span>
        <span class="count1"></span>
      </div>

      <?php
      include "../DBConnect.php";
      $stmt = $conn->query('SELECT * FROM users where CounterNumber!=0 order by CounterNumber asc');
      $users = mysqli_fetch_all($stmt, MYSQLI_ASSOC);

      echo '<div class="row d-flex row-cols-lg-auto g-3 justify-content-center text-center align-middle counterStatus ">';
      foreach ($users as $user) {
          $counterNumbers = $user['CounterNumber'];
          $status = $user['is_logged_in'];
          $name = $user['First_Name'] . ' ' . $user['Last_Name'];
          $bgColor = '';
          if ($status == '1') {
              $bgColor = 'darkgreen';
          } else {
              $bgColor = 'darkred';
          }
          $textColor= 'white';

          echo '<div class="col-sm-2 mx-2 mt-5 align-items-center " style="background-color: ' . $bgColor . '; color: ' . $textColor . '; ">';
          // echo '<span class="fs-5 align-middle mt-10 " style="font-weight:bold;">' .$name .'</span>';
          echo '<div class="fs-1 align-middle">' . $counterNumbers . '</div>';
          echo '</div>';
      }
      echo '</div>';


      ?>
    </div>
  </div>
</div>


    <!-- For Bar Chart -->
<div class="container mt-5">
  <div class="row">
    <div class="col mb-5">

      <div id="chartcontainer">
        <h1 class="mt-7 customer-count">NUMBER OF CLIENTS PER STATUS</h1>
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- This will be for the chart -->
<script>
 let chart;

 const options = {
  year: 'numeric',
  month: '2-digit',
  day: '2-digit',
  timeZone: 'Asia/Manila'
};

const now = new Date().toLocaleString('en-US', options);
const formattedDate = now.slice(0, 10); // Extract the first 10 characters

document.getElementById("date").innerHTML = formattedDate;

function updateData(date) {
  // AJAX request to get data from PHP file
  $.ajax({
    url: "get-counter-customernumber.php",
    type: "POST",
    data: { date: date },
    dataType: "json",
    success: function(data) {
      console.log(data);

      const counterData = {};

// loop through the data and add the count and waiting/served/complete/incomplete count to the corresponding counter in the dictionary
for (let i = 0; i < data.length; i++) {
  const counter = data[i].counterNumber;

  if (!counterData[counter]) {
    // create default object for this counter with only the counts for the client types that have been encountered so far
    counterData[counter] = {
      count: 0,
      waitingCount: 0,
      servedCount: 0,
      completeCount: 0,
      incompleteCount: 0,
      facultyCount: 0,
      studentCount: 0,
      otherCount: 0,
      holdCount: 0
    };
  }

  // update counts for this counter
  counterData[counter].count += parseInt(data[i].count);
  counterData[counter].waitingCount += parseInt(data[i].waitingCount || 0);
  counterData[counter].servedCount += parseInt(data[i].servedCount || 0);
  counterData[counter].completeCount += parseInt(data[i].completeCount || 0);
  counterData[counter].incompleteCount += parseInt(data[i].incompleteCount || 0);
  counterData[counter].holdCount += parseInt(data[i].holdCount || 0);

  // update client type counts for this counter
  if (data[i].clientType === 'Faculty') {
    counterData[counter].facultyCount += parseInt(data[i].count);
  } else if (data[i].clientType === 'Student') {
    counterData[counter].studentCount += parseInt(data[i].count);
  } else if (data[i].clientType === 'Others') {
    counterData[counter].otherCount += parseInt(data[i].count);
  }
}

// create arrays for counter numbers, count of each client type, and waiting/served/complete/incomplete count
const count=[];
const counterNumbers = [];
const facultyCount = [];
const studentCount = [];
const otherCount = [];
const waitingCount = [];
const servedCount = [];
const completeCount = [];
const incompleteCount = [];
const holdCount = [];

// loop through the counterData dictionary and extract necessary information
for (const [counter, data] of Object.entries(counterData)) {
  count.push(data.count);
  counterNumbers.push(counter);
  facultyCount.push(data.facultyCount);
  studentCount.push(data.studentCount);
  otherCount.push(data.otherCount);
  waitingCount.push(data.waitingCount);
  servedCount.push(data.servedCount);
  completeCount.push(data.completeCount);
  incompleteCount.push(data.incompleteCount);
  holdCount.push(data.holdCount);
}


// Get all the chart instances
const charts = Chart.instances;

// Loop through all the charts and destroy them
for (const chart in charts) {
  charts[chart].destroy();
}


// create chart using Chart.js, it is a bar chart
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: counterNumbers,
    datasets: [
      {
        label: 'Faculty',
        data: facultyCount,
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
				borderColor: 'rgb(255, 99, 132)',
        borderWidth: 1,
        hidden: true // initially hidden
      },
      {
        label: 'Student',
        data: studentCount,
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgb(54, 162, 235)',
        borderWidth: 1
      },
      {
        label: 'Others',
        data: otherCount,
        backgroundColor: 'rgba(255, 206, 86, 0.2)',
        borderColor: 'rgba(255, 206, 86, 1)',
        borderWidth: 1
      },
      {
        label: 'Waiting',
        data: waitingCount,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      },
      {
      label: 'Served',
      data: servedCount,
      backgroundColor: 'rgba(153, 102, 255, 0.2)',
      borderColor: 'rgba(153, 102, 255, 1)',
      borderWidth: 1
      },
      {
      label: 'On-Hold',
      data: holdCount,
      backgroundColor: 'rgba(153, 102, 255, 0.2)',
      borderColor: 'rgba(153, 102, 255, 1)',
      borderWidth: 1
      },
      {
      label: 'Complete Transactions',
      data: completeCount,
      backgroundColor: 'rgba(153, 102, 255, 0.2)',
      borderColor: 'rgba(153, 102, 255, 1)',
      borderWidth: 1
      },
      {
      label: 'Incomplete Transactions',
      data: incompleteCount,
      backgroundColor: 'rgba(153, 102, 255, 0.2)',
      borderColor: 'rgba(153, 102, 255, 1)',
      borderWidth: 1
      }
      ]
      },
      options: {
      scales: {
      y: {
      beginAtZero: true
      }
      }
      }
      });

      // This is the pie chart for the number of customers each counter
        const ctx1 = document.getElementById('myPieChart').getContext('2d');
        console.log(count);
        const myPieChart = new Chart(ctx1, {
          type: 'doughnut',
          data: {
            labels: counterNumbers,
            datasets: [
              {
                data: count,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.5)',
                  'rgba(54, 162, 235, 0.5)',
                  'rgba(255, 206, 86, 0.5)',
                  'rgba(153, 102, 255, 0.5)',
                  'rgba(255, 159, 64, 0.5)',
                  'rgba(255, 99, 132, 0.5)',
                  'rgba(54, 162, 235, 0.5)'
                ]
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false
          }
        });

      // Calculate the total customer count
let totalCustomers = 0;
for (const counter of Object.keys(counterData)) {
  totalCustomers += counterData[counter].count;
}
// Update the customer count
$('.count').text(totalCustomers);

// Update the counter count
const totalCounters = Object.keys(counterData).length;
$('.count1').text(totalCounters);

}
});


}

// Call the updateData function initially
localStorage.setItem('filterdateofdashboard', formattedDate);
updateData(formattedDate);

$('#applyFilter').click(function() {
    // Get selected values
    var day = $('#dayFilter').val();
    var month = $('#monthFilter').val();
    var year = $('#yearFilter').val();

    // Construct date string
    var dateStr = month + '/' + day.padStart(2, '0') + '/' + year.padStart(2, '0');
    localStorage.setItem('filterdateofdashboard', dateStr);
    updateData(dateStr);
  });

  $('#clearFilter').click(function() {
    // Reset filter values
    $('#dayFilter').val('');
    $('#monthFilter').val('');
    $('#yearFilter').val('');
  });

// Set an interval to call the updateData function every minute
setInterval(updateData, 60000);

</script>
<!-- This will be the link if the certain div is clicked -->
<script>
  $("#totalnumberofusers").click(function(){
      window.location.href="showCustomerPerCourse.php";
  });

  // $("#totalnumberofcounters").click(function(){
  //     window.location.href="";
  // });
</script>
</html>