<?php

include('connection.php');

if(empty($_POST['verify'])) {
	header("Location: login.php");
}
else
{
$comp1 = trim($_POST['verify']);
$comp2 = trim($_POST['rand']);
if($comp1 != $comp2){
	header("Location: login-verify.php");
	return false;
}

}

$usrlogin = $_POST['usrlogin'];
if(stripos($usrlogin, "fau.edu") !== FALSE){
}
else
{
	header("Location: login-email.php");
	return false;
}
$usrpass = $_POST['usrpass'];
$usrrole = $_POST['usrrole'];
$usrname =  $_POST['usrname'];

$salt1    = "qm&h*";
$salt2    = "pg!@";

$password = hash('ripemd128', "$salt1$usrpass$salt2");

$query = "INSERT INTO members (usrlogin,usrpass,usrrole,usrname) VALUES ('$usrlogin','$password','$usrrole','$usrname')";
$data = mysql_query ($query)or die(mysql_error());
if($data)
{
	$sender = "WhatTheTutor";	
	$recipient = $usrlogin;
	$message =  "Welcome to What The Tutor website. We welcome you warmly to our service and hope you will use our services often. We hope to help you with finding a tutor for your area of interest. Enjoy our service.";
	$query = "INSERT INTO messages (sender,recipient,message) VALUES ('$sender','$recipient','$message')";
	$info = mysql_query ($query)or die(mysql_error());
		if($info)
		{
			echo "Message Sent";
		}
	echo "Registration Successful";
	$cookieusr =$_POST['usrlogin'];
	setcookie('username',$cookieusr,time()+36000);
	header("Location: account.php");
	
}
	


mysql_close($con);
?>



