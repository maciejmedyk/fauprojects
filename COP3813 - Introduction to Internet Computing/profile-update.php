<?php

include('connection.php');

$usrid = $_POST['usrid'];
$usrname = $_POST['usrname'];
$usrrole =  $_POST['usrrole'];

if(empty($_POST['usrpass']))
{
	$query = "UPDATE members SET usrrole =\"$usrrole\", usrname =\"$usrname\" WHERE usrid ='$usrid' ";
}
else
{
	$usrpass = $_POST['usrpass'];
	$salt1    = "qm&h*"; 
	$salt2    = "pg!@";
	$token    = hash('ripemd128', "$salt1$usrpass$salt2");

	$query = "UPDATE members SET usrrole =\"$usrrole\", usrpass =\"$token\", usrname =\"$usrname\" WHERE usrid ='$usrid' ";
}

$data = mysql_query ($query)or die(mysql_error());
	if($data)
	{
		echo "Profile Updated";
		header("Location: profile-updated.php");
	}

mysql_close($con);
?>