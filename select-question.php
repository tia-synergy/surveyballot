<?php
	include_once "db_connect.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	$question_added = 0;
	
	$selectCquestion = "select * from tb_cquestion where client_id='$client_id'";
	$resSelectCquestion = mysql_query($selectCquestion);
	
	if(mysql_num_rows($resSelectCquestion)>0)
	{
		$question_added = 1;
	}
	else
	{
		$selectCquestion = "select * from tb_questions where question_default=1";
		$resSelectCquestion = mysql_query($selectCquestion);
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(!empty($_POST['question-submit']))
		{
			for($i=0;$i<5;$i++)
			{
				$question_no = $i + 1;
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
				
				if($question_no==4)
				{
					if($result)
					{
						header("location:firstcustomer.php");
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
    
    <!--<link href="_layout/css/tooltip.css" rel="stylesheet" type="text/css" />-->
	
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
                            <li id="tab-2" class="active">
                                <a href="select-question.php">CREATE YOUR SURVEY</a>
						    </li>
                            <li id="tab-3">
                                <?php
								if($question_added==1)
								{
								?>
									<a href="firstcustomer.php">ADD YOUR CUSTOMERS</a>
								<?php
								}
								else
								{
								?>
									<a href="" style="opacity:0.5; cursor:default;">ADD YOUR CUSTOMERS</a>
								<?php
								}
								?>
							</li>
                            <li id="tab-4">
                                <?php
								$selectCustomer = "select * from tb_customer where client_id='$client_id'";
								$resSelectCustomer = mysql_query($selectCustomer);
								
								if(mysql_num_rows($resSelectCustomer)>0)
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
                                	<strong>Create your survey</strong> <br>
                                </h3>
								<form class="fixed" id="question-form" name="question-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div class="accordion">
										<?php
										// while($row_selectquestion = mysql_fetch_array($res_selectquestion))
										$resSelectCquestion = mysql_query($selectCquestion);
										$i = 0;
										while($rowSelectCquestion = mysql_fetch_array($resSelectCquestion))
										{
											$i = $i + 1;
											// $questionnameid = "question".$rowSelectCquestion['question_no']."_name";
											// $questionid = "question".$rowSelectCquestion['question_no'];
											
											// $divid = 'question'.$rowSelectCquestion['question_no'].'div';
											// $contentdiv = 'quescontent'.$rowSelectCquestion['question_no'];
											
											$questionnameid = "question".$i."_name";
											$questionid = "question".$i;
											
											$divid = 'question'.$i.'div';
											$contentdiv = 'quescontent'.$i;
										?>
											<a class="accordion-item" href="#" id=<?php echo $contentdiv;?>>
												<?php echo $rowSelectCquestion['question_name']; ?>
												<p style="font-size:14px;"><?php echo $rowSelectCquestion['question']; ?></p>
											</a>
											<div class="accordion-item-content">
												<a href="#" class="btn" data-reveal-id="<?php echo $divid;?>" style="float:right;">Change question</a>
											</div>
											<input type="hidden" name="<?php echo $questionnameid;?>" id="<?php echo $questionnameid;?>" value="<?php echo $rowSelectCquestion['question_name'];?>"/>
											<input type="hidden" name="<?php echo $questionid;?>" id="<?php echo $questionid;?>" value="<?php echo $rowSelectCquestion['question'];?>"/>
											<div id="<?php echo $divid;?>" class="reveal-modal" style="width:525px;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
												<h5>Change to your own question</h5>
												<input type="text" name="<?php echo $questionnameid.'new';?>" id="<?php echo $questionnameid.'new';?>" value="<?php echo $rowSelectCquestion['question_name'];?>"/>
												<textarea name="<?php echo $questionid.'new';?>" id="<?php echo $questionid.'new';?>"><?php echo $rowSelectCquestion['question'];?></textarea>
												<?php /*<input type="button" class="close-reveal-modal" name="change<?php echo $rowSelectCquestion['question_no'];?>" id="change<?php echo $rowSelectCquestion['question_no'];?>" value="Change"/> */?>
												<input type="button" class="close-reveal-modal btn" name="change<?php echo $i;?>" id="change<?php echo $i;?>" value="Change"/>
											</div>
										<?php
										}
										?>
										
									</div>
									<input id="question-submit" name="question-submit" type="submit" class="btn" value="Take me to the next step" />
								</form>
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
		$(document).ready(function(){
			$("#change1").click(function()
			{ 
				var question_name =  $("#question1_namenew").val();
				var question = $("#question1new").val();
				var data = question_name+"<p style='font-size:14px;'>"+question+"</p>";
				$("#quescontent1").html(data);
				
				document.getElementById('question1_name').value = question_name ; 
				document.getElementById('question1').value = question ; 
			});
			
			$("#change2").click(function()
			{ 
				var question_name =  $("#question2_namenew").val();
				var question = $("#question2new").val();
				var data = question_name+"<p style='font-size:14px;'>"+question+"</p>";
				$("#quescontent2").html(data);
				
				document.getElementById('question2_name').value = question_name ; 
				document.getElementById('question2').value = question ; 
			});
			
			$("#change3").click(function()
			{ 
				var question_name =  $("#question3_namenew").val();
				var question = $("#question3new").val();
				var data = question_name+"<p style='font-size:14px;'>"+question+"</p>";
				$("#quescontent3").html(data);
				
				document.getElementById('question3_name').value = question_name ; 
				document.getElementById('question3').value = question ; 
			});
			
			$("#change4").click(function()
			{ 
				var question_name =  $("#question4_namenew").val();
				var question = $("#question4new").val();
				var data = question_name+"<p style='font-size:14px;'>"+question+"</p>";
				$("#quescontent4").html(data);
				
				document.getElementById('question4_name').value = question_name ; 
				document.getElementById('question4').value = question ; 
			});
		});
	</script>
    

</body>
</html>