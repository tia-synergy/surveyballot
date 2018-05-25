<?php
	include_once "../db_connect.php";
	include "functions.php";
	
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
	
	$selectHeartbeat = "select * from tb_heartbeat where client_id='$client_id'";
	$resHeartbeat = mysql_query($selectHeartbeat);
	
	$selectCustomers = "select * from tb_customer where client_id='$client_id' order by customer_insertdate desc";
	$resCustomers = mysql_query($selectCustomers);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Survey Ballot Admin | Client Detail</title>
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
		<link href="../_layout/css/tooltip.css" rel="stylesheet" type="text/css" />
		
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
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Survey - <b><?php echo $rowClient['client_fullname']; ?></b></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								<!--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
							</div>
						</div>
						<div class="box-body">
							<?php
							$selectCusHis = "select * from tb_customerhistory where client_id='$client_id' and operation='heartbeatsent'";
							$resSelectCusHis = mysql_query($selectCusHis);
							
							$selectResponse = "select * from tb_customerheartbeat where client_id='$client_id' and status='responsereceived'";
							$resResponse = mysql_query($selectResponse);
							if(mysql_num_rows($resResponse)==0)
							{
							?>
								<div align="center">
									<h4 style="color:red;">Your survey has been sent out. Waiting for first Response.</h4>
								</div>
							<?php
							}
							else
							{
								$heartbeatSent = mysql_num_rows($resSelectCusHis);
								$heartbeatReceived = mysql_num_rows($resResponse);
								$heartbeatPending = $heartbeatSent - $heartbeatReceived;
								
								$selectMaxResponseDate = "select max(opdate) as lastdate from tb_customerhistory where client_id='$client_id' and operation='responsereceived'";
								$resMaxResponseDate = mysql_query($selectMaxResponseDate);
								$rowMaxResponseDate = mysql_fetch_array($resMaxResponseDate);
								
								$lastResponseDate = $rowMaxResponseDate['lastdate'];
								
								$selectdatediff = "select DATEDIFF(NOW(),'$lastResponseDate') AS DiffDate, TIMESTAMPDIFF(HOUR,'$lastResponseDate',NOW()) AS DiffHour, TIMESTAMPDIFF(MINUTE,'$lastResponseDate',NOW()) AS DiffMin";
								$resdatediff = mysql_query($selectdatediff);
								$rowdatediff = mysql_fetch_array($resdatediff);
								// echo "DiffDate: ".$rowdatediff['DiffDate'];
								// echo "DiffHour: ".$rowdatediff['DiffHour'];
								
								$diffstring = "";
								if($rowdatediff['DiffDate']>0)
								{
									$diffstring = $rowdatediff['DiffDate']." days ago";
								}
								elseif($rowdatediff['DiffHour']>0)
								{
									$diffstring = $rowdatediff['DiffHour']." hours ago";
								}
								elseif($rowdatediff['DiffMin']>0)
								{
									$diffstring = $rowdatediff['DiffMin']." minutes ago";
								}
								$selectHeartbeatData = "select * from tb_customerheartbeat where client_id='$client_id' and status='responsereceived'";
								$resHeartbeatData = mysql_query($selectHeartbeatData);
								$totalResponse = 0;
								$question1_total = 0;
								$question2_total = 0;
								$question3_total = 0;
								$question4_total = 0;
								$overall_total = 0;
								
								$loveyou_total = 0;
								$likeyou_total = 0;
								$notsatisfied_total = 0;
								
								$loveyou_percent = 0;
								$likeyou_percent = 0;
								$notsatisfied_percent = 0;
								while($rowHeartbeatData=mysql_fetch_array($resHeartbeatData))
								{
									$totalResponse = $totalResponse + 1;
									$question1_total = $question1_total + $rowHeartbeatData['question1_response'];
									$question2_total = $question2_total + $rowHeartbeatData['question2_response'];
									$question3_total = $question3_total + $rowHeartbeatData['question3_response'];
									$question4_total = $question4_total + $rowHeartbeatData['question4_response'];
									$overall_total = $overall_total + $rowHeartbeatData['overall_response'];
									
									if($rowHeartbeatData['recommend_response'] == 1)
									{
										$loveyou_total = $loveyou_total + 1;
									}
									elseif($rowHeartbeatData['recommend_response'] == 2)
									{
										$likeyou_total = $likeyou_total + 1;
									}
									elseif($rowHeartbeatData['recommend_response'] == 3)
									{
										$notsatisfied_total = $notsatisfied_total + 1;
									}
								}
								
								$loveyou_percent = ($loveyou_total*100)/mysql_num_rows($resHeartbeatData);
								$likeyou_percent = ($likeyou_total*100)/mysql_num_rows($resHeartbeatData);
								$notsatisfied_percent = ($notsatisfied_total*100)/mysql_num_rows($resHeartbeatData);

								$question1_value = $question1_total/$totalResponse;
								$question2_value = $question2_total/$totalResponse;
								$question3_value = $question3_total/$totalResponse;
								$question4_value = $question4_total/$totalResponse;
								$overall_value = $overall_total/$totalResponse;
								?>
								
								<p style="margin-bottom:0px;"><strong><?php echo $heartbeatReceived;?> of <?php echo $heartbeatSent;?> Survey Received</strong></p>Last received about <?php echo $diffstring;?> <?php if($heartbeatPending>0){ echo ', '.$heartbeatPending.' Pending'; } ?>
								<div class="row">
									<div style="margin-top:20px;" align="center">
										<div>
											<?php 
											$selectquestion = "select * from tb_cquestion where client_id='$client_id'";
											$resselectquestion = mysql_query($selectquestion);
											$i=1;
											while($rowquestion = mysql_fetch_array($resselectquestion))
											{
												$divid = "sub".$i;
												if($i==1)
												{
													$color = "#00c0ef";
													$value = number_format($question1_value,2);
												}
												elseif($i==2)
												{
													$color = "#00a65a";
													$value = number_format($question2_value);
												}
												elseif($i==3)
												{
													$color = "#f39c12";
													$value = number_format($question3_value);
												}
												elseif($i==4)
												{
													$color = "#dd4b39";
													$value = number_format($question4_value);
												}
												
												
											?>
												<div class="col-md-2" style="margin-top:20px;">
													<a href="#" onmouseover="tooltip.pop(this, '<?php echo "#".$divid;?>', {position:0, offsetX:0, offsetY:-65, effect:'slide'})">
														<input type="text" class="knob" style="display:inline-block;" value="<?php echo $value;?>" data-width="100" data-height="100" data-fgColor="<?php echo $color;?>" data-readonly="true" data-min="0" data-max="10" data-angleOffset="180"/>
														<div class="knob-label"><?php echo $rowquestion['question_name'];?> </div>
													</a>
												</div>
												<div style="display:none;">
													<div id="<?php echo $divid;?>" style="width:250px;">
														<?php echo $rowquestion['question'];?>      
													</div>
												</div>
												
												<?php
												$i++;
											}
											?>
											<div class="col-md-2" style="margin-top:20px;">
												<a href="#" onmouseover="tooltip.pop(this, '<?php echo "#sub".$i;?>', {position:0, offsetX:0, offsetY:-65, effect:'slide'})">
													<input type="text" class="knob" style="display:inline-block;" value="<?php echo number_format($overall_value);?>" data-width="100" data-height="100" data-fgColor="<?php echo $color;?>" data-readonly="true" data-min="0" data-max="10" data-angleOffset="180"/>
													<div class="knob-label">Overall</div>
												</a>
											</div>
											<div style="display:none;">
												<div id="sub<?php echo $i;?>" style="width:250px;">
													Overall      
												</div>
											</div>
										</div>									
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
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
										<th>Survey Sent</th>
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
							</table>
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
		
		<script src="../_layout/js/tooltip.js" type="text/javascript"></script>
		
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