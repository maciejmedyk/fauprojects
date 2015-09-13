<?php 
          $con=mysql_connect('localhost','******','**********');
          mysql_select_db('cop3540', $con);
          if(!$con)
          {
            echo "Database login failed! PLease try again";
            header("Location: login.php");
            return false;
          }
?>