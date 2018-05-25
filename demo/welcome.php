<?php
include_once "db_connect.php";

session_start();
if( !isset($_SESSION['email']) )
{
	//header("location:index.php");
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
    
    
	<title> Welcome </title>
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
        	
        <!-- /// HEADER-TOP  //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            
            <div class="row">
            	<div class="span6" id="header-top-widget-area-1">
                	
                    <div class="widget widget_text">
                    
                        <div class="textwidget">
                            <p class="last">Mauris commodo rhoncus dolor porttitor duis lactus.</p>
                        </div><!-- edn .textwidget -->
                        
                    </div><!-- end .widget_text -->
                    
                </div><!-- end .span6 -->
            	<div class="span6" id="header-top-widget-area-2">
                	
                   <div class="widget ewf_widget_contact_info">
                        
                        <ul>
                            <li>
                            	<span>
                                	<i class="ifc-phone1"></i>
                                </span>
                                +1 (234) 567 890
                            </li>
                            <li>
                            	<span>
                                	<i class="ifc-message"></i>
                                </span>
                                <a href="mailto:#">office@integrity.com</a>
                            </li>
                        </ul>
                        
                    </div><!-- end .ewf_widget_contact_info -->
                    
                </div><!-- end .span6 -->                
            </div><!-- end .row -->
            
        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        
        </div><!-- end #header-top -->
        <div id="header">
        
		<!-- /// HEADER  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

			<div class="row">
				<div class="span3">
				
					<!-- // Logo // -->
					
					<a href="index.php" id="logo">
                    	<img class="responsive-img" src="_layout/images/logo.png" alt="">
                    </a>
				
				</div><!-- end .span3 -->
				<div class="span9">
				
					<!-- // Mobile menu trigger // -->
					
                	<a href="#" id="mobile-menu-trigger">
                    	<i class="fa fa-bars"></i>
                    </a>
                    
                    <!-- // Custom search // -->                                        
                    
					<form action="#" id="custom-search-form" method="get" role="search">
                        <input type="text" value="" name="s" id="s" placeholder="type and press enter to search...">
                        <input type="submit" id="custom-search-submit" value="">
                    </form>

                    <a id="custom-search-button" href="#"></a>
					
					<!-- // Menu // -->
					
					<ul class="sf-menu fixed" id="menu">
						<li class="dropdown">
                        	<a href="index.php">Home</a>
                            <ul>
                            	<li>
                                	<a href="index.php">Home 1</a>
                                </li>
                                <li>
                                	<a href="index-2.html">Home 2</a>
                                </li>
                                <li>
                                	<a href="index-3.html">Home 3</a>
                                </li>
                                <li>
                                	<a href="index-4.html">Home 4</a>
                                </li>
                                <li>
                                	<a href="index-5.html">Home 5</a>
                                </li>
                                <li>
                                	<a href="index-6.html">Home 6</a>
                                </li>
                                <li>
                                	<a href="index-7.html">Home 7</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                        	<a href="about-us.html">Pages</a>
                            <ul>
                                <li>
                                	<a href="about-us.html">About us</a>
                                </li>
								<li>
                                	<a href="about-us-2.html">About us 2</a>
                                </li>
                                <li>
                                	<a href="about-me.html">About me</a>
                                </li>
                                <li>
                                	<a href="services.html">Services</a>
                                </li>
                                <li>
                                	<a href="single-service.html">Single service</a>
                                </li>
                                <li>
                                	<a href="pricing.html">Pricing</a>
                                </li>
                                <li>
                                	<a href="testimonials.html">Testimonials</a>
                                </li>
                                <li>
                                	<a href="page-404.html">Page 404</a>
                                </li>
                                <li>
                                	<a href="page-with-sidebar.html">Page with sidebar</a>
                                </li>
                                <li>
                                	<a href="full-width-page.html">Full width page</a>
                                </li>
                                <li class="dropdown">
                                	<a href="#">3rd level dropdown</a>
                                    <ul>
										<li>
                                        	<a href="#">3rd level</a>
                                        </li>
										<li>
                                        	<a href="#">dropdown</a>
                                        </li>
										<li>
                                        	<a href="#">exemple</a>
                                        </li>
									</ul>									 
								</li>
                            </ul>
                        </li>
                        <li class="current">                        	
                        	<a href="#">Features</a>
                            
                            <div class="sf-mega sf-mega-4-col">
                            	
                                <div class="sf-mega-section">
                                
                                    <ul>
                                        <li>                                        	
                                            <a href="typography.html">
                                            	<i class="ifc-generic_text"></i>
                                                Typography
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="responsive-grid.html">
                                            	<i class="ifc-vpn"></i>
                                                Responsive Grid
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="sliders.html">
                                            	<i class="ifc-tv"></i>
                                            	Sliders
                                            </a>
                                        </li>                                                                               
										<li>                                        	
                                            <a href="headline.html">
                                            	<i class="ifc-up2"></i>
                                                Headline
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="animations.html">
                                            	<i class="ifc-joystick"></i>
                                                Animations
                                            </a>
                                        </li> 
                                        <li>                                        	
                                            <a href="alerts-notifications.html">
                                            	<i class="ifc-error"></i>
                                                Alerts and Notifications
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="custom-lists.html">
                                            	<i class="ifc-torah"></i>
                                            	Custom Lists
                                            </a>
                                        </li>                                        
                                    </ul>
                                
                                </div><!-- end .sf-mega-section -->
                                
                                <div class="sf-mega-section">
                                
                                    <ul> 
                                        <li>                                        	
                                            <a href="dividers.html">
                                            	<i class="ifc-line"></i>
                                                Dividers
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="buttons.html">
                                            	<i class="ifc-sent"></i>
                                                Buttons
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="google-maps.html">
                                            	<i class="ifc-map_marker"></i>
                                                Google maps
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="page-sections.html">
                                            	<i class="ifc-cut"></i>
                                                Page sections
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="parallax-backgrounds.html">
                                            	<i class="ifc-align_justify"></i>
                                                Parallax backgrounds
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="video-background.html">
                                            	<i class="ifc-video_camera"></i>
                                                Video background
                                            </a>
                                        </li> 
                                        <li>                                        	
                                            <a href="process-builder.html">
                                            	<i class="ifc-circuit"></i>
                                            	Process Builder
                                            </a>
                                        </li>                                        
                                    </ul>
                                
                                </div><!-- end .sf-mega-section -->
                                
                                <div class="sf-mega-section">
                                
                                    <ul>
                                    	<li>                                        	
                                            <a href="accordion-toggles.html">
                                            	<i class="ifc-week_view"></i>
                                                Accordion and Toggles
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="tabs.html">
                                            	<i class="ifc-data_in_both_directions"></i>
                                            	Tabs
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="icon-boxes.html">
                                            	<i class="ifc-inbox"></i>
                                                Icon Boxes
                                            </a>
                                        </li>
                                        <li>                                        	
                                            <a href="infographics.html">
                                            	<i class="ifc-combo_chart"></i>
                                            	Infographics
                                            </a>
                                        </li> 
                                        <li>                                        	
                                            <a href="pricing-data-tables.html">
                                            	<i class="ifc-price_tag"></i>
                                            	Pricing &amp; Data tables
                                            </a>
                                        </li>                                                                                                           	
                                        <li>                                        	
                                            <a href="social-media.html">
                                            	<i class="ifc-facebook"></i>
                                            	Social Media
                                            </a>
                                        </li>                                        
                                        <li>
                                            <a href="widgets.html">
                                            	<i class="ifc-info"></i>
                                                Widgets
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </div><!-- end .sf-mega-section -->
                                
                                <div class="sf-mega-section hidden-phone hidden-tablet">
                                    
                                    <p>
                                    	<img src="_layout/images/mega-menu.png" alt="">
                                    </p>
                                    
                                    <p>Lorem ipsum dolor sit amet, risus ante dictum diam nec.</p>
                                    
                                    <a class="btn" href="#">Read More</a>
                                    
                                </div><!-- end .sf-mega-section -->
                                
                        	</div><!-- end .sf-mega -->
                            
                        </li>			
						<li class="dropdown">
                        	<a href="portfolio-3-cols.html">Portfolio</a>
                            <ul>
								<li class="dropdown">
									<a href="#">Portfolio classic</a>
									<ul>
										<li>
											<a href="portfolio-classic-3-cols.html">Portfolio classic 3 cols</a>
										</li> 
										<li>
											<a href="portfolio-classic-4-cols.html">Portfolio classic 4 cols</a>
										</li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#">Portfolio filterable</a>
									<ul>
										<li>
											<a href="portfolio-3-cols.html">Portfolio 3 cols</a>
										</li> 
										<li>
											<a href="portfolio-4-cols.html">Portfolio 4 cols</a>
										</li>
									</ul>
								</li>	
								<li>
									<a href="portfolio-masonry.html">Portfolio masonry</a>
								</li>								
								<li>
									<a href="portfolio-item.html">Portfolio item</a>
								</li>
							</ul>                           
                        </li>
                        <li class="dropdown">
                        	<a href="blog.html">Blog</a>
                            <ul>
                                <li>
                                	<a href="blog.html">Blog</a>
                                </li>
                                <li>
                                	<a href="blog-post.html">Blog post</a>
                                </li>
                            </ul>                               
                        </li>
                        <li>
                        	<a href="logout.php">Logout</a>                              
                        </li>
					</ul>

				</div><!-- end .span9 -->
			</div><!-- end .row -->
            
        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

		</div><!-- end #header -->		
		<div id="content">
		
		<!-- /// CONTENT  /////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

			<div id="page-header" style="background-image:url(_content/backgrounds/1920x250-1.jpg);">
            	
                <div id="page-header-overlay"></div>
                
                <div class="row">
                	<div class="span12">
                    	
                        <h3>Welcome</h3>
                        
                    </div><!-- end .span12 -->
                </div><!-- end .row -->
                
            </div><!-- end #page-header -->
            
			<div class="row">
				<div class="span12">
                	
                    <div class="tabs-container">
                    
                        <ul class="tabs-menu fixed">
                            <li>
                                <a href="prepare.php">Setup Your Company</a>
                            </li>
                            <li>
                                <a href="#">Create Your Survey</a>
                            </li>
                            <li>
                                <a href="#">Add Your Customers</a>
                            </li>
                            <li>
                                <a href="#">Preview Survey</a>
                            </li>
                        </ul><!-- end .tabs-menu -->
                        
                        <div class="tabs">
                            
                            <div class="tab-content fixed" id="content-tab-1-1">
                            
                            	<img src="_content/services/145x145-1.png" alt="">
                            
                                <h5>
                                	<strong>Setup Your Company</strong> <br>
                                    Quisque ultricies ex quis nibh gravida, rhoncus egestas nisl ullamcorper. Vivamus ac egestas arcu. 
                                    Pellentesque tristique imperdiet ipsum, quis dignissim ipsum sollicitudin molestie. Proin vitae tortor 
                                    eu dui tincidunt volutpat. Morbi lorem est, tristique sit amet mauris quis, interdum lacinia mauris. 
                                    Aliquam erat volutpat. Pellentesque pretium luctus nisl vitae semper. 
                                </h5>
                            
                            </div><!-- end .tab-content -->
                            
                            
                            
						</div><!-- end .tabs -->  
                    
                    </div><!-- end .tab-container -->
                    
                </div><!-- end .span12 -->
            </div><!-- end .row -->
		
                        
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

		</div><!-- end #content -->
        <div id="footer">
		
		<!-- /// FOOTER     ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

			<div class="row">
				<div class="span3" id="footer-widget-area-1">
					
					<div class="widget widget_text">
                        
                        <h4 class="widget-title">Text widget</h4>
                    
                        <div class="textwidget">
                        
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sodales cursus metus. Aliquam accumsan pretium 
                            tellus, ac adipiscing metus dignissim in. Pellentesque vel porta libero, sit amet commodo nibh. </p>
                            
                            <p>Convallis, hendrerit lobortis nisl. Fusce sagittis erat felis, sed varius nibh convallis non. Sed accumsan 
                            lobortis sollicitudin. Vestibulum varius cursus pharetra. Vivamus tincidunt nisi et auctor mattis. Aliquam 
                            bibendum dui purus.</p>
                            
                        </div><!-- edn .textwidget -->
                        
                    </div><!-- end .widget_text -->
					
				</div><!-- end .span3 -->
				<div class="span3" id="footer-widget-area-2">
					
					<div class="widget widget_recent_entries">
                        
                        <h4 class="widget-title">Latest Posts</h4>
                    
                        <ul>
                            <li>
                                
                                <img src="_content/blog-post/70x70-1.png" alt="">
                                
                                <a href="#">Aliquam accumsan pretium volutpat. </a>
                                
                                <p class="post-date"><small>22 Nov by <a href="#">Admin</a> in <a href="#">News</a></small></p>
                                
                            </li>
                            <li>
                                
                                <img src="_content/blog-post/70x70-2.png" alt="">
                                
                                <a href="#">Fusce sagittis erat felis varius duis.</a>
                                
                                <p class="post-date"><small>20 Nov by <a href="#">Admin</a> in <a href="#">News</a></small></p>
                                
                            </li>
                            <li>
                                
                                <img src="_content/blog-post/70x70-3.png" alt="">
                                
                                <a href="#">Vivamus tincidunt nisi et dolor auctor.</a>
                                
                                <p class="post-date"><small>18 Nov by <a href="#">Admin</a> in <a href="#">News</a></small></p>
                                
                            </li>
                        </ul>
                        
                    </div><!-- end .widget_recent_entries -->
					
				</div><!-- end .span3 -->
				<div class="span3" id="footer-widget-area-3">
					
					<div class="widget ewf_widget_flickr">
                    
                    	<h4 class="widget-title">Flickr</h4>
                    
                    	<div class="flickr-feed">
                    		<script src="http://www.flickr.com/badge_code_v2.gne?count=9&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=52617155@N08"></script>
                    	</div>
                    
                    </div><!-- end .ewf_widget_flickr -->
					
				</div><!-- end .span3 -->
				<div class="span3" id="footer-widget-area-4">
					
					<div class="widget widget_text">
                        
                        <h4 class="widget-title">Get In Touch</h4>
                    
                        <div class="textwidget">
                        
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit etiam sodales.
                            
                        </div><!-- edn .textwidget -->
                        
                    </div><!-- end .widget_text -->
                    
                    <div class="widget ewf_widget_contact_info">
                
                        <h4 class="widget-title">Address</h4>
                        
                        <ul>
                            <li>
                            	<span>
                                	<i class="ifc-home"></i>
                                </span>
                                616 Travis Street, Palm Beach,  FL 3340, United States
                            </li>
                            <li>
                            	<span>
                                	<i class="ifc-phone2"></i>
                                </span>
                                +1 (234) 567 890
                            </li>
                            <li>
                            	<span>
                                	<i class="ifc-message"></i>
                                </span>
                                <a href="mailto:#">office@integrity.com</a>
                            </li>
                        </ul>
                        
                    </div><!-- end .ewf_widget_contact_info -->
					
				</div><!-- end .span3 -->
			</div><!-- end .row -->
            
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

		</div><!-- end #footer -->
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
		
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->    
		
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