<?php
	include_once("session.php"); 
	include_once("header.php");
	$page = "Drivers";
    $pageTitle = "Drivers";
    $search = true;
?>
<body>
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
                  <li><a href="#driverInfoTab" class="selected">Drivers</a></li>
                  <li><a href="#addDriversTab">Add Drivers</a></li>
                </ul>
                
                <div class="scrollable-y tabContent" id="driverInfoTab">
                    <div class="" id="displayData">
                        <form>
                            <fieldset>
                                <legend>Filters:</legend>
                                    <input checked id="showInactiveDriver" type="checkbox" value="show" name="showInactive"/> Show inactive drivers.
                            </fieldset>
                        </form> 
                        <br>
                        <?php getDrivers(0,"all");?>
                    </div>
                </div>
                
                <div class="tabContent hide" id="addDriversTab">
                    <div class="scrollable-y container-fluid">
                        <form id="editDriverForm" class="form-horizontal" action="#" role="form" method="post">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="fName">*First Name:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="fName" name="fName" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="lName">*Last Name:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="lName" name="lName" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">*Email:</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="phone">*Phone Number:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="dLicense">Drivers License #:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="dLicense" name="dLicense" placeholder="Enter drivers license number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="vehMake">Vehicle Make:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="vehMake" name="vehMake" placeholder="Enter vehicle's make">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="vehModel">Vehicle Model:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="vehModel" name="vehModel" placeholder="Enter vehicle's model">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="vehYear">Vehicle Year:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="vehYear" name="vehYear" placeholder="Enter vehicle's year">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="vehTag">Vehicle Tag:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="vehTag" name="vehTag" placeholder="Enter vehicle's tag">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="insCo">Insurance Company:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="insCo" name="insCo" placeholder="Enter insurance company">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="insPolicy">Policy Number:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="insPolicy" name="insPolicy" placeholder="Enter insurance policy number">
                                </div>
                            </div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="delArea">Starting delivery area:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="delArea" name="delArea" placeholder="Enter a starting zone this can be an address, zip code or intersection">
								</div>
							</div>
							
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="notes">Driver Notes:</label>
                                <div class="col-sm-6">
                                    <textarea id="delNotes" name="notes" class="form-control" rows="6" style="min-width: 100%"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="checkbox">
                                        <legend>Delivery Days *</legend>
                                        <label><input type="checkbox" name="schedule" value="Mo">Monday</label>
                                        <label><input type="checkbox" name="schedule" value="Tu">Tuesday</label>
                                        <label><input type="checkbox" name="schedule" value="We">Wednesday</label>
                                        <label><input type="checkbox" name="schedule" value="Th">Thursday</label>
                                        <label><input type="checkbox" name="schedule" value="Fr">Friday</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div id="insertDriver" class="btn btn-success">Add Driver</div>
                                </div>
                            </div>

                        </form>
                        <!--<div id="errorMSG"></div>-->
                    </div>
                </div>


            </div>
            <!--TabWrapper -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<?php include("footer.php");?>
</body>
</html>
