<?php
include_once("session.php");

if($_POST["action"] == "getRouteInfo"){
    
    include('../connection.php');
    
    $driverID = $_POST["dID"];
    
	if($driverID == ""){
        echo "<script> errorMSG('There was an error trying to look up driverID: ".$driverID.".'); </script>";
        return;
    }

    //$countQuery = "SELECT d.dID, d.dFirstName, d.dLastName, d.lat, d.lng
    //                FROM drivers AS d
    //                WHERE d.dID = $driverID;";
    
    $countQuery = "SELECT d.dID, d.dFirstName, d.dLastName, d.curLat, d.curLng
                    FROM drivers AS d
                    WHERE d.dID = $driverID;";
    
    $sql = $db->query($countQuery);
    $row_cnt = $sql->num_rows;
    
    if(!$sql){
        echo "<div class='alert alert-warning fade in msg'>There were SQL errors.<br/>".mysqli_error($db)."</div>";
        return;
    }
    
    $info = $sql->fetch_array();
    echo json_encode($info);
}

if($_POST["action"] == "getClientInfo"){
    include('../connection.php');

    $driverID = $_POST["dID"];
    
    if(isset($_SESSION['dataOffset'])){
        $offset = $_SESSION['dataOffset'];
    }else{
        $offset = 0;
    }
    
    
    //Set timezone for this session.
    $query = "SET @@session.time_zone = '-05:00'";
    $sql = $db->query($query);
    
    $query = "SELECT r.dID, r.rSuccess, c.cFirstName, c.cLastName, c.cAddress1, c.cCity, c.cPhone, c.cDeliveryNotes, c.cID
            FROM clients AS c
            JOIN routes AS r
            ON r.cID = c.cID
            WHERE r.dID = $driverID
            AND date(r.rDate) = subdate(curdate(), $offset)
            ORDER BY rSuccess ASC, cLastName;";
    
    
	$sql = $db->query($query);
	$row_cnt = $sql->num_rows;
    
    $table = "";
    
    if(!$sql){
        echo "<div class='alert alert-danger fade in msg'>There were SQL errors.<br/>".mysqli_error($db)."</div>";
        return;
    }

    if ($row_cnt == 0){
        echo "<div class='alert alert-warning fade in msg'>There are currently no clients on this drivers route.</div>";
    } else {
        $table .= "<table class='alignleft table table-hover'>
            <thead class='tableHead'>
            <tr>
                <th>Status</th>   
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Delivery Notes</th>
            </tr>
            </thead>
            <tbody>";

        $temp = "";

        while ($info = $sql->fetch_array()) {
            
            if($info['rSuccess'] == 1){
                $status = 'Delivered'; 
            } else {
                $status = 'Waiting for delivery.'; 
            }
            $temp .= $status . " ";
            
            $table .= "<tr data-cid='". $info['cID'] ."' class='clientMapRow' style='" . (($status == 'Delivered')? '' : 'background-color: #FFDBDB;' ) . "'>
                <td>" . $status . "</td>
                <td>" . $info['cLastName'] . ", " . $info['cFirstName'] . "</td>
                <td>" . $info['cAddress1'] . " " . $info['cCity'] . "</td>
                <td>" . formatPhone($info['cPhone']) . "</td>
                <td>" . $info['cDeliveryNotes'] . "</td>
            </tr>";
        }
        $table .= "</tbody></table>";
        echo $table;
    }
}

if($_POST["action"] == "getMapInfo"){
    include('../connection.php');

    $driverID = $_POST["dID"];

    if(isset($_SESSION['dataOffset'])){
        $offset = $_SESSION['dataOffset'];
    }else{
        $offset = 0;
    }
    
    //Set timezone for this session.
    $query = "SET @@session.time_zone = '-05:00'";
    $sql = $db->query($query);
    
    $query = "SELECT r.dID, r.rSuccess, c.*
            FROM clients AS c
            JOIN routes AS r
            ON r.cID = c.cID
            WHERE r.dID = $driverID
            AND date(r.rDate) = subdate(curdate(), $offset)
            ORDER BY cLastName ASC;";
    
    
	$sql = $db->query($query);
	$row_cnt = $sql->num_rows;
    
    if(!$sql){
        echo "<div class='alert alert-danger fade in msg'>There were SQL errors.<br/>".mysqli_error($db)."</div>";
        return;
    }
    
    if ($row_cnt == 0){
        echo "<div class='alert alert-warning fade in msg'>There are currently no clients on this drivers route.</div>";
    } else {
        $data = array();
        $idx = 0;
        while ($info = $sql->fetch_array()) {
            //$info2 = json_encode($info);
            $data[$idx] = $info;
            $idx = $idx + 1;
        }

        echo json_encode($data);
    }
}

//Set the data that is retrieved on the overview page to a specific day.
if($_POST["action"] == "loadSpecificData"){
    $_SESSION['dataOffset'] = $_POST['offset'];
}

?>