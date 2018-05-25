<?php
	include_once "db_connect.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	$customers_added = 0;
	
	$selectCustomer = "select * from tb_customer where client_id='$client_id' ORDER BY customer_insertdate DESC";
	$resSelectCustomer = mysql_query($selectCustomer);
	
	if(mysql_num_rows($resSelectCustomer)>0)
	{
		$customers_added = 1;
	}
	
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
				$selectCusInfo = "select * from tb_customer where client_id='$client_id' and customer_email='$customer_email' ORDER BY customer_insertdate DESC";
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
					
					$query = "insert into tb_customer (client_id,customer_firstname,customer_lastname,customer_email,customer_status,customer_company,customer_group,customer_insertdate,customer_isActive) values ('$client_id','$customer_firstname','$customer_lastname','$customer_email','$customer_status','$customer_company','$customer_group',NOW(),'$customer_isActive')";
					$result = mysql_query($query);
					
					if($result)
					{
						header("location:sendsurvey.php");
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
    
	<title>Customers</title>
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
        <!-- /// HEADER-TOP  //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            
            
        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        </div><!-- end #header-top -->
        <div id="header" style="top:30px;">
        <!-- /// HEADER ////////////////////////////////////////////////////// -->
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
					<?php /*<ul class="sf-menu fixed" id="menu">
						<li>
                        	<a href="logout.php">Results</a>                              
                        </li>
						<li>
                        	<a href="logout.php">Customers</a>                              
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
					</ul>*/ ?>
				</div><!-- end .span9 -->
			</div><!-- end .row -->            
        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #header -->		
		<div id="content" style="margin-top:150px;">
		<!-- /// CONTENT  //////////////////////////////////////////////////////////////////////////////////////////////// -->
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
                            <?php
							$selectCompany = "select * from tb_company where client_id='$client_id'";
							$resSelectCompany = mysql_query($selectCompany);
							if(mysql_num_rows($resSelectCompany)>0)
							{
							?>
								<a href="prepare.php">SETUP YOUR COMPANY</a>
							<?php
							}
							else
							{
							?>
								<a href="" style="opacity:0.5; cursor:default;">SETUP YOUR COMPANY</a>
							<?php
							}
							?>
                            </li>
                            <li id="tab-2">
                                <?php
								$selectCquestion = "select * from tb_cquestion where client_id='$client_id'";
								$resSelectCquestion = mysql_query($selectCquestion);
								if(mysql_num_rows($resSelectCquestion)>0)
								{
								?>
									<a href="select-question.php">CREATE YOUR SURVEY</a>
								<?php
								}
								else
								{
								?>
									<a href="" style="opacity:0.5; cursor:default;">CREATE YOUR SURVEY</a>
								<?php
								}
								?>
							</li>
                            <li id="tab-3" class="active">
                                <a href="firstcustomer.php">ADD YOUR CUSTOMERS</a>
							</li>
                            <li id="tab-4">
                                <?php
								if($customers_added==1)
								{
								?>
									<a href="#content-tab-1-4">PREVIEW SURVEY</a>
								<?php
								}
								else
								{
								?>
									<a href="" style="opacity:0.5; cursor:default;">PREVIEW SURVEY</a>
								<?php
								}
								?>
                            </li>
                        </ul><!-- end .tabs-menu -->
                        <div class="tabs">
                            <div class="tab-content">
                            	<h3 align="center">
                                	<strong>Add Your Customers</strong> <br>
									<?php
									if($customers_added==0)
									{
									?>
										Add your first customer.
									<?php
									}
									?>
                                </h3>
								<div class="span7">
									<a href="#" class="btn" data-reveal-id="myModal" style="float:right;">Add Single Customer</a>
									<!--<a href="#" class="btn" data-reveal-id="multipleCustomer" style="float:right;">Import Customers</a>-->
								</div><br/>
								
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
												<td><?php if($rowSelectCustomer['customer_status']==1) echo 'Active'; else echo 'Disabled'; ?> </td>
												<td><a href="">-</a></td>
												<td><a href="">Update</a></td>
												<td><?php echo $rowSelectCustomer['customer_company']; ?></td>
												<td><?php if('' == $rowSelectCustomer['customer_group']) echo '-'; else echo $rowSelectCustomer['customer_group']; ?></td>
												<td><?php if('' == $rowSelectCustomer['customer_lastresponded']) echo '-'; else echo $rowSelectCustomer['customer_lastresponded']; ?></td>
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
                        </div><!-- end .tabs -->  
                    
                    </div><!-- end .tab-container -->
                    
                </div><!-- end .span12 -->
            </div><!-- end .row -->
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
        <div id="footer-bottom">
        <!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////////////////////////////////// -->	
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
		<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->    
		</div><!-- end #footer-bottom -->
	</div><!-- end #wrap -->
    
    <a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>
	
	<div id="myModal" class="reveal-modal" style="/*width:525px;*/" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Add Customer</strong> <br>
		</h5>
		<div class="row">
			<form class="fixed" id="customer-form" name="customer-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
				<div class="row">
					<div class="span3">
						<label>First Name</label>
						<input type="text" name="first_name" value="">
					</div>
					<div class="span3">
						<label>Last Name</label>
						<input type="text" name="last_name" value="">
					</div>
				</div>
				<div class="row">
					<div class="span3">
						<label>Company</label>
						<input type="text" name="company" value="">
					</div>
					<div class="span3">
						<label>Group</label>
						<input type="text" name="group" value="">
					</div>
				</div>
				<div class="row">
					<div class="span6">
						<label>Email</label>
						<input type="text" name="email" value="">
					</div>
				</div>
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
	<?php
	/*for($i=0;$i<4;$i++)
	{
	?>
		<div id="<?php echo 'question'.$i;?>" class="reveal-modal" style="width:525px;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	
		</div>
	<?php
	}*/
	?>
	
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