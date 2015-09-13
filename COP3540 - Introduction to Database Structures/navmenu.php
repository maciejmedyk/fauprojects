<html>
<head>
</head>
<body>
<div class = "navbar navbar-default navbar-static-top" role="navigation">
		<!--<div class = "container">-->
			
			<div class = "nav navbar-nav navbar-left">
      			<li><a href="?home" class = "navbar-brand"><img width=150 src="img/logo.png"></a></li>
	      		<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
				</button>
       		</div>
			<div class = "navmenu">
				<div class = "collapse navbar-collapse navHeaderCollapse" scrollbar="hidden">

				<ul class = "nav navbar-nav navbar-right">
					<li><a href="?query=01" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "01") { echo "class=\"selected\"";}} ?>>Query 01</a></li>
					<li><a href="?query=02" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "02") { echo "class=\"selected\"";}} ?>>Query 02</a></li>
					<li><a href="?query=03" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "03") { echo "class=\"selected\"";}} ?>>Query 03</a></li>
					<li><a href="?query=04" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "04") { echo "class=\"selected\"";}} ?>>Query 04</a></li>
					<li><a href="?query=05" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "05") { echo "class=\"selected\"";}} ?>>Query 05</a></li>
					<li><a href="?query=06" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "06") { echo "class=\"selected\"";}} ?>>Query 06</a></li>
					<li><a href="?query=07" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "07") { echo "class=\"selected\"";}} ?>>Query 07</a></li>
					<li><a href="?query=08" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "08") { echo "class=\"selected\"";}} ?>>Query 08</a></li>
					<li><a href="?query=09" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "09") { echo "class=\"selected\"";}} ?>>Query 09</a></li>
					<li><a href="?query=10" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "10") { echo "class=\"selected\"";}} ?>>Query 10</a></li>
					<li><a href="?query=11" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "11") { echo "class=\"selected\"";}} ?>>Query 11</a></li>
					<li><a href="?query=12" <?php if (isset($_GET["query"])) { if ($_GET["query"] == "12") { echo "class=\"selected\"";}} ?>>Query 12</a></li>
				</ul>
				</div>
			</div>
		<!--</div>-->
	</div>
</body>
</html>