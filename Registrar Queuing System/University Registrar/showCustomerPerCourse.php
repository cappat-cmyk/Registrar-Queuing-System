<?php 
session_start();
include "SideBar_UniversityRegistrar.php";
include "../SessionTimeout.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Queue Count Bar Chart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
  <!-- Pinaltan ko ng online link nag eerror side bar pag yung offline link nakalagay -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../jquery/jquery.min.js"></script>
  <style>
    #chartcontainer{
      align-content:center;
      max-width: 1300px;
      max-height:450px;
    }
    /* customer count at the current day */
      .customer-count {
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

      /*  */
      #contain-course {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
      }

      .customer-count1 {
        margin: 5px;
        text-align: center;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 10px;
      }
      .customer-count:hover {
  background-color: #cfe3f9;
  cursor: pointer;
}

      /*  */
  </style>
</head>
<body>

<div class="jumbotron"> 
    <div class="d-flex justify-content-center">
      <div id="contain-course">
        <div id="course-data" class="row justify-content-center"></div>
    </div>
  </div>
</div>

<script>
function getCourse() {
  var filterDate = localStorage.getItem('filterdateofdashboard');
  $.ajax({
    url: 'getCustomerPerCourse.php',
    type: "POST",
    data: { date: filterDate },
    dataType: 'json',
    success: function (data) {
      console.log(data);
      var output = '';
      $.each(data, function (key, value) {
        console.log(data);
        output += '<div class="row justify-content-center text-center">';
        output += '<div class="customer-count" style="height: 18vh; width: 40vh;">';
        output += '<h6 class="fs-6" style="font-weight: bold">' + value.Course + '</h6>';
        output += '<span class="count">' + value.count + '</span>';
        output += '</div></div>';
        // Add a new row after every 4 columns
        if ((key + 1) % 4 === 0) {
          output += '</div><div class="row justify-content-center">';
        }
      });
      // Add the divs to a row
      var row = $('<div class="row justify-content-center"></div>').append(output);
      $('#course-data').html(row);
    },
    error: function () {
      $('#course-data').html('<p>Error loading course data.</p>');
    }
  });
}

getCourse();
</script>

</body>
</html>
