<?php
	include_once "db_connect.php";
	include "functions.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	$customer_id = $_GET['id'];
	
	$client_email = $_SESSION['email'];
	
	$selectCustDetail = "select * from tb_customer where id='$customer_id'";
	$resCustDetail = mysql_query($selectCustDetail);
	$rowCustDetail = mysql_fetch_array($resCustDetail);
	
	$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
	$resHeartbeat = mysql_query($selectHeartbeat);
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!empty($_POST['customer-submit']))
		{
			$customer_email = $_POST['email'];
			$customer_email = stripslashes($customer_email);
			$customer_email = mysql_real_escape_string($customer_email);
			if(!filter_var($customer_email, FILTER_VALIDATE_EMAIL))
			{
				$error = "Please enter a valid email address of customer.";
			}
			else
			{
				$selectCusInfo = "select * from tb_customer where client_id='$client_id' and customer_email='$customer_email' and customer_email!='".$rowCustDetail['customer_email']."'";
				$resSelectCusInfo = mysql_query($selectCusInfo);
				if(mysql_num_rows($resSelectCusInfo)>0)
				{
					$error = 'You have already entered this customer.';
				}
				else
				{
					$customer_firstname = $_POST['first_name'];
					$customer_lastname = $_POST['last_name'];
					$customer_email = $_POST['email'];
					$customer_status = 1;
					$customer_isActive = 1;
					$customer_company = $_POST['company'];
					$customer_group = $_POST['group'];
					
					$query = "update tb_customer set customer_firstname='$customer_firstname', customer_lastname='$customer_lastname', customer_email='$customer_email', customer_company='$customer_company', customer_group='$customer_group', customer_updatedate=NOW() where client_id='$client_id' and id='$customer_id'";
					$result = mysql_query($query);
					
					if($result)
					{
						header("location:customer-detail.php?id=".$rowCustDetail['id']);
						exit();
					}
				}
			}
		}
		elseif(!empty($_POST['out-submit']))
		{
			$query = "update tb_customer set customer_isActive=2 where client_id='$client_id' and id='$customer_id'";
			$result = mysql_query($query);
			
			if($result)
			{
				header("location:customer-detail.php?id=".$rowCustDetail['id']);
				exit();
			}
		}
		elseif(!empty($_POST['activate-submit']))
		{
			$query = "update tb_customer set customer_isActive=1 where client_id='$client_id' and id='$customer_id'";
			$result = mysql_query($query);
			
			if($result)
			{
				header("location:customer-detail.php?id=".$rowCustDetail['id']);
				exit();
			}
		}
		elseif(!empty($_POST['heartbeat-submit']))
		{
			if(mysql_num_rows($resHeartbeat) == 0)
			{
				$selectEmail = "select * from tb_emailwording where email_for='initial'";
			}
			
			$resEmail = mysql_query($selectEmail);
			$rowEmail = mysql_fetch_array($resEmail);
			
			$token = sha1(uniqid($rowCustDetail['customer_firstname'], true));
			
			
			//require_once "Mail.php";  
			// $from = "Sandra Sender <sender@example.com>"; 
			// $from = $client_email; 
			// // $to = "Ramona Recipient <recipient@example.com>"; 
			// $to = "vickyshah.cer@gmail.com";
			// $subject = "Hi!"; 
			// $body = "Hi,\n\nHow are you?";  
			// $host = "smtp.gmail.com"; 
			// $username = "vaibhavi@synergyit.ca"; 
			// $password = "vaibhavicky";  
			// $headers = array ('From' => $from,   'To' => $to,   'Subject' => $subject); 
			// $smtp = Mail::factory('smtp',   array ('host' => $host,     'auth' => true,     'username' => $username,     'password' => $password));  
			// $mail = $smtp->send($to, $headers, $body);  
			// if (PEAR::isError($mail)) 
			// {   
				// echo("<p>" . $mail->getMessage() . "</p>");  
			// } 
			// else 
			// {   
				// echo("<p>Message successfully sent!</p>");  
			// }
			
			// if($result)
			// {
				// header("location:customer-detail.php?id=".$rowCustDetail['id']);
				// exit();
			// }
		}
	}
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
    
	<title>Customers</title>
	<meta name="description" content=" add description  ... ">
    
	<!-- Bootstrap 3.3.2 -->
    <link href="_layout/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="_layout/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="_layout/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	
    <!-- /// Favicons ////////  -->
    <link rel="shortcut icon" href="favicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144-precomposed.png">

	<!-- /// Google Fonts ////////  -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic">
    
	<link rel="stylesheet" href="_layout/css/foundation.min.css">
	
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
   
	<script src="_layout/js/vendor/modernizr.js"></script>
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
		<!-- /// HEADER-TOP  //////////////////////////////////// -->
			
			
			
		<!-- ///////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #header-top -->
		<div id="header" style="top:30px;">
		<!-- /// HEADER  /////////////////////////////////////////////////// -->
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
						<li><a href="results.php">Results</a></li>
						<li class="current"><a href="customers.php">Customers</a></li>
						<li><a href="pulses.php">Heartbeats</a></li>
						<li><a href="report.php">Report</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div><!-- end .span9 -->
			</div><!-- end .row -->         
		<!-- ///////////////////////////////////////////// -->
		</div><!-- end #header -->		
		<div id="content" style="margin-top:150px;">
			<!-- /// CONTENT  ///////////////////////////////// -->
			<div class="row">
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
				<?php
				if($rowCustDetail['customer_isActive'] == 2)
				{
				?>
					<div style="color:rgb(255,255,255); background-color:darkorange;padding-top:10px;padding-bottom:10px;padding-left:10px;margin-top:-20px;margin-bottom:10px;">
						This customer has opted out of all future heartbeats.
					</div>
				<?php
				}
				?>
				<div style="margin-bottom:70px;">
					<div class="span6">
						<h3 style="margin-bottom:-5px;">
							<strong><?php echo $rowCustDetail['customer_firstname'].' '.$rowCustDetail['customer_lastname'];?></strong>
							<?php echo '- '.$rowCustDetail['customer_company']; ?>
						</h3>
						<h5><?php echo $rowCustDetail['customer_email']; ?></h5>
					</div>
					<div class="span6">
						<?php
						/*
							
							
							if(mysql_num_rows($resHeartbeat) == 0) 
							{
							?>
								<a href="#" class="btn" data-reveal-id="myModal" style="float:right;">Delete Customer</a>
							<?php
							}
						*/
						?>
						<a href="#" class="btn" data-reveal-id="editCustomer" style="float:right;">Edit Customer Details</a>
						<?php
						if($rowCustDetail['customer_isActive'] == 1)
						{
						?>
							<a href="#" class="btn" data-reveal-id="optoutCustomer" style="float:right;">Opt Out Customer</a>
						<?php
						}
						elseif($rowCustDetail['customer_isActive'] == 2)
						{
						?>
							<a href="#" class="btn" data-reveal-id="optinCustomer" style="float:right;">Reactivate Customer</a>
						<?php
						}
						?>
						
					</div>
				</div>
				
				<div class="box-body">
					<?php
					if($rowCustDetail['customer_isActive'] == 1)
					{
					?>
						<div class="divider single-line"></div>
						<div class="content-wrapper">
							<?php
							if($rowCustDetail['customer_heartbeatcount'] == 0) 
							{
							?>
									<!-- Content Header (Page header) -->
									<section class="content-header" align="center">
										<form class="fixed" name="heartbeat-form" name="heartbeat-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
											<h4><?php echo $rowCustDetail['customer_firstname']; ?> has never been sent a heartbeat.</h4>
											<input id="heartbeat-submit" name="heartbeat-submit" type="submit" class="btn" value="Send them a heartbeat" />
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
												$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
												$resHeartbeat = mysql_query($selectHeartbeat);
												while($rowHeartbeat=mysql_fetch_array($resHeartbeat))
												{
													$sendDate = date_parse($rowHeartbeat['send_date']);
													$openDate = date_parse($rowHeartbeat['open_date']);
													$responseDate = date_parse($rowHeartbeat['response_date']);
													if($rowHeartbeat['status'] == "heartbeatsent")
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
																<div class='timeline-footer'>
																	<a class="btn btn-primary btn-xs">Send followup email manually</a>
																</div>
															</div>
														</li>
													<?php
													}
													elseif($rowHeartbeat['status'] == "emailopened")
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
																<div class='timeline-footer'>
																	<a class="btn btn-primary btn-xs">Send followup email manually</a>
																</div>
															</div>
														</li>
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
																<div class='timeline-footer'>
																	<a class="btn btn-primary btn-xs">Send followup email manually</a>
																</div>
															</div>
														</li>
													<?php
													}
													elseif($rowHeartbeat['status'] == "responsereceived")
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
																<div class='timeline-footer'>
																	<a class="btn btn-primary btn-xs">Send followup email manually</a>
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
																	<a class="btn btn-primary btn-xs">Send followup email manually</a>
																</div>
															</div>
														</li>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$responseDate['day'].' '.get_month($responseDate['month']).', '.$responseDate['year'];?></span>
																<h3 class="timeline-header">Customer has submitted survey.</h3>
																<div class="timeline-body">
																	
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
														<?php echo $todaydate['day'].' '.get_month($todaydate['month']).', '.$todaydate['year'];?>
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
						</div>
						<?php
					}
					?>
					
					
				</div>
            </div><!-- end .row -->
		<!-- ///////////////////////////////////// -->
		</div><!-- end #content -->
        <div id="footer-bottom">
			<!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////// -->	
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
		<!-- //////////////////////////////////////////////////////////// -->    
		</div><!-- end #footer-bottom -->
	</div><!-- end #wrap -->
    
    <a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>
	
	<div id="editCustomer" class="reveal-modal" style="width:525px;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Edit Customer</strong> <br>
		</h5>
		<div>
			<form class="fixed" id="customer-form" name="customer-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
				<div>
					<div class="span3">
						<label>First Name</label>
						<input type="text" name="first_name" value="<?php echo $rowCustDetail['customer_firstname'];?>">
					</div>
					<div class="span3">
						<label>Last Name</label>
						<input type="text" name="last_name" value="<?php echo $rowCustDetail['customer_lastname'];?>">
					</div>
				</div>
				<div>
					<div class="span3">
						<label>Company</label>
						<input type="text" name="company" value="<?php echo $rowCustDetail['customer_company'];?>">
					</div>
					<div class="span3">
						<label>Group</label>
						<input type="text" name="group" value="<?php echo $rowCustDetail['customer_group'];?>">
					</div>
				</div>
				<label>Email</label>
				<input type="text" name="email" value="<?php echo $rowCustDetail['customer_email'];?>">
				<input id="customer-submit" name="customer-submit" type="submit" class="btn" value="Save Customer" />
			</form>        
		</div>
		<a class="close-reveal-modal" href="customers.php">&#215;</a>		
	</div>
  
	<div id="optoutCustomer" class="reveal-modal" style="width:525px;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Are you sure you want to opt out this customer?</strong> <br>
			The customer will not receive any more Heartbeats.
		</h5>
		<form class="fixed" id="out-form" name="out-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
			<input type="submit" id="out-submit" name="out-submit" class="btn" value="Yes, OptOut" />
		</form>
		<a class="btn" href="" class="btn">Cancel</a>
		<a class="close-reveal-modal">&#215;</a>		
	</div>
	
	<div id="optinCustomer" class="reveal-modal" style="width:525px;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Are you sure you want to reactivate this customer?</strong> <br>
			The customer will receive Heartbeats again.
		</h5>
		<form class="fixed" id="activate-form" name="activate-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
			<input type="submit" id="activate-submit" name="activate-submit" class="btn" value="Yes, Reactivate" />
		</form>
		<a class="btn" href="" class="btn">Cancel</a>
		<a class="close-reveal-modal">&#215;</a>		
	</div>
	
	<script src="_layout/js/vendor/fastclick.js"></script>

	<!-- /// jQuery ////////  -->
	<script src="_layout/js/jquery-2.1.1.min.js"></script>
	
	<script src="_layout/js/foundation.min.js"></script>
    
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
    
    <!-- /// Twitter ////////  -->
	<script src="_layout/js/twitter/twitterfetcher.js"></script>
	
	<!-- /// Custom JS ////////  -->
	<script src="_layout/js/plugins.js"></script>	
	<script src="_layout/js/scripts.js"></script>
	
	<script type="text/javascript">
		// Foundation.set_namespace = function() {};
		$(document).foundation();
	</script>
    

</body>
</html>