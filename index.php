<?php 
		include_once "db_connect.php";
		session_start();
		
		
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
	<title> Customer Survey</title>
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
	    <?php include "header.php"; ?>		
		<!--<div id="content1" style="margin-top:150px;">-->
		<div id="content1">
		<!-- /// CONTENT  ///////////////////////// -->
			<?php /*<div class="fullwidthbanner-container">
                <div class="fullwidthbanner">
                    <ul>
						<li data-transition="fade">
                            <img src="_layout/images/banner-4.jpg"  alt="" height="300">
                            <!--<img src="_content/slider/1920x650-2.jpg"  alt="">
                            <div class="caption sft" data-x="250" data-y="0" data-speed="1000" data-start="1000" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p1.png" alt="">
                            </div>
                            <div class="caption sfb" data-x="150" data-y="480" data-speed="1000" data-start="1300" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p2.png" alt="">
                            </div>
							<div class="caption sfb" data-x="730" data-y="475" data-speed="1000" data-start="1600" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p3.png" alt="">
                            </div>
                            <div class="caption sfb" data-x="760" data-y="340" data-speed="1000" data-start="1900" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p4.png" alt="">
                            </div>
                            <div class="caption sfl" data-x="0" data-y="250" data-speed="1000" data-start="2100" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p5.png" alt="">
                            </div>
                            <div class="caption sfb" data-x="830" data-y="470" data-speed="1000" data-start="2400" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p6.png" alt="">
                            </div>
                            <div class="caption fade" data-x="850" data-y="540" data-speed="1000" data-start="3000" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p7.png" alt="">
                            </div>
                            <div class="caption fade" data-x="870" data-y="350" data-speed="1000" data-start="3300" data-easing="easeOutExpo">
                                <img src="_content/slider/slide2-p8.png" alt="">
                            </div>
                            <div class="caption title-bg sft" data-x="220" data-y="230" data-speed="1000" data-start="3600"data-easing="easeOutExpo">
								Enjoy integrity template
                            </div>
                            <div class="caption sfb" data-x="530" data-y="520" data-speed="1000" data-start="4000" data-easing="easeOutExpo">
                                <a class="btn btn-large" href="#">Purchase Now</a>
                            </div>
                            <div class="caption sfb" data-x="310" data-y="520" data-speed="1000" data-start="4300" data-easing="easeOutExpo">
                                <a class="btn btn-large btn-white alt" href="#">Discover More</a>
                            </div>-->
                        </li>
						<!--<li data-transition="fade">
                            <img src="_content/slider/1920x650-4.jpg"  alt="">
                            <div class="caption title-2 sft" data-x="50" data-y="110" data-speed="1000" data-start="1000"         data-easing="easeOutExpo">
                                 Integrity multi-purpose <br> business template
                            </div>
                            <div class="caption subtitle alt sfl" data-x="50" data-y="280" data-speed="1000" data-start="1400"    data-easing="easeOutExpo">
                                 the most beautiful template on the market
                            </div>
                            <div class="caption text sfl" data-x="50" data-y="350" data-speed="1000" data-start="1800" data-easing="easeOutExpo">
                                 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam a adipiscing libero, ultrices <br>
								 lectus. Cras porta nisl at tincidunt tincidunt. Sed consectetur sapien vel libero feugiat vitae. 
                            </div>
                            <div class="caption sfb" data-x="50" data-y="460" data-speed="1000" data-start="2200" data-easing="easeOutExpo">
								<a class="btn btn-large btn-white" href="#">Discover More</a> 
                            </div>
                            <div class="caption sfb" data-x="270" data-y="460" data-speed="1000" data-start="2500" data-easing="easeOutExpo">
                                <a class="btn btn-large" href="#">Purchase Now</a> 
                            </div>
                        </li>
                        <li data-transition="fade">
                            <img src="_content/slider/1920x650-1.jpg"  alt="">
                            <div class="caption sfb" data-x="0" data-y="350" data-speed="1000" data-start="1000" data-easing="easeOutExpo">
                                <img src="_content/slider/slide1-p1.png" alt="">
                            </div>
                            <div class="caption sfb" data-x="700" data-y="295" data-speed="1000" data-start="1400" data-easing="easeOutExpo">
                                <img src="_content/slider/slide1-p2.png" alt="">
                            </div>
                            <div class="caption sfb" data-x="270" data-y="210" data-speed="1000" data-start="1800" data-easing="easeOutExpo">
                                <img src="_content/slider/slide1-p3.png" alt="">
                            </div>
                            <div class="caption title sft" data-x="300" data-y="70" data-speed="1000" data-start="2200" data-easing="easeOutExpo">
                                Enjoy
                            </div>
                            <div class="caption subtitle sfr" data-x="550" data-y="80" data-speed="1000" data-start="2600"      data-easing="easeOutExpo">
                                <strong>Integrity multi-purpose <br> business template</strong>
                            </div>
                        </li>
                        <li data-transition="fade">
                            <img src="_content/slider/1920x650-3.jpg"  alt="">
                            <div class="caption title sfl" data-x="240" data-y="280" data-speed="1000" data-start="1000" data-easing="easeOutExpo">
                                Explore
                            </div>
                            <div class="caption subtitle sfr" data-x="580" data-y="290" data-speed="1000" data-start="1400"data-easing="easeOutExpo">
                                <strong>Integrity multi-purpose <br> business template</strong>
                            </div>
                        </li>-->
                    </ul>
                </div><!-- end .fullwidthbanner -->
            </div><!-- end .fullwidthbanner-container -->			*/?>
			<img src="_layout/images/banner-4.jpg"  alt="" style="width:100%"> 
		
            <div class="row">	
				
            	<!--<div class="span12">					-->
				
					<div class="headline" style="margin-bottom:10px;">
				
                        <!--<h2>How good your relation with your customer?</h2>-->
                        <h4 style="margin-top:20px; margin-bottom:20px;">We provide a Real Professional online survey tool to listen to your customers and find out what you are doing well and where you can improve to keep your customers happy. </h4>
						<a class="btn btn-large" href="<?php if(isset($_SESSION['clientid'])) echo 'customers.php'; else echo 'login.php';?>" >Create Your First Survey</a>
						
					</div><!-- end .headline -->
					
					<div class="headline" style="margin-bottom:10px;">
                        <h3>A Survey tool built for effective market research solutions for all types of businesses to measure customer satisfaction</h3>
                    </div><!-- end .headline-2 -->
				<!--</div><!-- end .span12 -->
            <!--</div><!-- end .row -->
			<div class="row">
				<div class="span6">
					<div class="icon-box-4"    style="margin-bottom: 25px;">
						<div class="icon-box-content" style="margin-left:0px;">
							<h4>
								<a href="single-service.html">Customer Surveys</a>
							</h4>
    							<p>If you want actionable insight into your customer satisfaction levels, it’s very simple… you need to create a customer survey that asks the right questions and is optimized enough to get high survey response rates.<br/>
                                A customer survey will help you to know your customers’ likes, dislikes, and the areas of improvement that exist. For example, what does the average customer think about prices of services you provide? Too high? Just right? How well is your staff doing on customer service, is there anything at all about the customer experience that turns off your customers?<br/>
                                Your employee will meet milestones based on the needs of the customers and if you are developing a new product or service or updating the existing one, customer can provide you feedback about the design and functionality of the product.
                            </p>
						</div><!-- end .icon-box-content -->
					</div><!-- end .icon-box-4 -->
					<div class="icon-box-4">
                    <div class="icon-box-content" style="margin-left:0px;">
                            <h4>
                                <a href="single-service.html">Identify Unhappy Customers</a>
                            </h4>
                            <p><b>Get notified when we find your customers unhappy </b>
                            <br/>Business growth depends upon strong customer retention. To retain more customers, you need to listen to them and know when they are ‘at risk’.<br/>
                            By using surveys in survey ballot and asking customers the right questions, you can find out what they really think about your service. The feedback becomes actionable and your unhappy customers would be identified by our proprietary algorithms and tag them as 'at risk' and instantly emails you through a notification.
                            </p>
                        </div>
					<!-- end .icon-box-content -->
					</div><!-- end .icon-box-4 -->
				</div><!-- end .span6 -->
				<div class="span6">
					<div class="icon-box-4" style="margin-bottom: 25px;">
						  <div class="icon-box-content" style="margin-left:0px;">
                            <h4>
                                <a href="single-service.html">Measure and Track Customer Satisfaction</a>
                            </h4>
                            <p>The purpose of this type of surveys is to keep track of how satisfied your customers are. A happy customer is extremely valuable to your company. Happy customers come back and make repeat purchases; they have higher customer lifetime values and are less likely to defect to competitors.
                            <br/> 
                            On the flipside, an unhappy customer is a nightmare. They are more likely not to continue to buy from you, and even worse, they tell lots of people about their bad experience.<br/>
                            Choose the Survey Ballot that gives you the ability to track and trend satisfaction levels from one survey period to the next and intelligently identify customers who might be at risk.<br/><br/>  <br/>       
                            </p>
                        </div><!-- end .icon-box-content -->
					</div><!-- end .icon-box-4 -->
					<div class="icon-box-4">
						<div class="icon-box-content" style="margin-left:0px;">
							<h4>
								<a href="single-service.html">Get Testimonials, Display and Share Them</a>
							</h4>
							<p>A testimonial is a truthful endorsement whereby someone testifies to the quality of a product, person or service<br/>
                            Great testimonials tell people that your product or service is not only legit, but awesome enough that other people are seeing great results from it<br/>
                            Generate testimonials from your customers, display them using our testimonial widget and have them instantly shared across Facebook and Twitter
                            </p>
						</div><!-- end .icon-box-content -->
					</div><!-- end .icon-box-4 -->
				</div><!-- end .span6 -->
			</div><!-- end .row -->
        <!-- ///////////////////////////////////////////////// -->
		</div><!-- end #content -->
        <div id="footer-bottom">
        <!-- /// FOOTER-BOTTOM     /////////////////////////////////////////// -->	
			<div class="row">
				<div class="span6" id="footer-bottom-widget-area-1">
					<div class="widget widget_text">
                        <div class="textwidget">
                            <!--<p class="last">Synergy Echo &copy; 2015 All rights reserved</p>-->
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
		<!-- ////////////////////////////////////////////////////////// -->    
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