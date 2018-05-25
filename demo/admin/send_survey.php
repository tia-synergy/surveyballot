<?php
	include_once "../db_connect.php";
	include "functions.php";
	
	session_start();
	if( !isset($_SESSION['id']) )
	{
		header("location:index.php");
	}
	
	$id = $_SESSION['id'];
	
	$customer_id = $_GET['customer_id'];
	$selCustomer = "select * from tb_customer1 where id='$customer_id'";
	$resCustomer = mysql_query($selCustomer);
	$rowCustomer = mysql_fetch_array($resCustomer);
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!empty($_POST['survey-submit']))
		{
			if('' != $_POST['template'])
			{
				$template_id = $_POST['template'];
				
				$selUser = "select * from tb_user where id='$id'";
				$resUser = mysql_query($selUser);
				$rowUser = mysql_fetch_array($resUser);
				
				$token = sha1(uniqid(rand(), true));
				
				$to = $rowCustomer['email'];
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: ".$rowUser['user_email'] . "\r\n";

				$subject = $_POST['email_sub']; 
				$body = "Hi ".$rowCustomer['name'].",<br/><br/>".$_POST['email_body']."<br/><br/><a href=www.surveyballot.com/response1.php?token=".$token.">Submit your survey</a><br/><br/>Kind Regards, <br/>".$rowUser['user_name'];
				
				mail($to,$subject,$body,$headers);
				
				$query = "insert into tb_survey (customer_id,template_id,send_date,status,token,sent_by) values ('$customer_id','$template_id',NOW(),'sent','$token',$id)";
				$res_query = mysql_query($query);
				
				if($res_query)
				{
					$success = "Survey sent successfully.";
				}
				else
				{
					$error = "There is ans error sending survey. Please try again later.";
				}
			}
			else
			{
				$error = "Please select template to send.";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Survey Ballot Admin | Send Survey</title>
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

		<!-- bootstrap wysihtml5 - text editor -->
		<link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
	
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
					<h1>Send Survey</h1>
					<ol class="breadcrumb">
						<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">Edit Customers</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="box">
						<div class="box-header with-border">
							Send Survey to <h3 class="box-title"><?php echo $rowCustomer['name'];?> (<?php echo $rowCustomer['email'];?>)</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div id="formstatus">
								<?php
								if("" != $success)
								{
								?>
									<div class="alert alert-success"><i class="icon fa fa-check"></i><?php echo $success;?></div>
								<?php
								}
								elseif("" != $error)
								{
								?>
									<div class="alert alert-danger"><i class="icon fa fa-ban"></i><?php echo $error;?></div>
								<?php
								}
								?>
							</div>
							<!-- form start -->
							<form role="form" id="survey-form" name="survey-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
								<div class="form-group">
									<label for="cus_name">Select Template</label>
									<select class="form-control" name="template" id="template" onchange="ontemplateSelect()">
										<option value="0">Select Template</option>
										<?php
										$selAllTemplate = "select * from tb_template";
										$resAllTemplate = mysql_query($selAllTemplate);
										while($rowAllTemplate=mysql_fetch_array($resAllTemplate))
										{
										?>
											<option value="<?php echo $rowAllTemplate['id'];?>"><?php echo $rowAllTemplate['name'];?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div id="templateResponse">
								
								</div>
								<div class="box-footer">
									<input id="survey-submit" name="survey-submit" type="submit" class="btn btn-primary" value="Send" />
								</div><!-- /.box-footer-->
							</form>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			<footer class="main-footer">
				<strong>Copyright &copy; 2015 <a href="synergyit.ca">Synergy IT</a>.</strong> All rights reserved.
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
		
		<!-- Bootstrap WYSIHTML5 -->
		<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	
		<!-- Demo -->
		<script src="../_layout/js/demo.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function () {
				$(".textarea").wysihtml5();
			});
			
			function ontemplateSelect()
			{
				var selectedTemplate = $("#template option:selected").val();
				$("#templateResponse").html("");
				if(selectedTemplate != -1)
				{
					$.ajax({
						type: "POST",
						url: "process-template.php",
						data: { template : selectedTemplate } 
					}).done(function(data){
						$("#templateResponse").html(data);
						$(".textarea").wysihtml5();
					});
				}
			}
		</script>
	</body>
</html>