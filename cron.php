<?php
include_once "db_connect.php";

$selectClient = "select * from tb_client where client_status=1";
$resClient = mysql_query($selectClient);
while($rowClient=mysql_fetch_array($resClient))
{
	$client_id = $rowClient['client_id'];
	$client_email = $rowClient['client_email'];
	
	$selCompany = "select * from tb_company where client_id='$client_id'";
	$resCompany = mysql_query($selCompany);
	$rowCompany = mysql_fetch_array($resCompany);
	
	$noofdaysdiff = '';
	if($rowCompany['feedback_frequency']=='Every Month')
	{
		$noofdaysdiff = 30;
	}
	elseif($rowCompany['feedback_frequency']=='Every 2 Months')
	{
		$noofdaysdiff = 60;
	}
	elseif($rowCompany['feedback_frequency']=='Every 3 Months')
	{
		$noofdaysdiff = 90;
	}
	elseif($rowCompany['feedback_frequency']=='Every 6 Months')
	{
		$noofdaysdiff = 180;
	}
	elseif($rowCompany['feedback_frequency']=='Once a Year')
	{
		$noofdaysdiff = 360;
	}
	
	$selectMaxSendDate = "select max(senddate) as lastsenddate from tb_heartbeat where client_id='$client_id'";
	$resMaxSendDate = mysql_query($selectMaxSendDate);
	$rowMaxSendDate = mysql_fetch_array($resMaxSendDate);
	
	$lastSendDate = $rowMaxSendDate['lastsenddate'];
	
	$selectdatediff = "select DATEDIFF(NOW(),'$lastSendDate') AS DiffDate";
	$resdatediff = mysql_query($selectdatediff);
	$rowdatediff = mysql_fetch_array($resdatediff);
	if($rowdatediff['DiffDate']>$noofdaysdiff)
	{
		$selectTotalHeartbeat = "select max(id) as maxId from tb_heartbeat where client_id='$client_id'";
		$resTotalHeartbeat = mysql_query($selectTotalHeartbeat);
		$rowTotalHeartbeat = mysql_fetch_array($resTotalHeartbeat);
		$heartbeat_id = $rowTotalHeartbeat['maxId'] + 1;
		
		$insertHeartbeat1 = "insert into tb_heartbeat (id,client_id,senddate) values ('$heartbeat_id','$client_id',NOW())";
		$resInsertHeartbeat1 = mysql_query($insertHeartbeat1);
			
		$selectAllCustomer = "select * from tb_customer where client_id='$client_id' and customer_status='1' and customer_isActive='1'";
		$resAllCustomer = mysql_query($selectAllCustomer);
		while($rowAllCustomer=mysql_fetch_array($resAllCustomer))
		{
			$customer_id = $rowAllCustomer['id'];
			
			$selectCustomerheartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='$customer_id'";
			$resCustomerheartbeat = mysql_query($selectCustomerheartbeat);
			if(mysql_num_rows($resCustomerheartbeat)==0)
			{
				$selectEmail = "select * from tb_emailwording where email_for='initial' and client_id='$client_id'";
			}
			else
			{
				$selectEmail = "select * from tb_emailwording where email_for='subsequent' and client_id='$client_id'";
			}
			$resEmail = mysql_query($selectEmail);
			$rowEmail = mysql_fetch_array($resEmail);
			
			$token = sha1(uniqid($rowAllCustomer['customer_firstname'], true));
			
			$updateCustomer = "update tb_customer set customer_heartbeatcount=customer_heartbeatcount+1 where id='$customer_id'";
			$resUpdateCustomer = mysql_query($updateCustomer);
			
			$insertHeartbeat = "insert into tb_customerheartbeat (client_id,heartbeat_id,customer_id,email_token,status,send_date) values ('$client_id','$heartbeat_id','$customer_id','$token','heartbeatsent',NOW())";
			$resInsertHeartbeat = mysql_query($insertHeartbeat);
			
			$insertHistory = "insert into tb_customerhistory (client_id,customer_id,operation,opdate) values ('$client_id','$customer_id','heartbeatsent',NOW())";
			$resHistory = mysql_query($insertHistory);
			
			$to = $rowAllCustomer['customer_email']; 
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: ".$client_email . "\r\n";
			$subject = "Request from ".$rowClient['client_company']; 
			$body = "Hi ".$rowAllCustomer['customer_firstname'].",<br/><br/>".$rowEmail['email_wording']."<br/><br/><a href=http://www.surveyballot.com/response.php?token=".$token.">Submit your survey</a><br/><br/>Kind Regards, <br/>".$rowClient['client_fullname']."<br/>".$rowClient['client_company']; 

			mail($to,$subject,$body,$headers);
		}
	}
}
?>	