<?php
include_once("session.php"); 
if( $_POST['action'] == "changeDate"){
	$day = $_POST['showDay'];
	
	//echo date('W') ."  ".date('w');
	
	$weekNumber = date('W');
	$dDay = getTodaysDay(date('w'));
	$dx = 0;
	if($day == 'yesterday'){
		$d = date('w');
		if($d == 0){
			$d = 6;
		} else {
			if($d == 1){
				$weekNumber = $weekNumber - 1;
			}
			$d = $d-1;
		}
		$dx =(60 * 60 * 24) * -1;
		$dDay = getTodaysDay($d);
	} else if($day == 'tomorrow'){
		$d = date('w');
		if($d == 6){
			$d = 0;
			$weekNumber = $weekNumber + 1;
		} else {
			if($d == 0){
				$weekNumber = $weekNumber + 1;
			}
			$d = $d+1;
		}
		
		$dx =(60 * 60 * 24) * 1;
		$dDay = getTodaysDay($d);
	}
	
	
	
	//echo "$weekNumber $dDay $dx</br>";
	getDeliverys($weekNumber, $dDay,$dx);
}


if( $_POST['action'] == "genNew"){
	initRoutes();
}

if( $_POST['action'] == "genToday"){
	$driverArray = $_POST['driverArray'];
	insertDriver(1,$driverArray);
}

if( $_POST['action'] == "genCopy"){
	copyLastWeek();
}


if( $_POST['action'] == "changeDriver"){
	$dID = $_POST['dID'];
	$rID = $_POST['rID'];
	
	$query = "UPDATE routes SET 
				dID ='$dID'
				WHERE rID='$rID'";
    $db->query($query);
	echo "Driver Changed!";
}


?>