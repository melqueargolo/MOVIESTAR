<?php 
//não precisa disso
session_start();

$BASE_URL = "http//".$_SERVER["SERVER_NAME"].dirname($_SERVER["REQUEST_URI"]."?"."/");
//$BASE_URL = "http//".$_SERVER["SERVER_NAME"].":8080/";


