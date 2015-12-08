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
            <a href="index.php"<button type="link" id="logoutButton" class="btn btn-default"> Back </button></a>
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
                echo "<th width=\"80%\">Delivery Notes</th>";
                echo "<tr><td id=\"dDSNotes\">" . $info['cDeliveryNotes'] . "</td></tr>";
                echo "<th width=\"80%\">Food Restrictions</th>";
                if($info['cFoodRestrictions'] == 0)
                {
                    echo "<tr><td id=\"dDSNotes\">No</td></tr>";
                }
                else
                {
                    echo "<tr><td id=\"dDSNotes\">Yes</td></tr>";
                }
                echo "<th width=\"80%\">Food Allergies</th>";
                if($info['cFoodAllergies'] == 0)
                {
                    echo "<tr><td id=\"dDSNotes\">No</td></tr>";
                }
                else
                {
                    echo "<tr><td id=\"dDSNotes\">Yes</td></tr>";
                }
            }
            echo "</table><br>"; ?>
            <div id="dSheetsButtons">
                <div id="dHeadLeft"<?php echo "<td id=\"dDSAction\"><form action=\"navigate.php\" method=\"post\"><input class=\"hidden\" name=\"cID\" value=\"" .  $id . "\"><input type=\"submit\" id=\"emergencyButton\" class=\"btn btn-default\" value=\"Navigate\"></form></td></tr>"; ?></div>
                <div id="dHeadRight"<?php echo "<td id=\"dDSAction\"><form action=\"checkout.php\" method=\"post\"><input class=\"hidden\" name=\"cID\" value=\"" .  $id . "\"><input type=\"submit\" id=\"logoutButton\" class=\"btn btn-default\" value=\"Checkout\"></form></td></tr>"; ?></div>
            </div>
            <?php
			$query = "SELECT * FROM `notes` WHERE `notes`.`cID` = $id ORDER BY `nDate` DESC LIMIT 10";			
			$notes = $db->query($query);
			$row_cnt = $notes->num_rows;
            if ($row_cnt == 0)
            {

            }
            else
            {
                echo "<table border cellpadding = 3 class=\"driverNotesSheets\">";
                {
                    echo "<th width=\"75%\">Note</th>" . "<th width=\"5%\">Flag</th>" . "<th width=\"30%\">Date</th>";
                }
                while ($info = $notes->fetch_array()) {
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
                echo "</table>";
            }
         
            ?>
            <div id="dSheetsButtons">
                <!--<a href="#"<button type="link" class="btn btn-default"> Add Note </button></a><br>-->
            </div>
        </div>
    </div>
</div>
</body>
</html>