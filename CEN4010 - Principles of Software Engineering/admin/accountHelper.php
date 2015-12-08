<?php
include_once("session.php"); 

//
//Submits administrators for both the add and edit forms.
//
if($_POST["action"] == "submitAdmin"){
	$sID      = $_POST['sID'];
	$fName    = $_POST['fName'];
	$lName    = $_POST['lName'];
	$email    = $_POST['email'];
	$pwd      = $_POST['pwd'];
	$secQ     = $_POST['secQuestion'];
	$secA     = $_POST['secAnswer'];
    $active   = $_POST['active'];
    $super     = $_POST['type'];
	
    $active = ($active == "true")? 1 : 0;
    $super = ($super == "true")? 1 : 0;
	
    if($sID != ""){
        	$query = "UPDATE superusers SET 
				sFirstName ='$fName ', 
				sLastName ='$lName', 
				sUsername ='$email', 
				sPassword ='$pwd', 
				sSecurityQuestion ='$secQ', 
				sSecuryAnswer ='$secA', 
				sSuperAdmin ='$super',
				sActive ='$active'
                WHERE sID ='$sID';
                ";
    }else{
            $query = "INSERT INTO superusers (sFirstName,sLastName,sUsername,sPassword,sSecurityQuestion,sSecuryAnswer,sSuperAdmin,sActive) 
							VALUES ('$fName', '$lName', '$email', '$pwd', '$secQ', '$secA', '$super','$active')";
    }
    
    if (!$db->query($query)) {
        print_r($db->error_list);
    }else{
        $_SESSION['errorMSG'] = "Admin info for ".$fName." ".$lName." has been successfully updated.";
        $_SESSION['errorType'] = 1;
        echo "<script> window.location.replace('account.php') </script>";
    }
}
?>