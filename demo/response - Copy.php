<?php
	include_once "db_connect.php";
	
	$token = $_GET['token'];
	
	$selheartbeat = "select * from tb_customerheartbeat where email_token='$token'";
	$resheartbeat = mysql_query($selheartbeat);
	$rowheartbeat = mysql_fetch_array($resheartbeat);
	
	$client_id = $rowheartbeat['client_id'];
	$selclient = "select * from tb_client where client_id='$client_id'";
	$resclient = mysql_query($selclient);
	$rowclient = mysql_fetch_array($resclient);
	
	$customer_id = $rowheartbeat['customer_id'];
	$selcustomer = "select * from tb_customer where id='$customer_id'";
	$rescustomer = mysql_query($selcustomer);
	$rowcustomer = mysql_fetch_array($rescustomer);
	
	$selcquestions = "select * from tb_cquestion where client_id='$client_id' order by question_no";
	$rescquestions = mysql_query($selcquestions);
	
	/*
	on form post 
	1. insert data into tb_customerhistory
	*/
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
    
	<title>Response</title>
	<meta name="description" content=" add description  ... ">
    
	<link href="_layout/css/jquery-ui.css" rel="stylesheet">
	
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
    <link href="_layout/css/_all-skins.min.css" rel="stylesheet" type="text/css" />
	
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
		<!-- /// HEADER-TOP  ////////////////////// -->
			
			
			
		<!-- ////////////////////////////////////////// -->
		</div><!-- end #header-top -->
		<div id="header" style="top:30px;">
		<!-- /// HEADER  /////////////////////////// -->
				
		<!-- ////////////////////////////////////// -->
		</div><!-- end #header -->		
		<div id="content">
			<!-- /// CONTENT  ////////////////////////// -->
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
				<div>
					<div align="center" style="padding-top:40px;">
						<img class="responsive-img" src="_layout/images/logo.png" alt="">
						<h3 style="padding-top:40px;"><?php echo "Hi ".$rowcustomer['customer_firstname'];?></h3>
						<h5 style="margin-bottom:30px;">Please submit your satisfaction scores. Our Heartbeat program is designed to allow us to monitor and improve the level of service we provide to our clients.</h5>
						<div align="left" style="margin-left:15px;">
						<?php 
						while($rowcquestion = mysql_fetch_array($rescquestions))
						{
							if($rowcquestion['question_no']==1)
							{
								$color = "#00c0ef";
							}
							elseif($rowcquestion['question_no']==2)
							{
								$color = "#00a65a";
							}
							elseif($rowcquestion['question_no']==3)
							{
						 		$color = "#f39c12";
							}
							elseif($rowcquestion['question_no']==4)
							{
								$color = "#dd4b39";
							}
						?>
							<p>
								<span style="color:<?php echo $color;?>; font-size:18px;"><strong><?php echo $rowcquestion['question_name'];?></strong></span><br />
								<?php echo $rowcquestion['question'];?>
							</p>
							<div id="radioset<?php echo $rowcquestion['question_no'];?>">
							<?php 
						  	for($i=0;$i<10;$i++)
							{
								// if($i==0)
									// echo "Very Poor";
								// elseif($i==5)
									// echo "Average";
								// if($i==7)
									// echo "Satisfied";
								// if($i==10)
									// echo "Impressed";
								$radioid = "radio_".$rowcquestion['question_no']."_".$i;
							?>
								<input type="radio" class="alert1" id="<?php echo $radioid;?>" name="radio"><label for="<?php echo $radioid;?>"><?php echo $i+1;?></label>
								<?php
									if($i==0)
									{
									?>
										<div class="highlight" style="margin-left:1px; padding-left:10px;">Very Poor</div>
									<?php
									}
									elseif($i==4)
									{
									?>
										<div class="highlight" style="margin-left:335px; padding-left:14px;">Average</div>
									<?php
									}
									elseif($i==6)
									{
									?>
										<div class="highlight" style="margin-left:503px; padding-left:14px;">Satisfied</div>
									<?php
									}
									elseif($i==9)
									{
									?>
										<div class="highlight" style="margin-left:755px; padding-left:8px;">Impressed</div>
									<?php
									}
									?>
								<?php /*
								<div class="alert1" style="color:<?php echo $color;?>"><?php echo $i+1;?>
									<?php
									if($i==0)
									{
									?>
										<div class="highlight">Very Poor</div>
									<?php
									}
									elseif($i==4)
									{
									?>
										<div class="highlight">Average</div>
									<?php
									}
									elseif($i==6)
									{
									?>
										<div class="highlight">Satisfied</div>
									<?php
									}
									elseif($i==9)
									{
									?>
										<div class="highlight">Impressed</div>
									<?php
									}
									?>
								</div>
								*/?>
							<?php
							}
							?>
							</div>
							<div class="divider single-line" style="margin-top:70px;"></div>
						<?php
						}
						?>
							<p>
								<span style="font-size:18px;"><strong>Overall</strong></span><br />
								Overall, how satisfied are you with <?php echo $rowclient['client_company'];?>?
							</p>
							<?php 
							for($i=0;$i<10;$i++)
							{
								// if($i==0)
									// echo "Very Poor";
								// elseif($i==5)
									// echo "Average";
								// if($i==7)
									// echo "Satisfied";
								// if($i==10)
									// echo "Impressed";
							?>
								<div class="alert1" style="color:<?php echo $color;?>"><?php echo $i+1;?>
								<?php
								if($i==0)
								{
								?>
									<div class="highlight">Very Poor</div>
								<?php
								}
								elseif($i==4)
								{
								?>
									<div class="highlight">Average</div>
								<?php
								}
								elseif($i==6)
								{
								?>
									<div class="highlight">Satisfied</div>
								<?php
								}
								elseif($i==9)
								{
								?>
									<div class="highlight">Impressed</div>
								<?php
								}
								?>
								</div>
							<?php
							}
							?>
							<div class="divider single-line"></div>
							<label>How would you feel about recommending <?php echo $rowclient['client_company'];?>?</label>
							<input type="radio" value="1" />I would go out of my way to recommend <?php echo $rowclient['client_company'];?> 
							<input type="radio" value="1" /> I would recommend <?php echo $rowclient['client_company'];?> if asked  
							<input type="radio" value="1" /> I wouldn't feel comfortable recommending <?php echo $rowclient['client_company'];?>
						</div>
					</div>
				</div>
            </div><!-- end .row -->
		<!-- ////////////////////////// -->
		</div><!-- end #content -->
        
		<div id="footer-bottom">
			<!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////////////////////////////////////////////////////// -->	
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
		<!-- //////////////////////////////////////////////// -->    
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
	
	<script src="_layout/js/jquery-ui.js"></script>
	
	<!-- /// Custom JS ////////  -->
	<script src="_layout/js/plugins.js"></script>	
	<script src="_layout/js/scripts.js"></script>
	
	<script type="text/javascript">
		// Foundation.set_namespace = function() {};
		$(document).foundation();
		$( "#radioset1" ).buttonset();
		$( "#radioset2" ).buttonset();
		$( "#radioset3" ).buttonset();
		$( "#radioset4" ).buttonset();
		
	</script>
    

</body>
</html>