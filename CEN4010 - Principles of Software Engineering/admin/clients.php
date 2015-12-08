<?php
	include_once("session.php"); 
	include_once("header.php");
	$page = "Clients";
    $pageTitle = "Clients";
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
                  <li><a href="#clients" class="selected">Clients</a></li>
                  <li><a href="#addClientTab">Add Clients</a></li>
                </ul>
                <div class="scrollable-y tabContent" id="clients">
                    <div class="" id="displayData">
                        <form>
                            <fieldset>
                                <legend>Filters:</legend>
                                    <input checked id="showInactiveClients" type="checkbox" value="show" name="showInactive"/> Show inactive clients.
                            </fieldset>
                        </form> 
                        <br>
                        <?php getClient(0,"all");?>
                    </div>
                </div>
            
<!--

Tab with form to add clients below

-->

            <div class="scrollable-y tabContent hide" id="addClientTab">
                <div class="fullHeight container-fluid">
                    <br/>
                    <form id="editClientForm" class="form-horizontal" action="#" role="form" method="post">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="fName">First Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="fName" name="fName" placeholder="Enter first name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="lName">Last Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="lName" name="lName" placeholder="Enter last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label col-sm-2" for="pwd">Password:</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="phone">Phone Number:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address1">Address:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="addr1" name="address1" placeholder="Enter street address">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address2">Address:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="addr2" name="address2" placeholder="Enter secondary street address">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-2" for="city">City:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="state">State:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="state" name="state" placeholder="Enter state">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="zip">ZIP Code:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Enter zip code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="delNotes">Delivery Notes:</label>
                            <div class="col-sm-6">
                                <textarea id="delNotes" name="delNotes" class="form-control" rows="6" style="min-width: 100%"></textarea>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-sm-2" for="FAList">Food Alergies:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="FAList" name="FAList" placeholder="Example: nuts,shellfish,wheat">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="zip">Food Restrictions:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="FRList" name="FRList" placeholder="Example: milk,bacon">
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <div class="checkbox">
                                    <label style="color: red;" ><input id="activeCheckbox" type="checkbox" checked value="1">Is Active</label>
                                    <!--label><input id="FR" type="checkbox" value="1">Food Restrictions </label-->
                                </div>
                            </div>
                        </div>
                        <div id="errorMSG"></div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <div id="addClient" class="btn btn-success">Add Client</div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            
            
            
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    </div>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<?php include("footer.php");?>
</body>
</html>