<?php

include('connection.php');

$istudent = $_POST["istudent"];
$tstudent = $_POST["tstudent"];
$classid = $_POST["classid"];
$meetingdate =  $_POST["meetingdate"];
$meetingtime =  $_POST["meetingtime"];
$meetinglocation =  $_POST["meetinglocation"];
$query = "INSERT INTO meetings (istudent,tstudent,classid,meetingdate,meetingtime,meetinglocation) VALUES ('$istudent','$tstudent','$classid','$meetingdate','$meetingtime','$meetinglocation')";
$data = mysql_query ($query)or die(mysql_error());
if($data)
{
	echo "Meeting Created";
	header("Location: meeting-history.php");
}

mysql_close($con);
?>



