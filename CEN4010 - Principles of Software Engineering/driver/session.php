<?php

include('../connection.php');
session_start();

$driverID=$_SESSION['driverID'];
$login_name = $_SESSION['driverName'];
if(!isset($driverID)){
    header('Location: ../index.php');
	exit;
}
include_once("functions.php");
date_default_timezone_set("America/New_York"); 
$date = date("Y-m-d");
?>