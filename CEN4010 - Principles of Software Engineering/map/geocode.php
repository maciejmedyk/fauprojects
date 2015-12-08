<?php 
function getGeoLocation($address){
	$API_KEY = 'AIzaSyBL6ZmQaGywbYAJMxnkbhLFarYBlCHxtVE';
	$baseurl = "https://maps.google.com/maps/api/geocode/json?sensor=false&address=";
	$adr = urlencode($address);
	
	$url = $baseurl.$adr."&key=".$API_KEY;
	
	$resp_json = file_get_contents($url);
	$resp = json_decode($resp_json, true);

	if ($resp['status']='OK') 
	{
		return $resp['results'][0]['geometry']['location'];
	}
	else
	{
		return false;
	}
}
?>