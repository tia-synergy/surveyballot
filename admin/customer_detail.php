<?php
	include_once "../db_connect.php";
	include_once "../functions.php";
	include "functions.php";
	
	session_start();
	if( !isset($_SESSION['id']) )
	{
		header("location:index.php");
	}
	
	$id = $_SESSION['id'];
	
	$customer_id = $_GET['customer_id'];
	
	$selectCustomer = "select * from tb_customer1 where id='$customer_id'";
	$resCustomer = mysql_query($selectCustomer);
	$rowCustomer = mysql_fetch_array($resCustomer);
	
        
        $selSurvey = "select * from tb_survey where customer_id=".$customer_id." order by send_date desc";
        $resSurvey = mysql_query($selSurvey);
        $totalsurveySent = mysql_num_rows($resSurvey);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Survey Ballot Admin | Customer Detail</title>
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
					<h1>Detail - <b><?php echo $rowCustomer['name']; ?></b></h1>
					<ol class="breadcrumb">
						<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                                <li><a href="customers_list.php">List Customers</a></li>
						<li class="active">Detail</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								<!--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
							</div>
						</div>
						<div class="box-body">
							<table class="table table-striped">
								<tr>
                                                                    <td><b>Company</b></td>
                                                                    <td>
                                                                            <?php
                                                                            if($rowCustomer['company']=="")
                                                                            {
                                                                                    echo '-';
                                                                            }
                                                                            else
                                                                            {
                                                                            ?>
                                                                                    <?php echo $rowCustomer['company'];?>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                    </td>
                                                                    <td><b>Email</b></td>
                                                                    <td>
                                                                            <?php
                                                                            if($rowCustomer['email']=="")
                                                                            {
                                                                                    echo '-';
                                                                            }
                                                                            else
                                                                            {
                                                                            ?>
                                                                                    <?php echo $rowCustomer['email']; ?>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        <a href="send_survey.php?customer_id=<?php echo $customer_id; ?>">Send Survey</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Total Survey Sent</b></td>
                                                                    <td><?php echo $totalsurveySent;?></td>
                                                                </tr>
							</table>
						</div><!-- /.box-body -->
						<div class="box-footer">
							
						</div><!-- /.box-footer-->
					</div><!-- /.box -->
					<!-- Default box -->
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Survey - <b><?php echo $rowCustomer['name']; ?></b></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								<!--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
							</div>
						</div>
						<div class="box-body">
							<?php
                                                        
							if($totalsurveySent == 0) 
							{
							?>
								<!-- Content Header (Page header) -->
								<section class="content-header" align="center">
									<form class="fixed" name="heartbeat-form" name="heartbeat-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
										<h4><?php echo $rowCustomer['name']; ?> has never been sent a survey.</h4>
                                                                                <a href="send_survey.php?customer_id=<?php echo $customer_id; ?>"><input type="button" class="btn" value="Send survey" /></a>
									</form>
								</section>
							<?php
							}
							else
							{
								$todaydate = date_parse(date("Y-m-d"));
							?>
								<!-- Main content -->
								<section class="content">
									<!-- row -->
									<div class="row">
										<div class="col-md-12">
											<!-- The time line -->
											<ul class="timeline">
												<!-- timeline time label -->
												<li class="time-label">
													<span class="bg-red"><?php echo $todaydate['day'].' '.get_month($todaydate['month']).', '.$todaydate['year'];?></span>
												</li>
												<!-- /.timeline-label -->
												<!-- timeline item -->
												<?php 
												$startDate = "";
												while($rowSurvey=mysql_fetch_array($resSurvey))
												{
													$sendDate = date_parse($rowSurvey['send_date']);
													$startDate = $sendDate;
													$openDate = date_parse($rowSurvey['open_date']);
													$responseDate = date_parse($rowSurvey['response_date']);
													if($rowSurvey['status'] == "sent")
													{
													?>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$sendDate['day'].' '.get_month($sendDate['month']).', '.$sendDate['year'];?></span>
																<h3 class="timeline-header">Survey has been sent to customer.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not opened email.";
																	?>
																</div>
															</div>
														</li>
													<?php
													}
													elseif($rowSurvey['status'] == "emailopened")
													{
													?>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$openDate['day'].' '.get_month($openDate['month']).', '.$openDate['year'];?></span>
																<h3 class="timeline-header">Customer has opened the email.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not submitted survey. Waiting for reply.";
																	?>
																</div>
															</div>
														</li>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$sendDate['day'].' '.get_month($sendDate['month']).', '.$sendDate['year'];?></span>
																<h3 class="timeline-header">Survey has been sent to customer.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not opened email.";
																	?>
																</div>
																<div class='timeline-footer'>
																	
																</div>
															</div>
														</li>
													<?php
													}
													elseif($rowSurvey['status'] == "responsereceived")
													{
														$selectQuestion = "select * from tb_templateQuestion where template_id=".$rowSurvey['template_id']." order by question_no";
														$resQuestion = mysql_query($selectQuestion);
                                                                                                 	?>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$responseDate['day'].' '.get_month($responseDate['month']).', '.$responseDate['year'];?></span>
																<h3 class="timeline-header">Customer has submitted survey.</h3>
																<div class="timeline-body">
																	<div class="row">
																		<?php //echo $rowHeartbeat['overall_response'];?>
																		<?php
																		while($rowQuestion=mysql_fetch_array($resQuestion))
																		{
																			if($rowQuestion['question_no']==1)
																			{
																				$color = "#00c0ef";
																				$value = $rowSurvey['question1_response'];
																			}
																			elseif($rowQuestion['question_no']==2)
																			{
																				$color = "#00a65a";
																				$value = $rowSurvey['question2_response'];
																			}
																			elseif($rowQuestion['question_no']==3)
																			{
																				$color = "#f39c12";
																				$value = $rowSurvey['question3_response'];
																			}
																			elseif($rowQuestion['question_no']==4)
																			{
																				$color = "#dd4b39";
																				$value = $rowSurvey['question4_response'];
																			}
                                                                                                                                                        elseif($rowQuestion['question_no']==5)
																			{
																				$color = "#dd4b39";
																				$value = $rowSurvey['question5_response'];
																			}
                                                                                                                                                        elseif($rowQuestion['question_no']==6)
																			{
																				$color = "#dd4b39";
																				$value = $rowSurvey['question6_response'];
																			}
                                                                                                                                                        elseif($rowQuestion['question_no']==7)
																			{
																				$color = "#dd4b39";
																				$value = $rowSurvey['question7_response'];
																			}
                                                                                                                                                        elseif($rowQuestion['question_no']==8)
																			{
																				$color = "#dd4b39";
																				$value = $rowSurvey['question8_response'];
																			}
                                                                                                                                                        elseif($rowQuestion['question_no']==9)
																			{
																				$color = "#dd4b39";
																				$value = $rowSurvey['question9_response'];
																			}
                                                                                                                                                        elseif($rowQuestion['question_no']==10)
																			{
																				$color = "#dd4b39";
																				$value = $rowSurvey['question10_response'];
																			}
																		?>
																			<div class="col-md-2" style="width:139px; margin-top:20px;">
																				<input type="text" class="knob" style="display:inline-block;" value="<?php echo $value;?>" data-width="100" data-height="100" data-fgColor="<?php echo $color;?>" data-readonly="true" data-min="0" data-max="10" data-angleOffset="180"/>
																				<div class="knob-label" style="padding-left:20px;"><?php echo $rowQuestion['question_name'];?> </div>
																			</div>
																		<?php
																		}
																		?>
																		
																	</div>
																</div>
																
															</div>
														</li>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$openDate['day'].' '.get_month($openDate['month']).', '.$openDate['year'];?></span>
																<h3 class="timeline-header">Customer has opened the email.</h3>
																<div class="timeline-body">
																	<?php echo "Customer has not submitted survey. Waiting for reply."; ?>
																</div>
																<div class='timeline-footer'>
																	
																</div>
															</div>
														</li>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$sendDate['day'].' '.get_month($sendDate['month']).', '.$sendDate['year'];?></span>
																<h3 class="timeline-header">Survey has been sent to customer.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not opened email.";
																	?>
																</div>
																<div class='timeline-footer'>
																	
																</div>
															</div>
														</li>
													<?php
													}
												}
												?>
												<li class="time-label">
													<span class="bg-green">
														<?php echo ' '.$startDate['day'].' '.get_month($startDate['month']).', '.$startDate['year'];?>
													</span>
												</li>
												<li>
													<i class="fa fa-clock-o bg-gray"></i>
												</li>
											</ul>
										</div><!-- /.col -->
									</div><!-- /.row -->
								</section><!-- /.content -->
							<?php
							}
							?>
						</div><!-- /.box-body -->
						<div class="box-footer">
							Footer
						</div><!-- /.box-footer-->
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
		
		<script src="../_layout/js/knob/jquery.knob.js" type="text/javascript"></script>
		
		<!--<script src="../_layout/js/tooltip.js" type="text/javascript"></script>-->
		
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
			$(document).ready(function(){
				$(".knob").knob({
				  /*change : function (value) {
				   //console.log("change : " + value);
				   },
				   release : function (value) {
				   console.log("release : " + value);
				   },
				   cancel : function () {
				   console.log("cancel : " + this.value);
				   },*/
				  draw: function () {

					// "tron" case
					if (this.$.data('skin') == 'tron') {

					  var a = this.angle(this.cv)  // Angle
							  , sa = this.startAngle          // Previous start angle
							  , sat = this.startAngle         // Start angle
							  , ea                            // Previous end angle
							  , eat = sat + a                 // End angle
							  , r = true;

					  this.g.lineWidth = this.lineWidth;

					  this.o.cursor
							  && (sat = eat - 0.3)
							  && (eat = eat + 0.3);

					  if (this.o.displayPrevious) {
						ea = this.startAngle + this.angle(this.value);
						this.o.cursor
								&& (sa = ea - 0.3)
								&& (ea = ea + 0.3);
						this.g.beginPath();
						this.g.strokeStyle = this.previousColor;
						this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
						this.g.stroke();
					  }

					  this.g.beginPath();
					  this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
					  this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
					  this.g.stroke();

					  this.g.lineWidth = 2;
					  this.g.beginPath();
					  this.g.strokeStyle = this.o.fgColor;
					  this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
					  this.g.stroke();

					  return false;
					}
				  }
				});
			});
		</script>
	</body>
</html>