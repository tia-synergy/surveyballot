<?php
	include_once "db_connect.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:index.php");
	}
	
	$clientid = $_SESSION['client_id'];
	
	$selectemail = "select * from tb_emailwording where client_id='$client_id'";
	$resselectemail = mysql_query($selectemail);
		
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!empty($_POST['company-submit']))
		{
			if('' != $_POST['country'] && '' != $_POST['industry1'] && '' != $_POST['size'] && '' != $_POST['feedback'])
			{
				$country = $_POST['country'];
				$states = $_POST['states'];
				$industry1 = $_POST['industry1'];
				$industry2 = $_POST['industry2'];
				$size = $_POST['size'];
				$feedback = $_POST['feedback'];
				
				$query = "Insert into tb_company (client_id,country,state,industry,subindustry,size,feedback_frequency,insertdate) values (".$_SESSION['clientid'].",'$country','$states','$industry1','$industry2','$size','$feedback',NOW())";
				$result = mysql_query($query);
				
				if($result)
				{
					header("location:prepare.php");
					exit();
				}
			}
			else
			{
				if('' == $_POST['country'])
				{
					$error = 'Please select country.';
				}
				elseif('' == $_POST['industry1'])
				{
					$error = 'Please select industry.';
				}
				elseif('' == $_POST['size'])
				{
					$error = 'Please select size.';
				}
				elseif('' == $_POST['feedback'])
				{
					$error = 'Please select how often you want feedback.';
				}
			}
		}
		elseif(!empty($_POST['question-submit']))
		{
			$question_ids = $_POST['question_ids'];
			for($i=0;$i<count($question_ids);$i++)
			{
				$question_no = $i + 1;
				$query = "insert into tb_cquestion (client_id,question_no,question_id,insertdate) values ('$client_id','$question_no','$question_ids[$i]',NOW())";
				$result = mysql_query($query);
				
				if($result)
				{
					header("location:prepare.php");
					exit();
				}
			}
		}
		elseif(!empty($_POST['customer-submit']))
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
				$selectCusInfo = "select * from tb_customer where client_id='$client_id' and customer_email='$customer_email'";
				$resSelectCusInfo = mysql_query($selectCusInfo);
				if(mysql_num_rows($resSelectCusInfo)>0)
				{
					$error = 'You have already entered this customer.';
				}
				else
				{
					$customer_firstname = $_POST['customer_firstname'];
					$customer_lastname = $_POST['customer_lastname'];
					$customer_email = $_POST['customer_email'];
					$customer_status = 1;
					$customer_company = $_POST['customer_company'];
					$customer_group = $_POST['customer_group'];
					
					$query = "insert into tb_customer (client_id,customer_firstname,customer_lastname,customer_email,customer_status,customer_company,customer_group,customer_insertdate) values ('$client_id','$customer_firstname','$customer_lastname','$customer_email','$customer_status','$customer_company','$customer_group',NOW())";
					$result = mysql_query($query);
					
					if($result)
					{
						header("location:prepare.php");
						exit();
					}
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
						<a href="">Your Settings</a> | 
						<a href="logout.php">Logout</a>
					</div>
					<!-- // Mobile menu trigger // -->
					<a href="#" id="mobile-menu-trigger">
                    	<i class="fa fa-bars"></i>
                    </a>
                	<!-- // Menu // -->
					<ul class="sf-menu fixed" id="menu">
						<li>
                        	<a href="logout.php">Results</a>                              
                        </li>
						<li>
                        	<a href="customers.php">Customers</a>                              
                        </li>
						<li>
                        	<a href="logout.php">Heartbeats</a>                              
                        </li>
						<li>
                        	<a href="logout.php">Report</a>                              
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
                    	
                        <h3>4 Step Process</h3>
                        
                    </div><!-- end .span12 -->
                </div><!-- end .row -->
                
            </div><!-- end #page-header -->
           
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
                	
                    <div class="tabs-container" id="tabs-container">
						
                        <ul class="tabs-menu fixed">
                            <li id="tab-1">
                                <a href="#content-tab-1-1">SETUP YOUR COMPANY</a>
                            </li>
                            <li id="tab-2">
                                <a href="#content-tab-1-2">CREATE YOUR SURVEY</a>
                            </li>
                            <li id="tab-3">
                                <a href="#content-tab-1-3">ADD YOUR CUSTOMERS</a>
                            </li>
                            <li id="tab-4">
                                <a href="#content-tab-1-4">PREVIEW HEARTBEAT</a>
                            </li>
                        </ul><!-- end .tabs-menu -->
                        
                        <div class="tabs">
                            
                            <div class="tab-content" id="content-tab-1-1">
                            
                            	<h5>
                                	<strong>Setup Your Company</strong> <br>
                                </h5>
								<form class="fixed" id="company-form" name="company-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<label>Where is your business located?</label>
									<select id="country" name="country" class="country" onchange="oncountrySelect(<?php echo $state;?>);">
										<option value="-1">Select</option>
										<option value="United States" <?php if("United States" == $country) echo 'selected';?>>United States</option>
										<option value="Canada" <?php if("Canada" == $country) echo 'selected';?>>Canada</option>
									</select>
									<div id="countryResponse"></div>
									<label>Which industry are you in?</label>
									<select id="industry1" name="industry1" class="industry1" onchange="onindustrySelect(<?php echo $subindustry;?>)">
										<option value="-1">Select</option>
										<option value="Advertising & Marketing" <?php if("Advertising & Marketing" == $state) echo 'selected';?>>Advertising & Marketing</option>
										<option value="Business Support Services Sector" <?php if("Business Support Services Sector" == $state) echo 'selected';?>>Business Support Services Sector</option>
									</select>
									<div id="industryResponse"></div>
									<label>How big is your organization?</label>
									<select name="size" id="size">
										<option value="-1">Select</option>
										<option value="1-5 Employees" <?php if("1-5 Employees" == $size) echo 'selected';?>>1-5 Employees</option>
										<option value="6-10 Employees" <?php if("6-10 Employees" == $size) echo 'selected';?>>6-10 Employees</option>
										<option value="11-25 Employees" <?php if("11-25 Employees" == $size) echo 'selected';?>>11-25 Employees</option>
										<option value="26-50 Employees" <?php if("26-50 Employees" == $size) echo 'selected';?>>26-50 Employees</option>
										<option value="51-100 Employees" <?php if("51-100 Employees" == $size) echo 'selected';?>>51-100 Employees</option>
										<option value="101-250 Employees" <?php if("101-250 Employees" == $size) echo 'selected';?>>101-250 Employees</option>
										<option value="251-500 Employees" <?php if("251-500 Employees" == $size) echo 'selected';?>>251-500 Employees</option>
										<option value="500+ Employees" <?php if("500+ Employees" == $size) echo 'selected';?>>500+ Employees</option>
									</select>
									<label>How often do you want customer feedback?</label>
									<select name="feedback" id="feedback">
										<option value="-1">Select</option>
										<option value="Every Month" <?php if("Every Month" == $feedback_frequency) echo 'selected';?>>Every Month</option>
										<option value="Every 2 Months" <?php if("Every 2 Months" == $feedback_frequency) echo 'selected';?>>Every 2 Months</option>
										<option value="Every 3 Months" <?php if("Every 3 Months" == $feedback_frequency) echo 'selected';?>>Every 3 Months</option>
										<option value="Every 6 Months" <?php if("Every 6 Months" == $feedback_frequency) echo 'selected';?>>Every 6 Months</option>
										<option value="Once a Year" <?php if("Once a Year" == $feedback_frequency) echo 'selected';?>>Once a Year</option>
									</select>
									<input id="company-submit" name="company-submit" type="submit" class="btn" value="Take me to the next step" />
								</form>
                                
                            </div><!-- end .tab-content -->
                            
                            <div class="tab-content fixed" id="content-tab-1-2">
								<h5>
                                	<strong>Create your survey</strong>
                                </h5>
								<form class="fixed" id="question-form" name="question-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<?php
									if($question_entered == 0)
									{
										$selectquestions = "select * from tb_questions where question_default = 1";
										$res_selectquestion = mysql_query($selectquestions);
									}
									else
									{
										$selectquestions = "select * from tb_questions where id in $question";
										$res_selectquestion = mysql_query($selectquestion);
									}
									?>
									<div class="accordion">
										<?php
										while($row_selectquestion = mysql_fetch_array($res_selectquestion))
										{
										?>
											<a class="accordion-item" href="#">
												<?php echo $row_selectquestion['question_name']; ?>
												<p style="font-size:14px;"><?php echo $row_selectquestion['question']; ?></p>
												<input type="hidden" name="question_ids[]" value="<?php echo $row_selectquestion['id'];?>" />
											</a>
											<div class="accordion-item-content">
												<?php /*<p><a href="#" data-toggle="modal" class="question">Change to your own question</a></p>*/ ?>
											</div>
										<?php
										}
										?>
									</div>
									<input id="question-submit" name="question-submit" type="submit" class="btn" value="Save Questions" />
								</form>
								
                            </div><!-- end .tab-content -->
                            
                            <div class="tab-content fixed" id="content-tab-1-3">
								<h5>
                                	<strong>Active Customers</strong> <br>
									Add your first customer.
								</h5>
								<form class="fixed" id="customer-form" name="customer-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<label>First Name</label>
									<input type="text" name="first_name" value="">
									<label>Last Name</label>
									<input type="text" name="last_name" value="">
									<label>Company</label>
									<input type="text" name="company" value="">
									<label>Group</label>
									<input type="text" name="group" value="">
									<label>Email</label>
									<input type="text" name="email" value="">
									<input id="customer-submit" name="customer-submit" type="submit" class="btn" value="Save Customer" />
								</form>
								<div class="box-body">
									<?php
									if(mysql_num_rows($resSelectCustomer)>0)
									{
									?>
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Name</th>
												<th>Status</th>
												<th>View</th>
												<th>Update</th>
												<th>Company</th>
												<th>Group</th>
												<th>Last Responded</th>
											</tr>
										</thead>
										<tbody>
											<?php
											while($rowSelectCustomer = mysql_fetch_array($resSelectCustomer))
											{
											?>
											<tr>
												<td><?php echo $rowSelectCustomer['customer_firstname'].' '.$rowSelectCustomer['customer_lastname'];?></td>
												<td><?php if($rowSelectCustomer['status']==1) echo 'Active'; else echo 'Disabled'; ?> </td>
												<td><a href="">-</a></td>
												<td><a href="">Update</a></td>
												<td><?php echo $rowSelectCustomer['customer_company']; ?></td>
												<td><?php echo $rowSelectCustomer['customer_group']; ?></td>
												<td><?php echo $rowSelectCustomer['customer_lastresponded']; ?></td>
											</tr>
											<?php
											}
											?>
										</tbody>
									</table>
									<?php 
									}
									?>
								</div>
                            </div><!-- end .tab-content -->
                            
                            <div class="tab-content fixed" id="content-tab-1-4">
                            
                            	<img src="_content/services/145x145-4.png" alt="">
                            
                                <h5>
                                	<strong>Donec pretium ante ac nulla vestibulum, eu gravida turpis.</strong> <br>
                                    In porta lacus quam, id elementum diam luctus efficitur. Vestibulum magna purus, pharetra non nisl in, placerat 
                                    interdum enim. Integer porta varius accumsan. Integer eget pharetra nunc. Donec vulputate in libero id cursus. 
                                    Pellentesque rutrum, neque vel scelerisque sollicitudin, mauris nibh varius ipsum, sed hendrerit augue enim nec 
                                    leo quis nulla acilisis felis vel convallis.
                                </h5>
                            
                            </div><!-- end .tab-content -->
                            
						</div><!-- end .tabs -->  
                    
                    </div><!-- end .tab-container -->
                    
                </div><!-- end .span12 -->
            </div><!-- end .row -->
			
			<div class="row">
            	<div class="span9">
                    
                    <div class="vertical-tabs-container fixed">
					
						<ul class="tabs-menu fixed">
                            <li>
                                <a href="#content-tab-3-1">Social media marketing</a>
                            </li>
                            <li>
                                <a href="#content-tab-3-2">Google adwords</a>
                            </li>
                            <li>
                                <a href="#content-tab-3-3">E-commerce integration</a>
                            </li>
                        </ul><!-- end .tabs-menu -->
                        
                        <div class="tabs">
                            
                            <div class="tab-content" id="content-tab-3-1">
                            
                            	<h4 class="text-uppercase"><strong>Social media marketing</strong></h4>
                            
                                <p>Fusce at ex commodo, convallis ligula id, aliquet lacus. Suspendisse accumsan, est sed feugiat dignissim, 
                                lacus tortor gravida nibh, vitae pulvinar sem ante in lorem. Vestibulum at nisl vel velit posuere pharetra 
                                vel a mauris. Fusce ante dolor, congue at viverra ac, molestie ut urna. Maecenas augue ligula, vehicula quis 
                                sagittis vel, consequat at nisi. donec eget dui ac ex bibendum gravida id eu tortor. </p>
                            
                            </div><!-- end .tab-content -->
                            
                            <div class="tab-content" id="content-tab-3-2">	
                                
                                <h4 class="text-uppercase"><strong>Google adwords</strong></h4>
                            
                                <p>Praesent venenatis, risus ac ornare consequat, dui diam pharetra enim, nec feugiat felis urna vel purus. 
                                Morbi neque velit, suscipit quis tortor eget, posuere mattis ex. Duis ac convallis libero. Integer faucibus 
                                consequat ex, lobortis dapibus odio lobortis quis. Aenean ullamcorper ipsum velit, eu fermentum enim pellentesque 
                                in. Praesent efficitur dolor non erat condimentum, eget malesuada augue efficitur. </p>
                                
                            </div><!-- end .tab-content -->
                            
                            <div class="tab-content" id="content-tab-3-3">	
                                
                                <h4 class="text-uppercase"><strong>E-commerce integration</strong></h4>
                            
                                <p>Mauris nisl lectus, pulvinar et iaculis a, fermentum id nunc. Etiam non dui non nulla pretium tempor ut ac 
                                justo. Fusce efficitur libero sit amet luctus malesuada. Maecenas rhoncus turpis quis mauris euismod ullamcorper. 
                                Suspendisse ipsum justo, viverra quis faucibus vel, ornare non neque. Integer non tortor id lacus blandit ultricies. 
                                Pellentesque et ullamcorper mauris, ut dolor arcu euismod accumsan. </p>
                                
                            </div><!-- end .tab-content -->
                            
						</div><!-- end .tabs -->  
					
					</div><!-- end .vertical-tabs-container -->
                    
                </div><!-- end .span9 -->
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