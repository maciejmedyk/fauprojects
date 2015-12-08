<?php

include('../connection.php');
session_start();

$adminID=$_SESSION['adminID'];
$login_name = $_SESSION['adminName'];
if(!isset($adminID)){
    header('Location: ../index.php');
	exit;
}
include_once("functions.php");
date_default_timezone_set("America/New_York"); 
$date = date("Y-m-d");
?>