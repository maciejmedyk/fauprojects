<?php

include('connection.php');

if(empty($_POST['sender'])) 
{
}
else
{
$sender = $_POST['sender'];
	if(empty($_POST['recipient'])) 
	{
	}
	else
	{
	$recipient = $_POST['recipient'];
		if(empty($_POST['message'])) 
		{
		}
		else
		{
		$message =  $_POST['message'];
		$query = "INSERT INTO messages (sender,recipient,message) VALUES ('$sender','$recipient','$message')";
		$data = mysql_query ($query)or die(mysql_error());
			if($data)
			{
				echo "Message Sent";
				header("Location: account-delivered.php");
			}
		}
	}
}

mysql_close($con);
?>



