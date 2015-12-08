<?php
include_once("session.php"); 
if($_POST["action"] == "driverNewpass"){
	$dID = $_POST['dID'];
	$pass = gPassword();
	$query = "UPDATE drivers SET 
				dPassword ='$pass '
				WHERE dID='$dID'";
    $db->query($query);
	echo "New Password ". $pass;
}


if($_POST['action'] == "unlockDriver"){
	unLock($_POST['dID']);
}

if($_POST['action'] == "retireDriver"){
	retireDriver($_POST['dID'], $_POST['step']);
}


if($_POST["action"] == "submitDriverEdit"){
	$dID            = $_POST['dID'];
	$fName          = $_POST['fName'];
	$lName          = $_POST['lName'];
	$email          = $_POST['email'];
	$phone          = $_POST['phone'];
	$license        = $_POST['license'];
	$make           = $_POST['make'];
	$model          = $_POST['model'];
	$year           = $_POST['year'];
	$tag            = $_POST['tag'];
	$insurance      = $_POST['insurance'];
	$policyNumber   = $_POST['policyNumber'];
	$delNotes       = $_POST['delNotes'];
	$schedule       = $_POST['schedule'];
	$schedule = implode(",", $schedule);
	
	$address = $_POST['delArea'];
	
	$address = str_replace("#", "", $address);
	$address = str_replace(" ", "-", $address);
	$address = preg_replace("/--+/", "+", $address);
	$address = str_replace("-", "+", $address);
	if(substr($address, -1) == "+"){
		$address = substr($address, 0, -1);
	}
	$json = "";
	$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA");
	//echo "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA";
	if($json != ""){
		$json = json_decode($json);

		$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$lng = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		
		if($lat == "" && $lng == ""){
			$lat = $json->{'results'}[0]->{'location'}->{'lat'};
			$lng = $json->{'results'}[0]->{'location'}->{'lng'};
		}else if($lat == ""){
			$lat = 'empty';
			$lng = 'empty';
		}
	}
	//echo $lat." ".$lng;
	$query = "UPDATE drivers SET 
				dFirstName ='$fName ', 
				dLastName ='$lName', 
				dPhoneNumber ='$phone', 
				dEmail ='$email', 
				dLicenseNumber ='$license', 
				dVehicleYear ='$year', 
				dVehicleMake ='$make', 
				dVehicleModel ='$model', 
				dVehicleTag ='$tag', 
				dInsuranceCo ='$insurance', 
				dInsurancePolicy ='$policyNumber',
				dStatusComment = '$delNotes',
				dSchedule = '$schedule',
				lat = '$lat',
				lng = '$lng'
				WHERE dID='$dID'";
				//echo $query;
    $db->query($query);
	
	echo "Driver Information has been Updated";
}


if($_POST["action"] == "submitNewDriver"){
	
	$fName          = $_POST['fName'];
	$lName          = $_POST['lName'];
	$email          = $_POST['email'];
	$phone          = $_POST['phone'];
	$license        = $_POST['license'];
	$make           = $_POST['make'];
	$model          = $_POST['model'];
	$year           = $_POST['year'];
	$tag            = $_POST['tag'];
	$insurance      = $_POST['insurance'];
	$policyNumber   = $_POST['policyNumber'];
	$delNotes       = $_POST['delNotes'];
	$schedule       = $_POST['schedule'];
	$schedule = implode(",", $schedule);
	$Active         = $_POST['Active'];
	
	$address = $_POST['delArea'];
	
	$address = str_replace("#", "", $address);
	$address = str_replace(" ", "-", $address);
	$address = preg_replace("/--+/", "+", $address);
	$address = str_replace("-", "+", $address);
	if(substr($address, -1) == "+"){
		$address = substr($address, 0, -1);
	}
	$json = "";
	$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA");
	//echo "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA";
	if($json != ""){
		$json = json_decode($json);

		$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$lng = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		
		if($lat == "" && $lng == ""){
			$lat = $json->{'results'}[0]->{'location'}->{'lat'};
			$lng = $json->{'results'}[0]->{'location'}->{'lng'};
		}else if($lat == ""){
			$lat = 'empty';
			$lng = 'empty';
		}
	}
	
	//Generate UserName
	$userName = gUsername($fName,$lName);
	//Generate Password
	$pass = gPassword();
	
	/*if($Active == "true"){
		$Active = 1;
	} else {
		$Active = 0;
	}*/
	
	
	$query = "INSERT INTO drivers (dFirstName,dLastName, dPhoneNumber, dEmail, dLicenseNumber, dVehicleYear, dVehicleMake, dVehicleModel, dVehicleTag, dInsuranceCo, dInsurancePolicy, dUsername, dPassword, dActive, dStatusComment, dSchedule, lat, lng) 
			VALUES ('$fName', '$lName', '$phone', '$email', '$license', '$year', '$make', '$model', '$tag', '$insurance', '$policyNumber', '$userName', '$pass', '$Active', '$delNotes', '$schedule', '$lat', '$lng')";
	//echo $query;
    $db->query($query);
	
	echo "<h2>Driver Added<h2>";
	echo "<h3>".$userName."</h3><h3> ".$pass."</h3>";
}
?>