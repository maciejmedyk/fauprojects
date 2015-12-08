<?php
//Used to log php info to the javascript console.
function consoleLog($msg){
    echo "<script>console.log('$msg');</script>";
}

//Redirect to different page.
function Redirect($url, $permanent = false){
    if (headers_sent() === false) {
    	header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}

function formatPhone($number){
    if ($number != ""){
        return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $number);
    }
}

function getClient($id, $count){
    include('../connection.php');
	if($count == "all"){
        $query = "SELECT cID, cFirstName, cLastName, cPhone, cActive, cDeliveryNotes
				FROM clients
				ORDER BY cLastName ASC";
    }elseif($count == "search"){
        $query = "SELECT cID, cFirstName, cLastName, cPhone, cActive, cDeliveryNotes 
            FROM clients
            WHERE cFirstName LIKE '%$id%' OR cLastName LIKE '%$id%' OR cPhone LIKE '%$id%'
            ORDER BY cLastName ASC";
    }
    
	$sql = $db->query($query);
	$row_cnt = $sql->num_rows;
    if ($row_cnt == 0){
        if ($count == "all") echo "<div class='alert alert-warning fade in msg'>There are currently no clients in the database.</div>";
        if ($count == "search")echo "<div class='alert alert-warning fade in msg'>There are currently no clients that match that query.</div>";
    } else {
        echo "<table id='clientTable' class='alignleft table table-hover'>
            <thead class='tableHead'>
            <tr>
            <th><i class='fa fa-check-square'></iclass></th>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Delivery Notes</th>
            </tr>
            </thead>
            <tbody>";


        while ($info = $sql->fetch_array()) {
            if($info['cActive'] == 1){
                $active ="Active";
                #$action = "Deactivate";
            } else {
                $active ="Inactive";
                #$action = "Activate";
            }
            echo "<tr data-status='" . $active ."'>
                <td><a href='clientEdit.php?cID=".$info['cID']."' class='dTableButton btn btn-xs btn-success' data-driverID='" . $info['cID'] . "'>Edit</a></td>
                <td>" . $info['cID'] . "</td>
                <td>" . $info['cLastName'] . ", " . $info['cFirstName'] . "</td>
                <td>" . formatPhone($info['cPhone']) . "</td>
                <td>" . $active . "</td>
                <td>" . $info['cDeliveryNotes'] . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }
}

function getDrivers($id, $count){
    include('../connection.php');
	if($count == "all"){
        $query = "SELECT *
                FROM drivers
                ORDER BY dLastName ASC";
    }elseif($count == "search"){
        $query = "SELECT *
            FROM drivers
            WHERE dFirstName LIKE '%$id%' OR dLastName LIKE '%$id%' OR dUsername LIKE '%$id%'
            ORDER BY dLastName ASC";
    }

    $sql = $db->query($query);
    $row_cnt = $sql->num_rows;
    if ($row_cnt == 0){
        if ($count == "all") echo "<div class='alert alert-warning fade in msg'>There are currently no drivers in the database.</div>";
        if ($count == "search") echo "<div class='alert alert-warning fade in msg'>There are currently no drivers that match your query.</div>";
    } else {
        echo "<table id='driverTable' class='alignleft table table-hover'>
        <thead class='tableHead'>
        <tr>
        <th width='25%'><i class='fa fa-check-square'></iclass></th>
        <th width='5%'>ID</th>
        <th width='10%'>Name</th>
        <th width='10%'>Username</th>
        <th width='15%'>Vehicle</th>
        <th width='10%'>Vehicle Tag</th>
        <th width='10%'>Insurance</th>
        <th width='10%'>Insurance Policy</th>
        <th width='5%'>Status</th>
        </tr>
        </thead>
        <tbody>";

        while ($info = $sql->fetch_array()) {
            if($info['dActive'] == 1){
                $active ="Yes";
                $action = "Deactivate";
            } else {
                $active ="No";
                $action = "Activate";
            }

            if(isRetired($info['dID']) ){
                $dlabel = "Retire";
                $status = "Active";
				$step = 0;
            } else {
                $dlabel = "Re-enable";
                $status = "Retired";
				$step = 1;
            }

            if(isLocked($info['dID']) ){
                $locked = '<a onclick="unlockDriver('.$info['dID'].')" class="dTableButton btn btn-xs btn-danger">Unlock Driver</a>';
            } else {
                $locked = "";
            }

            echo "<tr data-status='" . $status . "'>
                <td>
                    <a href='driverEdit.php?dID=" . $info['dID'] . "' class='dTableButton btn btn-xs btn-success' data-driverID='" . $info['dID'] . "'>Edit</a>						
                    <a onclick='retireDriver(".$info['dID'].", ".$step.")' class='dTableButton btn btn-xs btn-success' data-driverID='" . $info['dID'] . "'>".$dlabel." Driver</a>
                    ".$locked."
                </td>
                <td>" . $info['dID'] . "</td>
                <td>" . $info['dLastName'] . ", " . $info['dFirstName'] . "</td>
                <td>" . $info['dUsername'] . "</td>
                <td>" . $info['dVehicleYear'] . " " . $info['dVehicleMake'] . " " . $info['dVehicleModel'] . "</td>
                <td>" . $info['dVehicleTag'] . "</td>
                <td>" . $info['dInsuranceCo'] . "</td>
                <td>" . $info['dInsurancePolicy'] . "</td>
                <td>" . $status. "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }
}

function getOverviewDrivers($id, $count){
    include('../connection.php');
    
	$isSearch = false;
    
    if(isset($_SESSION['dataOffset'])){
        $offset = $_SESSION['dataOffset'];
    }else{
        $offset = 0;
    }
    
    //Set timezone for this session.
    $query = "SET @@session.time_zone = '-05:00'";
    $sql = $db->query($query);
    
	if($count == "all"){
        
        $countQuery = " SELECT r.rID, count(*) AS count, d.dFirstName, d.dLastName, r.dID, d.dPhoneNumber, d.lat, d.lng, r.rDate
                        FROM routes AS r
                        JOIN drivers AS d
                        ON r.dID = d.dID
                        WHERE date(r.rDate) = subdate(curdate(), $offset)
                        GROUP BY r.dID
                        ORDER BY d.dLastName ASC;";
        
        $completedQuery = "SELECT r.rID, count(*) AS completed, r.dID
                        FROM routes AS r
                        JOIN drivers AS d
                        ON r.dID = d.dID
                        WHERE date(r.rDate) = subdate(curdate(), $offset)
                        AND r.rSuccess = 1
                        GROUP BY r.dID
                        ORDER BY d.dLastName ASC;";

    }elseif($count == "search"){
        
        $isSearch = true;
		
        $countQueryNorm = "SELECT r.rID, count(*) AS count, r.dID
                        FROM routes AS r
                        JOIN drivers AS d
                        ON r.dID = d.dID
                        WHERE date(r.rDate) = subdate(curdate(), $offset)
                        GROUP BY r.dID
                        ORDER BY d.dLastName ASC;";
        
        $completedQueryNorm = "SELECT r.rID, count(*) AS completed, r.dID
                        FROM routes AS r
                        JOIN drivers AS d
                        ON r.dID = d.dID
                        WHERE date(r.rDate) = subdate(curdate(), $offset)
                        AND r.rSuccess = 1
                        GROUP BY r.dID
                        ORDER BY d.dLastName ASC;";
						
        $countQuery = "SELECT r.rID, count(*) AS count, d.dFirstName, d.dLastName, r.dID, d.dPhoneNumber, d.lat, d.lng, r.rDate
                        FROM routes AS r
                        JOIN drivers AS d
                        ON r.dID = d.dID
                        JOIN clients AS c
                        ON r.cID = c.cID
                        WHERE date(r.rDate) = subdate(curdate(), $offset)
                        AND (d.dFirstName LIKE '%$id%' OR d.dLastName LIKE '%$id%' OR c.cLastName LIKE '%$id%' OR c.cFirstName LIKE '%$id%')
                        GROUP BY r.dID
                        ORDER BY d.dLastName ASC;";
        
        $completedQuery = "SELECT r.rID, count(*) AS completed, r.dID
                        FROM routes AS r
                        JOIN drivers AS d
                        ON r.dID = d.dID
                        JOIN clients AS c
                        ON r.cID = c.cID
                        WHERE date(r.rDate) = subdate(curdate(), $offset)
                        AND r.rSuccess = 1
                        AND (d.dFirstName LIKE '%$id%' OR d.dLastName LIKE '%$id%' OR c.cLastName LIKE '%$id%' OR c.cFirstName LIKE '%$id%')
                        GROUP BY r.dID
                        ORDER BY d.dLastName ASC;";
        
    }

    //Get total deliveries per driver from database
    $countSql = $db->query($countQuery);
    $row_cnt = $countSql->num_rows;

    if(!$countSql){
        echo "<div class='alert alert-warning fade in msg'>There were SQL errors.<br/>".mysqli_error($db)."</div>";
        return;
    }
    
    //Get number of deliveries comleted
    $completedSql = $db->query($completedQuery);
    $row_cnt2 = $completedSql->num_rows;
    
    if(!$completedSql){
        echo "<div class='alert alert-warning fade in msg'>There were SQL errors:<br/>".mysqli_error($db)."</div>";
        return;
    }
	
    if ($row_cnt == 0){
        
        if ($count == "all") echo "<div class='alert alert-warning fade in msg'>There are currently no drivers scheduled today.</div>";
        if ($isSearch) echo "<div class='alert alert-warning fade in msg'>There are currently no drivers that match your query.</div>";
        
    } else {

    
        //Get counts for the search query
        if($isSearch){
            
            $countSqlNorm = $db->query($countQueryNorm);
            $completedSqlNorm = $db->query($completedQueryNorm);
            
            //Get total count from all drivers in search
            while ($info1 = $countSqlNorm->fetch_array()){
                $info1arr[$info1['dID']] = $info1;
            }

            //Get total count of completed delivers for a driver
            while ($info2 = $completedSqlNorm->fetch_array()){
                $info2arr[$info2['dID']] = $info2;
            }
            
        }else{
            
            //Get total count of completed delivers for a driver
            while ($info2 = $completedSql->fetch_array()){
                $info2arr[$info2['dID']] = $info2;
            }
            
        }

        $output = "";
        
        while ($info = $countSql->fetch_array()){
			
            if(isset($info1arr[$info['dID']])){
                $cou = $info1arr[$info['dID']]['count'];
            }else{
                $cou = $info['count']; 
            }
           
            
            //If there is a driver in the completed array match it up here.
            if (isset($info2arr[$info['dID']])){
                
                $comp = $info2arr[$info['dID']]['completed'];
                $percent = round($comp / $cou * 100,2);
                
            } else {
                $percent = 0;
                $comp = 0;
            }
            
            //Set the color of the progress bar depending on progress made.
            if ($percent < 25){
                $colorStyle = "progress-bar-danger";
            }else if ($percent < 50){
                $colorStyle = "progress-bar-warning";
            }else if ($percent < 75){
                $colorStyle = "progress-bar-info";
            }else {
                $colorStyle = "progress-bar-success";
            }

            
            $output .= "
            <div data-did='". $info['dID'] ."' class='panel panel-default driverPanel'>             
                <div class='panel-heading'>" . $info['dID'] . " " . $info['dLastName'] . ", " . $info['dFirstName'] . " " . $info['rDate'] ."</div>
                <div class='panel-body'>
                    <div style='margin-left: 10px; margin-right: 10px;' class='progress'>
                        <div class='".$colorStyle." progress-bar' role='progressbar' aria-valuenow='".$percent."' aria-valuemin='0' aria-valuemax='100' style='width:".$percent."%'>
                            <span style='color: black;'>". $percent ."% Completed</span>
                        </div>
                    </div>
                    Phone: " . formatPhone($info['dPhoneNumber']) . "<br />
                    Status: " . $comp . " of " . $cou . " completed.
                </div>
            </div>
            ";
            
            
        }
        echo $output;
    }
}

/*function getOverviewClient($id, $count){

    include('../connection.php');
	if($count == "all"){
        $query = "SELECT cID, cFirstName, cLastName, cPhone, cActive, cDeliveryNotes
				FROM clients
				ORDER BY cLastName ASC";
    }elseif($count == "search"){
        $query = "SELECT cID, cFirstName, cLastName, cPhone, cActive, cDeliveryNotes 
            FROM clients
            WHERE cFirstName LIKE '%$id%' OR cLastName LIKE '%$id%' OR cPhone LIKE '%$id%'
            ORDER BY cLastName ASC";
    }
    
	$sql = $db->query($query);
	$row_cnt = $sql->num_rows;
    if ($row_cnt == 0){
        if ($count == "all") echo "<div class='alert alert-warning fade in msg'>There are currently no clients in the database.</div>";
        if ($count == "search")echo "<div class='alert alert-warning fade in msg'>There are currently no clients that match that query.</div>";
    } else {
        echo "Drivers Clients";
        echo "<table class='alignleft table table-hover'>
            <thead class='tableHead'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>";


        while ($info = $sql->fetch_array()) {
            if($info['cActive'] == 1){
                $active ="Active";
                #$action = "Deactivate";
            } else {
                $active ="Inactive";
                #$action = "Activate";
            }
            echo "<tr>
                <td>" . $info['cID'] . "</td>
                <td>" . $info['cLastName'] . " " . $info['cFirstName'] . "</td>
                <td>" . formatPhone($info['cPhone']) . "</td>
                <td>" . $active . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }
}*/

function isRetired($dID){
	include('../connection.php');
	$query = "SELECT *
				FROM drivers
				WHERE dID = $dID AND dActive = 0";

	$sql = $db->query($query);
	$row_cnt = $sql->num_rows;
	if ($row_cnt == 0){
		return true;
	} else {
		return false;
	}
}

function retireDriver($dID,$x){
	include('../connection.php');
	$query = "UPDATE drivers SET 
				dActive = '$x'
				WHERE dID='$dID'";
							
		$db->query($query);
	
	if($x == 0){
		echo "Driver is retired";
	} else {
		echo "Driver is re-enabled";
	}
}

function isLocked($dID){
	include('../connection.php');
	$query = "SELECT *
				FROM trap
				WHERE lockedID ='$dID' AND lockType='1' AND lockCount > 9";

	$sql = $db->query($query);
	
	$row_cnt = $sql->num_rows;
	
	if ($row_cnt > 0){
		return true;
	} else {
		return false;
	}
}

function unLock($dID){
	include('../connection.php');
	// Update
	$query = "DELETE FROM trap
				WHERE lockedID ='$dID' AND lockType='1'";
	$db->query($query);
	echo "Driver Unlocked";
}

//
//Search functions just forward the request in the appropriate manner.
//
function searchClient($name){
    getClient($name, "search");
}

function searchAdmin($name){
    getAdminTable($name, "search");
}

function searchDriver($name){
    getDrivers($name, "search");
}

function searchReports($string){
    getReportsTable($string, "search");
}

function searchDeliveries($string){
    getDeliveriesTable($string, "search");
}

function searchEmergencies($search){
    getEmergencyTable($search, "search");
}

function searchOverview($search){
    getOverviewDrivers($search, "search");
}

function actionClient($clientID, $step){
	include('../connection.php');
	if($step == 1){
		
		$query = "SELECT *
					FROM clients
					WHERE cID = $clientID";
		$sql = $db->query($query);
		$info = $sql->fetch_array();
		$active = $info['cActive'];
		echo $active;
		
		if($active == 1){
			$active = 0;
		} else{
			$active = 1;
		}
		
		
		$query = "UPDATE clients SET 
				cActive = '$active'
				WHERE cID='$clientID'";
		
					
		$db->query($query);
		
		echo '<div class="formTitle">Client Deactivated</div>';
	} else {
		$query = "SELECT *
					FROM clients
					WHERE cID = $clientID";
		$sql = $db->query($query);
		$info = $sql->fetch_array();
		echo '<div class="formTitle">Delete Client Information</div>';
		echo '<div>Do you realy want to delete '. $info['cFirstName'] .', '. $info['cLastName'] .' .</div>';
		echo '<div onclick="actionClient('.$clientID.',1)" >Yes</div> <div onclick="actionClient('.$clientID.',0)">No</div>';
	}
}

function editClient($clientID){
	include('../connection.php');
	$query = "SELECT *
				FROM clients
				WHERE cID = $clientID
				ORDER BY cLastName ASC";
	$sql = $db->query($query);
	$info = $sql->fetch_array();
    
    $activeChecked = "";
    if ($info['cActive'] == 1){
        $activeChecked = "checked";
    }
    
	//echo '<div class="formTitle">Edit Client Information</div>';
    echo ' 
    
            <br/>
            <form id="editClientForm" class="form-horizontal" action="#" role="form" method="post">
                    <input id="cID" type="hidden" value="'.$clientID.'">
					<div class="form-group">
						<label class="control-label col-sm-2" for="fName">First Name:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="fName" name="fName" value="'.$info['cFirstName'].'" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="lName">Last Name:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="lName" name="lName" value="'.$info['cLastName'].'" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Email:</label>
						<div class="col-sm-6">
							<input type="email" class="form-control" id="email" name="email" value="'.$info['cEmail'].'">
						</div>
					</div>
					<!--<div class="form-group">
						<label class="control-label col-sm-2" for="pwd">Password:</label>
						<div class="col-sm-6">
							<input type="password" class="form-control" id="pwd" name="pwd" value="">
						</div>
					</div>-->
					<div class="form-group">
						<label class="control-label col-sm-2" for="phone">Phone Number:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="phone" name="phone" value="'.$info['cPhone'].'" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="address">Address:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="addr1" name="address" value="'.$info['cAddress1'].'" required>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="address">Address:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="addr2" name="address" value="'.$info['cAddress2'].'">
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="city">City:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="city" name="city" value="'.$info['cCity'].'" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="state">State:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="state" name="state" value="'.$info['cState'].'" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="zip">ZIP Code:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="zip" name="zip" value="'.$info['cZip'].'" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="delNotes">Delivery Notes:</label>
						<div class="col-sm-6">
							<textarea id="delNotes" name="delNotes" class="form-control" rows="6" value="'.$info['cDeliveryNotes'].'" style="min-width: 100%"></textarea>
						</div>
					</div>
                    
                    
                    
                    <div class="form-group">
						<label class="control-label col-sm-2" for="FAList">Food Alergies:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="FAList" name="FAList" value="'.$info['FAList'].'" placeholder="Example: nuts,shellfish,wheat">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="zip">Food Restrictions:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="FRList" name="FRList" value="'.$info['FRList'].'" placeholder="Example: milk,bacon">
						</div>
					</div>
                    
                    
                    
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<div class="checkbox">
								<!--label><input id="FA" type="checkbox" value="1">Food Allergies </label>
								<label><input id="FR" type="checkbox" value="1">Food Restrictions </label-->
                                <label style="color: red;"><input id="isActive" type="checkbox" value="1" ' . $activeChecked . '>Is Active</label>
							</div>
						</div>
					</div>
					<!--div id="errorMSG"></div-->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<div id="editClient" class="btn btn-success">Save</div>&nbsp;
                            <a href="clients.php" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>';
}

function editDriver($driverID){
	include('../connection.php');
	$query = "SELECT *
				FROM drivers
				WHERE dID = $driverID";
	$sql = $db->query($query);
	$info = $sql->fetch_array();
	$schedule = $info['dSchedule'];
	$lat = $info['lat'];
	$lng = $info['lng'];
	$schedule = explode(",", $schedule);
	$MoC = (in_array("Mo", $schedule) ? "checked" : "");
	$TuC = (in_array("Tu", $schedule) ? "checked" : "");
	$WeC = (in_array("We", $schedule) ? "checked" : "");
	$ThC = (in_array("Th", $schedule) ? "checked" : "");
	$FrC = (in_array("Fr", $schedule) ? "checked" : "");
	
	
	$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&region=USA");

	if($json != ""){
		$json = json_decode($json);

		$delArea = $json->{'results'}[0]->{'formatted_address'};
	}
	
	echo '<form id="editDriverForm" class="form-horizontal" action="#" role="form" method="post">
					<input id="dID" type="hidden" value="'.$driverID.'">
					<div class="form-group">
						<label class="control-label col-sm-2" for="fName">First Name:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="fName" name="fName" value="'.$info['dFirstName'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="lName">Last Name:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="lName" name="lName" value="'.$info['dLastName'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Email:</label>
						<div class="col-sm-6">
							<input type="email" class="form-control" id="email" name="email" value="'.$info['dEmail'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="phone">Phone Number:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="phone" name="phone" value="'.$info['dPhoneNumber'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="dLicense">Drivers License #:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="dLicense" name="dLicense" value="'.$info['dLicenseNumber'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="vehMake">Vehicle Make:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="vehMake" name="vehMake" value="'.$info['dVehicleMake'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="vehModel">Vehicle Model:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="vehModel" name="vehModel" value="'.$info['dVehicleModel'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="vehYear">Vehicle Year:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="vehYear" name="vehYear" value="'.$info['dVehicleYear'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="vehTag">Vehicle Tag:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="vehTag" name="vehTag" value="'.$info['dVehicleTag'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="insCo">Insurance Company:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="insCo" name="insCo" value="'.$info['dInsuranceCo'].'">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="insPolicy">Policy Number:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="insPolicy" name="insPolicy" value="'.$info['dInsurancePolicy'].'">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="delArea">Starting delivery area:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="delArea" name="delArea" value="'.$delArea.'">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="notes">Driver Notes:</label>
						<div class="col-sm-6">
							<textarea id="delNotes" name="notes" class="form-control" rows="6" style="min-width: 100%">
							'.$info['dStatusComment'].'
							</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<div class="checkbox">
								<legend>Delivery Days *</legend>
								<label><input type="checkbox" name="schedule" value="Mo" '.$MoC.'>Monday</label>
								<label><input type="checkbox" name="schedule" value="Tu" '.$TuC.'>Tuesday</label>
								<label><input type="checkbox" name="schedule" value="We" '.$WeC.'>Wednesday</label>
								<label><input type="checkbox" name="schedule" value="Th" '.$ThC.'>Thursday</label>
								<label><input type="checkbox" name="schedule" value="Fr" '.$FrC.'>Friday</label>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<div id="editDriver" class="btn btn-success">Save</div>
                            <a href="drivers.php" class="btn btn-danger">Cancel</a>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<div id="changePassword" class="btn btn-success" onclick="changePassword('.$driverID.')">Generate New Password</div>
						</div>
					</div>

				</form>';
}

//
//Gets a form to add or edit an administrator.
//use $adminID of -1 for an empty form.
//
function getAdminForm($adminID){
    
    if ($_SESSION["isSuperAdmin"] != 1){
        echo '
        <div class="jumbotron">
            <h1>Sorry! :(</h1>
            <p>You must be a Super Administrator to add an administrator.</p>
        </div>
        ';
        return;
    }
    
    if($adminID === -1){
        $emptyForm = true;
        $sID = "";
    }else{
        $emptyForm = false;
        $sID = 'value="'.$adminID.'"';
    }
    
    if(!$emptyForm){
        include('../connection.php');
        $query = "SELECT *
                    FROM superusers
                    WHERE sID = $adminID
                    ORDER BY sLastName ASC";
        $sql = $db->query($query);
        $info = $sql->fetch_array();

        $activeChecked = ($info['sActive'] == 1)? "checked" : "";
        $superChecked = ($info['sSuperAdmin'] == 1)? "checked" : "";
    }

    echo '          <br /><div class="">
                    <form id="editAdminForm" class="form-horizontal" action="#" role="form" method="post">
                    <input type="text" id="sID" '.$sID.' hidden>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="fName">First Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="fName" name="fName" placeholder="Enter first name" value="' . ((isset($info['sFirstName']))? $info['sFirstName'] : "") . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="lName">Last Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="lName" name="lName" placeholder="Enter last name" value="' . ((isset($info['sLastName']))? $info['sLastName'] : "") . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="' . ((isset($info['sUsername']))? $info['sUsername'] : "") . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pwd">Password:</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter a password." value="' . ((isset($info['sPassword']))? $info['sPassword'] : "") . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pwd2">Verify Password:</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Re-Enter your password for verification." value="' . ((isset($info['sPassword']))? $info['sPassword'] : "") . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="securityQuestion">Security Question:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="securityQuestion" name="securityQuestion" placeholder="Enter a question you can answer during password recovery." value="' . ((isset($info['sSecurityQuestion']))? $info['sSecurityQuestion'] : "") . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="securityAnswer">Answer:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="securityAnswer" name="securityAnswer" placeholder="Enter your answer to the security question" value="' . ((isset($info['sSecuryAnswer']))? $info['sSecuryAnswer'] : "") . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <div class="checkbox">
                                    <label style="color: red;" ><input id="activeCheck" type="checkbox" ' . ((!$emptyForm)? $activeChecked : "checked") . ' value="1">Is Active</label>
                                </div>
                                <div class="checkbox">
                                    <label style="color: red;"><input id="superAdminCheck" type="checkbox" ' . ((!$emptyForm)? $superChecked : "") .' value="1">Is SuperAdmin</label>
                                </div>                 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                ' . (($emptyForm)? '<div id="addAdminButton" class="btn btn-success">Add Admin</div>' :
                                     '<div id="addAdminButton" class="btn btn-success">Save</div><a href="account.php" style="margin-left: 1em;" id="cancelAdminButton" class="btn btn-danger">Cancel</a>') . '
                            </div>
                        </div>
                    </form></div>
        ';

}

//
//Gets the administrators table populated with data.
//
function getAdminTable($id, $count){
    include('../connection.php');
	if($count == "all"){
        $query = "SELECT sID, sFirstName, sLastName, sUsername, sSuperAdmin, sActive
				FROM superusers
				ORDER BY sLastName ASC";
    }elseif($count == "search"){
        $query = "SELECT sID, sFirstName, sLastName, sUsername, sSuperAdmin, sActive 
            FROM superusers
            WHERE sFirstName LIKE '%$id%' OR sLastName LIKE '%$id%' OR sUsername LIKE '%$id%'
            ORDER BY sLastName ASC";
    }
    
    $errorMSG = "";
    
	$sql = $db->query($query);
	$row_cnt = $sql->num_rows;
    if ($row_cnt == 0){
        if ($count == "all") echo "<div class='alert alert-warning fade in msg'>There are currently no clients in the database.</div>";
        if ($count == "search") echo "<div class='alert alert-warning fade in msg'>There are currently no clients that match that query.</div>";
    } else {
        echo "<table class='alignleft table table-hover'>
            <thead class='tableHead'>
                <tr>";
        
        if ($_SESSION["isSuperAdmin"] == 1){
            echo "<th><i class='fa fa-check-square'></iclass></th>";
        }
        
        echo "      <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";


        while ($info = $sql->fetch_array()) {
            
            if($info['sActive'] == 1){
                $status ="Active";
            } else {
                $status ="Inactive";
            }
            
            if($info['sSuperAdmin'] == 1){
                $type ="Super";
            } else {
                $type ="Regular";
            }
            
            if ($_SESSION["isSuperAdmin"] == 1){
                echo "<tr><td><a href='accountEdit.php?sID=".$info['sID']."' class='sTableButton btn btn-xs btn-success' data-adminID='" . $info['sID'] . "'>Edit</a></td>";
            }else{
                echo "<tr>";
            }
            
            echo "<td>" . $info['sID'] . "</td>
                <td>" . $info['sLastName'] . ", " . $info['sFirstName'] . "</td>
                <td>" . $info['sUsername'] . "</td>
                <td>" . $type . "</td>
                <td>" . $status . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }
}

//
//Gets the settings form.
//
function getSettingsForm(){
    
}

//
//Gets a table of all the emergency notifications sent to the server.
//
function getEmergencyTable($id, $count){
        include('../connection.php');
	if($count == "all"){
        $query = "SELECT emergency.*, drivers.dFirstName, drivers.dLastName, drivers.dPhoneNumber
                FROM emergency, drivers
                WHERE emergency.dID = drivers.dID
                ORDER BY emergency.eDate DESC, emergency.eResolved DESC;";
    }elseif($count == "search"){
        //This query needs fixing.
        $query = "SELECT emergency.*, drivers.dFirstName, drivers.dLastName, drivers.dPhoneNumber
            FROM emergency, drivers
            WHERE eID LIKE '%$id%' OR eDate LIKE '%$id%' OR dFirstName LIKE '%$id%' OR dLastName LIKE '%$id%'
            ORDER BY eDate DESC, eResolved DESC;";
    }else{
        $query = "SELECT emergency.*, drivers.dFirstName, drivers.dLastName, drivers.dPhoneNumber
                FROM emergency, drivers
                WHERE emergency.dID = drivers.dID
                ORDER BY eDate DESC, eResolved DESC
                LIMIT ".$count.";";
    }

    $sql = $db->query($query);
    $row_cnt = $sql->num_rows;
    if ($row_cnt == 0){
        print_r( $db->error_list );
        if ($count == "all") echo "<div class='alert alert-warning fade in msg'>There are currently no emergency events posted.</div>";
        if ($count == "search") echo "<div class='alert alert-warning fade in msg'>There are currently no events that match your query.</div>";
    } else {
        echo "<div class=''><table id='emergencyTable' class='alignleft table table-hover'>
        <thead class='tableHead'>
        <tr>
            <th>Action</th>
            <th>Date</th>
            <th>Submitted By</th>
            <th>Driver Phone</th>
            <th>Location</th>
            <th>Resolved</th>
        </tr>
        </thead>
        <tbody>";

        while ($info = $sql->fetch_array()) {
            
            if($info['eCoordinates'] != ""){
                
                //This converts the coordinates to an address which can be displayed in the chart
                /*$json = "";
                $coords = str_replace(' ', '', $info['eCoordinates']);
                $search =  "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$coords; 
                $json = file_get_contents($search);
                if($json != ""){
                    $json = json_decode($json);
                    $location = $json->{'results'}[1]->{'formatted_address'};
                }*/
                
                $array = explode(' ', $info['eCoordinates'], 2);
                $location = "{lat: ".$array[0]." lng: ".$array[1]."}";
                
            }else{
                $location = "";
            }
            
            echo "<tr data-coords='" . $info['eCoordinates'] . "' data-eID='" . $info['eID'] . "' style='".(($info['eResolved'] == 0)? 'background-color: #F9DBDB;' : '')."'>
                <td><a href='#' class='eTableButton btn btn-xs btn-success' data-eid='" . $info['eID'] . "' style='display:" .(($info['eResolved'] == 1)? 'none;' : ';')  . "'>Acknowledge</a></td>
                <td>" . $info['eDate'] . "</td>
                <td>" . $info['dLastName'] . ", " . $info['dFirstName'] . "</td>
                <td>" . formatPhone($info['dPhoneNumber']) . "</td>
                <td><a href=# onclick='replaceMarker($location)'  >".(($location != '')? 'Show on map' : 'No Data')."</a></td>
                <td>" . (($info['eResolved'] == 1)? 'Yes' : '') . "</td>
            </tr>";
        }
        echo "</tbody></table></div>";
    }
}

//
//Gets a table of all the notes attached to clients.
//
function getNotesTable($id, $count){
        include('../connection.php');
	if($count == "all"){
        $query = "SELECT notes.*, clients.cFirstName, clients.cLastName
                FROM notes, clients
                WHERE notes.cID = clients.cID
                ORDER BY nDate DESC";
    }elseif($count == "search"){
        //This query needs fixing.
        $query = "SELECT notes.*, clients.cFirstName, clients.cLastName
            FROM notes, clients
            WHERE notes.nID LIKE '%$id%' OR nDate LIKE '%$id%' OR cFirstName LIKE '%$id%' OR cLastName LIKE '%$id%'
            ORDER BY nDate DESC";
    }else{
        $query = "SELECT notes.*, clients.cFirstName, clients.cLastName
                FROM notes, clients
                WHERE notes.cID = clients.cID
                ORDER BY nDate DESC
                LIMIT ".$count.";";
    }

    $sql = $db->query($query);
    $row_cnt = $sql->num_rows;
    if ($row_cnt == 0){
        print_r( $db->error_list );
        if ($count == "all") echo "<div class='alert alert-warning fade in msg'>There are currently no notes posted.</div>";
        if ($count == "search") echo "<div class='alert alert-warning fade in msg'>There are currently no notes that match your query.</div>";
    } else {
        echo "<table id='notesTable' class='scrollable-y alignleft table table-hover'>
        <thead class='tableHead'>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Client</th>
            <th>Note</th>
            <th>Urgent</th>
        </tr>
        </thead>
        <tbody class='scrollable-y'>";

        while ($info = $sql->fetch_array()) {
            
            echo "<tr style='" . (($info['nUrgent'] == 1)? 'background-color: #FFEAEA;' : '' ) . "' data=nID'" . $info['nID'] . "' data-cID='" . $info['cID'] . "'>
                </td>
                <td>" . $info['nID'] . "</td>
                <td>" . $info['nDate'] . "</td>
                <td>" . $info['cLastName'] . ", " . $info['cFirstName'] . "</td>
                <td>" . $info['nComment'] . "</td>
                <td>" . (($info['nUrgent'] == 1)? 'yes' : '') . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }
}

function gUsername($name, $last){
	include('../connection.php');
	if($last == "recursive"){
		$userName = $name;
	} else {
		$userName = substr($name, 0, 1);
		$userName .= $last;
	}
	
	// Check if username is taken
	$query = 'SELECT * FROM drivers where dUsername = "'.$userName.'"';

	$sql = $db->query($query);
	$taken = $sql->num_rows;

	if($taken > 0){
		$number = rand(10, 999);
		$userName .= $number;
	    return gUsername($userName, "recursive");
	} else {
	  return $userName;
	}
}

function gPassword(){
	$lArray = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$nol = 0;
	$pass = "";
	$next = "";
	for ($i = 0; $i <= 5; $i++) {
		$nol = rand(0,1);
		
		if($nol == 0){
			$next = rand(0,9);
		} else {
			$next = $lArray[rand(0,25)];
		}
		$pass .= $next;
	}
	return $pass;
}

function slice($input, $slice) {
    $arg = explode(':', $slice);
    $start = intval($arg[0]);
    if ($start < 0) {
        $start += strlen($input);
    }
    if (count($arg) === 1) {
        return substr($input, $start, 1);
    }
    if (trim($arg[1]) === '') {
        return substr($input, $start);
    }
    $end = intval($arg[1]);
    if ($end < 0) {
        $end += strlen($input);
    }
    return substr($input, $start, $end - $start);
}

function getTodaysDay($d){
	if($d == null){
		$d = date("w");
	}
	switch ($d) {
    case 0:
        $dayW = "Su";
        break;
    case 1:
        $dayW = "Mo";
        break;
    case 2:
        $dayW = "Tu";
        break;
	case 3:
        $dayW = "We";
        break;
	case 4:
        $dayW = "Th";
        break;
	case 5:
        $dayW = "Fr";
        break;
	case 6:
        $dayW = "Sa";
        break;
	}
	return $dayW;
}

// FIX SUNDAY BUG
function getWeek(){
	$d = date("w");
	$w = date('W');
	if($d == 0){
		$w++;
	}
	return $w;
}

function copyLastWeek(){
	$time_pre = microtime(true);
	include('../connection.php');
	set_time_limit(120);
	$lastWeek = getWeek()-1;
	$thisWeek = getWeek();
	$query = "SELECT
			  routes.rID,
			  routes.rWeek,
			  routes.dID,
			  routes.cID,
			  routes.rDay
			FROM routes
			  INNER JOIN clients
			WHERE routes.cID = clients.cID
			AND clients.cActive = 1
			AND routes.rWeek = $lastWeek";
	//echo $query;
	$sql = $db->query($query);
	 while ($info = $sql->fetch_array()) {
		$cID = $info['cID'];
		$dID = $info['dID'];
		// Check if client is in for this week.
		if(!inForThisWeek($cID,$thisWeek,$db)){
			// Today is
			for($i = 1; $i <= 5; $i++){
				$delDay = date('Y/m/d',time()+( $i - date('w'))*24*3600);
				$rDay = getTodaysDay($i);
				
				//echo $delDay.' '.$info['cID'].' '.$rDay.' '.$thisWeek.'</br>';
				
					$unixDate = unixTime($delDay);
					$query = "INSERT INTO routes (cID,dID,rDate,unixDate,rDay,rWeek) 
								VALUES ('$cID','$dID', '$delDay','$unixDate', '$rDay', '$thisWeek')";
					//echo $query;
					$db->query($query);
				
			}
		}
	}
	$time_post = microtime(true);
	$exec_time = $time_post - $time_pre;
	
	echo "Last weeks routes has been copyed: ".format_period($exec_time)."</br>";
}

function populateRoutes(){
	$time_pre = microtime(true);
	include('../connection.php');
	set_time_limit(120);
	$reportS = 0;
	$reportW = 0;
	$thisWeek = getWeek();
	$query = "SELECT cID FROM clients WHERE cActive = 1";
	$sql = $db->query($query);
	 while ($info = $sql->fetch_array()) {
		$cID = $info['cID'];
		// Check if client is in for this week.
		if(!inForThisWeek($cID,$thisWeek,$db)){
			// Today is
			for($i = 1; $i <= 5; $i++){
				$delDay = date('Y/m/d',time()+( $i - date('w'))*24*3600);
				$rDay = getTodaysDay($i);
				
				//echo $delDay.' '.$info['cID'].' '.$rDay.' '.$thisWeek.'</br>';
				
				$unixDate = unixTime($delDay);
			
					$query = "INSERT INTO routes (cID,rDate,unixDate,rDay,rWeek) 
								VALUES ('$cID', '$delDay','$unixDate', '$rDay', '$thisWeek')";
					//echo $query;
					$db->query($query);
					$reportS++;
				
			}
		} else {
			$reportW++;
		}
		
	}

	$time_post = microtime(true);
	$exec_time = $time_post - $time_pre;
	echo "$reportS Clients were populated -- $reportW Clients were already  populated for this week</br>";
	echo "Routes has been populated: ".format_period($exec_time)."</br>";
	
	
}

function todaysDrivers($day){
	include('../connection.php');
	set_time_limit(120);
	$query = "SELECT * FROM drivers WHERE dActive = 1 AND dSchedule LIKE ('%$day%')";
	//echo $query;
	$sql = $db->query($query);
	$drivers = '';
	while( $dInfo = $sql->fetch_array()){
		$drivers .= '<div class="col-md-4"><input name="drivers[]" class="driver_checkbox" type="checkbox" value="'.$dInfo['dID'].'" checked /> '.$dInfo['dFirstName'].', '.$dInfo['dLastName'].'</div>' ;
		
		$driver_array[] = $dInfo;
	}
	echo $drivers;
}

function insertDriver($date, $dArray){
	$time_pre = microtime(true);
	include('../connection.php');
	set_time_limit(1500);
	$query = "SELECT dID, lat, lng,dSchedule FROM drivers WHERE dActive = 1";
	$sql = $db->query($query);
	while( $dInfo = $sql->fetch_array()){
		if($dArray != 0){
			
			if (in_array($dInfo['dID'], $dArray)) {
				$driver_array[] = $dInfo;
			}
			
			
		} else {
			$driver_array[] = $dInfo;
		}
	}
	//print_r($driver_array);
	if($date == 0){
		$rQuery = "SELECT
			  routes.rID,
			  routes.cID,
			  routes.rDay,
			  clients.cLng,
			  clients.cLat
			FROM routes
			  INNER JOIN clients
			WHERE routes.cID = clients.cID";
	} else {
		$todayUnixDate = mktime(6, 0, 0, date('n'), date('j'), date('Y'));
		//echo $todayUnixDate;
		$rQuery = "SELECT
			  routes.rID,
			  routes.cID,
			  routes.rDay,
			  clients.cLng,
			  clients.cLat
			FROM routes
			  INNER JOIN clients
			WHERE routes.unixDate = $todayUnixDate AND  routes.cID = clients.cID";
	}
	//echo $rQuery;
	$route = $db->query($rQuery);
	while($cInfo = $route->fetch_array()){
		//echo "----------------------------------</br>";
		//echo $cInfo['rID'].' '.$cInfo['cID'].' '.$cInfo['rDay'].' '.$cInfo['cLat'].' '.$cInfo['cLng'].'</br>';
		$driver = closestDriver($cInfo['cLat'],$cInfo['cLng'], $cInfo['rDay'], $driver_array);
		
		$rID = $cInfo['rID'];
		$updateQ = "UPDATE routes SET dID =$driver WHERE rID=$rID";
		//echo $updateQ.'</br>';
		$db->query($updateQ);
		//echo "----------------------------------</br>";
	}
	$time_post = microtime(true);
	$exec_time = $time_post - $time_pre;
	
	echo "Drivers has been assigned: ".format_period($exec_time)."</br>";
}

function closestDriver($cLat,$cLng, $dDay, &$dArray){
	if($cLat == null || $cLng == null){
		//echo "Invalid location </br>";
		return 0;
	} else {
		$closestDriver = 0;
		$sDistance = 6371000;
		$cDistance = 6371000;
		//echo $cLat.' '.$cLng.'</br>';
		foreach ($dArray as $key => $driver) {
			$driverID = $driver[0];
			$driverLat = $driver[1];
			$driverLng = $driver[2];
			$driverSchedule = $driver[3];
			$driverScheduleArray = explode(",",$driverSchedule);
			// Check delivery Day
			if(in_array($dDay, $driverScheduleArray)){
				//echo $driverID.' ';
				$cDistance = vincentyGreatCircleDistance($cLat,$cLng,$driverLat,$driverLng);
				if($cDistance < $sDistance){
					$closestDriver = $driverID;
					$sDistance = $cDistance;
				}
			} else {
				//echo "($driverID) I dont work that day ($driverSchedule | $dDay | ) </br>";
			}
			//echo $sDistance.' '.$cDistance.'</br>';
		}
		//echo $closestDriver.'</br>';
		return $closestDriver;
	}
}

function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000){
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $lonDelta = $lonTo - $lonFrom;
  $a = pow(cos($latTo) * sin($lonDelta), 2) +
    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

  $angle = atan2(sqrt($a), $b);
  return $angle * $earthRadius;
}

function inForThisWeek($cID, $thisWeek,$db){

	$query = "SELECT * FROM routes where cID = $cID AND rWeek = '$thisWeek'";


	$sql = $db->query($query);
	$iWeek = $sql->num_rows;

	if($iWeek > 0){
		return true;
	} else {
	  return false;
	}
}

function initRoutes(){
	$time_pre = microtime(true);
	// Populate the routes DB
	populateRoutes();
	// Select Driver
	insertDriver(0,0);
	$time_post = microtime(true);
	$exec_time = $time_post - $time_pre;
	
	echo "New Schedules as Been Created: ".format_period($exec_time)."</br>";
	
	
}

function getDeliverys($weekNumber, $dDay,$d){
	include('../connection.php');
	$listOfAllDrivers = genDList($db);
	$rQuery = "SELECT
				  clients.cFirstName,
				  clients.cLastName,
				  drivers.dID,
				  drivers.dFirstName,
				  drivers.dLastName,
				  drivers.dPhoneNumber,
				  routes.rID,
				  routes.rDate,
				  routes.rSuccess,
				  routes.rReschedule
				FROM routes
				  INNER JOIN clients
				  INNER JOIN drivers
				WHERE clients.cID = routes.cID
				AND drivers.dID = routes.dID
				AND routes.rWeek = $weekNumber
				AND routes.rDay = '$dDay'";
	//echo $rQuery;
	$route = $db->query($rQuery);
	$delCount = $route->num_rows;
	echo '<div>'.date("F j, Y", time() +$d).'</div>';
	echo "<table class='alignleft table table-hover'>
            <thead class='tableHead'>
            <tr>
				<th>Driver</th>
				<th>Driver Number</th>
				<th>Client</th>
				<th>Status</th>
            </tr>
            </thead>
            <tbody>";

	if($delCount == 0){
		echo "<tr>
				<th>No delivery today!</th>
			  </tr>";
	} else {
		while($dInfo = $route->fetch_array()){
			if($dInfo['rSuccess'] == 1){
				$status ="Delivered";
				#$action = "Deactivate";
			} else {
				$status ="Enroute";
				#$action = "Activate";
			}
			$rID = $dInfo['rID'];
			$dID = $dInfo['dID'];
			$clientName = $dInfo['cLastName'].', '.$dInfo['cFirstName'];
			$driverName = $dInfo['dLastName'].', '.$dInfo['dFirstName'];
			$driverNumber = formatPhone($dInfo['dPhoneNumber']);
			
			/*if($dDay == getTodaysDay(date('w'))){
				$selectD = "<select onchange='changeDriver($rID,this.options[this.selectedIndex].value)'>
							<option value='$dID'>$driverName</option>				
							$listOfAllDrivers
							</select>";
			} else {
				$selectD = $driverName;
			}*/
			
			$selectD = "<select onchange='changeDriver($rID,this.options[this.selectedIndex].value)'>
							<option value='$dID'>$driverName</option>				
							$listOfAllDrivers
							</select>";
			
			echo "<tr>
					<td>
					$selectD
					</td>
					<td>$driverNumber</td>
					<td>$clientName</td>
					<td>$status</td>
				</tr>";
		}
	}
	echo "</tbody></table>";

}

function genDList($db){
	
	$query = "SELECT dID,dLastName,dFirstName FROM drivers WHERE dActive = 1 ORDER BY dLastName ASC";

    $sql = $db->query($query);
    $list = '';
    while ($info = $sql->fetch_array()) {
		$dID = $info['dID'];
		$driverName = $info['dLastName'].', '.$info['dFirstName'];
		$list .= '<option value="'.$dID.'">'.$driverName.'</option>';
	}
	return $list;
}

function rangeWeek($datestr) {
	$dt = strtotime($datestr);
	echo date('N', $dt)==1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt));
	echo " - ";
	echo date('N', $dt)==7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt));
}

function unixTime($thisDate){
	//echo $thisDate."</br>";
	$xDate = explode("/", $thisDate);
	return mktime(6, 0, 0, $xDate[1], $xDate[2], $xDate[0]);
}

function format_period($seconds_input){
  $hours = (int)($minutes = (int)($seconds = (int)($milliseconds = (int)($seconds_input * 1000)) / 1000) / 60) / 60;
  return $hours.':'.($minutes%60).':'.($seconds%60).(($milliseconds===0)?'':'.'.rtrim($milliseconds%1000, '0'));
}
?>