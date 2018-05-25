<?php
	include_once "db_connect.php";
	include "functions.php";
	
	date_default_timezone_set('Canada/Eastern');
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	
	$selectClient = "select * from tb_client where client_id='$client_id'";
	$resClient = mysql_query($selectClient);
	$rowClient = mysql_fetch_array($resClient);
	
	$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and status='heartbeatsent'";
	$resHeartbeat = mysql_query($selectHeartbeat);
	
	$selectquestion = "select * from tb_questions";
	$resselectquestion = mysql_query($selectquestion);
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!empty($_POST['heartbeat-submit']))
		{
			if(mysql_num_rows($resHeartbeat) == 0)
			{
				$selectEmail = "select * from tb_emailwording where email_for='initial'";
			}
			$resEmail = mysql_query($selectEmail);
			$rowEmail = mysql_fetch_array($resEmail);
			
			$selectActiveCus = "select * from tb_customer where client_id='$client_id' and customer_isActive='1'";
			$resActiveCus = mysql_query($selectActiveCus);
			$i = 0;
			while($rowActiveCus = mysql_fetch_array($resActiveCus))
			{
				//generate unique token for each email sent
				$token = sha1(uniqid($rowActiveCus['customer_firstname'], true));
				$customer_id = $rowActiveCus['id'];
				$insertheartbeat = "insert into tb_customerheartbeat (client_id,customer_id,send_date,email_token,status) values ('$client_id','$customer_id',NOW(),'$token','heartbeatsent')";
				$resheartbeat = mysql_query($insertheartbeat);
				
				//also add into history table
				$queryCustomerHis = "insert into tb_customerhistory (client_id,customer_id,operation,opdate) values ('$client_id','$customer_id','heartbeatsent',NOW())";
				$resCustomerHis = mysql_query($queryCustomerHis);
				//add code to send email to customer
				
				$i++;
				if($i == mysql_num_rows($resActiveCus))
				{
					header("location:results.php");
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
    <title>Results</title>
	<meta name="description" content=" add description  ... ">
    
	<link href="_layout/css/tooltip.css" rel="stylesheet" type="text/css" />
	
	<link href="_layout/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="_layout/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<link href="_layout/css/_all-skins.min.css" rel="stylesheet" type="text/css" />
	
	<!-- /// Favicons ////////  -->
    <link rel="shortcut icon" href="favicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144-precomposed.png">

	<!-- /// Google Fonts ////////  -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic">
    
    <!-- /// FontAwesome Icons 4.2.0 ////////  -->
	<link rel="stylesheet" href="_layout/css/fontawesome/font-awesome.min.css">
    
    <!-- /// Custom Icon Font ////////  -->
    <link rel="stylesheet" href="_layout/css/iconfontcustom/icon-font-custom.css">  
    
	<!-- /// Template CSS ////////  -->
    <link rel="stylesheet" href="_layout/css/base.css">
    <link rel="stylesheet" href="_layout/css/grid.css">
    <link rel="stylesheet" href="_layout/css/elements.css">
    <link rel="stylesheet" href="_layout/css/layout.css">

	<!-- /// Boxed layout ////////  -->
	<!-- <link rel="stylesheet" href="_layout/css/boxed.css"> -->
    
	<!-- /// JS Plugins CSS ////////  -->
	<link rel="stylesheet" href="_layout/js/revolutionslider/css/settings.css">
	<link rel="stylesheet" href="_layout/js/revolutionslider/css/custom.css">
    <link rel="stylesheet" href="_layout/js/bxslider/jquery.bxslider.css">
    <link rel="stylesheet" href="_layout/js/magnificpopup/magnific-popup.css">
    <link rel="stylesheet" href="_layout/js/animations/animate.min.css">
	<link rel="stylesheet" href="_layout/js/itplayer/css/YTPlayer.css">
    
    <!-- /// Template Skin CSS ////////  -->
	<!-- <link rel="stylesheet" href="_layout/css/skins/default.css"> -->
    <!-- <link rel="stylesheet" href="_layout/css/skins/red.css"> -->
	<!-- <link rel="stylesheet" href="_layout/css/skins/yellow.css"> -->
	<!-- <link rel="stylesheet" href="_layout/css/skins/green.css"> -->
</head>
<body>
	<noscript>
        <div class="javascript-required">
            <i class="fa fa-times-circle"></i> You seem to have Javascript disabled. This website needs javascript in order to function properly!
        </div>
    </noscript>    	
	<!--[if lte IE 8]>
         <div class="modern-browser-required">
        	You are using an <strong>outdated</strong> browser. Please 
        	<a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">upgrade your browser</a> 
            to improve your experience.
		</div>
    <![endif]-->

	<div id="wrap">
	    <div id="header-top">
		<!-- /// HEADER-TOP  //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #header-top -->
		<div id="header" style="top:30px;">
		<!-- /// HEADER  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
			<div class="row">
				<div class="span3">
					<!-- // Logo // -->
					<a href="index.html" id="logo">
						<img class="responsive-img" src="_layout/images/logo.png" alt="">
					</a>
				</div><!-- end .span3 -->
				<div class="span9">
					<div style="float:right;">
						<a href="setting.php">Your Settings</a> | 
						<a href="logout.php">Logout</a>
					</div>
					<!-- // Mobile menu trigger // -->
					<a href="#" id="mobile-menu-trigger">
						<i class="fa fa-bars"></i>
					</a>
					<!-- // Menu // -->
					<ul class="sf-menu fixed" id="menu">
						<li class="current"><a href="results.php">Results</a></li>
						<li><a href="customers.php">Customers</a></li>
						<li><a href="pulses.php">Heartbeats</a></li>
						<li><a href="report.php">Report</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div><!-- end .span9 -->
			</div><!-- end .row -->         
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #header -->		
		
		<div id="content" style="margin-top:150px;">
			<!-- /// CONTENT  ////////////////////////////////////////////////////////////////////////////////////////////// -->
			<div class="row" style="">
				<div id="formstatus">
					<?php
					if("" != $success)
					{
					?>
						<div class="alert success"><i class="fa fa-check-circle-o"></i><?php echo $success;?></div>
					<?php
					}
					elseif("" != $error)
					{
					?>
						<div class="alert error"><i class="fa fa-times-circle"></i><?php echo $error;?></div>
					<?php
					}
					?>
				</div>
				<div>
				<?php
				if(mysql_num_rows($resHeartbeat)==0)
				{
				?>
					<div>
						No Heartbeat sent yet. Send your first heartbeat to all active customers.
						<div style="float:right;">
							<form class="fixed" name="heartbeat-form" name="heartbeat-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
								<input id="heartbeat-submit" name="heartbeat-submit" type="submit" class="btn" value="Send First Heartbeat" />
							</form>
						</div>
					</div>
				<?php
				}
				else
				{
				?>
					<div>
						<?php
						$selectCusHis = "select * from tb_customerhistory where client_id='$client_id' and operation='heartbeatsent'";
						$resSelectCusHis = mysql_query($selectCusHis);
						
						$selectResponse = "select * from tb_customerhistory where client_id='$client_id' and operation='responsereceived'";
						$resResponse = mysql_query($selectResponse);
						if(mysql_num_rows($resResponse)==0)
						{
						?>
							<div align="center">
								<h4 style="color:red;">Your heartbeat has been sent out. Waiting for first Response.</h4>
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
						?>
							<div>
								<h3 style="margin-bottom:-5px;"><?php echo $heartbeatReceived;?> of <?php echo $heartbeatSent;?> Heartbeats Received</h3>Last received about <?php echo $diffstring;?> <?php if($heartbeatPending>0){ echo ', '.$heartbeatPending.' Pending'; } ?>
							</div>
							<div class="row">
								<div class="span8" style="margin-top:20px;" align="center">
									<div>
										<?php 
										$i=1;
										while($rowquestion = mysql_fetch_array($resselectquestion))
										{
											$divid = "sub".$i;
											if($i==1)
											{
												$color = "#00c0ef";
												$value = $question1_value;
											}
											elseif($i==2)
											{
												$color = "#00a65a";
												$value = $question2_value;
											}
											elseif($i==3)
											{
												$color = "#f39c12";
												$value = $question3_value;
											}
											elseif($i==4)
											{
												$color = "#dd4b39";
												$value = $question4_value;
											}
											
											if($i%2 != 0)
											{
											?>
												<div class="span6" style="margin-left:0px;">
											<?php
											}
										?>
											<div class="span3" style="margin-top:20px;">
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
											if($i%2 == 0)
											{
											?>
												</div>
											<?php
											}
											$i++;
										}
										?>
										
									</div>									
								</div>
								<div class="span4" align="center">
									<a href="#"><h4 style=""><?php echo $loveyou_total;?>(<?php echo $loveyou_percent.'%';?>)</h4></a>
									<p>LOVE YOU</p>
									
									<div class="divider single-line"></div>
								
									<a href="#"><h4 style=""><?php echo $likeyou_total;?>(<?php echo $likeyou_percent.'%';?>)</h4></a>
									<p>LIKE YOU</p>
									
									<div class="divider single-line"></div>
								
									<a href="#"><h4 style=""><?php echo $notsatisfied_total;?>(<?php echo $notsatisfied_percent.'%';?>)</h4></a>
									<p>NOT SETISFIED</p>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				<?php
				}
				?>
				</div>
				<div class="row" style="border-top:1px solid; margin-top:25px;">
					<div class="span6" style="margin-top:20px;">
						<?php 
						$selectHeartbeatData = "select * from tb_customerheartbeat where client_id='$client_id' and status='responsereceived'";
						$resHeartbeatData = mysql_query($selectHeartbeatData);
						$customeratrisk = 0; 
						while($rowHeartbeatData=mysql_fetch_array($resHeartbeatData))
						{
							if($rowHeartbeatData['question1_response']<7 || $rowHeartbeatData['question2_response']<7 || $rowHeartbeatData['question3_response']<7 || $rowHeartbeatData['question4_response']<7)
							{
								$customeratrisk = $customeratrisk + 1;
							}
						}
						?>
						<p><a href="customers.php?type=atrisk">You have <?php echo $customeratrisk;?> customer at risk.</a></p>
						<?php 
						$resHeartbeatData = mysql_query($selectHeartbeatData);
						while($rowHeartbeatData=mysql_fetch_array($resHeartbeatData))
						{
							if($rowHeartbeatData['question1_response']<7 || $rowHeartbeatData['question2_response']<7 || $rowHeartbeatData['question3_response']<7 || $rowHeartbeatData['question4_response']<7)
							{
								$selectCustomer = "select * from tb_customer where id=".$rowHeartbeatData['customer_id'];
								$resCustomer = mysql_query($selectCustomer);
								$rowCustomer = mysql_fetch_array($resCustomer);
								
								$dateSubmitted = date_parse($rowHeartbeatData['response_date']);
								
								$question1_percent = ($rowHeartbeatData['question1_response']*100)/10;
								$question2_percent = ($rowHeartbeatData['question2_response']*100)/10;
								$question3_percent = ($rowHeartbeatData['question3_response']*100)/10;
								$question4_percent = ($rowHeartbeatData['question4_response']*100)/10;
							?>
								<div class="span2" style="margin-left:0px;">
									<a href="customer-detail.php?id=<?php echo $rowCustomer['id'];?>"><?php echo $rowCustomer['customer_firstname'].' - '.$rowCustomer['customer_company']; ?></a>
									<br /><small>
									<?php echo "Submitted ".$dateSubmitted['day'].' '.get_month($dateSubmitted['month']).', '.$dateSubmitted['year'];
									?></small>
								</div>
								<div class="span3" style="margin-left:50px;">
									<div class="span1" style="margin-left:0px;">
										<?php echo $rowHeartbeatData['overall_response']; ?>
									</div>
									<div class="span2">
										<div class="progress xs">
											<div class="progress-bar progress-bar-blue" style="width: <?php echo $question1_percent.'%';?>;"></div>
										</div>
										<div class="progress xs">
											<div class="progress-bar progress-bar-green" style="width: <?php echo $question2_percent.'%';?>;"></div>
										</div>
										<div class="progress xs">
											<div class="progress-bar progress-bar-yellow" style="width: <?php echo $question3_percent.'%';?>;"></div>
										</div>
										<div class="progress xs">
											<div class="progress-bar progress-bar-red" style="width: <?php echo $question4_percent.'%';?>;"></div>
										</div>
									</div>
								</div>
								<div class="divider single-line" style="margin-top:110px;"></div>
						<?php
							}
						}
						?>
					</div><!-- end .span6 -->
					<div class="span6" style="margin-top:20px; border-l">
						<h3>Activity Feed</h3>
						<?php
						$selectActivity = "select * from tb_customerhistory where client_id='$client_id' order by opdate desc";
						$resActivity = mysql_query($selectActivity);
						?>
						<div class="widget widget_recent_entries">
							<ul>
								<?php
								while($rowActivity=mysql_fetch_array($resActivity))
								{
									$selectCus = "select * from tb_customer where id='".$rowActivity['customer_id']."'";
									$resCus = mysql_query($selectCus);
									$rowCus = mysql_fetch_array($resCus);
								?>
									<li>
									<?php
									if($rowActivity['operation']=='added')
									{
										$time_display = date_difference($rowActivity['opdate']);
										$dateParsed = date_parse($rowActivity['opdate']);
									?>
										<img src="_content/blog-post/unknown_user-70x70.png" alt="">
										<?php echo $rowClient['client_fullname'];?> added <a href="customer-detail.php?id=<?php echo $rowCus['id'];?>"><?php echo $rowCus['customer_firstname'].' '.$rowCus['customer_lastname'];?></a> from <?php echo $rowCus['customer_company'];?>
										<p class="post-date"><small><?php echo $dateParsed['day'].' '.get_month($dateParsed['month']).', '.$dateParsed['year'];?></small></p>
									<?php
									}
									elseif($rowActivity['operation']=='responsereceived')
									{
										$time_display = date_difference($rowActivity['opdate']);
										$dateParsed = date_parse($rowActivity['opdate']);
									?>
										<img src="_content/blog-post/unknown_user-70x70.png" alt="">
										<a href="customer-detail.php?id=<?php echo $rowCus['id'];?>"><?php echo $rowCus['customer_firstname'].' '.$rowCus['customer_lastname'];?></a> from <?php echo $rowCus['customer_company'];?> submitted Heartbeat
										<p class="post-date"><small><?php echo $dateParsed['day'].' '.get_month($dateParsed['month']).', '.$dateParsed['year'];?></small></p>
									<?php
									}
									elseif($rowActivity['operation']=='resubmit')
									{
										$time_display = date_difference($rowActivity['opdate']);
										$dateParsed = date_parse($rowActivity['opdate']);
									?>
										<img src="_content/blog-post/unknown_user-70x70.png" alt="">
										<a href="customer-detail.php?id=<?php echo $rowCus['id'];?>"><?php echo $rowCus['customer_firstname'].' '.$rowCus['customer_lastname'];?></a> from <?php echo $rowCus['customer_company'];?> resubmitted Heartbeat
										<p class="post-date"><small><?php echo $dateParsed['day'].' '.get_month($dateParsed['month']).', '.$dateParsed['year'];?></small></p>
									<?php
									}
									elseif($rowActivity['operation']=='feedback')
									{
										$time_display = date_difference($rowActivity['opdate']);
										$dateParsed = date_parse($rowActivity['opdate']);
									?>
										<img src="_content/blog-post/unknown_user-70x70.png" alt="">
										<a href="customer-detail.php?id=<?php echo $rowCus['id'];?>"><?php echo $rowCus['customer_firstname'].' '.$rowCus['customer_lastname'];?></a> from <?php echo $rowCus['customer_company'];?> provided Feedback
									<?php
									}
									elseif($rowActivity['operation']=='feedback')
									{
										$time_display = date_difference($rowActivity['opdate']);
										$dateParsed = date_parse($rowActivity['opdate']);
									?>
										<img src="_content/blog-post/unknown_user-70x70.png" alt="">
										<a href="customer-detail.php?id=<?php echo $rowCus['id'];?>"><?php echo $rowCus['customer_firstname'].' '.$rowCus['customer_lastname'];?></a> from <?php echo $rowCus['customer_company'];?> posted a testimonial
									<?php
									}
									?>
									</li>
								<?php
								}
								?>
							</ul>
						</div>
					</div><!-- end .span6 -->
				</div><!-- end .row -->
            </div><!-- end .row -->
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
		
		<div id="footer-bottom">
		<!-- /// FOOTER-BOTTOM    ///////////////////////////////////////// -->	
			<div class="row">
				<div class="span6" id="footer-bottom-widget-area-1">
					<div class="widget widget_text">
						<div class="textwidget">
							<p class="last">Integrity &copy; 2014 All rights reserved</p>
						</div><!-- edn .textwidget -->
					</div><!-- end .widget_text -->
				</div><!-- end .span6 -->
				<div class="span6" id="footer-bottom-widget-area-2">
					
					<div class="widget ewf_widget_social_media"> 
						
						<div class="fixed">
							
							<a href="#" class="googleplus-icon social-icon">
								<i class="fa fa-google-plus"></i>
							</a>
							
							<a href="#" class="pinterest-icon social-icon">
								<i class="fa fa-pinterest"></i>
							</a>
							
							<a href="#" class="facebook-icon social-icon">
								<i class="fa fa-facebook"></i>
							</a>
							
							<a href="#" class="twitter-icon social-icon">
								<i class="fa fa-twitter"></i>
							</a>
							
						</div>
					
					</div><!-- end .ewf_widget_social_media -->
					
				</div><!-- end .span6 -->
			</div><!-- end .row -->
		
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->    
		
		</div><!-- end #footer-bottom -->
	</div><!-- end #wrap -->
    
    <a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>
	
	<?php /*<div class="modal" id="questionFormScreen">
		<div class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				Oops..	
			</div>
		<div class="modal-body text-center">
			Your reward Points are less that product points.
		</div>
		</div>
		</div>
  </div>*/ ?>
  
    <!-- /// jQuery ////////  -->
	<script src="_layout/js/jQuery-2.1.3.min.js"></script>
	<script src="_layout/bootstrap/bootstrap.min.js.js"></script>
	<script src="_layout/js/knob/jquery.knob.js" type="text/javascript"></script>
	
	<script src="_layout/js/tooltip.js" type="text/javascript"></script>
	
    <!-- /// ViewPort ////////  -->
	<script src="_layout/js/viewport/jquery.viewport.js"></script>
    
    <!-- /// Easing ////////  -->
	<script src="_layout/js/easing/jquery.easing.1.3.js"></script>

    <!-- /// SimplePlaceholder ////////  -->
	<script src="_layout/js/simpleplaceholder/jquery.simpleplaceholder.js"></script>

    <!-- /// Fitvids ////////  -->
    <script src="_layout/js/fitvids/jquery.fitvids.js"></script>
    
    <!-- /// Animations ////////  -->
    <script src="_layout/js/animations/animate.js"></script>
     
    <!-- /// Superfish Menu ////////  -->
	<script src="_layout/js/superfish/hoverIntent.js"></script>
    <script src="_layout/js/superfish/superfish.js"></script>
    
    <!-- /// Revolution Slider ////////  -->
    <script src="_layout/js/revolutionslider/js/jquery.themepunch.tools.min.js"></script>
    <script src="_layout/js/revolutionslider/js/jquery.themepunch.revolution.min.js"></script>
    
    <!-- /// bxSlider ////////  -->
	<script src="_layout/js/bxslider/jquery.bxslider.min.js"></script>
    
   	<!-- /// Magnific Popup ////////  -->
	<script src="_layout/js/magnificpopup/jquery.magnific-popup.min.js"></script>
    
    <!-- /// Isotope ////////  -->
	<script src="_layout/js/isotope/imagesloaded.pkgd.min.js"></script>
	<script src="_layout/js/isotope/isotope.pkgd.min.js"></script>
    
    <!-- /// Parallax ////////  -->
	<script src="_layout/js/parallax/jquery.parallax.min.js"></script>

	<!-- /// EasyPieChart ////////  -->
	<script src="_layout/js/easypiechart/jquery.easypiechart.min.js"></script>
    
	<!-- /// YTPlayer ////////  -->
	<script src="_layout/js/itplayer/jquery.mb.YTPlayer.js"></script>
	
    <!-- /// Easy Tabs ////////  -->
    <script src="_layout/js/easytabs/jquery.easytabs.min.js"></script>	
    
    <!-- /// Form validate ////////  -->
    <script src="_layout/js/jqueryvalidate/jquery.validate.min.js"></script>
    
	<!-- /// Form submit ////////  -->
    <script src="_layout/js/jqueryform/jquery.form.min.js"></script>
    
    <!-- /// gMap ////////  -->
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="_layout/js/gmap/jquery.gmap.min.js"></script>

	<!-- /// Twitter ////////  -->
	<script src="_layout/js/twitter/twitterfetcher.js"></script>
	
	<!-- /// Custom JS ////////  -->
	<script src="_layout/js/plugins.js"></script>	
	<script src="_layout/js/scripts.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			var tabload = '<?php echo $tabload;?>';
			$('#tabs-container').easytabs({
				animationSpeed: 300,
				defaultTab: "#"+tabload
			});
			
			// $(".question").click(function (e) {
				// e.preventDefault();
				// $('#questionFormScreen').modal();
			// });
			
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
		
		function oncountrySelect(state)
		{
			var selectedCountry = $(".country option:selected").val();
			$("#countryResponse").html("");
			if(selectedCountry != -1)
			{
				$.ajax({
					type: "POST",
					url: "process-country.php",
					data: { country : selectedCountry, state : state } 
				}).done(function(data){
					$("#countryResponse").html(data);
				});
			}
		}
		
		function onindustrySelect(subindustry)
		{
			var selectedIndustry = $(".industry1 option:selected").val();
			$("#industryResponse").html("");
			if(selectedIndustry != -1)
			{
				$.ajax({
					type: "POST",
					url: "process-industry.php",
					data: { industry : selectedIndustry, subindustry : subindustry } 
				}).done(function(data){
					$("#industryResponse").html(data);
				});
			}
		}
	</script>
    

</body>
</html>