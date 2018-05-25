<?php

function top()
{
	?>
	<header class="main-header">
				<!-- Logo -->
				<a href="dashboard.php" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>S</b>Ballot</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Survey</b>Ballot</span>
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
								<a href="logout.php">Logout</a>
							</li>
						</ul>
					</div>
				</nav>
			</header>
<?php
}

function left_nav()
{
?>
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
						<!--<li class="treeview">
							<a href="#">
								<i class="fa fa-files-o"></i>
								<span>Client</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="client_list.php"><i class="fa fa-circle-o"></i> List Client</a></li>
							</ul>
						</li>-->
						<li class="treeview">
							<a href="#">
								<i class="fa fa-files-o"></i>
								<span>Customer</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="customers_add.php"><i class="fa fa-circle-o"></i> Add Customer</a></li>
								<li><a href="customers_list.php"><i class="fa fa-circle-o"></i> List Customer</a></li>
							</ul>
						</li>
						<li class="treeview">
							<a href="#">
								<i class="fa fa-files-o"></i>
								<span>Question Template</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="template_add.php"><i class="fa fa-circle-o"></i> Add Template</a></li>
								<li><a href="template_list.php"><i class="fa fa-circle-o"></i> List Template</a></li>
							</ul>
						</li>
					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>
<?php
}
?>