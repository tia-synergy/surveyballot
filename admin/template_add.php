<?php
	include_once "../db_connect.php";
	include "functions.php";
	
	session_start();
	if( !isset($_SESSION['id']) )
	{
		header("location:index.php");
	}
	
	$id = $_SESSION['id'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!empty($_POST['template-submit']))
		{
			$t_name = $_POST['t_name'];
			$email_sub = $_POST['email_sub'];
			$email_body = $_POST['email_body'];
			
			$insert_query = "insert into tb_template (name,email_sub,email_body) values ('$t_name','$email_sub','$email_body')";
			$res_query = mysql_query($insert_query);
			
			$template_id = mysql_insert_id();
			
			for($i=1;$i<=10;$i++)
			{
				$question_no = $i;
				if($question_no == 1)
				{
					$question_name = $_POST['question1_name'];
					$question = $_POST['question1'];
				}
				elseif($question_no == 2)
				{
					$question_name = $_POST['question2_name'];
					$question = $_POST['question2'];
				}
				elseif($question_no == 3)
				{
					$question_name = $_POST['question3_name'];
					$question = $_POST['question3'];
				}
				elseif($question_no == 4)
				{
					$question_name = $_POST['question4_name'];
					$question = $_POST['question4'];
				}
				elseif($question_no == 5)
				{
					$question_name = $_POST['question5_name'];
					$question = $_POST['question5'];
				}
				elseif($question_no == 6)
				{
					$question_name = $_POST['question6_name'];
					$question = $_POST['question6'];
				}
				elseif($question_no == 7)
				{
					$question_name = $_POST['question7_name'];
					$question = $_POST['question7'];
				}
				elseif($question_no == 8)
				{
					$question_name = $_POST['question8_name'];
					$question = $_POST['question8'];
				}
				elseif($question_no == 9)
				{
					$question_name = $_POST['question9_name'];
					$question = $_POST['question9'];
				}
				elseif($question_no == 10)
				{
					$question_name = $_POST['question10_name'];
					$question = $_POST['question10'];
				}
				
				$query = "insert into tb_templateQuestion (template_id,question_no,question_name,question,insertdate) values ('$template_id','$question_no','$question_name','$question',NOW())";
				$result = mysql_query($query);
				
				if($question_no==10)
				{
					if($result)
					{
						$success = "Data Updated Successfully.";
					}
					else
					{
						$error = "There is ans error updating data. Please try again later.";
					}
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Survey Ballot Admin | Template Add</title>
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
					<h1>Add Template</h1>
					<ol class="breadcrumb">
						<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						<li class="active">Add Template</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"></h3>
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
							<form role="form" id="template-form" name="template-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
								<div class="form-group">
									<label for="t_name">Template Name</label>
									<input type="text" class="form-control" id="t_name" name="t_name" >
								</div>
								<div class="form-group">
									<label for="email_sub">Email Subject</label>
									<input type="text" class="form-control" id="email_sub" name="email_sub" >
								</div>
								<div class="form-group">
									<label for="email_body">Email Body</label>
									<textarea class="textarea" id="email_body" name="email_body" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $rowTemplate['email_body'];?></textarea>
								</div>
								<?php 
								for($i=1;$i<=10;$i++)
								{
									$questionnameid = "question".$i."_name";
									$questionid = "question".$i;
								?>
									<div class="form-group">
										<label>Question <?php echo $i;?></label>
										<input class="form-control" name="<?php echo $questionnameid;?>" id="<?php echo $questionnameid;?>" value="" placeholder="title" />
										<textarea class="form-control" name="<?php echo $questionid;?>" id="<?php echo $questionid;?>" placeholder="question"></textarea>
									</div>
								<?php
								}
								?>
								<div class="box-footer">
									<input id="template-submit" name="template-submit" type="submit" class="btn btn-primary" value="Submit" />
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
				$("#example1").dataTable();
				$('#example2').dataTable({
					"bPaginate": true,
					"bLengthChange": false,
					"bFilter": false,
					"bSort": true,
					"bInfo": true,
					"bAutoWidth": false
				});
				
				$(".textarea").wysihtml5();
			});
		</script>
	</body>
</html>