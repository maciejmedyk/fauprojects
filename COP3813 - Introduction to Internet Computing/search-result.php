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
	<div id="acct_container">
       <div class="searchleftside">
          <form class="searchagainform" action="search-result.php" method="post">
          <label for="search">Class</label><br>
          <input type="text" id="classid" name="search"><br><br>
          <label for="tutor">Tutor</label><br>
          <input type="text" id="tutor" name="tutor"><br><br>
          <label for="description">Description</label><br>
          <input type="text" id="description" name="description"><br><br><br>
          <button type="submit" class="btn btn-default">      Search      </button>
      </div>
			<div class="searchrightside">
        <div class="messagecontainer">
        <?php
          include('connection.php');

          $data = mysql_query("SELECT * FROM listings ORDER BY timestamp DESC LIMIT 30") or die(mysql_error()); 
          
          if(empty($_POST['search'])) {
          }
          else
          {
          $found = trim($_POST['search']);
          $data = mysql_query("SELECT * FROM listings WHERE classid LIKE '%{$found}%' ORDER BY timestamp DESC LIMIT 30") or die(mysql_error()); 
          }

          if(empty($_POST['tutor'])) {
          }
          else
          {
          $found = trim($_POST['tutor']);
          $data = mysql_query("SELECT * FROM listings WHERE usrlogin LIKE '%{$found}%' ORDER BY timestamp DESC LIMIT 30") or die(mysql_error()); 
          }

          if(empty($_POST['description'])) {
          }
          else
          {
          $found = trim($_POST['description']);
          $data = mysql_query("SELECT * FROM listings WHERE description LIKE '%{$found}%' ORDER BY timestamp DESC LIMIT 30") or die(mysql_error()); 
          }

          Print "<table border  cellspacing=\"10\" id=\"searchtable\">";
          
          $cookie_name = 'username';
          if(!isset($_COOKIE[$cookie_name])) 
          {
              Print "<th>Class</th>" . "<th width=80%>Description</th>" . "<th width=\"20%\">Review</th>" . "<th>Contact</th>";
              while($info = mysql_fetch_array( $data )) 
              { 
                 Print "<tr><td width=\"8%\">".$info['classid'] . "</td>"; 
                 Print "<td>".$info['description'] . " </td>";
                 $user = $info['usrlogin'];
                 $reviews = mysql_query("SELECT * FROM meetings WHERE tstudent LIKE '%{$user}%'") or die(mysql_error());
                 $temp = 0;
                 $count = 0;
                 while($rev = mysql_fetch_array( $reviews ))
                 {
                    if($rev['punctuality'] > 0)
                    {
                      $temp += $rev['punctuality'];
                      $count+= 1;
                    }
                    if($rev['knowledge'] > 0)
                    {
                      $temp += $rev['knowledge'];
                      $count+= 1;
                    }  
                 }
                 $result=0;
                 if($count > 0) $result+=$temp/$count; ?>
                 <td><div class="progress"><div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="3" style="width:<?php echo $result*20; ?>%"></div></div></td>
                 <?php
                 Print "<td class=\"contacticon\"><a href=\"account-compose.php\"><img src=\"img/contact.png\" width=\"30px\" height=\"30px\"></a></td></tr>";
              } 
          }
          else
          {
              Print "<th>Class</th>" . "<th>Tutor</th>" . "<th width=80%>Description</th>" . "<th width=\"20%\">Review</th>" . "<th>Contact</th>";
              while($info = mysql_fetch_array( $data )) 
              { 
                 Print "<tr><td width=\"8%\">".$info['classid'] . "</td>"; 
                 Print "<td>".$info['usrlogin'] . " </td>";
                 Print "<td>".$info['description'] . " </td>";
                 $user = $info['usrlogin'];
                 $reviews = mysql_query("SELECT * FROM meetings WHERE tstudent LIKE '%{$user}%'") or die(mysql_error());
                 $temp = 0;
                 $count = 0;
                 while($rev = mysql_fetch_array( $reviews ))
                 {
                    if($rev['punctuality'] > 0)
                    {
                      $temp += $rev['punctuality'];
                      $count+= 1;
                    }
                    if($rev['knowledge'] > 0)
                    {
                      $temp += $rev['knowledge'];
                      $count+= 1;
                    }  
                 }
                 $result=0;
                 if($count > 0) $result+=$temp/$count; ?>
                 <td><div class="progress"><div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="3" style="width:<?php echo $result*20; ?>%"></div></div></td>
                 <?php
                 Print "<td class=\"contacticon\"><a href=\"account-compose.php\"><img src=\"img/contact.png\" width=\"30px\" height=\"30px\"></a></td></tr>";
              } 
          }
          Print "</table>";
          mysql_close($con);
        ?>
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