<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What The Tutor | Login</title>

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
	  <?php $cookie_name = 'username';
	  if(!isset($_COOKIE[$cookie_name])) 
	  {
	      header("Location: login.php");
	  } ?>
	<div id="acct_container">
     	<div class="acctleftside">
	      <button id="loginbutton" type="button" class="btn btn-default" disabled>  Welcome: <text id="loguser"><?php echo $_COOKIE[$cookie_name];?></text></button><br>
        <a href="account.php"><button id="acctbutton" type="button" class="btn btn-default"> Messages </button><br></a>
        <div class="messsidebox">
          <a href="account.php"><button id="messbutton" type="button" class="btn btn-default"> Unread </button><br></a>
          <a href="account-inbox.php"><button id="messbutton" type="button" class="btn btn-default"> Inbox </button><br></a>
          <a href="account-sent.php"><button id="messbutton" type="button" class="btn btn-default"> Sent </button><br></a>
          <a href="account-compose.php"><button id="messbutton" type="button" class="btn btn-default"> Compose </button><br></a>
        </div>
        <a href="search-result.php"><button id="acctbutton" type="button" class="btn btn-default"> Search </button><br></a>
        <?php include('check-role.php');
        if($tutor == 1) { ?>
        <a href="listing-create.php"><button id="acctbutton" type="button" class="btn btn-default"> Create Listing </button></a><br>
        <?php } ?>
        <a href="meeting-create.php"><button id="acctbutton" type="button" class="btn btn-default"> Create Meeting </button></a><br>
        <?php if($tutor == 1) { ?>
        <a href="listing-history.php"><button id="acctbutton" type="button" class="btn btn-default"> My Listings </button></a><br>
        <?php } ?>
        <a href="meeting-history.php"><button id="acctbutton" type="button" class="btn btn-default"> My Meetings </button></a><br>
        <?php if($tutor == 1) { ?>
        <a href="review-history.php"><button id="acctbutton" type="button" class="btn btn-default"> My Reviews </button></a><br>
        <?php } ?>
        <a href="profile.php"><button id="activebutton" type="button" class="btn btn-default"> My Profile </button></a><br>
        </div>
			<div class="messagerightside">
        <div class="messagespacer">
            <h4> User Profile </h4>
        </div>
        <div class="composeside">
        <form enctype="multipart/form-data" class="profileform" action="profile-update.php" method="post">
        <?php 
          include('connection.php');

          $data = mysql_query("SELECT * FROM members WHERE usrlogin LIKE '%{$_COOKIE[$cookie_name]}%'") or die(mysql_error()); ?>

          <label for="usrname">User Full Name</label><br>
          <input type="text" id="usrname" name="usrname" value="<?php echo $info['usrname']; ?>" required>
          <input class="hidden" type="text" id="usrid" name="usrid" value="<?php echo $info['usrid']; ?>"><br><br>

          <?php
          echo "<label for=\"usrlogin\">User FAU Email</label><br>";
          echo "<select width=\"200px\" type=\"email\" id=\"usrlogin\" name=\"usrlogin\" value=\"" . $_COOKIE[$cookie_name] . "\" disabled required><br>";
          $info = mysql_fetch_array( $data );

          echo "<option value =\"" . $info['usrlogin'] ."\">";
          echo $info['usrlogin'] . "</option>";

          echo "</select><br><br>"; 
          ?>
          <label for="usrpass">User Password</label><br>
          <input type="password" id="usrpass" name="usrpass" required><br><br>
          <label for="usrrole">User Role</label><br>
          <select width="200px" type="text" id="usrrole" name="usrrole" required>
          <option value="CStudent" <?php if($info['usrrole'] =="CStudent") echo "selected"; ?>>Current Student</option>
          <option value="TStudent" <?php if($info['usrrole'] =="TStudent") echo "selected"; ?>>Tutor Student</option>
          <option value="PStudent" <?php if($info['usrrole'] =="PStudent") echo "selected"; ?>>Prior Student</option>
          </select><br><br><br> 
          <button type="submit" class="btn btn-default">      Update Profile      </button></form> <br><h3> Profile Updated </h3>
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