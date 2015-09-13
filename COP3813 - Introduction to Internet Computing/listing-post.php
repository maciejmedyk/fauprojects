<?php

include('connection.php');

if(empty($_POST['user'])) 
{
}
else
{
$usrlogin = $_POST['user'];
	if(empty($_POST['classid'])) 
	{
	}
	else
	{
	$classid = $_POST['classid'];
		if(empty($_POST['description'])) 
		{
		}
		else
		{
		$description =  $_POST['description'];
		$query = "INSERT INTO listings (usrlogin,classid,description) VALUES ('$usrlogin','$classid','$description')";
		$data = mysql_query ($query)or die(mysql_error());
			if($data)
			{
				echo "Listing Created";
				header("Location: listing-posted.php");
			}
		}
	}
}

mysql_close($con);
?>



