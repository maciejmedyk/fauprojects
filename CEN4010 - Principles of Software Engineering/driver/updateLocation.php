<?php
include_once("session.php"); 
    if(isset($_POST['dID']) && isset($_POST['lng']) && isset($_POST['lat'])){
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $dID = $_POST['dID'];
        
        $query = "UPDATE drivers SET curLat='$lat', curLng='$lng' WHERE dID=$dID;";
        $sql = $db->query($query);

        if($sql){
            echo "Successfully updated driver " . $dID . " with location: " . $lat . "  " . $lng;
        }else{
            echo "There was an SQL Error:  " . $sql->error;
        }
    }else{
        echo "Driver Location Update failed.";
    }


?>