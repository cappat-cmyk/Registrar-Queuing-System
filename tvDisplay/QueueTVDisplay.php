<!DOCTYPE html>
<html>
<head>
	<title>Queue TV Display</title>
	<!-- Include the Socket.IO client library -->
	<script src="../node_modules/socket.io/client-dist/socket.io.js"></script>
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
            font-size: 5rem;
        }
        td {
            font-size: 4rem;
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
            <td id="counter3" class="TicketNumber"></td>
            </tr>
            <tr>
            <td>4</td>
            <td id="counter4" class="TicketNumber"></td>
            </tr>
            <tr>
            <td>5</td>
            <td id="counter5" class="TicketNumber"></td>
            </tr>
            <tr>
            <td colspan="2">Please proceed to your designated <br> counter number when called</td>
            </tr>
            </tbody>

            </table>
            </div>

	<!-- Initialize the speech synthesis API -->
	<script>
		window.speechSynthesis.onvoiceschanged = function() {
			window.speechSynthesis.getVoices();
		};

		// Connect to the web socket server
		const socket = io('http://192.168.85.100:3000');

		// Listen for incoming messages from the web socket server
		socket.on('call-customer', function(data) {
			const obj = JSON.parse(data);
			const counterNumber = obj.counterNumber;
			const ticketNumber = obj.ticketNumber;
            console.log(ticketNumber);

			// Update the corresponding table row with the ticket number
			document.getElementById(`counter${counterNumber}`).textContent = ticketNumber;

		});
	</script>
</body>
</html>
