<?php
	include_once "db_connect.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!empty($_POST['company-submit']))
		{
			$updateClient = "update tb_client set client_company='".$_POST['cname']."' where client_id='$client_id'";
			$resUpdateClient = mysql_query($updateClient);
			
			$website = $_POST['cwebsite'];
			$country = $_POST['country'];
			$states = $_POST['states'];
			$industry1 = $_POST['industry1'];
			$industry2 = $_POST['industry2'];
			$size = $_POST['size'];
			$feedback = $_POST['feedback'];

			$updateCompany = "update tb_company set company_website='$website', country='$country', state='$states', industry='$industry1', subindustry='$industry2', size='$size', feedback_frequency='$feedback', updatedate=NOW() where client_id='$client_id'";
			$resUpdateCompany = mysql_query($updateCompany);
			
			if($resUpdateCompany)
			{
				$success = "Data Updated Successfully.";
			}
			else
			{
				$error = "There is ans error updating data. Please try again later.";
			}
		}
		elseif(!empty($_POST['user-submit']))
		{
			$fullname = $_POST['fullname'];
			$email = $_POST['email'];
			
			$currentpassword = $_POST['currentpw'];
			if($currentpassword == '')
			{
				$updateClient = "update tb_client set client_fullname='$fullname', client_email='$email' where client_id='$client_id'";
				$resUpdateClient = mysql_query($updateClient);
				if($resUpdateClient)
				{
					$success = "Data Updated Successfully.";
				}
				else
				{
					$error = "There is ans error updating data. Please try again later.";
				}
			}
			else
			{
				$selectClient = "select * from tb_client where client_id='$client_id'";
				$resClient = mysql_query($selectClient);
				$rowClient = mysql_fetch_array($resClient);
				if(md5($currentpassword) == $rowClient['client_password'])
				{
					if($_POST['newpw'] != '')
					{
						$newpassword = md5($_POST['newpw']);
						$updateClient = "update tb_client set client_fullname='$fullname', client_email='$email', client_password='$newpassword' where client_id='$client_id'";
						$resUpdateClient = mysql_query($updateClient);
						if($resUpdateClient)
						{
							$success = "Data Updated Successfully.";
						}
						else
						{
							$error = "There is ans error updating data. Please try again later.";
						}
					}
					else
					{
						$updateClient = "update tb_client set client_fullname='$fullname', client_email='$email' where client_id='$client_id'";
						$resUpdateClient = mysql_query($updateClient);
						if($resUpdateClient)
						{
							$success = "Data Updated Successfully.";
						}
						else
						{
							$error = "There is ans error updating data. Please try again later.";
						}
					}
				}
				else
				{
					$error = "Please enter correct current password";
				}
			}
		}
		elseif(!empty($_POST['email-submit']))
		{
			$initialmail = $_POST['initialmail'];
			$followupmail = $_POST['followupmail'];
			$subsequentmail = $_POST['subsequentmail'];
			
			$query1 = "update tb_cemailwording set email_wording='$initialmail' where email_for='initial' and client_id='$client_id'";
			$resquery1 = mysql_query($query1);
				
			$query2 = "update tb_cemailwording set email_wording='$subsequentmail' where email_for='subsequent' and client_id='$client_id'";
			$resquery2 = mysql_query($query2);
				
			$query3 = "update tb_cemailwording set email_wording='$followupmail' where email_for='followup' and client_id='$client_id'";
			$resquery3 = mysql_query($query3);
			
			if($resquery3)
			{
				$success = "Data Updated Successfully.";
			}
			else
			{
				$error = "There is ans error updating data. Please try again later.";
			}
		}
		elseif(!empty($_POST['question-submit']))
		{
			for($i=1;$i<11;$i++)
			{
				$question_no = $i;
				if($question_no == 1)
				{
					$question_name = $_POST['question1_name'];
					$question = $_POST['question1'];
				}
				elseif($question_no == 2)
				{
					$question_name = $_POST['question2_name'];
					$question = $_POST['question2'];
				}
				elseif($question_no == 3)
				{
					$question_name = $_POST['question3_name'];
					$question = $_POST['question3'];
				}
				elseif($question_no == 4)
				{
					$question_name = $_POST['question4_name'];
					$question = $_POST['question4'];
				}
				elseif($question_no == 5)
				{
					$question_name = $_POST['question5_name'];
					$question = $_POST['question5'];
				}
				elseif($question_no == 6)
				{
					$question_name = $_POST['question6_name'];
					$question = $_POST['question6'];
				}
				elseif($question_no == 7)
				{
					$question_name = $_POST['question7_name'];
					$question = $_POST['question7'];
				}
				elseif($question_no == 8)
				{
					$question_name = $_POST['question8_name'];
					$question = $_POST['question8'];
				}
				elseif($question_no == 9)
				{
					$question_name = $_POST['question9_name'];
					$question = $_POST['question9'];
				}
				elseif($question_no == 10)
				{
					$question_name = $_POST['question10_name'];
					$question = $_POST['question10'];
				}
				
				$selectCquestion1 = "select * from tb_cquestion where client_id='$client_id' and question_no='$question_no'";
				$resSelectCquestion1 = mysql_query($selectCquestion1);
				if(mysql_num_rows($resSelectCquestion1)>0)
				{
					$query = "update tb_cquestion set question_name='$question_name', question='$question' where question_no='$question_no' and client_id='$client_id'";
					$result = mysql_query($query);
				}
				else
				{
					$query = "insert into tb_cquestion (client_id,question_no,question_name,question,insertdate) values ('$client_id','$question_no','$question_name','$question',NOW())";
					$result = mysql_query($query);
				}
				
				if($question_no==10)
				{
					if($result)
					{
						$success = "Data Updated Successfully.";
					}
					else
					{
						$error = "There is ans error updating data. Please try again later.";
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
    <div id="wrap">
		<div id="header-top">
		<!-- /// HEADER-TOP  //////////////////////////////////////////////////////////////// -->
			
		<!-- ///////////////////////////////////////////////////////////////// -->
		</div><!-- end #header-top -->
		<div id="header" style="top:30px;">
		<!-- /// HEADER  ////////////////////////////////////////////////////////////// -->
			<div class="row">
				<div class="span4">
					<!-- // Logo // -->
					<a href="index.php" id="logo">
						<img class="responsive-img" src="_layout/images/logo.png" alt="" style="width:100%">
					</a>
				</div><!-- end .span3 -->
				<div class="span8">
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
						<li><a href="pulses.php">Survey</a></li>
						<li><a href="report.php">Report</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div><!-- end .span9 -->
			</div><!-- end .row -->         
		<!-- /////////////////////////////////////////////////////////// -->
		</div><!-- end #header -->		
		<!--<div id="content" style="margin-top:150px;">-->
		<div id="content1">
			<!-- /// CONTENT  /////////////////////////////////////////////////////// -->
			<div class="row">
            	<div class="span12" style="border:1px solid;">
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
					<div class="vertical-tabs-container fixed">
						<ul class="tabs-menu fixed">
                            <li><a href="#content-tab-3-1">Company Settings</a></li>
                            <li><a href="#content-tab-3-2">User Settings</a></li>
                            <li><a href="#content-tab-3-3">E-mail Settings</a></li>
                            <li><a href="#content-tab-3-4">Questions</a></li>
                            <?php /*<li><a href="#content-tab-3-5">Brand Settings</a></li>*/?>
                        </ul><!-- end .tabs-menu -->
                        <div class="tabs">
                            <div class="tab-content" id="content-tab-3-1">
                            	<h4><strong>Company Settings</strong></h4>
								<div class="divider single-line"></div>
								<?php
								$selectClient = "select * from tb_client where client_id='$client_id'";
								$resClient = mysql_query($selectClient);
								$rowClient = mysql_fetch_array($resClient);
								
								$selectCompany = "select * from tb_company where client_id='$client_id'";
								$resCompany = mysql_query($selectCompany);
								$rowCompany = mysql_fetch_array($resCompany);
								?>
                                <form class="fixed" id="company-form" name="company-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div class="row">
										<div class="span8">
											<div class="span4">
												<label><strong>Company Name</strong></label>
												<input class="span4" type="text" id="cname" name="cname" value="<?php echo $rowClient['client_company'];?>" placeholder="Company Name" />
											</div>
											<div class="span4">
												<label><strong>Company Website</strong></label>
												<input class="span4" type="text" id="cwebsite" name="cwebsite" value="<?php echo $rowCompany['company_website'];?>" placeholder="Company Website" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="span8" style="margin-left:0px;">
											<div class="span4">
												<label><strong>Where is your business located?</strong></label>
												<select id="country" name="country" class="country" onchange="oncountrySelect('<?php echo $rowCompany['state'];?>');">
													<option value="United States" <?php if("United States" == $rowCompany['country']) echo 'selected';?>>United States</option>
													<option value="Canada" <?php if("Canada" == $rowCompany['country']) echo 'selected';?>>Canada</option>
												</select>
												<div id="countryResponse"></div>
											</div>
											<div class="span4">
												<label><strong>Which industry are you in?</strong></label>
												<select id="industry1" name="industry1" class="industry1" onchange="onindustrySelect('<?php echo $rowCompany['subindustry'];?>')">
													<option value="Advertising & Marketing" <?php if("Advertising & Marketing" == $rowCompany['industry']) echo 'selected';?>>Advertising & Marketing</option>
													<option value="Business Support Services Sector" <?php if("Business Support Services Sector" == $rowCompany['industry']) echo 'selected';?>>Business Support Services Sector</option>
												</select>
												<div id="industryResponse"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<label><strong>How big is your organization?</strong></label>
										<select name="size" id="size">
											<option value="1-5 Employees" <?php if("1-5 Employees" == $rowCompany['size']) echo 'selected';?>>1-5 Employees</option>
											<option value="6-10 Employees" <?php if("6-10 Employees" == $rowCompany['size']) echo 'selected';?>>6-10 Employees</option>
											<option value="11-25 Employees" <?php if("11-25 Employees" == $rowCompany['size']) echo 'selected';?>>11-25 Employees</option>
											<option value="26-50 Employees" <?php if("26-50 Employees" == $rowCompany['size']) echo 'selected';?>>26-50 Employees</option>
											<option value="51-100 Employees" <?php if("51-100 Employees" == $rowCompany['size']) echo 'selected';?>>51-100 Employees</option>
											<option value="101-250 Employees" <?php if("101-250 Employees" == $rowCompany['size']) echo 'selected';?>>101-250 Employees</option>
											<option value="251-500 Employees" <?php if("251-500 Employees" == $rowCompany['size']) echo 'selected';?>>251-500 Employees</option>
											<option value="500+ Employees" <?php if("500+ Employees" == $rowCompany['size']) echo 'selected';?>>500+ Employees</option>
										</select>
									</div>
									<div class="row">
										<label><strong>How often do you want customer feedback?</strong></label>
										<select name="feedback" id="feedback">
											<option value="Every Month" <?php if("Every Month" == $rowCompany['feedback_frequency']) echo 'selected';?>>Every Month</option>
											<option value="Every 2 Months" <?php if("Every 2 Months" == $rowCompany['feedback_frequency']) echo 'selected';?>>Every 2 Months</option>
											<option value="Every 3 Months" <?php if("Every 3 Months" == $rowCompany['feedback_frequency']) echo 'selected';?>>Every 3 Months</option>
											<option value="Every 6 Months" <?php if("Every 6 Months" == $rowCompany['feedback_frequency']) echo 'selected';?>>Every 6 Months</option>
											<option value="Once a Year" <?php if("Once a Year" == $rowCompany['feedback_frequency']) echo 'selected';?>>Once a Year</option>
										</select>
									</div>
									<input id="company-submit" name="company-submit" type="submit" class="btn" value="Save Settings" />
								</form>
                            </div><!-- end .tab-content -->
                            <div class="tab-content" id="content-tab-3-2">	
                                <h4 class="text-uppercase"><strong>User Settings</strong></h4>
								<div class="divider single-line"></div>
                                <form class="fixed" id="user-form" name="user-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div class="span8">
										<div class="span4">
											<label><strong>Full Name</strong></label>
											<input class="span4" type="text" id="fullname" name="fullname" value="<?php echo $rowClient['client_fullname'];?>" placeholder="Enter your full name" />
										</div>
										<div class="span4">
											<label><strong>Email</strong></label>
											<input class="span4" type="text" id="email" name="email" value="<?php echo $rowClient['client_email'];?>" placeholder="Enter your email" />
										</div>
									</div>
									<div class="span8" style="margin-left:0px;">
										<div class="span4">
											<label><strong>Change Password</strong></label>
											<input class="span4" type="password" id="currentpw" name="currentpw" value="" placeholder="Current password" />
										</div>
										<div class="span4">
											
										</div>
									</div>
									<div class="span8" style="margin-left:0px;">
										<div class="span4">
											<input class="span4" type="password" id="newpw" name="newpw" value="" placeholder="New password" />
										</div>
									</div>
									<input id="user-submit" name="user-submit" type="submit" class="btn" value="Save Settings" />
								</form>
                            </div><!-- end .tab-content -->
                            <div class="tab-content" id="content-tab-3-3">	
                                <h4 class="text-uppercase"><strong>Email Settings</strong></h4>
								<div class="divider single-line"></div>
								<form class="fixed" id="email-form" name="email-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div>
										<label><strong>Send Email as</strong>
										<?php echo $rowClient['client_fullname'];?>
										</label>
									</div>
									<div>
										<?php 
										$selectEmail = "select * from tb_emailwording where client_id='$client_id'";
										$resEmail = mysql_query($selectEmail);
										while($rowEmail=mysql_fetch_array($resEmail))
										{
											if($rowEmail['email_for'] == 'initial')
											{
											?>
												<label><strong>Initial Mail Wording</strong></label>
												<textarea name="initialmail" id="initialmail"><?php echo $rowEmail['email_wording'];?></textarea>
											<?php
											}
											elseif($rowEmail['email_for'] == 'followup')
											{
											?>
												<label><strong>Followup Mail Wording</strong></label>
												<textarea name="followupmail" id="followupmail"><?php echo $rowEmail['email_wording'];?></textarea>
											<?php
											}
											elseif($rowEmail['email_for'] == 'subsequent')
											{
											?>
												<label><strong>Subsequent Mail Wording</strong></label>
												<textarea name="subsequentmail" id="subsequentmail"><?php echo $rowEmail['email_wording'];?></textarea>
											<?php
											}
										}
										?>
										<input id="email-submit" name="email-submit" type="submit" class="btn" value="Save Settings" />
									</div>
								</form>
                            </div><!-- end .tab-content -->
                            <div class="tab-content" id="content-tab-3-4">	
                                <h4 class="text-uppercase"><strong>Questions</strong></h4>
								<div class="divider single-line"></div>
								<form class="fixed" id="question-form" name="question-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div>
										<?php 
										$selectCquestion = "select * from tb_cquestion where client_id='$client_id' order by question_no";
										$resCquestion = mysql_query($selectCquestion);
										$questionCount = 0;
										while($rowCquestion=mysql_fetch_array($resCquestion))
										{
											$questionCount = $questionCount + 1;
											$questionnameid = "question".$rowCquestion['question_no']."_name";
											$questionid = "question".$rowCquestion['question_no'];
										?>
											<label><strong>Question <?php echo $rowCquestion['question_no'];?></strong></label>
											<input name="<?php echo $questionnameid;?>" id="<?php echo $questionnameid;?>" value="<?php echo $rowCquestion['question_name'];?>"/>
											<textarea name="<?php echo $questionid;?>" id="<?php echo $questionid;?>"><?php echo $rowCquestion['question'];?></textarea>
										<?php
										}										
										for($i=$questionCount+1;$i<=10;$i++)
										{
											$questionnameid = "question".$i."_name";
											$questionid = "question".$i;
										?>
											<label><strong>Question <?php echo $i;?></strong></label>
											<input name="<?php echo $questionnameid;?>" id="<?php echo $questionnameid;?>" value=""/>
											<textarea name="<?php echo $questionid;?>" id="<?php echo $questionid;?>"></textarea>
										<?php
										}
										?>
										<input id="question-submit" name="question-submit" type="submit" class="btn" value="Save Settings" />
									</div>
								</form>
                            </div><!-- end .tab-content -->
						</div><!-- end .tabs -->  
					
					</div><!-- end .vertical-tabs-container -->
                    
                </div><!-- end .span9 -->
            </div><!-- end .row -->
			<!-- /////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
        
		<div id="footer-bottom">
			<!-- /// FOOTER-BOTTOM     ///////////////////////////////////////////////// -->	
			<div class="row">
				<div class="span6" id="footer-bottom-widget-area-1">
					<div class="widget widget_text">
						<div class="textwidget">
							<!--<p class="last">Integrity &copy; 2014 All rights reserved</p>-->
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
		<!-- ////////////////////////////////////////////////////////////////////////////// -->    
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
			The customer will not receive any more Survey.
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
			The customer will receive Survey again.
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
	
		$(document).ready(function(){
			oncountrySelect('<?php echo $rowCompany['state'];?>');
			onindustrySelect('<?php echo $rowCompany['subindustry'];?>');
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