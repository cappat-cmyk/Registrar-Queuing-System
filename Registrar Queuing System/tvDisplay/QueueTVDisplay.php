<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueueTVDisplay</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
          background-color: whitesmoke;
        }
        .col1 {
            height: 870px;
        }
        .transactionhistorytable {
            text-align: center;
            width: 100%;
            height: 600px;
        }
        .thead {
            background-color: #012265;
            color:#FFDE00;
            height: 100px;
            font-size: 2rem;
        }
        td {
            font-size: 2rem;
            text-align: center;
        }
        .form-control {
            max-width: 20%;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-12 md-12 lg-12 class mt-2"> 
            <div class="table-responsive">
            <table id="myTable" class="table table-striped table-hover transactionhistorytable">
                <thead class="thead">
                <tr>
                <th>Counter</th>
                <th>Ticket</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>1</td>
                <td id="counter1" class="TicketNumber"></td>
                </tr>

                <tr>
                <td>2</td>
                <td id="counter2" class="TicketNumber"></td>
                </tr>

                <tr>
                <td>3</td>
                <td  id="counter3" class="TicketNumber"></td>
                </tr>

                <tr >
                <td>4</td>
                <td id="counter4" class="TicketNumber"></td>
                </tr>

                <tr>
                <td>5</td>
                <td id="counter5" class="TicketNumber"></td>
                </tr>
            </tbody>
            </table>
            </div>
 
<script>
      var updateTable = function() {
    $.getJSON('tvdisplay.php', function(data) {
        data.forEach(function(counter) {
            console.log(counter);
            if (counter.counter_id == 1) {
                var ticketNumber = counter.ticket_number;
                document.getElementById("counter1").innerHTML = ticketNumber;
            }
            else if (counter.counter_id == 2) {
                var ticketNumber = counter.ticket_number;
                document.getElementById("counter2").innerHTML = ticketNumber;
            }
            else if (counter.counter_id == 3) {
                var ticketNumber = counter.ticket_number;
                document.getElementById("counter3").innerHTML = ticketNumber;
            }
            else if (counter.counter_id == 4) {
                var ticketNumber = counter.ticket_number;
                document.getElementById("counter4").innerHTML = ticketNumber;
            }
            else if (counter.counter_id == 5) {
                var ticketNumber = counter.ticket_number;
                document.getElementById("counter5").innerHTML = ticketNumber;
            }
        });
    });
};

updateTable();
setInterval(updateTable, 1000);


</script>
</body>
</html>