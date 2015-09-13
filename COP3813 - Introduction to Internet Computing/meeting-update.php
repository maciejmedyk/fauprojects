<?php

include('connection.php');

if(empty($_POST["meetingid"]))
{
	header("Location: meeting-history.php");
}
else
{
	$id = trim($_POST['meetingid']);
	if(empty($_POST["iaccept"]))
	{

	}
	else
	{
	  	$query = "UPDATE meetings SET iaccept = 1 WHERE meetingid ='$id' ";
	  	$data = mysql_query ($query)or die(mysql_error());
		header("Location: meeting-history.php");

	}
	if(empty($_POST["taccept"]))
	{

	}
	else
	{
		$query = "UPDATE meetings SET taccept = 1 WHERE meetingid ='$id' ";
		$data = mysql_query ($query)or die(mysql_error());
		header("Location: meeting-history.php");
	}
}

mysql_close($con);
?>



