<!--div class="mask">	
	<!--<div class="popBody">
	<div class="popClose">X</div>
	<div class="popUp"></div>
	<div id="errorMSG"></div>
    </div>
	
	<div class="popBody">
		<div class="popClose">X</div>
		<div class="popUp"></div>
		<div id="errorMSG"></div>
	</div>
</div> -->

<div class="loadingMask">
	<div class="load-wrapp">
		<div class="load-3">
			<p>Loading</p>
			<p id="lMSG"></p>
			<div class="line"></div>
			<div class="line"></div>
			<div class="line"></div>
		</div>
	</div>
</div>

<!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="script/jquery-1.10.2.min.js"></script>
    <script src="script/bootstrap.min.js"></script>
    <!--<script src="script/jquery-ui.js"></script>
    <script src="script/jquery-migrate-1.2.1.min.js"></script>
    <script src="script/bootstrap-hover-dropdown.js"></script>
    <script src="script/html5shiv.js"></script>
    <script src="script/respond.min.js"></script>
    <script src="script/jquery.metisMenu.js"></script>
    <script src="script/jquery.slimscroll.js"></script>
    <script src="script/jquery.cookie.js"></script>
    <script src="script/icheck.min.js"></script>
    <script src="script/custom.min.js"></script>
    <script src="script/jquery.menu.js"></script>
    <script src="script/pace.min.js"></script>
    <script src="script/holder.js"></script>-->
    <script src="script/responsive-tabs.js"></script>
    <!--CORE JAVASCRIPT-->
	<script src="script/main.js"></script>
    <script src="script/tab.js"></script>

<?php
    //
    //Will display error message on page load if set in session variable.
    //Usefull for success messages after redirect.
    //
    if(isset($_SESSION['errorMSG']) && $_SESSION['errorMSG'] != ""){
        
        $errorMSG = $_SESSION['errorMSG'];
        $errorType = $_SESSION['errorType'];
        
        echo "<script>errorMSG('$errorMSG', '$errorType');</script>";
        
        $_SESSION['errorMSG'] = "";
        $_SESSION['errorMSG'] = "";
    }
?>