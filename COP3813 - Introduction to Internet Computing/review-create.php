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
        <a href="review-history.php"><button id="activebutton" type="button" class="btn btn-default"> My Reviews </button></a><br>
        <?php } ?>
        <a href="profile.php"><button id="acctbutton" type="button" class="btn btn-default"> My Profile </button></a><br>
        </div>
			<div class="messagerightside">
        <div class="messagespacer">
            <h4> Create Review </h4>
        </div>
        <div class="composeside">
        <form class="composeform" action="review-post.php" method="post">
          <?php 
          include('connection.php');

          $id = trim($_POST['meetingid']);
          $data = mysql_query("SELECT * FROM meetings WHERE meetingid LIKE '%{$id}%' ORDER BY timestamp DESC") or die(mysql_error()); 

          echo "<label for=\"user\">Tutor</label><br>";
          echo "<select width=\"200px\" type=\"email\" id=\"user\" name=\"user\" value=\"" . $_COOKIE[$cookie_name] . "\" required><br>";
          ($info = mysql_fetch_array( $data ));
          echo "<option value =\"" . $info['tstudent'] ."\">";
          echo $info['tstudent'] . "</option>";
          echo "</select><br><br>"; 
          ?>
          <label for="punctuality">Availability and Price</label><br><select id="punctuality" name="punctuality" required>
          <option value="5">Extremly Good</option>
          <option value="4">Somewhat Good</option>
          <option value="3">About Average</option>
          <option value="2">Somewhat Poor</option>
          <option value="1">Extremly Poor</option>
          </select><br><br>
          <label for="knowledge">Knowledge</label><br><select id="knowledge" name="knowledge" required>
          <option value="5">Extremly Good</option>
          <option value="4">Somewhat Good</option>
          <option value="3">About Average</option>
          <option value="2">Somewhat Poor</option>
          <option value="1">Extremly Poor</option>
          </select><br><br>
          <input class="hidden" name="meetingid" value="<?php  echo $id;  ?>">
          <label for="review-area">Review</label><br><textarea rows="15" cols="30" type="text" id="reviewarea" name="reviewarea" required></textarea><br>
          <button type="submit" class="btn btn-default">      Post Review      </button><br><br></form>
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