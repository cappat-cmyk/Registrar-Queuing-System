<!DOCTYPE html>
<html>
<head>
	<title>Queue TV Display</title>
	<!-- Include the Socket.IO client library -->
	<script src="https://cdn.socket.io/socket.io-3.1.3.min.js"></script>
</head>
<body>
	<h1>Queue TV Display</h1>
	<p id="queue-number"></p>

	<!-- Initialize the speech synthesis API -->
	<script>
		window.speechSynthesis.onvoiceschanged = function() {
			window.speechSynthesis.getVoices();
		};

		// Connect to the web socket server
		const socket = io('http://localhost:3000');

		// Listen for incoming messages from the web socket server
		socket.on('queue-number', function(queueNumber) {
			// Set the queue number on the page
			document.getElementById('queue-number').textContent = 'Queue number ' + queueNumber;

			// Use the speech synthesis API to speak the queue number
			const message = new SpeechSynthesisUtterance('Queue number ' + queueNumber);
			window.speechSynthesis.speak(message);
		});
	</script>
</body>
</html>
