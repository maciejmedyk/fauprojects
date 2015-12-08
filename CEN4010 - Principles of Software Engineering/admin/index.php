<?php
	include_once("session.php"); 
	include_once("header.php");
	$page = "Overview";
    $pageTitle = "Overview";
    $search = true;
?>
<body>
<?php include("menus.php"); ?>
	<div id="page-wrapper">
        
    <!-- 
        Page Title
    -->
		<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="container-fluid">
                <div class="page-header pull-left">
                    <div class="page-title">
                        <?php echo $pageTitle ?>
                    </div>
                </div>
                <div id="dataRefresh" class="pull-right"></div>
            </div>
			<div class="clearfix"></div>
            
            <!-- Universal error or success message. Called with errorMSG(message, type) -->
            <div id="">
                <div id="errorWrapper" class="alert alert-dismissable" style="display: none">
                    <button id="closeError" type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    <div id="errorMSG"></div>
                </div>
            </div>
		</div>
        
        
        <!-- Main Content goes here -->
        <div style="" class="fullHeight container-fluid">
            <div class="tabWrapper">
                <div class="fullHeight container-fluid tabContent" id="overviewTab">
                    
                    <div class="fullHeight row">
                        <div class="col-sm-4 scrollable-y" id="displayData">
                            <?php getOverviewDrivers(0, "all"); ?>
                        </div>

                        <div class="fullHeight col-sm-8">

                            <div style="height: 50%;" id="overviewMap"></div>

                            <div id="clientTable" style="height: 50%;" class="scrollable-y" id="">
                                <div class="jumbotron">
                                    <h2>Welcome to MOW Delivery Tracker.</h2>
                                    <p>To display client and routing data, please click a driver from the list on the left.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        <!-- /.container-fluid -->
        </div>
    </div>
    <!-- /#page-wrapper -->
    
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<?php include("footer.php");?>
</body>
<script>

$(document).ready(function() {
        $(".tabWrapper").css('padding-bottom', '85px');
});

</script>

<script src="script/overviewMapFunctions.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
</html>