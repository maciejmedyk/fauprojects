<?php 
include('connection.php');
$tutor = 0;
$data = mysql_query("SELECT * FROM members WHERE usrlogin LIKE '%{$_COOKIE[$cookie_name]}%'") or die(mysql_error());
$info = mysql_fetch_array( $data );
if(($info["usrrole"]) == "TStudent")
{
	$tutor = 1;
}
?>