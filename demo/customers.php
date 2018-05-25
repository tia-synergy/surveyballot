<?php
	include_once "db_connect.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	$status = $_GET['status'];
	$recommend = $_GET['recommend'];
	$flag = $_GET['flag'];
	
	$selectActiveCustomer = "select * from tb_customer where client_id='$client_id' and customer_isActive='1'";
	$resSelectActiveCustomer = mysql_query($selectActiveCustomer);
	$totalActiveCustomers = mysql_num_rows($resSelectActiveCustomer);
	
	$selectInActiveCustomer = "select * from tb_customer where client_id='$client_id' and customer_isActive='2'";
	$resSelectInActiveCustomer = mysql_query($selectInActiveCustomer);
	$totalInActiveCustomers = mysql_num_rows($resSelectInActiveCustomer);
	
	$selectCustomer = "select * from tb_customer where client_id='$client_id'";
	$resSelectCustomer = mysql_query($selectCustomer);
	$totalCustomers = mysql_num_rows($resSelectCustomer);
	
	if($status == 1)
	{
		$resCustomer = mysql_query($selectActiveCustomer);
	}
	elseif($status == 2)
	{
		$resCustomer = mysql_query($selectInActiveCustomer);
	}
	else
	{
		$resCustomer = mysql_query($selectCustomer);
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
				$selectCusInfo = "select * from tb_customer where client_id='$client_id' and customer_email='$customer_email'";
				$resSelectCusInfo = mysql_query($selectCusInfo);
				if(mysql_num_rows($resSelectCusInfo)>0)
				{
					$error = 'You have already entered this customer with same email address.';
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
					$customer_heartbeatcount = 0;
					
					$query = "insert into tb_customer (client_id,customer_firstname,customer_lastname,customer_email,customer_status,customer_company,customer_group,customer_insertdate,customer_isActive,customer_heartbeatcount) values ('$client_id','$customer_firstname','$customer_lastname','$customer_email','$customer_status','$customer_company','$customer_group',NOW(),'$customer_isActive','$customer_heartbeatcount')";
					$result = mysql_query($query);
					
					$selectCusid = "select id from tb_customer where client_id='$client_id' and customer_email='$customer_email'";
					$resCusid = mysql_query($selectCusid);
					$rowCusid = mysql_fetch_array($resCusid);
					$currentCustId = $rowCusid['id'];
					
					$queryCustomerHis = "insert into tb_customerhistory (client_id,customer_id,operation,opdate) values ('$client_id','$currentCustId','added',NOW())";
					$resCustomerHis = mysql_query($queryCustomerHis);
					if($result)
					{
						header("location:customers.php");
						exit();
					}
				}
			}
		}
		elseif(!empty($_POST['multiple-submit']))
		{
			if ($_FILES[csv][size] > 0) 
			{
				//get the csv file
				$file = $_FILES[csv][tmp_name];
				$handle = fopen($file,"r");
	
				//loop through the csv file and insert into database
				while ($data = fgetcsv($handle,1000,",","'"))
				{
					// if ($data[0]) {
						// mysql_query("INSERT INTO contacts (contact_first, contact_last, contact_email) VALUES
							// (
								// '".addslashes($data[0])."',
								// '".addslashes($data[1])."',
								// '".addslashes($data[2])."'
							// )
						// ");
					// }
					
					$customer_email = addslashes($data[2]);
					$customer_email = stripslashes($customer_email);
					$customer_email = mysql_real_escape_string($customer_email);
					if(!filter_var($customer_email, FILTER_VALIDATE_EMAIL))
					{
						// $error = "Please enter a valid email address of customer.";
					}
					else
					{
						$selectCusInfo = "select * from tb_customer where client_id='$client_id' and customer_email='$customer_email'";
						$resSelectCusInfo = mysql_query($selectCusInfo);
						if(mysql_num_rows($resSelectCusInfo)==0)
						{
							$customer_firstname = addslashes($data[0]);
							$customer_lastname = addslashes($data[1]);
							$customer_email = addslashes($data[2]);
							$customer_status = 1;
							$customer_isActive = 1;
							$customer_company = addslashes($data[3]);
							$customer_group = addslashes($data[4]);
							$customer_heartbeatcount = 0;
							
							$query = "insert into tb_customer (client_id,customer_firstname,customer_lastname,customer_email,customer_status,customer_company,customer_group,customer_insertdate,customer_isActive,customer_heartbeatcount) values ('$client_id','$customer_firstname','$customer_lastname','$customer_email','$customer_status','$customer_company','$customer_group',NOW(),'$customer_isActive','$customer_heartbeatcount')";
							$result = mysql_query($query);
							
							$selectCusid = "select id from tb_customer where client_id='$client_id' and customer_email='$customer_email'";
							$resCusid = mysql_query($selectCusid);
							$rowCusid = mysql_fetch_array($resCusid);
							$currentCustId = $rowCusid['id'];
							
							$queryCustomerHis = "insert into tb_customerhistory (client_id,customer_id,operation,opdate) values ('$client_id','$currentCustId','added',NOW())";
							$resCustomerHis = mysql_query($queryCustomerHis);
							if($result)
							{
								
							}
						}
					}
				} 
			
				header("location:customers.php");
				exit();
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
    	
	<!--[if lte IE 8]>
         <div class="modern-browser-required">
        	You are using an <strong>outdated</strong> browser. Please 
        	<a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">upgrade your browser</a> 
            to improve your experience.
		</div>
    <![endif]-->
	<div id="wrap">
		<div id="header-top">
			
		<!-- /// HEADER-TOP  //////////////////////////////////////////////////////////////////////// -->
			
			
			
		<!-- ////////////////////////////////////////////////////////////////////////////////////////////// -->
		
		</div><!-- end #header-top -->
		<div id="header" style="top:30px;">
		<!-- /// HEADER  ///////////////////////////////////////////////////////// -->
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
						<li class="current"><a href="customers.php">Customers</a></li>
						<li><a href="pulses.php">Survey</a></li>
						<li><a href="report.php">Report</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div><!-- end .span9 -->
			</div><!-- end .row -->         
		<!-- /////////////////////////////////////////////// -->
		</div><!-- end #header -->		
		<!--<div id="content" style="margin-top:150px;">-->
		<div id="content">
			<!-- /// CONTENT  ////////////////////////////////////////////////////////////// -->
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
						<div>
							<div class="span6">
								<h3 style="margin-bottom:-5px;">
								<?php 
								if($status==1)
								{
								?>
									<strong>Active Customers</strong>
								<?php
								}
								elseif($status==2)
								{
								?>
									<strong>InActive Customers</strong>
								<?php
								}
								else
								{
								?>
									<strong>All Customers</strong>
								<?php
								}
								?>
								</h3>
								<h6 style="margin-bottom:10px;">
									<a href="customers.php?status=1">Active Customers(<?php echo $totalActiveCustomers;?>)</a> /
									<a href="customers.php?status=2">InActive Customers(<?php echo $totalInActiveCustomers;?>)</a> /
									<a href="customers.php">All Customers(<?php echo $totalCustomers;?>)</a>
								</h6>
							</div>
							<div class="span6">
								<span style="float:right; margin-right:10px;">
									<a href="commentall.php">View All Comments</a> | 
									<a href="testimonialall.php">View All Feedback</a>
								</span>
								<span style="float:right;">
									<a href="#" class="btn" data-reveal-id="myModal">Add Single Customer</a>
									<a href="#" class="btn" data-reveal-id="multipleCustomer">Import Customers</a>
								</span>
							</div>
						</div>
						<div class="box-body">
							<?php
							if(mysql_num_rows($resCustomer)>0)
							{
							?>
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Status</th>
										<th>Overall</th>
										<th>Company</th>
										<th>Group</th>
									</tr>
								</thead>
								<tbody>
									<?php
									while($rowCustomer = mysql_fetch_array($resCustomer))
									{
										$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='".$rowCustomer['id']."' order by heartbeat_id desc limit 1";
										// echo "query: ".$selectHeartbeat;
										$resHeartbeat = mysql_query($selectHeartbeat);
										$rowHeartbeat = mysql_fetch_array($resHeartbeat);
										// echo "aa================ ".mysql_num_rows($resHeartbeat);
										if($flag == 'lowrate')
										{
											
										}
										
										if($recommend == '' or $rowHeartbeat['recommend_response']==$recommend)
										{
										?>
											<tr>
												<td><a href="customer-detail.php?id=<?php echo $rowCustomer['id'];?>"><?php echo $rowCustomer['customer_firstname'].' '.$rowCustomer['customer_lastname'];?></a></td>
												<td>
												<?php
													if(mysql_num_rows($resHeartbeat) == 0) 
														echo 'No Survey Sent';
													
													if($rowHeartbeat['status'] == 'heartbeatsent' || $rowHeartbeat['status'] == 'emailopened')
													{
														echo 'Waiting for response';
													}
													elseif($rowHeartbeat['status'] == 'responsereceived')
													{
														echo 'Response Received';
													}
												?> 
												</td>
												<?php
												if($rowHeartbeat['status'] == 'responsereceived')
												{
												?>
													<td><?php echo $rowHeartbeat['overall_response'];?></td>
												<?php
												}
												else
												{
												?>
													<td>-</td>
												<?php
												}
												?>
												<td><?php echo $rowCustomer['customer_company']; ?></td>
												<td><?php if($rowCustomer['customer_group'] == '') echo '-'; else echo $rowCustomer['customer_group']; ?></td>
											</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
							<?php 
							}
							else
							{
								echo "No Customers Found.";
							}
							?>
						</div>
                    </div><!-- end .tabs -->  
                </div><!-- end .span12 -->
            </div><!-- end .row -->
		<!-- ///////////////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
		<div id="footer-bottom">
			<!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////////////////////////////////////////////////////// -->	
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
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->    
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
			<form class="fixed" id="multiple-form" name="multiple-form" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
				Choose your file: <br />
				<input name="csv" type="file" id="csv" />
				<input id="multiple-submit" name="multiple-submit" type="submit" class="btn" value="Add Customers" />
			</form> 
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