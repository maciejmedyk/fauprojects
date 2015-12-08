<?php
include_once("session.php"); 

if($_POST["action"] == "clientEdit"){
	editClient($_POST['cID']);
}

if($_POST['action']== "clientDelete"){
	actionClient($_POST['cID'],0);
}

if($_POST['action'] == "clientDeleteConfirm"){
	actionClient($_POST['cID'],1);
}

if($_POST["action"] == "submitClientEdit"){
	$cID      = $_POST['cID'];
	$fName    = $_POST['fName'];
	$lName    = $_POST['lName'];
	$email    = $_POST['email'];
	$phone    = $_POST['phone'];
	$addr1    = $_POST['addr1'];
	$addr2    = $_POST['addr2'];
	$city     = $_POST['city'];
	$state    = $_POST['state'];
	$zip      = $_POST['zip'];
	$delNotes = $_POST['delNotes'];
	$FA       = $_POST['FA'];
	$FR       = $_POST['FR'];
    $FAList   = $_POST['FAList'];
    $FRList   = $_POST['FRList'];
	$Active   = $_POST['Active'];

	$address = "$addr1 $addr2 $city $state $zip";
	
	$address = str_replace("#", "", $address);
	$address = str_replace(" ", "-", $address);
	$address = preg_replace("/--+/", "+", $address);
	$address = str_replace("-", "+", $address);
	if(substr($address, -1) == "+"){
		$address = substr($address, 0, -1);
	}
	$json = "";
	$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA");

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
	
	if($FAList == ""){
		$FA = 0;
	} else {
		$FA = 1;
	}
	
	if($FRList == ""){
		$FR = 0;
	} else {
		$FR = 1;
	}
	
	if($Active == "true"){
		$Active = 1;
	} else {
		$Active = 0;
	}
	
	$query = "UPDATE clients SET 
				cFirstName ='$fName ', 
				cLastName ='$lName', 
				cAddress1 ='$addr1', 
				cAddress2 ='$addr2', 
				cCity ='$city', 
				cState ='$state', 
				cZip ='$zip',
				cLat ='$lat',
				cLng ='$lng',
				cPhone ='$phone', 
				cFoodAllergies ='$FA', 
				cFoodRestrictions ='$FR', 
				cDeliveryNotes ='$delNotes',
				cActive ='$Active',
                FAList ='$FAList',
                FRList ='$FRList'
				WHERE cID ='$cID';
                ";
    
    if (!$db->query($query)) {
        print_r($db->error_list);
    }else{
        $_SESSION['errorMSG'] = "Client info for ".$fName." ".$lName." has been successfully updated.";
        $_SESSION['errorType'] = 1;
        echo "<script> window.location.replace('clients.php') </script>";
    }
}


if($_POST["action"] == "submitNewClient"){
	$fName    = $_POST['fName'];
	$lName    = $_POST['lName'];
	$email    = $_POST['email'];
	$phone    = $_POST['phone'];
	$addr1    = $_POST['addr1'];
	$addr2    = $_POST['addr2'];
	$city     = $_POST['city'];
	$state    = $_POST['state'];
	$zip      = $_POST['zip'];
	$delNotes = $_POST['delNotes'];
	//$FA       = $_POST['FA'];
	//$FR       = $_POST['FR'];
    $FAList   = $_POST['FAList'];
    $FRList   = $_POST['FRList'];
	$Active   = $_POST['Active'];
	
	$address = "$addr1 $addr2 $city $state $zip";
	
	$address = str_replace("#", "", $address);
	$address = str_replace(" ", "-", $address);
	$address = preg_replace("/--+/", "+", $address);
	$address = str_replace("-", "+", $address);
	if(substr($address, -1) == "+"){
		$address = substr($address, 0, -1);
	}
	
	$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA");
	$json = json_decode($json);

    //These keep giving undefined offset errors but it works fine.
	$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	$lng = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	
	if($lat == "" && $lng == ""){
		$lat = $json->{'results'}[0]->{'location'}->{'lat'};
		$lng = $json->{'results'}[0]->{'location'}->{'lng'};
	}else if($lat == ""){
		$lat = 'empty';
		$lng = 'empty';
	}
	
	if($FAList == ""){
		$FA = 0;
	} else {
		$FA = 1;
	}
	
	if($FRList == ""){
		$FR = 0;
	} else {
		$FR = 1;
	}
	
	if($Active == "true"){
		$Active = 1;
	} else {
		$Active = 0;
	}
	
	
	$query = "INSERT INTO clients (cFirstName,cLastName,cAddress1,cAddress2,cCity,cState,cZip,cLat,cLng,cPhone,cFoodAllergies,cFoodRestrictions,cDeliveryNotes,cActive,FAList,FRList) 
							VALUES ('$fName', '$lName', '$addr1', '$addr2', '$city', '$state', '$zip','$lat','$lng', '$phone', '$FA', '$FR', '$delNotes', '1', '$FAList', '$FRList')";
	
    if (!$db->query($query)) {
        print_r($db->error_list);
    }else{
        $_SESSION['errorMSG'] = $fName." ".$lName." has been successfully added to the list.";
        $_SESSION['errorType'] = 1;
        echo "<script> window.location.replace('clients.php') </script>";
    }
}
?>