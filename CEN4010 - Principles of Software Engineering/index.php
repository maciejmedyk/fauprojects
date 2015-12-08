<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-O-W Delivery</title>

    <!-- Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   </head>
   <body>
        <div id="indexHead">
           <a href="index.php"><button class="btn btn-info">      Driver      </button></a>
           <a href="aindex.php"><button class="btn btn-default">      Admin       </button></a>
       </div>
       <div id="indexDiv">
           <form id="inputForm" data-user-type="Driver" action="" method="post">
				<img class="driver_L" src="img/mowlogoblue.png" height=45px alt="Meals On Wheels Logo"><br>
				<img class="driver_L" src="img/mowdeliveryblue.png" height=35px alt="Delivery Logo"><br><br>

               <label for="username">Username</label><br>
			   <input autofocus class="form-control" type="text" id="username" name="username" ><br>
               <label for="password">Password</label><br>
			   <input class="form-control" type="password" id="password" name="password" ><br>
			   
			   <span><div id="errorMSG"></div></span><br>
			   
               <div id="driverForms" class="loginFormSubmit btn btn-info driver_L">      Login      </div><br><br>
				<a href="#" class="admin_L disable" ><p>Forgot your password?</p></a>
           </form>
       </div>
	   
		
   </body>
</html>
<script src="js/main.js"></script>