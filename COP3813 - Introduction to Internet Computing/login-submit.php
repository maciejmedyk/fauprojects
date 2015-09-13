<?php
function CheckLoginInDB($username,$password)
{
	include('connection.php');
  
	$qry = "Select * from cop3813.members  where usrlogin='$username' and usrpass='$password' ";
	$result = mysql_query($qry);
	$count = mysql_num_rows($result);
	if( $count!=1 )
	{
		$error_msg = "Error logging in. ";
		header("Location: login-again.php");
		return false;
	}
	return true;
}
 
	if(empty($_POST['username']))
	{
		echo "UserName is empty!<br />";
		header("Location: login-again.php");
	  	return false;
	}
  
	if(empty($_POST['password']))
	{
		$error_msg = "Password is empty!";
		header("Location: login-again.php");
		return false;
		
		   }
	$username = trim($_POST['username']);
	$usrpass = trim($_POST['password']);
	$salt1    = "qm&h*";
  
	$salt2    = "pg!@";

	$password = hash('ripemd128', "$salt1$usrpass$salt2");
	//$password = $usrpass;
	
	if(!CheckLoginInDB($username,$password))
	{
		//$error_msg = "Wrong Password !!";
		header("Location: login-again.php");
		return false;		
	}
	else
	{
		$cookieusr =$_POST['username'];
		setcookie('username',$cookieusr,time()+36000);
		echo "You Have logged in succesfully !!";
		header("Location: account.php");
	}
	//mysql_close($con);
 ?>