<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-O-W Delivery</title>

    <!-- Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   </head>
   <body>
        
     <div id="indexDiv">
				<?php 
					include('scripts/loginHelper.php');
					$isLocked = unlockedIP($_SERVER['REMOTE_ADDR']);
					if($isLocked[0]): 
				?>
					
					<form id="inputForm" data-user-type="Admin" action="passwordRecovery.php" method="post">
						<img class="admin_L" src="img/mowlogogreen.png" height=45px alt="Meals On Wheels Logo"><br>
						<img class="admin_L" src="img/mowdeliverygreen.png" height=35px alt="Delivery Logo"><br><br>
						<div>Password Recovery</div>
						
							<span><div id="errorMSG"><?php echo $isLocked[1];?></div></span><br>

						
						<input class="btn btn-success" type="submit" value="Forgot your password?">						
					</form>
				<?php elseif(isset($_POST['password'])): ?>
				
					<form id="inputForm" data-user-type="Admin" action="aindex.php" method="post">
						<img class="admin_L" src="img/mowlogogreen.png" height=45px alt="Meals On Wheels Logo"><br>
						<img class="admin_L" src="img/mowdeliverygreen.png" height=35px alt="Delivery Logo"><br><br>
						<div>Password Recovery</div>
						<?php 
							$sID = $_POST['uID'];
							$password = $_POST['password'];
							// Get security question
							
							$question = saveNewPassword($sID,$password);
						 
						 ?>
						<span><div id="errorMSG">New Password Has Been Created</div></span><br>
						
						<a href="aindex.php"><button class="btn btn-success"> Back to login </button></a>						
					</form>
					
				<?php elseif(isset($_POST['answer'])): ?>
				
					<form id="inputForm" data-user-type="Admin" action="passwordRecovery.php" method="post">
						<img class="admin_L" src="img/mowlogogreen.png" height=45px alt="Meals On Wheels Logo"><br>
						<img class="admin_L" src="img/mowdeliverygreen.png" height=35px alt="Delivery Logo"><br><br>
						<div>Password Recovery</div>
						<?php 
							$sID = $_POST['uID'];
							$q = $_POST['question'];
							$answer = $_POST['answer'];
							// Get security question
							
							$question = checkSecurityQuestion($sID,$answer);
							if($question[0]):
							$lable = "New Password";
						 
						 ?>
							<input type="hidden" value="<?php echo $sID;?>" id="uID" name="uID" >
							<label for="newPassword">Create a new password</label><br>
							<input autofocus class="form-control" type="password" id="password" name="password" ><br> 
						<?php else: $lable = "Answer";?>
							<input type="hidden" value="<?php echo $sID;?>" id="uID" name="uID" >
							<input type="hidden" value="<?php echo $q;?>" id="question" name="question" >							
							<label for="question"><?php echo $q;?></label><br>
							<input autofocus class="form-control" type="text" id="answer" name="answer" value="<?php echo $answer;?>"><br> 
							<span><div id="errorMSG">Incorrect Answer!</div></span><br>
						<?php endif;?>
						
						<input class="btn btn-success" type="submit" value="<?php echo $lable;?>">					
					</form>
					
				
				<?php elseif(isset($_POST['username'])): ?>
				
					<form id="inputForm" data-user-type="Admin" action="passwordRecovery.php" method="post">
						<img class="admin_L" src="img/mowlogogreen.png" height=45px alt="Meals On Wheels Logo"><br>
						<img class="admin_L" src="img/mowdeliverygreen.png" height=35px alt="Delivery Logo"><br><br>
						<div>Password Recovery</div>
						<?php 
							$userName = $_POST['username'];
							// Get security question
							
							$question = getSecurityQuestion($userName);
							if($question[0]):
							$lable = "Answer";
						 
						 ?>
							<input type="hidden" value="<?php echo $question[1];?>" id="uID" name="uID" >
							<input type="hidden" value="<?php echo $question[2];?>" id="question" name="question" >							
							<label for="question"><?php echo $question[2];?></label><br>
							<input autofocus class="form-control" type="text" id="answer" name="answer" ><br> 
						<?php else: $lable = "Forgot your password?"; ?>
							<label for="username">Username</label><br>
							<input autofocus class="form-control" type="text" id="username" name="username" value="<?php echo $_POST['username'];?>"><br>
							<span><div id="errorMSG">Invalid user name!</div></span><br>
						<?php endif;?>
						
						<input class="btn btn-success" type="submit" value="<?php echo $lable;?>">						
					</form>
					
				
					
				<?php else: ?>
				
					<form id="inputForm" data-user-type="Admin" action="passwordRecovery.php" method="post">
						<img class="admin_L" src="img/mowlogogreen.png" height=45px alt="Meals On Wheels Logo"><br>
						<img class="admin_L" src="img/mowdeliverygreen.png" height=35px alt="Delivery Logo"><br><br>
						<div>Password Recovery</div>

						<label for="username">Username</label><br>
						<input autofocus class="form-control" type="text" id="username" name="username" ><br>

						<span><div id="errorMSG"></div></span><br>
						<input class="btn btn-success" type="submit" value="Forgot your password?">						
					</form>
				 
				<?php endif;?>
      
	</div>   
		
   </body>
</html>
<script src="js/main.js"></script>