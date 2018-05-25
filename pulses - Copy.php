<?php
	include_once "db_connect.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	
	$selectHeartbeat = "select * from tb_heartbeat where client_id='$client_id'";
	$resHeartbeat = mysql_query($selectHeartbeat);
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
		<!-- /// HEADER-TOP  ///////////////////////////////////////////////// -->
			
			
			
		<!-- ///////////////////////////////////////////////////////////////////// -->
		</div><!-- end #header-top -->
		<div id="header" style="top:30px;">
		<!-- /// HEADER  ///////////////////////////////////////////////////////////////// -->
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
						<li><a href="customers.php">Customers</a></li>
						<li class="current"><a href="pulses.php">Heartbeats</a></li>
						<li><a href="report.php">Report</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div><!-- end .span9 -->
			</div><!-- end .row -->         
		<!-- /////////////////////////////////////////////////////////// -->
		</div><!-- end #header -->		
		<div id="content" style="margin-top:150px;">
			<!-- /// CONTENT  ////////////////////////////////////////////////////////////////////// -->
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
				<div class="span12">
					<div class="content-wrapper">
						<!-- Main content -->
						<section class="content">
							<!-- row -->
							<div class="row">
								<div class="col-md-12">
								<!-- The time line -->
									<ul class="timeline">
										<?php 
										while($rowHeartbeat=mysql_fetch_array($resHeartbeat))
										{
										?>
										<!-- timeline item -->
										<li>
											<i class="fa fa-envelope bg-blue"></i>
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
												<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
												<div class="timeline-body">
												  Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
												  weebly ning heekya handango imeem plugg dopplr jibjab, movity
												  jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
												  quora plaxo ideeli hulu weebly balihoo...
												</div>
												<div class='timeline-footer'>
													<a class="btn btn-primary btn-xs">Read more</a>
													<a class="btn btn-danger btn-xs">Delete</a>
												</div>
											</div>
										</li>
										<!-- END timeline item -->
										<?php
										}
										?>
								<!-- timeline item -->
								<li>
								  <i class="fa fa-user bg-aqua"></i>
								  <div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
									<h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
								  </div>
								</li>
								<!-- END timeline item -->
								<!-- timeline item -->
								<li>
								  <i class="fa fa-comments bg-yellow"></i>
								  <div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
									<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
									<div class="timeline-body">
									  Take me to your leader!
									  Switzerland is small and neutral!
									  We are more like Germany, ambitious and misunderstood!
									</div>
									<div class='timeline-footer'>
									  <a class="btn btn-warning btn-flat btn-xs">View comment</a>
									</div>
								  </div>
								</li>
								<!-- END timeline item -->
								<!-- timeline time label -->
								<li class="time-label">
								  <span class="bg-green">
									3 Jan. 2014
								  </span>
								</li>
								<!-- /.timeline-label -->
								<!-- timeline item -->
								
								<!-- END timeline item -->
								<li>
								  <i class="fa fa-clock-o bg-gray"></i>
								</li>
							  </ul>
							</div><!-- /.col -->
						  </div><!-- /.row -->


						</section><!-- /.content -->
					</div>
                </div><!-- end .span12 -->
            </div><!-- end .row -->
		<!-- ///////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
		<div id="footer-bottom">
			<!-- /// FOOTER-BOTTOM     //////////////////////////////////////// -->	
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
		<!-- ///////////////////////////////////////////////////// -->    
		</div><!-- end #footer-bottom -->
	</div><!-- end #wrap -->
    
    <a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>
	
	<div id="myModal" class="reveal-modal" style="width:525px;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Add Customer</strong> <br>
		</h5>
		<div>
			<form class="fixed" id="customer-form" name="customer-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
				<div>
					<div class="span3">
						<label>First Name</label>
						<input type="text" name="first_name" value="">
					</div>
					<div class="span3">
						<label>Last Name</label>
						<input type="text" name="last_name" value="">
					</div>
				</div>
				<div>
					<div class="span3">
						<label>Company</label>
						<input type="text" name="company" value="">
					</div>
					<div class="span3">
						<label>Group</label>
						<input type="text" name="group" value="">
					</div>
				</div>
				<label>Email</label>
				<input type="text" name="email" value="">
				<input id="customer-submit" name="customer-submit" type="submit" class="btn" value="Save Customer" />
			</form>        
		</div>
		<a class="close-reveal-modal" href="customers.php">&#215;</a>		
	</div>
  
	<div id="multipleCustomer" class="reveal-modal" style="width:525px;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Add Multiple Customers</strong> <br>
		</h5>
		<div>
			Please submit your file as a CSV in the following format.     
		</div>
		<a class="close-reveal-modal" href="customers.php">&#215;</a>		
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