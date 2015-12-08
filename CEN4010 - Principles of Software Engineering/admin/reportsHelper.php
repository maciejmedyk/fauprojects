<?php
include("functions.php");

if($_POST["action"] == "resolveEmergency"){
    
    include('../connection.php');
    
    $eID = $_POST["eID"];
    
    $query = "UPDATE emergency
            SET eResolved=1
            WHERE eID='$eID';";
    
    $sql = $db->query($query);
    
    if(!$sql){
        echo "<div class='alert alert-warning fade in msg'>There were SQL errors.<br/>".mysqli_error($db)."</div>";
        return;
    }
    echo 1;
}
?>