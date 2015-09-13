<html>
<head>
</head>
<body>
<div class = "navbar navbar-default navbar-static-top" role="navigation">
		<!--<div class = "container">-->
			
			<div class = "nav navbar-nav navbar-left">
      			<li><a href ="index.php" class = "navbar-brand"><img width=150 height=35 src="img/logo.png"></a></li>
	      		<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
				</button>
       		</div>
			<div class = "navmenu">
				<div class = "collapse navbar-collapse navHeaderCollapse" scrollbar="hidden">

				<ul class = "nav navbar-nav navbar-right">
					<li><a href="index.php">Search</a></li>
					<li> <?php $cookie_name = 'username'; 
					if(!isset($_COOKIE[$cookie_name])) 
					{
						echo "";
					}
					else
					{
    					echo '<a href="account.php">Account</a>';
					}?></li>
					<li><a href="about.php">About</a></li>
					<li> <?php $cookie_name = 'username'; 
					if(!isset($_COOKIE[$cookie_name])) 
					{
						echo '<a href="login.php">Login</a>';
					}
					else
					{
    					echo '<a href="login-delete.php">Logout</a>';
					}?></li>
				</ul>
				</div>
			</div>
		<!--</div>-->
	</div>
</body>
</html>