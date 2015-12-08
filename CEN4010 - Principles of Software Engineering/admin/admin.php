<?php
include('../scripts/login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
    header("location: ahome.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-O-W Delivery</title>

    <!-- Stylesheets -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="indexHead">
    <a href="../index.php"><button type="link" class="btn btn-default">      Driver      </button></a>
    <a href="admin.php"<button type="link" id="adminActiveButton" class="btn btn-default">      Admin       </button></a>
</div>
<div id="adminDiv">
    <form id="adminForm" action="" method="post">
        <img src="../img/mowlogogreen.png" height=45px alt="Meals On Wheels Logo"><br>
        <img src="../img/mowdeliverygreen.png" height=35px alt="Delivery Logo"><br><br>
        <label for="username">Username</label><br><input autofocus class="form-control" type="text" id="username" name="username" ><br>
        <label for="password">Password</label><br><input class="form-control" type="password" id="password" name="password" ><br><span><?php echo $error . "<br>"; ?></span><br>
        <button name="submit" type="submit" class="btn btn-default">      Login      </button><br><br>
        <a href="#"><p>Forgot your password?</p></a>
    </form>
</div>
</body>
</html>