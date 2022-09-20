<?php 

require_once "Templates/header.php"; //ja tem tem todos os reuqures nele

if($userDao){
    $userDao->destroyToken();
}