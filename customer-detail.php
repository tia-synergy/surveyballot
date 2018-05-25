<?php
	include_once "db_connect.php";
	include "functions.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	$customer_id = $_GET['id'];
	
	$client_email = $_SESSION['email'];
	
	$selectCustDetail = "select * from tb_customer where id='$customer_id'";
	$resCustDetail = mysql_query($selectCustDetail);
	$rowCustDetail = mysql_fetch_array($resCustDetail);
	
	$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
	$resHeartbeat = mysql_query($selectHeartbeat);
	
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
				$selectCusInfo = "select * from tb_customer where client_id='$client_id' and customer_email='$customer_email' and customer_email!='".$rowCustDetail['customer_email']."'";
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
					
					$query = "update tb_customer set customer_firstname='$customer_firstname', customer_lastname='$customer_lastname', customer_email='$customer_email', customer_company='$customer_company', customer_group='$customer_group', customer_updatedate=NOW() where client_id='$client_id' and id='$customer_id'";
					$result = mysql_query($query);
					
					if($result)
					{
						header("location:customer-detail.php?id=".$rowCustDetail['id']);
						exit();
					}
				}
			}
		}
		elseif(!empty($_POST['out-submit']))
		{
			$query = "update tb_customer set customer_isActive=2 where client_id='$client_id' and id='$customer_id'";
			$result = mysql_query($query);
			
			if($result)
			{
				header("location:customer-detail.php?id=".$rowCustDetail['id']);
				exit();
			}
		}
		elseif(!empty($_POST['activate-submit']))
		{
			$query = "update tb_customer set customer_isActive=1 where client_id='$client_id' and id='$customer_id'";
			$result = mysql_query($query);
			
			if($result)
			{
				header("location:customer-detail.php?id=".$rowCustDetail['id']);
				exit();
			}
		}
		elseif(!empty($_POST['followup-submit']))
		{
			$selectEmail = "select * from tb_emailwording where email_for='followup' and client_id='$client_id'";
			$resEmail = mysql_query($selectEmail);
			$rowEmail = mysql_fetch_array($resEmail);
			
			$selectTotalHeartbeat = "select max(heartbeat_id) as maxId from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
			$resTotalHeartbeat = mysql_query($selectTotalHeartbeat);
			$rowTotalHeartbeat = mysql_fetch_array($resTotalHeartbeat);
			$heartbeat_id = $rowTotalHeartbeat['maxId'];
			
			$selectToken = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id' and heartbeat_id='$heartbeat_id'";
			$restoken = mysql_query($selectToken);
			$rowToken = mysql_fetch_array($restoken);
			
			$token = $rowToken['email_token'];
			
			$selectClient = "select * from tb_client where client_id='$client_id'";
			$resClient = mysql_query($selectClient);
			$rowClient = mysql_fetch_array($resClient);
			
			$insertHistory = "insert into tb_customerhistory (client_id,customer_id,operation,opdate) values ('$client_id','$customer_id','followupsent',NOW())";
			$resHistory = mysql_query($insertHistory);
			
			$to = $rowCustDetail['customer_email']; 
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: ".$client_email . "\r\n";
			// $to = "vickyshah.cer@gmail.com";
			$subject = "Followup Request from ".$rowClient['client_company']; 
			$body = "Hi ".$rowCustDetail['customer_firstname'].",<br/><br/>".$rowEmail['email_wording']."<br/><br/><a href=". $_SERVER['SERVER_NAME']."/response.php?token=".$token.">Submit your survey</a><br/><br/>Kind Regards, <br/>".$rowClient['client_fullname']."<br/>".$rowClient['client_company'];  
			
			// echo "to: ".$to;
			// echo "subject: ".$subject;
			// echo "body: ".$body;
			// echo "headers: ".$headers;
			mail($to,$subject,$body,$headers);
			$success = "Followup email sent successfully.";
			
			// require("./smtp/class.phpmailer.php");
			// $mail = new PHPMailer();
			// $mail->IsSMTP(); 	// set mailer to use SMTP
			// $mail->Host = "southcarolina.networkphantom.net"; // specify main and backup server
			// $mail->SMTPAuth = true; // turn on SMTP authentication
			// $mail->Username = "noreplay@reliableappraisal.ca"; // SMTP username
			// $mail->Password = "c1BSTofzcP"; // SMTP password
			// $mail->Port = 465;
			// $mail->SMTPSecure = "ssl";
			// $mail->From = $_POST['cemail'];
			// $mail->FromName = trim($_POST['cname']);
			// $mail->AddAddress("info@reliableappraisal.ca");
			// if($_POST['cemail'] != ""){	$mail->AddBcc($_POST['cemail']); }// applicant email address
			// $mail->Subject = "Appraisal Request by"." ".$_POST['cname']." - ".$_POST['appname']."";//Appraisal Request
			// $mail->Body = $body;
			// $mail->IsHTML(true);
			
				
			// if(!$mail->Send())
			// {
				// echo "Message could't be sent. Mailer Error: " . $mail->ErrorInfo;
				// exit;
				header("Location:".$_SERVER['HTTP_REFERER']."?&hdname=1");
			// }
			// else
			// {
				// echo '<script>window.location="thanks.php"</script>';
				
			// }
		}
		elseif(!empty($_POST['heartbeat-submit']))
		{
			$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
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
			
			// echo "to: ".$to;
			// echo "subject: ".$subject;
			// echo "body: ".$body;
			// echo "headers: ".$headers;
			mail($to,$subject,$body,$headers);
			
			//$success = "Survey sent successfully.";
			header("location:customer-detail.php?id=".$customer_id);
			// $host = "smtp.gmail.com"; 
			// $username = "vaibhavi@synergyit.ca"; 
			// $password = "vaibhavicky";  
			// $headers = array ('From' => $from,   'To' => $to,   'Subject' => $subject); 
			// $smtp = Mail::factory('smtp',   array ('host' => $host,     'auth' => true,     'username' => $username,     'password' => $password));  
			// $mail = $smtp->send($to, $headers, $body);  
			// if (PEAR::isError($mail)) 
			// {   
				// echo("<p>" . $mail->getMessage() . "</p>");  
			// } 
			// else 
			// {   
				// echo("<p>Message successfully sent!</p>");  
			// }
			
			// if($result)
			// {
				// header("location:customer-detail.php?id=".$rowCustDetail['id']);
				// exit();
			// }*/
		}
			elseif(!empty($_POST['survey-submit']))
		{
			$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
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
			
			// echo "to: ".$to;
			// echo "subject: ".$subject;
			// echo "body: ".$body;
			// echo "headers: ".$headers;
			mail($to,$subject,$body,$headers);
			
			//$success = "Survey sent successfully.";
			header("location:customer-detail.php?id=".$customer_id);
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
    
	<!-- /// Google Fonts ////////  -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic">
    
	<link rel="stylesheet" href="_layout/css/foundation.min.css">
	
	<link href="_layout/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="_layout/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<link href="_layout/css/_all-skins.min.css" rel="stylesheet" type="text/css" />
	
    <!-- /// Favicons ////////  -->
    <link rel="shortcut icon" href="favicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144-precomposed.png">

	
	
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
		<?php include "header.php"; ?>	
		<div id="content" style="margin-top:150px;">
			<!-- /// CONTENT  ///////////////////////////////// -->
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
				<?php
				if($rowCustDetail['customer_isActive'] == 2)
				{
				?>
					<div style="color:rgb(255,255,255); background-color:darkorange;padding-top:10px;padding-bottom:10px;padding-left:10px;margin-top:-20px;margin-bottom:10px;">
						This customer has opted out of all future heartbeats.
					</div>
				<?php
				}
				?>
				<div style="margin-bottom:70px;">
					<div class="span6">
						<h3 style="margin-bottom:-5px;">
							<strong><?php echo $rowCustDetail['customer_firstname'].' '.$rowCustDetail['customer_lastname'];?></strong>
							<?php echo '- '.$rowCustDetail['customer_company']; ?>
						</h3>
						<h5><?php echo $rowCustDetail['customer_email']; ?></h5>
					</div>
					<div class="span6">
						<?php
						/*
							
							
							if(mysql_num_rows($resHeartbeat) == 0) 
							{
							?>
								<a href="#" class="btn" data-reveal-id="myModal" style="float:right;">Delete Customer</a>
							<?php
							}
						*/
						?>
						<a href="#" class="btn" data-reveal-id="sendnewCustomer" style="float:right;">Send New Survey</a>
						<a href="#" class="btn" data-reveal-id="editCustomer" style="float:right;">Edit Customer Details</a>
						<?php
						if($rowCustDetail['customer_isActive'] == 1)
						{
						?>
							<a href="#" class="btn" data-reveal-id="optoutCustomer" style="float:right;">Opt Out Customer</a>
						<?php
						}
						elseif($rowCustDetail['customer_isActive'] == 2)
						{
						?>
							<a href="#" class="btn" data-reveal-id="optinCustomer" style="float:right;">Reactivate Customer</a>
						<?php
						}
						?>
						
					</div>
				</div>
				
				<div class="box-body">
					<?php
					if($rowCustDetail['customer_isActive'] == 1)
					{
					?>
						<div class="divider single-line"></div>
						<div class="content-wrapper">
							<?php
							if($rowCustDetail['customer_heartbeatcount'] == 0) 
							{
							?>
									<!-- Content Header (Page header) -->
									<section class="content-header" align="center">
										<form class="fixed" name="heartbeat-form" method="post" action="">
											<h4><?php echo $rowCustDetail['customer_firstname']; ?> has never been sent a survey.</h4>
											<input id="heartbeat-submit" name="heartbeat-submit" type="submit" class="btn" value="Send them a survey" />
										</form>
									</section>
							<?php
							}
							else
							{
								$todaydate = date_parse(date("Y-m-d"));
							?>
								<!-- Main content -->
								<section class="content">
									<!-- row -->
									<div class="row">
										<div class="col-md-12">
											<!-- The time line -->
											<ul class="timeline">
												<!-- timeline time label -->
												<li class="time-label">
													<span class="bg-red"><?php echo $todaydate['day'].' '.get_month($todaydate['month']).', '.$todaydate['year'];?></span>
												</li>
												<!-- /.timeline-label -->
												<!-- timeline item -->
												<?php 
												$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id' order by send_date desc";
												$resHeartbeat = mysql_query($selectHeartbeat);
												
												$startDate = "";
												while($rowHeartbeat=mysql_fetch_array($resHeartbeat))
												{
													$sendDate = date_parse($rowHeartbeat['send_date']);
													$startDate = $sendDate;
													$openDate = date_parse($rowHeartbeat['open_date']);
													$responseDate = date_parse($rowHeartbeat['response_date']);
													if($rowHeartbeat['status'] == "heartbeatsent")
													{
													?>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$sendDate['day'].' '.get_month($sendDate['month']).', '.$sendDate['year'];?></span>
																<h3 class="timeline-header">Survey has been sent to customer.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not opened email.";
																	?>
																</div>
																<div class='timeline-footer'>
																	<form class="fixed" id="followup-form" name="followup-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
																		<input type="submit" id="followup-submit" name="followup-submit" class="btn" value="Send followup email manually" />
																	</form>
																</div>
															</div>
														</li>
													<?php
													}
													elseif($rowHeartbeat['status'] == "emailopened")
													{
													?>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$openDate['day'].' '.get_month($openDate['month']).', '.$openDate['year'];?></span>
																<h3 class="timeline-header">Customer has opened the email.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not submitted survey. Waiting for reply.";
																	?>
																</div>
																<div class='timeline-footer'>
																	<form class="fixed" id="followup-form" name="followup-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
																		<input type="submit" id="followup-submit" name="followup-submit" class="btn" value="Send followup email manually" />
																	</form>
																</div>
															</div>
														</li>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$sendDate['day'].' '.get_month($sendDate['month']).', '.$sendDate['year'];?></span>
																<h3 class="timeline-header">Survey has been sent to customer.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not opened email.";
																	?>
																</div>
																<div class='timeline-footer'>
																	
																</div>
															</div>
														</li>
													<?php
													}
													elseif($rowHeartbeat['status'] == "responsereceived")
													{
														$selectQuestion = "select * from tb_cquestion where client_id='$client_id' order by question_no";
														$resQuestion = mysql_query($selectQuestion);
													?>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$responseDate['day'].' '.get_month($responseDate['month']).', '.$responseDate['year'];?></span>
																<h3 class="timeline-header">Customer has submitted survey.</h3>
																<div class="timeline-body">
																	<div class="row">
																		<?php //echo $rowHeartbeat['overall_response'];?>
																		<?php
																		while($rowQuestion=mysql_fetch_array($resQuestion))
																		{
																			if($rowQuestion['question_no']==1)
																			{
																				$color = "#00c0ef";
																				$value = $rowHeartbeat['question1_response'];
																			}
																			elseif($rowQuestion['question_no']==2)
																			{
																				$color = "#00a65a";
																				$value = $rowHeartbeat['question2_response'];
																			}
																			elseif($rowQuestion['question_no']==3)
																			{
																				$color = "#f39c12";
																				$value = $rowHeartbeat['question3_response'];
																			}
																			elseif($rowQuestion['question_no']==4)
																			{
																				$color = "#dd4b39";
																				$value = $rowHeartbeat['question4_response'];
																			}
																			elseif($rowQuestion['question_no']==5)
																			{
																				$color = "#dd4b39";
																				$value = $rowHeartbeat['question5_response'];
																			}
																			elseif($rowQuestion['question_no']==6)
																			{
																				$color = "#dd4b39";
																				$value = $rowHeartbeat['question6_response'];
																			}
																			elseif($rowQuestion['question_no']==7)
																			{
																				$color = "#dd4b39";
																				$value = $rowHeartbeat['question7_response'];
																			}
																			elseif($rowQuestion['question_no']==8)
																			{
																				$color = "#dd4b39";
																				$value = $rowHeartbeat['question8_response'];
																			}
																			elseif($rowQuestion['question_no']==9)
																			{
																				$color = "#dd4b39";
																				$value = $rowHeartbeat['question9_response'];
																			}
																			elseif($rowQuestion['question_no']==10)
																			{
																				$color = "#dd4b39";
																				$value = $rowHeartbeat['question10_response'];
																			}
																		?>
																			<div class="span2" style="width:139px; margin-top:20px;">
																				<input type="text" class="knob" style="display:inline-block;" value="<?php echo $value;?>" data-width="100" data-height="100" data-fgColor="<?php echo $color;?>" data-readonly="true" data-min="0" data-max="10" data-angleOffset="180"/>
																				<div class="knob-label" style="padding-left:20px;"><?php echo $rowQuestion['question_name'];?> </div>
																			</div>
																		<?php
																		}
																		?>
																		<div class="span2" style="width:139px; margin-top:20px;">
																			<input type="text" class="knob" style="display:inline-block;" value="<?php echo $rowHeartbeat['overall_response'];?>" data-width="100" data-height="100" data-fgColor="<?php echo $color;?>" data-readonly="true" data-min="0" data-max="10" data-angleOffset="180"/>
																			<div class="knob-label" style="padding-left:20px;">Overall </div>
																		</div>
																	</div>
																</div>
																<div class='timeline-footer'>
																	<?php
																	if($rowHeartbeat['comment'] != "")
																	{
																	?>
																		<strong>Comment:</strong>
																	<?php
																		echo $rowHeartbeat['comment'];
																	}		 
																	?>
																	<?php
																	if($rowHeartbeat['feedback'] != "")
																	{
																	?>
																		<br/><strong>Feedback:</strong>
																	<?php
																		echo $rowHeartbeat['feedback'];
																		/*
																	?>
																		<div align="right">
																		<div class="fb-share-button" data-href="http://surveyballot.com/results.php" data-layout="button_count"></div>
																		</div>
																	<?php
																		*/
																	}		 
																	?>
																	
																	
																</div>
															</div>
														</li>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$openDate['day'].' '.get_month($openDate['month']).', '.$openDate['year'];?></span>
																<h3 class="timeline-header">Customer has opened the email.</h3>
																<div class="timeline-body">
																	<?php echo "Customer has not submitted survey. Waiting for reply."; ?>
																</div>
																<div class='timeline-footer'>
																	
																</div>
															</div>
														</li>
														<li>
															<i class="fa fa-envelope bg-blue"></i>
															<div class="timeline-item">
																<span class="time"><i class="fa fa-clock-o"></i><?php echo ' '.$sendDate['day'].' '.get_month($sendDate['month']).', '.$sendDate['year'];?></span>
																<h3 class="timeline-header">Survey has been sent to customer.</h3>
																<div class="timeline-body">
																	<?php
																		echo "Customer has not opened email.";
																	?>
																</div>
																<div class='timeline-footer'>
																	
																</div>
															</div>
														</li>
													<?php
													}
												}
												?>
												<li class="time-label">
													<span class="bg-green">
														<?php echo ' '.$startDate['day'].' '.get_month($startDate['month']).', '.$startDate['year'];?>
													</span>
												</li>
												<li>
													<i class="fa fa-clock-o bg-gray"></i>
												</li>
											</ul>
										</div><!-- /.col -->
									</div><!-- /.row -->
								</section><!-- /.content -->
							<?php
							}
							?>
						</div>
						<?php
					}
					?>
					
					
				</div>
            </div><!-- end .row -->
		<!-- ///////////////////////////////////// -->
		</div><!-- end #content -->
        <div id="footer-bottom">
			<!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////// -->	
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
		<!-- //////////////////////////////////////////////////////////// -->    
		</div><!-- end #footer-bottom -->
	</div><!-- end #wrap -->
    
    <a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>
	
	<div id="editCustomer" class="reveal-modal" style="/*width:525px;*/" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Edit Customer</strong> <br>
		</h5>
		<div class="row">
			<form class="fixed" id="customer-form" name="customer-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
				<div class="row">
					<div class="span3">
						<label>First Name</label>
						<input type="text" name="first_name" value="<?php echo $rowCustDetail['customer_firstname'];?>">
					</div>
					<div class="span3">
						<label>Last Name</label>
						<input type="text" name="last_name" value="<?php echo $rowCustDetail['customer_lastname'];?>">
					</div>
				</div>
				<div class="row">
					<div class="span3">
						<label>Company</label>
						<input type="text" name="company" value="<?php echo $rowCustDetail['customer_company'];?>">
					</div>
					<div class="span3">
						<label>Group</label>
						<input type="text" name="group" value="<?php echo $rowCustDetail['customer_group'];?>">
					</div>
				</div>
				<div class="row">
					<div class="span6">
						<label>Email</label>
						<input type="text" name="email" value="<?php echo $rowCustDetail['customer_email'];?>">
					</div>
				</div>
				<input id="customer-submit" name="customer-submit" type="submit" class="btn" value="Save Customer" />
			</form>        
		</div>
		<a class="close-reveal-modal" href="customers.php">&#215;</a>		
	</div>
  
  <!---send new survey-->
	<div id="sendnewCustomer" class="reveal-modal" style="/*width:525px;*/" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
		<h5>
			<strong>Send New Survey</strong> <br>
		</h5>
		<div class="row">
			<form class="fixed" id="customer-form" name="customer-form" action="" 
			method="post">
				<input id="survey-submit" name="survey-submit" type="submit" class="btn" value="Send them again new Survey" /> 
			</form>        
		</div>
		<a class="close-reveal-modal" href="customers.php">&#215;</a>		
	</div>
	
	
	<!--End---->
  
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
	<script src="_layout/js/jQuery-2.1.3.min.js"></script>
	<script src="_layout/bootstrap/js/bootstrap.min.js"></script>
	<script src="_layout/js/knob/jquery.knob.js" type="text/javascript"></script>
	
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
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<script type="text/javascript">
		// Foundation.set_namespace = function() {};
		$(document).foundation();
		
		$(document).ready(function(){
			$(".knob").knob({
			  /*change : function (value) {
			   //console.log("change : " + value);
			   },
			   release : function (value) {
			   console.log("release : " + value);
			   },
			   cancel : function () {
			   console.log("cancel : " + this.value);
			   },*/
			  draw: function () {

				// "tron" case
				if (this.$.data('skin') == 'tron') {

				  var a = this.angle(this.cv)  // Angle
						  , sa = this.startAngle          // Previous start angle
						  , sat = this.startAngle         // Start angle
						  , ea                            // Previous end angle
						  , eat = sat + a                 // End angle
						  , r = true;

				  this.g.lineWidth = this.lineWidth;

				  this.o.cursor
						  && (sat = eat - 0.3)
						  && (eat = eat + 0.3);

				  if (this.o.displayPrevious) {
					ea = this.startAngle + this.angle(this.value);
					this.o.cursor
							&& (sa = ea - 0.3)
							&& (ea = ea + 0.3);
					this.g.beginPath();
					this.g.strokeStyle = this.previousColor;
					this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
					this.g.stroke();
				  }

				  this.g.beginPath();
				  this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
				  this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
				  this.g.stroke();

				  this.g.lineWidth = 2;
				  this.g.beginPath();
				  this.g.strokeStyle = this.o.fgColor;
				  this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
				  this.g.stroke();

				  return false;
				}
			  }
			});
		});
	</script>
    

</body>
</html>