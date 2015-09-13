<?php 	setcookie('username', htmlspecialchars($_POST['user_name']), time() + 1, '/');
	$cookie_name = 'username';
	unset($_COOKIE['username']);
	// empty value and expiration one hour before
	$res = setcookie('username', '', time() - 3600);
	header("Location: login.php");
	exit;
?>
