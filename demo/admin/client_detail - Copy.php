<?php
	include_once "../db_connect.php";
	
	session_start();
	if( !isset($_SESSION['id']) )
	{
		header("location:index.php");
	}
	
	$id = $_SESSION['id'];
	
	$selectUser = "select * from tb_user where id='$id'";
	$resUser = mysql_query($selectUser);
	$rowUser = mysql_fetch_array($resUser);
	
	$client_id = $_GET['clientid'];
	
	$selectClient = "select * from tb_client where client_id='$client_id'";
	$resClient = mysql_query($selectClient);
	$rowClient = mysql_fetch_array($resClient);
	
	$selectCustomers = "select * from tb_customer where client_id='$client_id' order by customer_insertdate desc";
	$resCustomers = mysql_query($selectCustomers);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Synergy Echo Admin | Client Detail</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.4 -->
		<link href="../_layout/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Ionicons -->
		<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<!-- AdminLTE Skins. Choose a skin from the css/skins 
			 folder instead of downloading all of them to reduce the load. -->
		<link href="../_layout/css/_all-skins.min.css" rel="stylesheet" type="text/css" />

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="skin-blue sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="dashboard.php" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>S</b>Echo</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Synergy</b>Echo</span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- Messages: style can be found in dropdown.less-->
							<li class="dropdown messages-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-envelope-o"></i>
									  <span class="label label-success">4</span>
									</a>
									<ul class="dropdown-menu">
									  <li class="header">You have 4 messages</li>
									  <li>
										<!-- inner menu: contains the actual data -->
										<ul class="menu">
										  <li><!-- start message -->
											<a href="#">
											  <div class="pull-left">
												<img src="../_layout/images/unknown_user-70x70.png" class="img-circle" alt="User Image"/>
											  </div>
											  <h4>
												Support Team
												<small><i class="fa fa-clock-o"></i> 5 mins</small>
											  </h4>
											  <p>Why not buy a new awesome theme?</p>
											</a>
										  </li><!-- end message -->
										</ul>
									  </li>
									  <li class="footer"><a href="#">See All Messages</a></li>
									</ul>
								  </li>
								  <!-- Notifications: style can be found in dropdown.less -->
								  <li class="dropdown notifications-menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									  <i class="fa fa-bell-o"></i>
									  <span class="label label-warning">10</span>
									</a>
									<ul class="dropdown-menu">
									  <li class="header">You have 10 notifications</li>
									  <li>
										<!-- inner menu: contains the actual data -->
										<ul class="menu">
										  <li>
											<a href="#">
											  <i class="fa fa-users text-aqua"></i> 5 new members joined today
											</a>
										  </li>
										</ul>
									  </li>
									  <li class="footer"><a href="#">View all</a></li>
									</ul>
								  </li>
								  <!-- Tasks: style can be found in dropdown.less -->
								  <li class="dropdown tasks-menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									  <i class="fa fa-flag-o"></i>
									  <span class="label label-danger">9</span>
									</a>
									<ul class="dropdown-menu">
									  <li class="header">You have 9 tasks</li>
									  <li>
										<!-- inner menu: contains the actual data -->
										<ul class="menu">
										  <li><!-- Task item -->
											<a href="#">
											  <h3>
												Design some buttons
												<small class="pull-right">20%</small>
											  </h3>
											  <div class="progress xs">
												<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
												  <span class="sr-only">20% Complete</span>
												</div>
											  </div>
											</a>
										  </li><!-- end task item -->
										</ul>
									  </li>
									  <li class="footer">
										<a href="#">View all tasks</a>
									  </li>
									</ul>
								  </li>
								  <!-- User Account: style can be found in dropdown.less -->
								  <li class="dropdown user user-menu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									  <img src="../_layout/images/unknown_user-70x70.png" class="user-image" alt="User Image"/>
									  <span class="hidden-xs"><?php echo $rowUser['user_name'];?></span>
									</a>
									<ul class="dropdown-menu">
									  <!-- User image -->
									  <li class="user-header">
										<img src="../_layout/images/unknown_user-70x70.png" class="img-circle" alt="User Image" />
										<p>
										  Alexander Pierce - Web Developer
										  <small>Member since Nov. 2012</small>
										</p>
									  </li>
									  <!-- Menu Body -->
									  <li class="user-body">
										<div class="col-xs-4 text-center">
										  <a href="#">Followers</a>
										</div>
										<div class="col-xs-4 text-center">
										  <a href="#">Sales</a>
										</div>
										<div class="col-xs-4 text-center">
										  <a href="#">Friends</a>
										</div>
									  </li>
									  <!-- Menu Footer-->
									  <li class="user-footer">
										<div class="pull-left">
										  <a href="#" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
										  <a href="#" class="btn btn-default btn-flat">Sign out</a>
										</div>
									  </li>
									</ul>
								  </li>
								  <!-- Control Sidebar Toggle Button -->
								  <li>
									<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
								  </li>
								</ul>
					</div>
				</nav>
			</header>
			<!-- =============================================== -->
			<!-- Left side column. contains the sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<ul class="sidebar-menu">
						<li class="header">MAIN NAVIGATION</li>
						<li class="treeview">
							<a href="dashboard.php">
								<i class="fa fa-dashboard"></i> <span>Dashboard</span> 
							</a>
						</li>
						<li class="treeview">
							<a href="#">
								<i class="fa fa-files-o"></i>
								<span>Client</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="client_list.php"><i class="fa fa-circle-o"></i> List Client</a></li>
								<li><a href="../layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
								<li><a href="../layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
								<li><a href="../layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
							</ul>
						</li>
            <li>
              <a href="../widgets.html">
                <i class="fa fa-th"></i> <span>Widgets</span> <small class="label pull-right bg-green">Hot</small>
              </a>
            </li>            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Charts</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                <li><a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                <li><a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
              </ul>
            </li>            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>UI Elements</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                <li><a href="../UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                <li><a href="../UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Forms</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Tables</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                <li><a href="../tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
              </ul>
            </li>
            <li>
              <a href="../calendar.html">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
                <small class="label pull-right bg-red">3</small>
              </a>
            </li>
            <li>
              <a href="../mailbox/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="label pull-right bg-yellow">12</small>
              </a>
            </li>
            <li class="treeview active">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Examples</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                <li><a href="login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                <li><a href="register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                <li><a href="lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                <li><a href="404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                <li><a href="500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                <li class="active"><a href="blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Multilevel</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                    <li>
                      <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                      <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
              </ul>
            </li>
            <li><a href="../../documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>Detail - <b><?php echo $rowClient['client_fullname']; ?></b></h1>
				<ol class="breadcrumb">
					<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li><a href="client_list.php">List Clients</a></li>
					<li class="active">Detail</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Company - <b><?php echo $rowClient['client_fullname']; ?></b></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
							<!--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
						</div>
					</div>
					<div class="box-body">
						<?php 
						$selectClientCompany = "select * from tb_company where client_id='$client_id'";
						$resClientCompany = mysql_query($selectClientCompany);
						$rowClientCompany = mysql_fetch_array($resClientCompany);
						?>
						<table class="table table-striped">
				            <tr>
								<td><b>Website</b></td>
								<td>
									<?php
									if($rowClientCompany['company_website']=="")
									{
										echo '-';
									}
									else
									{
									?>
										<a href="<?php echo $rowClientCompany['company_website'];?>"><?php echo $rowClientCompany['company_website'];?></a>
									<?php
									}
									?>
								</td>
								<td><b>Email</b></td>
								<td>
									<?php
									if($rowClient['client_email']=="")
									{
										echo '-';
									}
									else
									{
									?>
										<a href="mailto:<?php echo $rowClient['client_email']; ?>"><?php echo $rowClient['client_email']; ?></a>
									<?php
									}
									?>
								</td>
							</tr>
							<tr>
								<td><b>Country</b></td>
								<td>
									<?php
									if($rowClientCompany['country']=="")
									{
										echo '-';
									}
									else
									{
										echo $rowClientCompany['country'];
									}
									?>
								</td>
								<td><b>State</b></td>
								<td>
									<?php
									if($rowClientCompany['state']=="")
									{
										echo '-';
									}
									else
									{
										echo $rowClientCompany['state'];
									}
									?>
								</td>
							</tr>
							<tr>
								<td><b>Industry</b></td>
								<td>
									<?php
									if($rowClientCompany['industry']=="")
									{
										echo '-';
									}
									else
									{
										echo $rowClientCompany['industry'];
									}
									?>
								</td>
								<td><b>Sub Industry</b></td>
								<td>
									<?php
									if($rowClientCompany['industry']=="")
									{
										echo '-';
									}
									else
									{
										echo $rowClientCompany['industry'];
									}
									?>
									<?php echo $rowClientCompany['subindustry'];?></td>
							</tr>
							<tr>
								<td><b>Size</b></td>
								<td><?php echo $rowClientCompany['size'];?></td>
								<td><b>Feedback Frequency</b></td>
								<td><?php echo $rowClientCompany['feedback_frequency'];?></td>
							</tr>
						</table>
                    </div><!-- /.box-body -->
					<div class="box-footer">
						Footer
					</div><!-- /.box-footer-->
				</div><!-- /.box -->
				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Customers - <b><?php echo $rowClient['client_fullname']; ?></b></h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
							<!--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
						</div>
					</div>
					<div class="box-body">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Sr no.</th>
									<th>Name</th>
									<th>Email</th>
									<th>Company</th>
									<th>Status</th>
									<th>Insert Date</th>
									<th>Heartbeat Sent</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								while($rowCustomers=mysql_fetch_array($resCustomers))
								{
								?>
									<tr>
										<td><?php echo $i;?></td>
										<td><a href="customer_detail.php?customer_id=<?php echo $rowCustomers['id'];?>"><?php echo $rowCustomers['customer_firstname'].' '.$rowCustomers['customer_lastname'];?></a></td>
										<td><?php echo $rowCustomers['customer_email'];?></td>
										<td><?php echo $rowCustomers['customer_company'];?></td>
										<td>
											<?php
											if($rowCustomers['customer_isActive']==1)
											{
											?>
												<span class="label bg-green">Active</span>
											<?php
											}
											else
											{
											?>
												<span class="label bg-red">InActive</span>
											<?php
											}
											?>
										</td>
										<td><?php echo $rowCustomers['customer_insertdate'];?></td>
										<td><?php echo $rowCustomers['customer_heartbeatcount'];?></td>
									</tr>	
								<?php
									$i = $i+1;
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th>Sr no.</th>
									<th>Name</th>
									<th>Email</th>
									<th>Company</th>
									<th>Status</th>
									<th>Insert Date</th>
									<th>Heartbeat Sent</th>
								</tr>
							</tfoot>
						</table>
                    </div><!-- /.box-body -->
					<div class="box-footer">
						Footer
					</div><!-- /.box-footer-->
				</div><!-- /.box -->
			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
      </footer>
      
      <!-- Control Sidebar -->      
      <aside class="control-sidebar control-sidebar-dark">                
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class='control-sidebar-menu'>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3> 
            <ul class='control-sidebar-menu'>
              <li>
                <a href='javascript::;'>               
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>                                    
                </a>
              </li> 
              <li>
                <a href='javascript::;'>               
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>                                    
                </a>
              </li> 
              <li>
                <a href='javascript::;'>               
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-waring pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>                                    
                </a>
              </li> 
              <li>
                <a href='javascript::;'>               
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>                                    
                </a>
              </li>               
            </ul><!-- /.control-sidebar-menu -->         

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">            
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked />
                </label>                
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right" />
                </label>                
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>                
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../_layout/js/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../_layout/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- DATA TABES SCRIPT -->
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="../_layout/js/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../_layout/js/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../_layout/js/app.min.js" type="text/javascript"></script>
    
    <!-- Demo -->
    <script src="../_layout/js/demo.js" type="text/javascript"></script>
	<script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
  </body>
</html>