<?php
ini_set('display_errors', 0); 
include_once "../db_connect.php";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	if(!empty($_POST['login-submit']))
	{
		if("" != $_POST['email'] && "" != $_POST['password'])
		{
			$email = $_POST['email'];
			$password = $_POST['password'];
		
			$email = stripslashes($email);
			$password = stripslashes($password);
			$email = mysql_real_escape_string($email);
			$password = mysql_real_escape_string($password);
			
			 $password = md5($password);
			
			 $query = "Select id from tb_user where user_email='$email' and user_password='$password' and user_status=1";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
		
			if($count == 1)
			{
				$userrow = mysql_fetch_array($result);
				$userid = $userrow['id'];
			
				session_start();
				$_SESSION['email'] = $email;
				$_SESSION['id'] = $userid;
				
				header("location:dashboard.php");
				exit();
			}
			else
			{
				$error = "Email and Password does not match.";
			}
		}
		else
		{
			if("" == $_POST['email'])
			{
				$error = "Please enter your email address.";
			}
			elseif("" == $_POST['password'])
			{
				$error = "Please enter password.";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Survey Admin | Log in</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.4 -->
		<link href="../_layout/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="../_layout/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<!-- iCheck -->
		<link href="../_layout/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="">
		<div class="login-box">
			<div class="login-logo" style="margin-left:-40px;">
				<a href="index.php"><img class="responsive-img" src="../_layout/images/logo.png" alt=""></a>
			</div><!-- /.login-logo -->
			<div class="login-box-body" style="background:#d2d6de;">
				<p class="login-box-msg">Sign in to start your session</p>
				<form class="fixed" id="login-form" name="login-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>"> 
					<div class="form-group has-feedback">
						<input type="email" id="email" name="email" class="form-control" placeholder="Email"/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password"id="password" name="password" class="form-control" placeholder="Password"/>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-4" style="float:right;">
							<input type="submit" class="btn btn-primary btn-block btn-flat" id="login-submit" name="login-submit" value="Sign In">
						</div><!-- /.col -->
					</div>
				</form>
			</div><!-- /.login-box-body -->
		</div><!-- /.login-box -->

		<!-- jQuery 2.1.4 -->
		<script src="../_layout/js/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.2 JS -->
		<script src="../_layout/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<!-- iCheck -->
		<script src="../_layout/iCheck/icheck.min.js" type="text/javascript"></script>
		<script>
			$(function () {
				$('input').iCheck({
				  checkboxClass: 'icheckbox_square-blue',
				  radioClass: 'iradio_square-blue',
				  increaseArea: '20%' // optional
				});
			});
		</script>
	</body>
</html>