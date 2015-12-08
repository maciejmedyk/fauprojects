<?php
	include_once("session.php"); 
	include_once("header.php");
	$page = "Reports";
    $pageTitle = "Reports";
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
                <ul id="tabs">
                    <li><a href="#alertsTab" class="selected">Emergency Alerts</a></li>
                    <li><a href="#notesTab">Client Notes</a></li>
                    <!--li><a href="#eventsTab">Event Log</a></li-->
                </ul>
                <div class="tabContent" id="alertsTab">
                    
                    <div id="emergencyMap"></div>
                    
                    <div class="scrollable-y60" id="displayData">
                        <?php getEmergencyTable(0, "all"); ?>
                    </div>
                    
                </div>

                <div class="tabContent" id="notesTab">
                    <div class="scrollable-y" id="">
                        <?php getNotesTable(0, "all"); ?>
                    </div>
                </div>
                <!--div class="tabContent" id="eventsTab">
                    <div class="scrollable-y" id="">
                        <?php /*getEventsTable(0, "all");*/ ?>
                    </div>
                </div-->
                
            </div>
        <!-- /.container-fluid -->
        </div>
    <!-- /#page-wrapper -->
    </div>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<?php include("footer.php");?>
</body>

<script src="script/eMapFunctions.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
</html>