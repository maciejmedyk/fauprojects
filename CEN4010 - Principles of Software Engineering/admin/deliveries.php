<?php
	include_once("session.php"); 
	include_once("header.php");
	$page = "Deliveries";
    $pageTitle = "Delivery Scheduling";
    $search = true;
?>
<body>
<?php include("menus.php"); ?>
	<div id="page-wrapper">
        
    <!-- 
        Page Title
    -->
		<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
			<div class="page-header pull-left">
				<div class="page-title">
					<?php echo $pageTitle ?>
				</div>
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
        <div class="fullHeight container-fluid">
            <div class="tabWrapper">
                <ul id="tabs">
                    <li><a href="#deliveries" class="selected">Deliveries</a></li>
                    <li><a href="#generateDeliveryTab">Generate Delivery</a></li>
                </ul>
                
                
                <!----   
                Deliveries tab
                ------>
                
                <div class="tabContent" id="deliveries">
                    <div class="fullHeight container-fluid">
                        <div class="row" style="padding: 0px 20px;">
                            <div id="delYesterday" class="col-md-4 btn btn-success" ><< Yesterday</div> 
                            <div id="delToday" class="col-md-4 btn btn-success">Today</div> 
                            <div id="delTomorrow" class="col-md-4 btn btn-success">Tomorrow >></div>
                        </div>
                        <div class="scrollable-yHeader" id="displayData">
                            <?php unixTime('11/23/2015');?>
                            <?php getDeliverys(date('W'),getTodaysDay(date('w')),0);?>
                        </div>
                    </div>
                </div>
                
                <!----   
                Create routes tab
                ------>
                
                <div class="scrollable-y tabContent" id="generateDeliveryTab">
                    <div class="fullHeight container-fluid">
                        <div class="row" style="padding: 10px 30px;">
                            <div id="genCopy" class="col-md-4 btn btn-success" >Use Last Weeks</br> <?php rangeWeek( date("Y-m-d", time() - 604800) );?></div> 
                            <div id="genNew" class="col-md-4 btn btn-success">Create New Schedule For</br> <?php rangeWeek( date("Y-m-d", time()) );?></div> 
                            <div class="col-md-4 row">
								<div id="genToday" class="col-md-12 btn btn-success">Recalculate Today </br> <?php echo date("Y-m-d", time());?></div>
								<div class="col-md-12 row"> <?php todaysDrivers(getTodaysDay(date('w')));?></div>
							</div>
							
                        </div>
                    </div>
                </div>
                

                
                
            </div>
            <!--/tabWrapper -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<?php include("footer.php");?>

</body>
</html>