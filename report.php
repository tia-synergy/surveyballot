<?php
	include_once "db_connect.php";
	include "functions.php";
	
	date_default_timezone_set('Canada/Eastern');
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	
	$selectClient = "select * from tb_client where client_id='$client_id'";
	$resClient = mysql_query($selectClient);
	$rowClient = mysql_fetch_array($resClient);
	
	// $selectCusHis = "select * from tb_customerhistory where client_id='$client_id' and operation='heartbeatsend'";
	// $resSelectCusHis = mysql_query($selectCusHis);
	
	$selectHeartbeat = "select * from tb_heartbeat where client_id='$client_id'";
	$resHeartbeat = mysql_query($selectHeartbeat);
	
	$selectActiveCustomer = "select * from tb_customer where client_id='$client_id' and customer_isActive='1'";
	$resSelectActiveCustomer = mysql_query($selectActiveCustomer);
	$totalActiveCustomers = mysql_num_rows($resSelectActiveCustomer);
	$resCustomer = mysql_query($selectActiveCustomer);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
    <title>Results</title>
	<meta name="description" content=" add description  ... ">
    
	<link href="_layout/css/jquery-ui.css" rel="stylesheet" type="text/css" />
	
	<link href="_layout/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="_layout/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<link href="_layout/css/_all-skins.min.css" rel="stylesheet" type="text/css" />
	
	<link href="_layout/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
	
	<!-- /// Favicons ////////  -->
    <link rel="shortcut icon" href="favicon.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144-precomposed.png">

	<!-- /// Google Fonts ////////  -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic">
    
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
		<div id="content1">
			<!-- /// CONTENT  /////////////////////////////////////////// -->
			<div class="row" style="">
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
				<div>
				<?php
				if(mysql_num_rows($resHeartbeat)==0)
				{
				?>
					<div>
						No Survey sent yet. Send your first survey to all active customers.
						<div style="float:right;">
							<form class="fixed" name="heartbeat-form" name="heartbeat-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
								<input id="heartbeat-submit" name="heartbeat-submit" type="submit" class="btn" value="Send First Survey" />
							</form>
						</div>
					</div>
				<?php
				}
				else
				{
				?>
					<div>
						<form>
							<div class="form-group">
								<label>Date range:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="daterange"/>
								</div><!-- /.input group -->
							</div>
						</form>
						<div id="resultdiv">
							<?php
							$selectResponse = "select * from tb_customerhistory where client_id='$client_id' and operation='responsereceived'";
							$resResponse = mysql_query($selectResponse);
							if(mysql_num_rows($resResponse)==0)
							{
							?>
								<div align="center">
									Your survey has been sent out. Waiting for first Response.
								</div>
							<?php
							}
							else
							{
								$heartbeatReceived = mysql_num_rows($resResponse);
								
								$selectHeartbeatData = "select * from tb_customerheartbeat where client_id='$client_id' and status='responsereceived'";
								$resHeartbeatData = mysql_query($selectHeartbeatData);
								$totalResponse = 0;
								$question1_total = 0;
								$question2_total = 0;
								$question3_total = 0;
								$question4_total = 0;
								$question5_total = 0;
								$question6_total = 0;
								$question7_total = 0;
								$question8_total = 0;
								$question9_total = 0;
								$question10_total = 0;
								$overall_total = 0;
								
								$loveyou_total = 0;
								$likeyou_total = 0;
								$notsatisfied_total = 0;
								
								$loveyou_percent = 0;
								$likeyou_percent = 0;
								$notsatisfied_percent = 0;
								
								while($rowHeartbeatData=mysql_fetch_array($resHeartbeatData))
								{
									$totalResponse = $totalResponse + 1;
									$question1_total = $question1_total + $rowHeartbeatData['question1_response'];
									$question2_total = $question2_total + $rowHeartbeatData['question2_response'];
									$question3_total = $question3_total + $rowHeartbeatData['question3_response'];
									$question4_total = $question4_total + $rowHeartbeatData['question4_response'];
									$question5_total = $question5_total + $rowHeartbeatData['question5_response'];
									$question6_total = $question6_total + $rowHeartbeatData['question6_response'];
									$question7_total = $question7_total + $rowHeartbeatData['question7_response'];
									$question8_total = $question8_total + $rowHeartbeatData['question8_response'];
									$question9_total = $question9_total + $rowHeartbeatData['question9_response'];
									$question10_total = $question10_total + $rowHeartbeatData['question10_response'];
									$overall_total = $overall_total + $rowHeartbeatData['overall_response'];
									
									if($rowHeartbeatData['recommend_response'] == 1)
									{
										$loveyou_total = $loveyou_total + 1;
									}
									elseif($rowHeartbeatData['recommend_response'] == 2)
									{
										$likeyou_total = $likeyou_total + 1;
									}
									elseif($rowHeartbeatData['recommend_response'] == 3)
									{
										$notsatisfied_total = $notsatisfied_total + 1;
									}
								}
								
								$loveyou_percent = ($loveyou_total*100)/mysql_num_rows($resHeartbeatData);
								$likeyou_percent = ($likeyou_total*100)/mysql_num_rows($resHeartbeatData);
								$notsatisfied_percent = ($notsatisfied_total*100)/mysql_num_rows($resHeartbeatData);
								
								$question1_value = $question1_total/$totalResponse;
								$question2_value = $question2_total/$totalResponse;
								$question3_value = $question3_total/$totalResponse;
								$question4_value = $question4_total/$totalResponse;
								$question5_value = $question5_total/$totalResponse;
								$question6_value = $question6_total/$totalResponse;
								$question7_value = $question7_total/$totalResponse;
								$question8_value = $question8_total/$totalResponse;
								$question9_value = $question9_total/$totalResponse;
								$question10_value = $question10_total/$totalResponse;
								$overall_value = $overall_total/$totalResponse;
								$overall_value = number_format($overall_value,2);
							?>
								<div>
									<h3 style="margin-bottom:-5px;">Report for</h3>
								</div>
								<div class="row" align="center">
									<div class="span12" style="margin-top:20px;" align="center">
										<?php 
										$i=1;
										$selectquestion = "select * from tb_cquestion where client_id='$client_id' order by question_no";
										$resselectquestion = mysql_query($selectquestion);
										while($rowquestion = mysql_fetch_array($resselectquestion))
										{
											$divid = "sub".$i;
											if($i==1)
											{
												$color = "#00c0ef";
												$value = number_format($question1_value,2);
											}
											elseif($i==2)
											{
												$color = "#00a65a";
												$value = number_format($question2_value);
											}
											elseif($i==3)
											{
												$color = "#f39c12";
												$value = number_format($question3_value);
											}
											elseif($i==4)
											{
												$color = "#dd4b39";
												$value = number_format($question4_value);
											}
											elseif($i==5)
											{
												$color = "#dd4b39";
												$value = number_format($question5_value);
											}
											elseif($i==6)
											{
												$color = "#dd4b39";
												$value = number_format($question6_value);
											}
											elseif($i==7)
											{
												$color = "#dd4b39";
												$value = number_format($question7_value);
											}
											elseif($i==8)
											{
												$color = "#dd4b39";
												$value = number_format($question8_value);
											}
											elseif($i==9)
											{
												$color = "#dd4b39";
												$value = number_format($question9_value);
											}
											elseif($i==10)
											{
												$color = "#dd4b39";
												$value = number_format($question10_value);
											}
											
											
										?>
											<div class="span2" style="margin-top:20px;">
												<a href="#" title="<?php echo $rowquestion['question'];?>">
													<input type="text" class="knob" style="display:inline-block;" value="<?php echo $value;?>" data-width="100" data-height="100" data-fgColor="<?php echo $color;?>" data-readonly="true" data-min="0" data-max="10" data-angleOffset="180"/>
													<div class="knob-label"><?php echo $rowquestion['question_name'];?></div>
												</a>
											</div>
											<div style="display:none;">
												<div id="<?php echo $divid;?>" style="width:250px;">
													<?php echo $rowquestion['question'];?>      
												</div>
											</div>	
											<?php
											$i++;
										}
										?>	
										<div class="span2" style="margin-top:20px;">
											<input type="text" class="knob" style="display:inline-block;" value="<?php echo $overall_value;?>" data-width="100" data-height="100" data-fgColor="#dd4b39" data-readonly="true" data-min="0" data-max="10" data-angleOffset="180"/>
											<div class="knob-label">Overall</div>
										</div>									
									</div>
									<div class="span12" align="center" style="margin-top:20px;">
										<table>
											<tr>
												<td>
													<a href="#"><h4 style=""><?php echo $loveyou_total;?>(<?php echo number_format($loveyou_percent,2).'%';?>)</h4></a>
													<p>LOVE YOU</p>
												</td>
												<td>
													<a href="#"><h4 style=""><?php echo $likeyou_total;?>(<?php echo number_format($likeyou_percent,2).'%';?>)</h4></a>
													<p>LIKE YOU</p>
												</td>
												<td>
													<a href="#"><h4 style=""><?php echo $notsatisfied_total;?>(<?php echo $notsatisfied_percent.'%';?>)</h4></a>
													<p>NOT SATISFIED</p>
												</td>
											</tr>
										</table>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				<?php
				}
				?>
				</div>
				<div class="row" style="border-top:1px solid; margin-top:25px;">
					<div class="span12">
						<div>
							<div>
								<div class="span6">
									<h3 style="margin-bottom:-5px;">
										<strong>Customers</strong>
									</h3>
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
										?>
										<tr>
											<?php
											$selectHeartbeat = "select * from tb_customerheartbeat where client_id='$client_id' and customer_id='".$rowCustomer['id']."'";
											$resHeartbeat = mysql_query($selectHeartbeat);
											$rowHeartbeat = mysql_fetch_array($resHeartbeat);
											?>
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
            </div><!-- end .row -->
		<!-- //////////////////////////////////////////////////////////// -->
		</div><!-- end #content -->
		<br>
		<div id="footer-bottom">
		<!-- /// FOOTER-BOTTOM     ///////////////////////////////////////// -->	
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
		<!-- ////////////////////////////////////////////////////// -->    
		</div><!-- end #footer-bottom -->
	</div><!-- end #wrap -->
    
    <a id="back-to-top" href="#">
    	<i class="ifc-up4"></i>
    </a>
	
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
	<script src="_layout/js/jQuery-2.1.3.min.js"></script>
	<script src="_layout/bootstrap/js/bootstrap.min.js"></script>
	<script src="_layout/js/knob/jquery.knob.js" type="text/javascript"></script>
	
	<script src="_layout/js/jquery-ui.js" type="text/javascript"></script>
	
	<script src="_layout/js/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	
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
		$(document).ready(function(){
			$( document ).tooltip({
			  show: null,
			  position: {
				my: "center bottom",
				at: "left+30 top-80"
			  },
			  open: function( event, ui ) {
				ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
			  }
			});
			
			var tabload = '<?php echo $tabload;?>';
			$('#tabs-container').easytabs({
				animationSpeed: 300,
				defaultTab: "#"+tabload
			});
			
			// $('#daterange').daterangepicker({
				// onSelect: function ()
                // {
                  // Do all your stuffs here
                  // Then add this line to trigger the change event manually.
                  // $(this).change();
                // }
			// });
			 // jQuery("input").bind("change", function(){
				// console.error("change detected");
			  // });
			  
			$('#daterange').daterangepicker({ 
				},
				function(start, end, label) {
					$('#resultdiv').html('<img src="_layout/images/loading.gif">');
					// alert('A date range was chosen: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
					
					var myData = 'startdate='+start.format('YYYY-MM-DD')+'&enddate='+end.format('YYYY-MM-DD');
					$.ajax({
						url:"fetchsurveydata.php",
						type: "get",
						data: myData,
						success: function(data){
							$("#resultdiv").html(data);	
						}
					});
				}
			);
			// $('#daterange').change(function() {
			  // alert( "Handler for .change() called." );
			// });
			// $(".question").click(function (e) {
				// e.preventDefault();
				// $('#questionFormScreen').modal();
			// });
			
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
		
		function ondatechange() 
		{
			alert("date change called");
		}
	</script>
    

</body>
</html>