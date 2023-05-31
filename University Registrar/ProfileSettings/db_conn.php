<?php 

$sName = "localhost";
$uName = "Registrar";
$pass = "Uphsl123";
$db_name = "registrar queuing system";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}
?>