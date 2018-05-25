<?php
include_once "db_connect.php";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	if(!empty($_POST['register-submit']))
	{
		if("" != $_POST['cname'] && "" != $_POST['fname'] && "" != $_POST['email'] && "" != $_POST['password'] && "" != $_POST['cpassword'])
		{
			$email = $_POST['email'];
			$email = stripslashes($email);
			$email = mysql_real_escape_string($email);
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$error = "Please enter a valid email address.";
			}
			else
			{
				$selUser = "select client_id from tb_client where client_email='$email'";
				$selUserRes = mysql_query($selUser);
				if(mysql_num_rows($selUserRes)>0)
				{
					$error = "You are already registered with same email address.";
				}
				else
				{
					$fullname = $_POST['fname'];
					$companyname = $_POST['cname'];
					$password = $_POST['password'];
					
					$fullname = stripslashes($fullname);
					$companyname = stripslashes($companyname);
					$password = stripslashes($password);
					
					$fullname = mysql_real_escape_string($fullname);
					$companyname = mysql_real_escape_string($companyname);
					$password = mysql_real_escape_string($password);
					
					$password = md5($password);
					
					$status = 1;
					
					$query = "Insert into tb_client (client_fullname,client_email,client_company,client_password,client_status,client_insertDate) values ('$fullname','$email','$companyname','$password','$status',NOW())";
					$result = mysql_query($query);
					$userid = mysql_insert_id();
					
					if(!$result)
					{	
						echo mysql_error();
						$registerError = "An error occurred while registration. Please try again later.";
					}
					else
					{
						$to = $email;
						$subject = 'Welcome to Cutomer Survey';
						$headers = "From: vaibhavi@synergyit.ca\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						$message = 'Hi '.$fname.',<br><br>Welcome to customer survey site. <br><br>Thanks,<br>Customer Survey Team';
						mail($to, $subject, $message, $headers);
						
						session_start();
						$_SESSION['email'] = $email;
						$_SESSION['clientid'] = $userid;
						
						header("location:prepare.php");
						exit();
					}
				}
			}
		}
		else
		{
			if("" == $_POST['cname'])
			{
				$error = "Please enter company name.";
			}
			elseif("" == $_POST['fname'])
			{
				$error = "Please enter your full name.";
			}
			elseif("" == $_POST['email'])
			{
				$error = "Please enter your email address.";
			}
			elseif("" == $_POST['password'])
			{
				$error = "Please enter password.";
			}
			elseif("" == $_POST['cpassword'])
			{
				$error = "Please confirm your password.";
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
    
    
	<title>Register for customer survey</title>
	<meta name="description" content=" add description  ... ">
    
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
<body class="sticky-header">
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
        <!-- /// HEADER-TOP  ////////////////////////////////////////// -->
          
            
        <!-- ////////////////////////////////////////////////////////// -->
        </div><!-- end #header-top -->
        <div id="header" style="top:30px;">
        <!-- /// HEADER  ////////////////////////////////////// -->
			<div class="row">
				<div class="span4">
					<!-- // Logo // -->
					<a href="index.php" id="logo">
                    	<img class="responsive-img" src="_layout/images/logo.png" alt="">
                    </a>
				</div><!-- end .span3 -->
				<div class="span8">
					<!-- // Mobile menu trigger // -->
					<a href="#" id="mobile-menu-trigger">
                    	<i class="fa fa-bars"></i>
                    </a>
                    <!-- // Menu // -->
					<ul class="sf-menu fixed" id="menu">
						<!--<li class="dropdown"><a href="index.php">Home</a></li>-->
                        <li class="dropdown"><a href="howitworks.php">How It Works</a></li>
                        <!--<li class="dropdown"><a href="portfolio.php">Customers</a></li>
                        <li class="dropdown"><a href="blog.php">Blog</a></li>-->
						<!--<li class="current"><a href="signup.php">Sign Up</a></li>-->
                        <li><a href="login.php" class="btn" style="margin-top:20px; padding:25px 25px; color:white;">Sign In</a></li>
					</ul>

				</div><!-- end .span9 -->
			</div><!-- end .row -->
        <!-- //////////////////////////////////////////////// -->
		</div><!-- end #header -->			
		<!--<div id="content" style="margin-top:150px;">-->
		<div id="content">
		<!-- /// CONTENT  ////////////////////////////////////////////////// -->
            <div class="row">
                <div class="span12">
                	<div class="headline-2">
                        <h4>Register</h4>
                    </div><!-- end .headline-2 -->
                    <form class="fixed" id="register-form" name="register-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">  
                        <fieldset>
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
                            <p>
                                <label>Company Name: <span style="font:red">*</span></label>
								<input class="span4" type="text" id="cname" name="cname" value="" placeholder="Company Name" />
                            </p>
                            <p>
                                <label>Full Name: <span style="font:red">*</span></label>
								<input class="span4" type="text" id="fname" name="fname" value="" placeholder="Full Name" />
                            </p>
							<p>
                                <label>Email: <span style="font:red">*</span></label>
								<input class="span4" type="text" id="email" name="email" value="" placeholder="Email" />
                            </p>
							<p>
                                <label>Password: <span style="font:red">*</span></label>
								<input class="span4" type="password" id="password" name="password" value="" placeholder="Password" />
                            </p>
							<p>
                                <label>Confirm Password: <span style="font:red">*</span></label>
								<input class="span4" type="password" id="cpassword" name="cpassword" value="" placeholder="Confirm Password" />
                            </p>
                            <p class="last">
                                <input id="register-submit" name="register-submit" type="submit" class="btn" value="Create Account" />
                            </p>
                        </fieldset>
					</form><!-- end #contact-form -->
                    
                </div><!-- end .span6 -->
            </div><!-- end .row -->      
        <!-- //////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
        <div id="footer-bottom">
        <!-- /// FOOTER-BOTTOM ///////////////////////////////// -->	
			<div class="row">
				<div class="span6" id="footer-bottom-widget-area-1">
					<div class="widget widget_text">
                        <div class="textwidget">
                          <!--  <p class="last">Integrity &copy; 2014 All rights reserved</p>-->
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
		<!-- ////////////////////////////////////////////////////// -->    
		</div><!-- end #footer-bottom -->
	</div><!-- end #wrap -->
    
    <a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>

    <!-- /// jQuery ////////  -->
	<script src="_layout/js/jquery-2.1.1.min.js"></script>

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
</body>
</html>