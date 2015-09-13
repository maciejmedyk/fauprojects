<?php

include('connection.php');

$id = $_POST['listingid'];
$usrlogin = $_POST['user'];
$classid = $_POST['classid'];
$description =  $_POST['description'];

$query = "UPDATE listings SET classid ='$classid' WHERE listingid ='$id' ";
$query = "UPDATE listings SET description =\"$description\" WHERE listingid ='$id' ";
$data = mysql_query ($query)or die(mysql_error());
	if($data)
	{
		echo "Message Sent";
		header("Location: listing-history.php");
	}



mysql_close($con);
?>



