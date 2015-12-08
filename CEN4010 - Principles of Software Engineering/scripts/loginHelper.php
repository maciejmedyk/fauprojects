<?php
function isLocked($uID, $uType, $lockedAt){
	if($lockedAt != 0){
		include('../connection.php');
		$query = "select lockCount from trap where lockedID='$uID' AND lockType='$uType'";	
		$sql = $db->query($query);
		$row = $sql->fetch_array();
		$row_cnt = $sql->num_rows;
		
		if ($row_cnt == 1){
			if($row['lockCount'] >= $lockedAt){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
	
}

function inLockTable($uID, $uType){
	include('../connection.php');
		$query = "select * from trap where lockedID='$uID' AND lockType='$uType'";	
		$sql = $db->query($query);
		$row = $sql->fetch_array();
		$row_cnt = $sql->num_rows;
		if ($row_cnt == 1){
			return true;
		} else {
			return false;
		}
}

function bruteForceProtection($userName, $uType){
	include('../connection.php');
	$unixTime = mktime( date("H") ,  date("i") ,  date("s") , date('n'), date('j'), date('Y'));

	if($uType == 1){
		$query = "SELECT dID
						FROM drivers
						WHERE dUsername = '$userName'";
	} else if($uType == 0) {
		$query = "SELECT sID
						FROM superusers
						WHERE sUsername = '$userName'";
	}
			
	$sql = $db->query($query);
	$row = $sql->fetch_array();
	$uID = $row['0'];

	if(inLockTable($uID, $uType)){
		// Update
		$query = "UPDATE trap SET 
			lockCount = lockCount + 1, 
			tTimestamp ='$unixTime'
			WHERE lockedID ='$uID';
			";
	} else {
		// Insert
		$query = "INSERT INTO trap (lockedID,lockCount,lockType) 
						VALUES ('$uID', '1', '$uType')";
	}
	$db->query($query);

}

function bruteForceCheck($userName, $uType, $lockedAt){
	include('../connection.php');
	$unixTime = mktime( date("H") ,  date("i") ,  date("s") , date('n'), date('j'), date('Y'));

	if($uType == 1){
		$query = "SELECT dID
						FROM drivers
						WHERE dUsername = '$userName'";
	} else if($uType == 0) {
		$query = "SELECT sID
						FROM superusers
						WHERE sUsername = '$userName'";
	}
			
		$sql = $db->query($query);
		$row = $sql->fetch_array();
		$uID = $row['0'];
		if(isLocked($uID, $uType, $lockedAt)){
			if($uType == 0){
				$msg = checkUnlock($uID);
			} else{
				$msg = "your account is locked out";
			}
			return array(true, $msg);
		} else {
			return array(false);
		}	
}

function bruteForceClean($uID, $uType){
	include('../connection.php');
	if(inLockTable($uID, $uType)){
		// Update
		$query = "DELETE FROM trap
					WHERE lockedID ='$uID' AND lockType='$uType'";
		$db->query($query);
	}
}

function checkUnlock($uID){
	// Unlock admin only
	include('../connection.php');
	$lockTime = 10;
	$unixTime = mktime( date("H") ,  date("i") ,  date("s") , date('n'), date('j'), date('Y'));
	$query = "select * from trap where lockedID='$uID' AND lockType='0'";

	$sql = $db->query($query);
	$row = $sql->fetch_array();
	
	$unixLock = $lockTime *60;
	$lockedTime = $row['tTimestamp'];
	$unlockAt = $lockedTime + $unixLock;

	if($unixTime >= $unlockAt){
		bruteForceClean($uID, 0);
		return "Your account has been unlocked please try loging in one more time";
	}
	$timeR = $unlockAt - $unixTime;
	$timeR = $timeR / 60;
	$timeR = round($timeR,1,PHP_ROUND_HALF_UP);
	return "You are locked out, your account will unlock in $timeR min";
		
}

function getSecurityQuestion($userName){
	include('connection.php');
	$query = "SELECT sID, sSecurityQuestion
						FROM superusers
						WHERE sUsername = '$userName'";
	$sql = $db->query($query);
	$row = $sql->fetch_array();
	$row_cnt = $sql->num_rows;
		
	if ($row_cnt == 1){
		return array(true ,$row['sID'], $row['sSecurityQuestion']);
	} else {
		bruteForceIPProtection($_SERVER['REMOTE_ADDR']);
		return array(false);
	}
}

function checkSecurityQuestion($sID, $answer){
	include('connection.php');
	$query = "SELECT *
					FROM superusers
					WHERE sID = '$sID' AND sSecuryAnswer = '$answer'";
	$sql = $db->query($query);
	$row = $sql->fetch_array();
	$row_cnt = $sql->num_rows;
		
	if ($row_cnt == 1){
		return array(true);
	} else {
		bruteForceIPProtection($_SERVER['REMOTE_ADDR']);
		return array(false);
	}
}

function bruteForceIPProtection($IP){
	include('connection.php');
	$unixTime = mktime( date("H") ,  date("i") ,  date("s") , date('n'), date('j'), date('Y'));


	if(lockedIP($IP)){
		// Update
		$query = "UPDATE trap SET 
			lockCount = lockCount + 1, 
			tTimestamp ='$unixTime'
			WHERE attactIP ='$IP';
			";
	} else {
		// Insert
		$query = "INSERT INTO trap (attactIP,lockCount,lockType) 
						VALUES ('$IP', '1', '2')";
	}
	$db->query($query);

}

function lockedIP($IP){
	include('connection.php');
		$query = "select * from trap where attactIP='$IP' AND lockType='2'";	
		$sql = $db->query($query);
		$row = $sql->fetch_array();
		$row_cnt = $sql->num_rows;
		if ($row_cnt == 1){
			return true;
		} else {
			return false;
		}
}

function unlockedIP($IP){
	// Unlock admin only
	include('connection.php');
	$lockTime = 10;
	$unixTime = mktime( date("H") ,  date("i") ,  date("s") , date('n'), date('j'), date('Y'));
	$query = "select * from trap where attactIP='$IP' AND lockType='2' AND lockCount >= '10'";

	$sql = $db->query($query);
	$row = $sql->fetch_array();
	$row_cnt = $sql->num_rows;
	if ($row_cnt == 1){
		$unixLock = $lockTime *60;
		$lockedTime = $row['tTimestamp'];
		$unlockAt = $lockedTime + $unixLock;

		if($unixTime >= $unlockAt){
			bruteForceIPClean($IP);
			return array(true,"You have been unlocked please try one more time");
		}
		$timeR = $unlockAt - $unixTime;
		$timeR = $timeR / 60;
		$timeR = round($timeR,1,PHP_ROUND_HALF_UP);
		return array(true,"You are locked out, this will reset in $timeR min");
	} else {
		return array(false);
	}
}

function bruteForceIPClean($IP){
	include('connection.php');
		$query = "DELETE FROM trap
					WHERE attactIP ='$IP' AND lockType='2'";
		$db->query($query);
}

function saveNewPassword($sID,$password){
	include('connection.php');
	//echo $sID.' '.$password;
	$query = "UPDATE superusers SET 
			sPassword = '$password'
			WHERE sID ='$sID'
			";
	//echo $query;
	$db->query($query);
}
?>