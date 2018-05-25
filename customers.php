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
	
	// pagination
							$perpage = 10;
							if(isset($_GET["page"]))
							{
								$page = intval($_GET["page"]);
							}
							else 
							{
								$page = 1;
							}
							$calc = $perpage * $page;
							$start = $calc - $perpage;
							
							
	
	$selectActiveCustomer = "select * from tb_customer where client_id='$client_id' and customer_isActive='1' ORDER BY customer_insertdate DESC ";
	$resSelectActiveCustomer = mysql_query($selectActiveCustomer);
	$totalActiveCustomers = mysql_num_rows($resSelectActiveCustomer);
	
	$selectInActiveCustomer = "select * from tb_customer where client_id='$client_id' and customer_isActive='2' ORDER BY customer_insertdate DESC ";
	$resSelectInActiveCustomer = mysql_query($selectInActiveCustomer);
	$totalInActiveCustomers = mysql_num_rows($resSelectInActiveCustomer);
			
							
	
	$selectCustomer = "select * from tb_customer where client_id='$client_id' ORDER BY customer_insertdate DESC Limit $start, $perpage";
	$resSelectCustomer = mysql_query($selectCustomer);
	
	$selectCustomer1 = "select * from tb_customer where client_id='$client_id' ORDER BY customer_insertdate DESC ";
	$resSelectCustomer1 = mysql_query($selectCustomer1);
	$totalCustomers = mysql_num_rows($resSelectCustomer1);
	
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
	if(isset($_GET["status_id"]) && isset($_GET["cust_id"]))
	{
		if($_GET["status_id"] == 1)
		{
			$update = "update tb_customer set customer_isActive=2 where id=".$_GET["cust_id"];
			$result = mysql_query($update);
		}
		else
		{
			$update = "update tb_customer set customer_isActive=1 where id=".$_GET["cust_id"];
			$result = mysql_query($update);
		}
		header("Location: customers.php");
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
				
				$selectCusInfo2 = "select * from tb_customer where client_id='$client_id'";
				$resSelectCusInfo2 = mysql_query($selectCusInfo2);
				
				$selectClient2 = "select * from tb_client where client_id='$client_id'";
				$resSelectClient2 = mysql_query($selectClient2);
				$recSelectClient2 = mysql_fetch_array($resSelectClient2);
				
				if(mysql_num_rows($resSelectCusInfo)>0 )
				{
					$error = 'You have already entered this customer with same email address.';
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
				//exit();
			}
		}
			elseif(isset($_REQUEST['survey-submit']))
			{
			echo $selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
			exit();
			$resHeartbeat = mysql_query($selectHeartbeat);
			if(mysql_num_rows($resHeartbeat) == 0)
			{
				$selectEmail = "select * from tb_emailwording where email_for='initial' and client_id='$client_id'";
			}
			else
			{
				$selectEmail = "select * from tb_emailwording where email_for='subsequent' and client_id='$client_id'";
			}
			$resEmail = mysql_query($selectEmail);
			$rowEmail = mysql_fetch_array($resEmail);
			
			$token = sha1(uniqid($rowCustDetail['customer_firstname'], true));
			
			$selectClient = "select * from tb_client where client_id='$client_id'";
			$resClient = mysql_query($selectClient);
			$rowClient = mysql_fetch_array($resClient);
			
			$updateCustomer = "update tb_customer set customer_heartbeatcount=customer_heartbeatcount+1 where id='$customer_id'";
			$resUpdateCustomer = mysql_query($updateCustomer);
			// echo 'updateCustomer: '.mysql_error();
			
			$selectTotalHeartbeat = "select max(id) as maxId from tb_heartbeat where client_id='$client_id'";
			$resTotalHeartbeat = mysql_query($selectTotalHeartbeat);
			$rowTotalHeartbeat = mysql_fetch_array($resTotalHeartbeat);
			$heartbeat_id = $rowTotalHeartbeat['maxId'];
			
			$insertHeartbeat = "insert into tb_customerheartbeat (client_id,heartbeat_id,customer_id,email_token,status,send_date) values ('$client_id','$heartbeat_id','$customer_id','$token','heartbeatsent',NOW())";
			$resInsertHeartbeat = mysql_query($insertHeartbeat);
			// echo 'insertHeartbeat: '.mysql_error();
			
			$insertHistory = "insert into tb_customerhistory (client_id,customer_id,operation,opdate) values ('$client_id','$customer_id','heartbeatsent',NOW())";
			$resHistory = mysql_query($insertHistory);
			// echo 'insertHistory: '.mysql_error();
			
			//require_once "Mail.php";  
			// $from = $client_email; 
			$to = $rowCustDetail['customer_email']; 
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// $headers .= "From: vaibhavi@synergyit.ca" . "\r\n";
			$headers .= "From: ".$client_email . "\r\n";
			// $to = "vickyshah.cer@gmail.com";
			$subject = "Request from ".$rowClient['client_company']; 
			$body = "Hi ".$rowCustDetail['customer_firstname'].",<br/><br/>".$rowEmail['email_wording']."<br/><br/><a href=". $_SERVER['SERVER_NAME']."/response.php?token=".$token.">Submit your survey</a><br/><br/>Kind Regards, <br/>".$rowClient['client_fullname']."<br/>".$rowClient['client_company'];  
			
			mail($to,$subject,$body,$headers);
			
			
			}
			
	//survey end
		
		elseif(!empty($_POST['cust-submit']))
			{
				if(!empty($_POST['cust']))
				{
					$_SESSION["data"] = $_POST['cust'];
					header("Location: createQuestions.php?title=customer");
				}
				else
				{
					$error = "Please select customer";
				}
			}
			
			
		elseif(isset($_GET["search_id"]))
		{
			
			$search = $_POST[ 'search' ]; 
		
			if( strlen( $search ) <= 1 ) 
				$error = "Search term too short"; 
			else 
			{ 
				
			 
				$search_exploded = explode ( " ", $search ); 
				$x = 0; 
				foreach( $search_exploded as $search_each ) 
				{ 
					$x++; 
					$construct = ""; 
					if( $x == 1 ) 
						$construct .="customer_firstname LIKE '%$search_each%' || customer_lastname LIKE '%$search_each%'"; 
					else 
						$construct .="AND customer_firstname LIKE '%$search_each%' || customer_lastname '%$search_each%'"; 
				} 
				
				
				$selectCustomer = " SELECT * FROM tb_customer WHERE $construct "; 
				$resCustomer = mysql_query( $selectCustomer ); 
				$foundnum = mysql_num_rows($resCustomer); 
				if ($foundnum == 0) 
					$error = "Sorry, there are no matching result for <b> $search </b>. </br> </br> 1. Try more general words. for example: If you want to search 'how to create a website' then use general keyword like 'create' 'website' </br> 2. Try different words with similar meaning </br> 3. Please check your spelling"; 
				else 
				{ 
					$success = "$foundnum results found !<p>"; 
					
				} 
			} 
	
		}
		elseif(isset($_POST["Import"])){
		
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
								window.location = \"customers.php?title=customer\"
								</script>";		
							}
							else {
								echo "<script type=\"text/javascript\">
								alert(\"CSV File has been successfully Imported.\");
								window.location = \"customers.php?title=customer\"
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
							window.location = \"customers.php\"
						  </script>";
		}
		}
		elseif(isset($_POST["Export"])){
		 
			$result = mysql_query("SELECT * FROM tb_customer where client_id=".$client_id);
			 
			csvToExcelDownloadFromResult($result);
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
    <script src="_layout/js/vendor/modernizr.js">
	</script>
	
	<style>
	page_links
{
 font-family: arial, verdana;
 font-size: 12px;
 border:1px #000000 solid;
 padding: 6px;
 margin: 3px;
 background-color: #cccccc;
 text-decoration: none;
}
#page_a_link
{
 font-family: arial, verdana;
 font-size: 12px;
 border:1px #000000 solid;
 color: #ff0000;
 background-color: #cccccc;
 padding: 6px;
 margin: 3px;
 text-decoration: none;
}
.tabs-container {
     margin-bottom: 0px !important; 
}
	
	</style>
	
	
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
									<a href="customers.php">All Customers(<?php echo $totalCustomers;?>)</a> /
									<a href="customers.php?status=1">Active Customers(<?php echo $totalActiveCustomers;?>)</a> /
									<a href="customers.php?status=2">InActive Customers(<?php echo $totalInActiveCustomers;?>)</a> 
									
								</h6>
							</div>
							<div class="span6">
								<!---<span style="float:right; margin-right:10px;">
									<a href="commentall.php">View All Comments</a> | 
									<a href="testimonialall.php">View All Feedback</a>
								</span>-->				
								</span>
								<span style="float:right;">
								
								<!--    <a href="createQuestions.php" class="btn" >Send New Survey</a>  <!-- data-reveal-id="sendnewCustomer" -->
									
									
									<a href="#" class="btn" data-reveal-id="myModal">Add Customer</a>
									<a href="#" class="btn" data-reveal-id="multipleCustomer">Import Customers</a>
									<div style="float:right;">
										<form class="form-horizontal" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" name="upload_excel" enctype="multipart/form-data">
									
											<button  type="submit" id="submit" name="Export" class="btn " data-loading-text="Loading...">Export Customers</button>
										</form>
								</div>
								</span>
							</div>
						</div>
						
						<?php
							
							
							if(mysql_num_rows($resCustomer)>0)
							{
							?>
						
						<div style="float:right;">
								<form method="post" action="customers.php?search_id=1">
									<div style="float:left;margin-right:5px;"><label>Search:</label></div>
									<div style="float:left;margin-right:5px;"><input type="text" name="search" id="search"  /></div>
									<div style="float:left;"><input type="submit" name="search_submit" value="Search" id="search_submit" class="btn"/></div>
								</form>
								</div>
						<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
						<div class="box-body">
							
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th><input type="checkbox" name="custall"  id="custall" value=""  style="-webkit-appearance:checkbox;float:left;"></th>
										<th>Name</th>
										<th>Status</th>
										<th>Overall</th>
										<th>Company</th>
										<th>Group</th>
										<th>Total Survey Sent</th>
										<?php
											//if($status == 2)
											//{
										?>
										<th>Action</th>
										<?php
											//}
										?>
										
									</tr>
								</thead>
								<tbody>
								
									<?php
									$i=0;
									$total_row = mysql_num_rows($resCustomer);
									while($rowCustomer = mysql_fetch_array($resCustomer))
									{										
										$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='".$rowCustomer['id']."' order by id desc limit 1";
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
											<?php
												if($rowCustomer["customer_isActive"] == 1)
												{
											?>
												<td><input type="checkbox" name="cust[]" value="<?php echo $rowCustomer['id']; ?>"  style="-webkit-appearance:checkbox;float:left;"></td>
											<?php
												}
												else
												{
													?>
													<td></td>
													<?php
												}
											?>
												<td><a href="customer-detail.php?title=customer&id=<?php echo $rowCustomer['id'];?>"><?php echo ucfirst($rowCustomer['customer_firstname']).' '.ucfirst($rowCustomer['customer_lastname']);?></a></td>
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
												<?php
													$cus_id = $rowCustomer['id'];
													$selectTotal = "select count(customer_id) as Total from tb_customerheartbeat where customer_id= ".$cus_id;
													$resSelectTotal = mysql_query($selectTotal);
													$recSelectTotal = mysql_fetch_array($resSelectTotal);
												?>
												<td><?php echo $recSelectTotal['Total']; ?></td>
											
												<?php
											
											
												if($rowCustomer['customer_isActive'] == 1)
												{
												?>
													<td><a href="customers.php?status_id=1 && cust_id=<?php echo $rowCustomer['id']; ?>">InActive</a></td>
												<?php
												}
												else
												{
												?>
													<td><a href="customers.php?status_id=2 && cust_id=<?php echo $rowCustomer['id']; ?>">Active</a></td>
												<?php
												}
											?>
											</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
							<input id="cust-submit" name="cust-submit" type="submit" class="btn" value="Send them a survey" style="margin-top:10px;"/>
							<?php 
							}
							else
							{
								echo "No Customers Found.";
							}
							?>
						</div>
						
						</form>
						
						</div><!-- end .tabs -->  
						<div style="float:right;">
						<!-- Pagination starts  -->
					<?php
if($totalCustomers != 0 && $totalCustomers > $perpage && ($_GET["status"] != 2 && $_GET["status"] != 1))
{
	if(isset($page))
	{

		$result = mysql_query("select Count(*) As Total from tb_customer where client_id=$client_id");
		$rows = mysql_num_rows($result);

		if($rows)
		{
			$rs = mysql_fetch_assoc($result);
			$total = $rs["Total"];
		}
		$totalPages = ceil($total / $perpage);
		if($page <=1 )
		{
			"<span id='page_links' style='font-weight: bold;'>Prev</span>";
		}
		else
		{
			$j = $page - 1;
			echo "<span><a id='page_a_link' href='customers.php?page=$j'>< Prev</a></span>";
		}

		for($i=1; $i <= $totalPages; $i++)
		{
			if($i<>$page)
			{
				echo "<span><a id='page_a_link' href='customers.php?page=$i'>$i</a></span>";
			}
			else
			{
				echo "<span id='page_links' style='font-weight: bold;'>$i</span>";
			}
		}
		if($page == $totalPages )
		{
			echo "<span id='page_links' style='font-weight: bold;'>Next ></span>";
		}
		else
		{
			$j = $page + 1;
			echo "<span><a id='page_a_link' href='customers.php?page=$j'>Next</a></span>";
		}
	}
}
					?>
					
				<!-- Pagination End -->
				</div>
                </div><!-- end .span12 -->
            </div><!-- end .row -->
		<!-- ///////////////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
		
			<!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////////////////////////////////////////////////////// -->	
			<?php include "footer.php"; ?>
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->    
		
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
						<input type="text" name="first_name" value="" placeholder="Enter FirstName" required >
					</div>
					<div class="span3">
						<label>Last Name</label>
						<input type="text" name="last_name" placeholder="Enter LastName" value="">
					</div>
				</div>
				<div class="row">
					<div class="span3">
						<label>Company</label>
						<input type="text" name="company" value="" >
					</div>
					<div class="span3">
						<label>Group Name</label>
						<input type="text" name="group" value="">
					</div>
				</div>
				<div class="row">
					<div class="span6">
						<label>Email</label>
						<input type="text" name="email" value="" placeholder="Enter Your Email">
					</div>
				</div>
				<input id="customer-submit" name="customer-submit" type="submit" class="btn" value="Save Customer" />
			</form>        
		</div>
		<a class="close-reveal-modal" href="customers.php">&#215;</a>		
	</div>
	
	<!---send new survey-->
	<!--<div id="sendnewCustomer" class="reveal-modal" style="/*width:525px;*/" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Send New Survey</strong> <br>
		</h5>
		<div class="row">
			<form class="fixed" id="customer-form" name="customer-form" action="allsurveysend.php" method="post">
				<input id="survey-submit" name="survey-submit" type="submit" class="btn" value="Send them again new Survey" /> 
			</form>        
		</div>
		<a class="close-reveal-modal" href="customers.php">&#215;</a>		
	</div>-->
	
	
	<!--End---->
	
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