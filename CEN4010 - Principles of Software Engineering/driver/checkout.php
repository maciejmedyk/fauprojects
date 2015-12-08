<?php
include_once("session.php"); 
include_once("../header.php");

if(isset($_GET['clientID'])){
	$id=$_GET['clientID'];
	$_SESSION['customer_id']= $id;
} else {
	$id=$_SESSION['customer_id'];
}
?>
<body>
    <div id="dID" data-did="<?php echo $_SESSION['driverID']; ?>"></div>
<div id="dBackDiv">
    <div id="dHead">
        <div id="dHeadLeft">
            <a href="emergency.php"<button type="link" id="emergencyButton" class="btn btn-default"> Emergency </button></a>
        </div>
        <div id="dHeadRight">
            <a href="sheets.php"<button type="link" id="logoutButton" class="btn btn-default"> Back </button></a>
        </div>
    </div><br>
    <div id="dWireFrame">
        <b align="center" id="welcome">Driver : <?php echo $login_name; ?></b><br>
        <p><?php date_default_timezone_set("America/New_York"); $date = date("Y-m-d"); echo $date; ?></p>
        <div id="dInsideFrame">
            <?php
			$query = "SELECT * FROM `clients` WHERE `clients`.`cID` = $id";
			$sql = $db->query($query);
            

            echo "<table border cellpadding = 3 class=\"driverDetailsSheets\">";
            while ($info = $sql->fetch_array()) {
                echo "<th width=\"80%\">Client</th>";
                echo "<tr><td id=\"dDSClient\">" . $info['cFirstName'] . ' ' . $info['cLastName'] . "</td></tr>";
                echo "<th width=\"80%\" id=\"dDSAddress\">Address</th>";
                echo "<tr><td id=\"dDSAddress1\">" . $info['cAddress1'] . ' ' . $info['cAddress2'] . "</td></tr>";
                echo "<tr><td id=\"dDSAddress2\">" . $info['cCity'] . ', ' . $info['cState'] . ' ' . $info['cZip'] . "</td></tr>";
                echo "<th width=\"80%\" id=\"dDSAddress\">Phone</th>";
                echo "<tr><td id=\"dDSNotes\">" . $info['cPhone'] . "</td></tr>";
                echo "<th width=\"80%\" id=\"dDSAddress\">Status</th>";
                echo "<form action=\"checkout.php\" method=\"post\">";
                echo "<div class=\"btn-group\" data-toggle=\"buttons\"><tr><td id=\"dDSStatus\">
                <div id=\"checkoutText1\"><b>Complete Delivery</b></div>
                <div id=\"checkoutText2\"><input type=\"radio\" id=\"option1\" name=\"options\" autocomplete=\"off\" value=\"1\"><label for=\"option1\"><span></span> </label></div>
                </td></tr>";
                echo "<tr><td id=\"dDSReschedule\">
                <div id=\"checkoutText1\"><b>Reschedule Delivery</b></div>
                <div id=\"checkoutText2\"><input type=\"radio\" id=\"option2\" name=\"options\" autocomplete=\"off\" value=\"2\"><label for=\"option2\"><span></span> </label></div>
                </td></tr></div>";
                echo "</table>";
                echo "<tr><td></tr><button type=\"submit\" id=\"buttonComplete\" class=\"btn btn-default\">Finalize</button></td></tr>";
                echo "</form>";
            } ?>

            <?php
            if (isset($_POST['options']))
            {
                $option = $_POST['options'];
				$query = "SELECT * FROM `routes`, `drivers`, `clients` WHERE `routes`.`cID` = `clients`.`cID` AND `routes`.`dID` = `drivers`.`dID` AND `routes`.`rDate` = '$date' AND `drivers`.`dID` = '$driverID' AND `clients`.`cID` = '$id'";
				
				$sql = $db->query($query);
				$info = $sql->fetch_array();
				
                if($option == 1)
                {
                    
                    $rID = $info['rID'];
                    $query = "UPDATE `routes` SET `routes`.`rSuccess` = '1' WHERE `routes`.`rID` =  '$rID'";
                    $db->query($query);
                    $row_cnt = $sql->num_rows;
					
					if ($row_cnt == 1){
                        echo "<div id=\"emergencyConfirmation\"><p>Complete</p></div>";
                        header('Location: index.php');
                    }
                }
                if($option == 2)
                {
                    $rID = $info['rID'];
                    $query = "UPDATE `routes` SET `routes`.`rReschedule` = '1' WHERE `routes`.`rID` =  '$rID'";
					$db->query($query);
                    $row_cnt = $sql->num_rows;
					if ($row_cnt == 1){
                        echo "<div id=\"emergencyConfirmation\"><p>Recheduled</p></div>";
                        header('Location: index.php');
                    }
                }
            }
            ?>

            <form class="form-inline" action="checkout.php" method="post">
                <table><tr id="noteRow"><td width="80%">
                <div id="noteLeft">
                    <input type="text" name="comment" class="form-control" id="noteField" placeholder="Note">
                        </td><td width="5%">
                    <label> Flag
                        <input type="checkbox" name="flag" id="noteCheck">
                    </label>
                </div></td><td width="20%">
                <div id="noteRight">
                     <button type="submit" id="noteButton" class="btn btn-default">Add Note</button>
                </div></td></tr>
                <?php
                if (isset($_POST['comment']))
                {
                    $comment = $_POST['comment'];
                    $comment = stripslashes($comment);
                    $comment = $db->real_escape_string($comment);
                    if (isset($_POST['flag']))
                    {
                        $query = "INSERT INTO `notes` (nDate, cID, dID, nComment, nUrgent) VALUES ('$date','$id','$driverID','$comment', 1)";
						$data = $db->query($query);
                        if($data){
                            echo "<div id=\"emergencyConfirmation\"><p>Note Added</p></div>";
                        }
                    }
                    else
                    {
                        $query = "INSERT INTO `notes` (nDate, cID, dID, nComment, nUrgent) VALUES ('$date','$id','$driverID','$comment', 0)";
                        $data = $db->query($query);
                        if($data)
                        {
                            echo "<div id=\"emergencyConfirmation\"><p>Note Added</p></div>";
                        }
                    }
                }
                ?>
            </form>


            <?php
			$query = "SELECT * FROM `notes` WHERE `notes`.`cID` = $id ORDER BY `nDate` DESC LIMIT 10";
			$data2 = $db->query($query);
            $row_cnt = $data2->num_rows;
            
            if ($row_cnt == 0)
            {

            }
            else
            {
            echo "<table border cellpadding = 3 class=\"driverNotesSheets\">";
            {
                echo "<th width=\"75%\">Note</th>" . "<th width=\"5%\">Flag</th>" . "<th width=\"30%\">Date</th>";
            }

            while ($info = $data2->fetch_array()) {
                echo "<tr><td id=\"dDSNNote\">" . $info['nComment'] . "</td>";
                if($info['nUrgent'] == 0)
                {
                    echo "<td id=\"dDSNFlag\"> </td>";
                }
                else
                {
                    echo "<td id=\"dDSNFlag\">&#10003</td>";
                }
                echo "<td id=\"dDSNDate\">" . $info['nDate'] . "</td></tr>";
            }
            echo "</table>";}
            ?>
            
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</body>
</html>