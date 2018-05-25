<?php
include_once "../db_connect.php";
include "functions.php";

session_start();
if( !isset($_SESSION['id']) )
{
	header("location:index.php");
}

$id = $_SESSION['id'];

if(isset($_POST["template"]))
{
    // Capture selected country
    $template_id = $_POST["template"];   
    
    if($template_id !== '0')
	{
		$selTemplate = "select * from tb_template where id='$template_id'";
		$resTemplate = mysql_query($selTemplate);
		$rowTemplate = mysql_fetch_array($resTemplate);

		echo '<div class="form-group">
									<label for="email_sub">Email Subject</label>
									<input type="text" class="form-control" id="email_sub" name="email_sub" value="'.$rowTemplate['email_sub'].'" >
								</div>
								<div class="form-group">
									<label for="email_body">Email Body</label>
									<textarea class="textarea" id="email_body" name="email_body" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">'.$rowTemplate['email_body'].'</textarea>
								</div>';

    } 
}

?>