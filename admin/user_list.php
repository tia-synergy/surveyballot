<?php
	include_once "../db_connect.php";
	include "functions.php";
	
	session_start();
	if( !isset($_SESSION['id']) )
	{
		header("location:index.php");
	}
	
	$id = $_SESSION['id'];
	
	$selectUser = "select * from tb_client order by client_id desc";
	$resSelectUser = mysql_query($selectUser);
	
	
	if(isset($_GET["status_id"]) && isset($_GET["user_id"]))
	{
		if($_GET["status_id"] == 1)
		{
			$update = "update tb_client set client_status=2 where client_id=".$_GET["user_id"];
			$result = mysql_query($update);
		}
		else
		{
			$update = "update tb_client set client_status=1 where client_id=".$_GET["user_id"]; 
			$result = mysql_query($update);
			
			$selectClient = "select * from tb_client where client_id=".$_GET["user_id"];
			$resSelectClient = mysql_query($selectClient);
			$recSelectClient = mysql_fetch_array($resSelectClient);
			$to = $recSelectClient["client_email"];
			$subject = 'Welcome to Cutomer Survey Ballot';
			$headers = "From: info@synergyit.ca\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = 'Hi '.$recSelectClient['client_fullname'].',<br><br>Welcome to customer Survey Ballot site. <br><br>Thanks,<br>Customer Survey Ballot Team';
			mail($to, $subject, $message, $headers);
		}
		header("Location: user_list.php");
	}
	if(isset($_GET["type"]) && isset($_GET["user_id"]))
	{
		if($_GET["type"] == 1)
		{
			$update = "update tb_client set client_type=2 where client_id=".$_GET["user_id"];
			$result = mysql_query($update);
		}
		else
		{
			$update = "update tb_client set client_type=1 where client_id=".$_GET["user_id"]; 
			$result = mysql_query($update);
		}
		header("Location: user_list.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Survey Ballot Admin | Customers List</title>
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
			<?php
			top();
			?>
			<!-- =============================================== -->
			<!-- Left side column. contains the sidebar -->
			<?php
			left_nav();
			?>
			
			<!-- =============================================== -->
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>All User</h1>
					<ol class="breadcrumb">
						<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">List User</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Sr no.</th>
										<th>User Name</th>
										<th>User Email</th>
										<th>Registered Date</th>
									<!--	<th>Edit</th>-->
										<th>Active/InActive</th>
									<!--    <th>Send Survey</th>-->
										<th>Internal/External</th>
									</tr>
								</thead>
								<tbody>
									<?php
									
									
									$i = 1;
									while($rowSelectUser=mysql_fetch_array($resSelectUser))
									{
									?>
										<tr>
											<td><?php echo $i;?></td>
                                            <td><?php echo $rowSelectUser['client_fullname'];?></td>
											<td><?php echo $rowSelectUser['client_email'];?></td>
											<td><?php echo $rowSelectUser['client_insertdate'];?></td>
											<!--<td><a href="customers_edit.php?customer_id=<?php echo $rowSelectUser['client_id']; ?>"><i class="fa fa-edit"></i></a>-->
											<?php
												if($rowSelectUser['client_status'] == 1)
												{
											?>
											<td><a href="user_list.php?status_id=1&&user_id=<?php echo $rowSelectUser['client_id']; ?>">InActive</a></td>
											<?php
												}
												else 
												{
											?>
											<td><a href="user_list.php?status_id=2&&user_id=<?php echo $rowSelectUser['client_id']; ?>">Active</a></td>
											<?php
												}
											?>
											<?php
												if($rowSelectUser['client_type'] == 1)
												{
											?>
											<td><a href="user_list.php?type=1&&user_id=<?php echo $rowSelectUser['client_id']; ?>">External</a></td>
											<?php
												}
												else 
												{
											?>
											<td><a href="user_list.php?type=2&&user_id=<?php echo $rowSelectUser['client_id']; ?>">Internal</a></td>
											<?php
												}
											?>
											<!--<td><a href="send_survey.php?customer_id=<?php echo $rowSelectUser['client_id']; ?>">Send</a>
											</td>-->
										</tr>	
									<?php
										$i = $i+1;
									}
									?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
						<div class="box-footer">
							Footer
						</div><!-- /.box-footer-->
					</div><!-- /.box -->
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			<footer class="main-footer">
				<strong>Copyright &copy; 2015 <a href="http://www.synergyit.ca/">Synergy IT</a>.</strong> All rights reserved.
			</footer>
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