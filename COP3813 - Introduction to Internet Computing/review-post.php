<?php

include('connection.php');

$id = $_POST["meetingid"];

$punctuality =  $_POST["punctuality"];
$knowledge =  $_POST["knowledge"];
$reviewarea =  $_POST["reviewarea"];
$query = "UPDATE meetings SET punctuality = \"$punctuality\" WHERE meetingid = '$id'";
$data = mysql_query ($query)or die(mysql_error());
$query = "UPDATE meetings SET knowledge = \"$knowledge\" WHERE meetingid = '$id'";
$data = mysql_query ($query)or die(mysql_error());
$query = "UPDATE meetings SET reviewarea = \"$reviewarea\" WHERE meetingid = '$id'";
$data = mysql_query ($query)or die(mysql_error());
$query = "UPDATE meetings SET reviewcomplete = 1 WHERE meetingid = '$id'";
$data = mysql_query ($query)or die(mysql_error());
if($data)
{
	echo "Review Created";
	header("Location: meeting-history.php");
}

mysql_close($con);
?>



