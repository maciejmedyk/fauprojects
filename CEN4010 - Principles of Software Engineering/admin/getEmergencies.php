<?php
include_once("session.php"); 

//
//Retrieves emergency notifications newer than the submitted date..
//
if($_POST["action"] == "getNewEmergencies"){
	 
    //$date = date('Y-m-d H:i:s', strtotime($_POST['date']));
    //$date = $_POST['date'];
    //$date = floor($date / 1000);
    
    $query = "SELECT e.*, d.dFirstName, d.dLastName
            FROM emergency AS e
            JOIN drivers AS d
            ON e.dID = d.dID
            WHERE e.eResolved = 0;";
            //AND UNIX_TIMESTAMP(e.eDate) > $date;";
            
    
    //echo $query;
    //return;
    $sql = $db->query($query);
	$row_cnt = $sql->num_rows;

    if(!$sql){
        echo "<div class='alert alert-danger fade in msg'>There were SQL errors.<br/>".mysqli_error($db)."</div>";
        return;
    }else{
        echo $row_cnt;
    }
    
    /*if ($row_cnt == 0){
        return;
    } else {            
        $data = array();
        $idx = 0;

        while ($info = $sql->fetch_array()) {

            if (strtotime($info['eDate']) < $date) {
                //echo strtotime($info['eDate']) . " is less than " . $date . "<br>" ;
                $data[$idx] = $info;
                $idx = $idx + 1;
            }

        }
        echo json_encode($data);
    }*/
}
?>