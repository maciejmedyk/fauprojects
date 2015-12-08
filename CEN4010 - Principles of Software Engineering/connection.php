<?php
//$connection = mysql_connect('us-cdbr-iron-east-02.cleardb.net', 'b041107957eecd','31d4176a');
//$db = mysql_select_db("ad_5b54bf9bc4c55af", $connection);
?>

<?php
//$db = mysqli_connect('us-cdbr-iron-east-02.cleardb.net', 'b041107957eecd', '31d4176a', 'ad_5b54bf9bc4c55af')
//$db = mysqli_connect('localhost','mmedyk','75QNrXUROmsEX','ad_5b54bf9bc4c55af')
$db = mysqli_connect('134.168.8.146','root','31d4176a','ad_5b54bf9bc4c55af')
	or die(mysqli_connect_error());
?>