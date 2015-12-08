<?php
include_once("session.php"); 
$search = $_POST['searchFor'];
$where = $_POST['where'];

if($where == "Clients"){
	if(strlen($search) == 0){
		getClient(0,"all");
	} else {
		searchClient($search);	
	}	
} elseif($where == "Drivers"){
    if(strlen($search) == 0){
		getDrivers(0,"all");
	} else {
		searchDriver($search);	
	}
} elseif($where == "Deliveries"){
    if(strlen($search) == 0){
		//Get all data here
	} else {
		//Get specific data here.	
	}
} elseif($where == "Reports"){
    if(strlen($search) == 0){
		getEmergencyTable(0, "all");
	} else {
		searchEmergencies($search);	
	}
} elseif($where == "Accounts"){
    if(strlen($search) == 0){
		getAdminTable(0, "all");
	} else {
		searchAdmin($search);
	}
} elseif($where == "Overview"){
    if(strlen($search) == 0){
		getOverviewDrivers(0, "all");
	} else {
		searchOverview($search);
	}
}
?>