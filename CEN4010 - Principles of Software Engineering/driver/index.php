<?php
include_once("session.php"); 
include_once("../header.php"); 
?>

<body>
    <div id="dID" data-did="<?php echo $_SESSION['driverID']; ?>"></div>
<div id="dBackDiv">
    <div id="dHead">
        <div id="dHeadLeft">
            <a href="emergency.php"<button type="link" id="emergencyButton" class="btn btn-default"> Emergency </button></a>
        </div>
        <div id="dHeadRight">
            <a href="logout.php"<button type="link" id="logoutButton" class="btn btn-default"> Log Out </button></a>
        </div>
    </div><br>
    <div id="dWireFrame">
        <b align="center" id="welcome">Driver : <?php echo $login_name; ?></b><br>
        <p><?php echo $date;?></p>
        <div id="dInsideFrame">
		<?php getDriverSheets($driverID, $date);?>
        </div>
    </div>
</div>
</body>
</html>