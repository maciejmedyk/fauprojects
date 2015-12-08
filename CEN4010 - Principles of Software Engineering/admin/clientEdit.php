<?php
	include_once("session.php"); 
	include_once("header.php");
	$page = "Clients";
    $pageTitle = "Edit Client";
    $search = false;
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
                <div class="content">
                    <div class="scrollable-y tabContent" id="clients">
                        <div class="fullHeight container-fluid">
                            <div id="displayData">
                                <?php editClient($_GET['cID']);?>
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