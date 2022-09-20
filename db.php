<?php 

$db_name = "moviestar";
$db_host = "localhost";
$db_user = "root";
$db_pass = "M12345678m11@";

$conn = new PDO("mysql:dbname=$db_name; dbhost=$db_host", $db_user, $db_pass);


//habilitar erro PDO
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

