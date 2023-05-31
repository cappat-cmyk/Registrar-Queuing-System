<?php

// $host = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'registrar queuing system';
$dbhost = "localhost";
$dbname = "registrar queuing system";
$dbuser = "Registrar";
$dbpass = "uphsl123";

// Connect to the database
$db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn = new mysqli('localhost', 'Registrar', 'uphsl123', 'registrar queuing system');

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>