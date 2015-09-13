<?php

include('connection.php');

if(empty($_POST["meetingid"]))
{
	header("Location: meeting-history.php");
}
else
{
	$id = trim($_POST['meetingid']);
	$query = "UPDATE meetings SET meetingcomplete = 1 WHERE meetingid ='$id' ";
  	$data = mysql_query ($query)or die(mysql_error());
	header("Location: meeting-history.php");
}

mysql_close($con);
?>



