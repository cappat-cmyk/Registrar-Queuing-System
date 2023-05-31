<?php
$ticketnumber = $_GET['data'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ticket Example</title>
	<style>
		.ticket {
			width: 300px;
			height: 250px;
			border: 2px solid black;
			padding: 10px;
			font-family: Arial, sans-serif;
			text-align: center;
			line-height: 1.5;
		}

		.ticket__title {
			font-size: 12px;
			font-weight: bold;
			margin-bottom: 0px;
		}

		.ticket__subtitle {
			font-size: 11px;
			font-weight: bold;
		}
		
		.ticketnumber {
			text-align: center;
			font-size: 60px;
			font-weight: bold;
			margin-bottom: 2mm;
			border-top: 1px solid black;
			padding-top: 2mm;
			position: relative;
		}

		.ticket__info {
			margin-top: 20px;
			font-size: 20px;
			font-weight: bold;
		}

		.footer {
			text-align: center;
			margin-top: 40px;
			margin-bottom: 2mm;
		}

		@media print {
			@page {
				margin-top: 0;
				margin-bottom: 0;
			}

			body {
				margin-top: 1.5cm;
				margin-bottom: 1.5cm;
			}

			/* Hide header and footer */
			header,
			footer {
				display: none;
			}
		}
	</style>
	<script>
		
    function printTicket() {

	document.querySelector('.ticketnumber').textContent="<?php echo $ticketnumber?>"
    var ticket = document.querySelector('.ticket').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = ticket;
    window.print();
    document.body.innerHTML = originalContents;
	setTimeout(function() {
    window.location.href = "Client-Registration1.php";
  }, 0.5); // Delay redirect by 1 second (1000 milliseconds)
}


	</script>
</head>
<body>
	<div class="ticket">
		<div class="ticket__title">
			University of Perpetual Help System Laguna
		</div>
		<div class="ticket__subtitle">
			Registrar's Office <br>
			Registrar Queuing System
		</div>
		<div class="ticket__info">
			Ticket number
		</div>
		<div class="ticketnumber"></div>
		<div class="footer">
			<?php
			date_default_timezone_set('Asia/Manila');
			$date = new DateTime();
			echo $date->format('F j, Y g:i A');
			?>
		</div>
	</div>
	<script>
		window.onload = function() {
			printTicket();
		};
	</script>
</body>
</html>
