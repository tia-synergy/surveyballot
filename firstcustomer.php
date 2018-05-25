<?php
	include_once "db_connect.php";
	
	session_start();
	$client_id = $_SESSION['clientid'];
	
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	/*else
	{
		$selectClient = "select * from tb_customer where client_id=".$client_id;
		$resSelectClient = mysql_query($selectClient);
		$recSelectClient = mysql_num_rows($resSelectClient);
		if($recSelectClient != 0)
		{
			
			header("location:customers.php");
		}
	}*/
	
	
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
				$selectCusInfo2 = "select * from tb_customer where client_id='$client_id'";
				$resSelectCusInfo2 = mysql_query($selectCusInfo2);
				
				
				$selectClient2 = "select * from tb_client where client_id='$client_id'";
				$resSelectClient2 = mysql_query($selectClient2);
				$recSelectClient2 = mysql_fetch_array($resSelectClient2);
				
				//echo mysql_num_rows($resSelectCusInfo2);
				if(mysql_num_rows($resSelectCusInfo)>0)
				{
					$error = 'You have already entered this customer.';
				}
				elseif(mysql_num_rows($resSelectCusInfo2) >= 10 && $recSelectClient2["client_type"] == 2)
				{
					$error = "You have reached your maximum limit. </br> You can add only 10 customer for trial version.";
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
						header("Location: firstcustomer.php");
						exit();
					}
				}
			}
		}
		if(isset($_POST["Import"])){
		
		$filename=$_FILES["file"]["tmp_name"];	
		if($_FILES["file"]["type"] == 'application/vnd.ms-excel')
		{
			
		
		$csv = array();
 
		if($_FILES["file"]["size"] > 0)
		{
			$customer_status = 1;
			$customer_isActive = 1;
		  	$file = fopen($filename, "r");
			$r=1;
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
				$csv[] = $getData;
				$r++;
			 }
			 
			 for($p=1; $p<=($r-2); $p++)
			 {
				 $countField = count($csv[0]);
					
					if($countField == 5 && $csv[0][0] == 'Firstname' && $csv[0][1] == 'Lastname' && $csv[0][2] == 'Email' && $csv[0][3] == 'Company' && $csv[0][4] == 'Group')
					{
					$customer_email = $csv[$p][2];
					
					$customer_email = stripslashes($customer_email);
					$customer_email = mysql_real_escape_string($customer_email);
					if(!filter_var($customer_email, FILTER_VALIDATE_EMAIL))
					{
						$error = "Please enter a valid email address of customers.";
					}
					
					else
					{
						$selectCusInfo = "select * from tb_customer where client_id='$client_id' and customer_email='$customer_email'";
						$resSelectCusInfo = mysql_query($selectCusInfo);
						
						$selectCusInfo3 = "select * from tb_customer where client_id='$client_id'";
						$resSelectCusInfo3 = mysql_query($selectCusInfo3);
						
						$selectClient3 = "select * from tb_client where client_id='$client_id'";
						$resSelectClient3 = mysql_query($selectClient3);
						$recSelectClient3 = mysql_fetch_array($resSelectClient3);
				
						//echo mysql_num_rows($resSelectCusInfo3); 
						if(mysql_num_rows($resSelectCusInfo)>0)
						{
							$error = 'You have already entered this customers with same email address.';
						}
						elseif(mysql_num_rows($resSelectCusInfo3) >= 10 && $recSelectClient3["client_type"] == 2)
						{
							$error = "You have reached your maximum limit. </br> You can add only 10 customer for trial version.";
						}
						else
						{
							$sql = "insert into tb_customer (client_id,customer_firstname,customer_lastname,customer_email,customer_status,customer_company,customer_group,customer_insertdate,customer_isActive) 
									values 
									('$client_id','".$csv[$p][0]."','".$csv[$p][1]."','".$csv[$p][2]."','$customer_status','".$csv[$p][3]."','".$csv[$p][4]."',NOW(),'$customer_isActive')";
                 
							$result = mysql_query($sql);
				 
							if(!isset($result))
							{
								echo "<script type=\"text/javascript\">
									alert(\"Invalid File:Please Upload CSV File.\");
									window.location = \"firstcustomer.php\"
									</script>";		
							}
							else {
								echo "<script type=\"text/javascript\">
									alert(\"CSV File has been successfully Imported.\");
									window.location = \"firstcustomer.php\"
									</script>";
							}
						}
					}
					}
					
					else
					{
						$error = "<p>Please follow the format -<br>=>FirstName<br>=>LastName<br>=>Email<br>=>Company<br>=>Group</p>";
					}
			 }
			
	         fclose($file);	
		}
		}
		
		else
		{
			echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"firstcustomer.php\"
						  </script>";
		}
		
		}
		if(isset($_POST["Export"])){
		 
			$result = mysql_query("SELECT * FROM tb_customer where client_id=".$client_id);
			 
			csvToExcelDownloadFromResult($result);
		}
		if(!empty($_POST['preview']))
		{
			if(!empty($_POST['cust']))
			{
				$_SESSION["cust_ids"] = $_POST['cust'];
				
				header("Location: sendsurvey.php");
			}
			else
			{
				$error = "Please select customer";
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
		<?php include "header.php"; ?>		
		<div id="content" style="margin-top:0px;">
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
				<div class="span12" style="margin-left:0px;">
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
							<div style="float:left;width:465px;">
                            	<h3 align="">
                                	<strong>Add Your Customers</strong> <br>
								</h3>
									<?php
									if($customers_added==0)
									{
									?>
										Add your first customer.
									<?php
									}
									?>
                                
							</div>
								<div class="" style="float:left;">
									<a href="#"  class="btn" data-reveal-id="myModal" >Add Customer</a>
									<a href="#"  class="btn" data-reveal-id="multipleCustomer" >Import Customers</a>
									 
								</div>
								<div style="float:left;">
									<form class="form-horizontal" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="upload_excel" enctype="multipart/form-data">
									<!--<a href="#" class="btn" data-reveal-id="exportCustomer" >Export Customers</a>-->
									<button  type="submit" id="submit" name="Export" class="btn " data-loading-text="Loading...">Export Customers</button>
									</form>
								</div>
								<div style="clear:both;"></div>
								<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
								<div class="box-body">
									<?php
									if(mysql_num_rows($resSelectCustomer)>0)
									{
									?>
									<div>
										<input type="submit" id="preview" name="preview" class="btn " style="float:right;background-color:green;"  value="Preview Your Survey ->" />
										<!--<a href="sendsurvey.php"  class="btn" style="float:right;background-color:green;" >Preview Your Heartbeat -></a>-->
									</div>
									
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th><input type="checkbox" name="custall"  id="custall" value=""  style="-webkit-appearance:checkbox;float:left;"></th>
												<th>Name</th>
												<th>Status</th>
												
												<th>Company</th>
												<th>Group</th>
												<th>Total Survey Sent</th>
												<th>Last Responded</th>
											</tr>
										</thead>
										<tbody>
											<?php
											while($rowSelectCustomer = mysql_fetch_array($resSelectCustomer))
											{
												$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='".$rowSelectCustomer['id']."' order by id desc limit 1";
												$resHeartbeat = mysql_query($selectHeartbeat);
												$rowHeartbeat = mysql_fetch_array($resHeartbeat);
											?>
											<tr>
											<?php
												if($rowSelectCustomer["customer_isActive"] == 1)
												{
											?>
												<td><input type="checkbox" name="cust[]" value="<?php echo $rowSelectCustomer['id']; ?>"  style="-webkit-appearance:checkbox;float:left;"></td>
												<?php
												}
												else
												{
													?>
													<td></td>
													<?php
												}
											?>
												<td><?php echo ucfirst($rowSelectCustomer['customer_firstname']).' '.ucfirst($rowSelectCustomer['customer_lastname']);?></td>
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
												
												<td><?php echo $rowSelectCustomer['customer_company']; ?></td>
												<td><?php if('' == $rowSelectCustomer['customer_group']) echo '-'; else echo $rowSelectCustomer['customer_group']; ?></td>
												<?php
													$cus_id = $rowSelectCustomer['id'];
													$selectTotal = "select count(customer_id) as Total from tb_customerheartbeat where customer_id= ".$cus_id;
													$resSelectTotal = mysql_query($selectTotal);
													$recSelectTotal = mysql_fetch_array($resSelectTotal);
												?>
												<td><?php echo $recSelectTotal['Total']; ?></td>
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
							</form>
                            </div><!-- end .tab-content -->
                        </div><!-- end .tabs -->  
                    
                    </div><!-- end .tab-container -->
                    
                </div><!-- end .span12 -->
            </div><!-- end .row -->
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
        
        <!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////////////////////////////////// -->	
			<?php include "footer.php"; ?>
		<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->    
		
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
						<label>Group Name</label>
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
			<table>
				<tr>
					<td>Firstname</td>
					<td>Lastname</td>
					<td>Email</td>
					<td>Company</td>
					<td>Group</td>
				</tr>
			</table>
			
                <form class="form-horizontal" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="upload_excel" enctype="multipart/form-data">
                    
                        <div class="">
                            <label class="" for="">Select File</label>
                            <div class="">
                                <input type="file" name="file" id="file" class="">
                            </div>
                        </div>
						<div class="">
                                <button type="submit" id="submit" name="Import" class="btn " data-loading-text="Loading...">Import</button>
                        </div>
                </form
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
		$('#custall').click(function(event) 
		{
		if(this.checked) 
		{
				// Iterate each checkbox
				$(':checkbox').each(function() {
				this.checked = true;
		});
		}
		else 
		{
			$(':checkbox').each(function() {
			this.checked = false;
		});
		}
		});
	</script>
    

</body>
</html>

<?php

function csvToExcelDownloadFromResult($result, $showColumnHeaders = true, $asFilename = 'allcustomers.csv') {
			
			setDownloadAsHeader($asFilename);
			return csvFileFromResult('php://output', $result, $showColumnHeaders);
		}
		function csvFileFromResult($filename, $result, $showColumnHeaders = true) {
			$fp = fopen($filename, 'w');
			$rc = csvFromResult($fp, $result, $showColumnHeaders);
			fclose($fp);
			return $rc;
		}
		function csvFromResult($stream, $result, $showColumnHeaders = true) {
			if($showColumnHeaders) {
			$columnHeaders = array();
			$nfields = mysql_num_fields($result);
			for($i = 0; $i < $nfields; $i++) {
				$field = mysql_fetch_field($result, $i);
				$columnHeaders[] = $field->name;
			}
			fputcsv($stream, $columnHeaders);
			}
	
			$nrows = 0;
			while($row = mysql_fetch_row($result)) {
				fputcsv($stream, $row);
				$nrows++;
			}
			
			exit;
			return $nrows;
		}
		

		function setDownloadAsHeader($filename) {
			if(headers_sent())
			return false;

			header('Content-disposition: attachment; filename=' . $filename);
			return true;
		}

?>