<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What The Tutor | Account</title>

    <!-- Stylesheets -->
    <link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,700|Karla:400,700|Quattrocento+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <!-- Colapseable menu -->

	<?php include('navmenu.php'); ?>

	<!-- Page content -->
	<div class="container">
		<div id="reg_container">
			<div class="leftside">
				<form class="inputform" action="login-submit.php" method="post">
					<h2>Account Login</h2><br>
					<label for="username">Email</label><br><input autofocus class="form-control" type="email" id="username" name="username" required><br>
					<label for="password">Password</label><br><input class="form-control" type="password" id="password" name="password" required><br>
					<button type="submit" class="btn btn-default">      Login      </button>
				</form>
			</div>
			<div class="rightside">
				<form class="inputform" action="login-register.php" method="post" onSubmit = "verifyForm()">
					<h2>Account Registration</h2><br>
					<label for="fullname">Full Name</label><br><input class="form-control" type="text" id="fullname" name="usrname" required><br>
					<label for="usernamereg">Email</label><br><input class="form-control" type="email" id="usernamereg" name="usrlogin" required><br>
					<label for="passwordreg">Password</label><br><input class="form-control" type="password" id="passwordreg" name="usrpass" required><br>
					<label for="username">Role</label><br><select class="form-control" id="role" name="usrrole" required>
					<option value="CStudent">Current Student</option>
					<option value="TStudent">Tutor Student</option>
					<option value="PStudent">Prior Student</option>
					</select><br>
					
					<label for="verify">Retype Number Below Exactly As Is</label><br>
					<input class="form-control" type="text" id="rand" name="rand"><br>
					<input class="form-control" type="text" id="verify" name="verify" required><br>
					<br>
					<button type="submit" class="btn btn-default">      Register      </button>
				</form>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<div class="footer">
		<div class="container">
			<a href="https://www.facebook.com/whatthetutor"><img src="img/facebook.png" alt="Faceboook Logo"></a>
			<a href="https://twitter.com/whatthetutor"><img src="img/twitter.png" alt="Twitter Logo"></a>
			<a href="https://www.youtube.com/user/whatthetutor"><img src="img/youtube.png" alt="YouTube Logo"></a>
		</div>
	</div>





    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/random.js"></script>
  </body>
</html>