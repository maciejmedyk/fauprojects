
<?php
function getDriverSheets($driverID, $date){
	include('../connection.php');
	$query = "SELECT * FROM 
					`routes`, `drivers`, `clients` 
					WHERE `routes`.`cID` = `clients`.`cID` AND 
					`routes`.`dID` = `drivers`.`dID` AND 
					 
					`drivers`.`dID` = '$driverID' AND `routes`.`rDate` = '$date'
					ORDER BY `routes`.`rSuccess` DESC, `routes`.`rReschedule` ASC";

	$sql = $db->query($query);
	$row_cnt = $sql->num_rows;
    if ($row_cnt == 0){
		echo "<div class='msg'>No Deliveries Today!</div>";
	} else {
	echo "<table border cellpadding = 3 class=\"driverSheets\">";
	echo "<th width=\"80%\">Client</th>" . "<th width=\"20%\">Action</th>";
	
		while ($info = $sql->fetch_array()) {
						echo "<tr><td id=\"dDSClient\">" . $info['cFirstName'] . ' ' . $info['cLastName'] . "</td>";
						if ($info['rSuccess'] == 0) {
								echo '<td id="dDSAction" td rowspan="4"><a href="sheets.php?clientID='. $info['cID'] .'" id="sheetsButtonS" class="btn btn-default">Select</a></td></tr>';
						} else {
								echo "<td id=\"dDSAction\" td rowspan='4'> <button type=\"link\" id=\"sheetsButtonD\" class=\"btn btn-default\" disabled>Delivered</button> </td></tr>";
						}
						echo "<tr><td id=\"dDSAddress1\">" . $info['cAddress1'] . ' ' . $info['cAddress2'] . "</td></tr>";
						echo "<tr><td id=\"dDSAddress2\">" . $info['cCity'] . ', ' . $info['cState'] . ' ' . $info['cZip'] . "</td></tr>";
						echo "<tr><td id=\"dDSNotes\">" . $info['cDeliveryNotes'] . "</td></tr>";
		}
		echo "</table>";
	}
}

function getClientInfo(){
	
}

function getClientNotes(){
	
}


?>