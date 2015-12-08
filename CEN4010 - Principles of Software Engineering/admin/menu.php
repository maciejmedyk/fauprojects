<div id="sidebar" role="navigation" data-step="2" data-intro="Template has <b>many navigation styles</b>" data-position="right" class="navbar-default navbar-static-side" style="min-height: 100%;">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    
                     <div class="clearfix"></div>
					<li><a href="index.php"><i class="fa fa-bars fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">MOW Admin</span></a></li>
					
                    <li <?php if($page === 'Deliveries') echo 'class="active"'?> ><a href="deliveries.php"><i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Deliveries</span></a></li>
                    
					<li <?php if($page === 'Clients') echo 'class="active"'?> ><a href="clients.php"><i class="fa fa-users fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i><span class="menu-title">Clients</span></a>
                       
                    </li>
					
                    <li <?php if($page === 'Drivers') echo 'class="active"'?> ><a href="drivers.php"><i class="fa fa-car fa-fw">
                        <div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">Drivers</span></a>
                       
                    </li>
					
                    <li <?php if($page === 'Reports') echo 'class="active"'?> ><a href="reports.php"><i class="fa fa-edit fa-fw">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">Reports</span></a>
                      
                    </li>
					
                    <li <?php if($page === 'Account') echo 'class="active"'?> ><a href="account.php"><i class="fa fa-th-list fa-fw">
                        <div class="icon-bg bg-blue"></div>
                    </i><span class="menu-title">Account</span></a>
                          
                    </li>
                   
                </ul>
            </div>
        </div>