<?php
	include_once("session.php"); 
	include_once("header.php");
	$page = "Accounts";
    $pageTitle = "Administration Accounts";
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
                    <li><a href="#adminListTab" class="selected">Administrators</a></li>
                    <?php if($_SESSION['isSuperAdmin'] == 1) echo '<li><a href="#addAdminTab">Add Admin</a></li>';?>
                    <!--li><a href="#settingsTab">Settings</a></li-->
                </ul>


                <!--
                    List of administrators.
                -->
                <div class="scrollable-y tabContent" id="adminListTab">
                    <div id="displayData">
                        <?php getAdminTable(0, "all"); ?>
                    </div>
                </div>


                <!--
                    Add an administrator tab.
                -->
                <div class="scrollable-y tabContent hide" id="addAdminTab">
                        <?php getAdminForm(-1); ?>
                </div>


                <!--
                    MOW Tracker settings page.
                -->
                <!--div class="scrollable-y tabContent hide" id="settingsTab">

                </div-->


            </div>
            <!--tabWrapper-->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<?php include("footer.php");?>
</body>
</html>