<?php
$pass="Uphsl123";
$hash = password_hash($pass, PASSWORD_DEFAULT); 
echo $hash;
?>