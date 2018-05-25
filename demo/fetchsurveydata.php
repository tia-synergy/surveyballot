<?php
	include_once "db_connect.php";
	include "functions.php";
	
	session_start();
	if( !isset($_SESSION['email']) )
	{
		header("location:login.php");
	}
	
	$client_id = $_SESSION['clientid'];
	
	$startdate = $_GET['startdate'];
	// $startdate = date("Y-m-d h:i:s",strtotime($startdate));
	$enddate = $_GET['enddate'];
	echo 'startdate: '.$startdate;
	echo 'enddate: '.$enddate;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
    <title>Results</title>
	<meta name="description" content=" add description  ... ">
    
	<link href="_layout/css/tooltip.css" rel="stylesheet" type="text/css" />
	
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
	<?php
	$selectResponse = "select * from tb_customerhistory where client_id='$client_id' and operation='responsereceived' and opdate>='$startdate' and opdate<='$enddate'";
	echo "quesry: ".$selectResponse;
	$resResponse = mysql_query($selectResponse);
	if(mysql_num_rows($resResponse)==0)
	{
	?>
		<div align="center">
			No response received in this date range.
		</div>
		<?php
	}
	else
	{
		$heartbeatReceived = mysql_num_rows($resResponse);
							
		$selectHeartbeatData = "select * from tb_customerheartbeat where client_id='$client_id' and status='responsereceived' and response_date>='$startdate' and response_date<='$enddate'";
		$resHeartbeatData = mysql_query($selectHeartbeatData);
		$totalResponse = 0;
		$question1_total = 0;
		$question2_total = 0;
		$question3_total = 0;
		$question4_total = 0;
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
				$selectquestion = "select * from tb_questions";
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
					
					
				?>
					<div class="span2" style="margin-top:20px;">
						<a href="#" onmouseover="tooltip.pop(this, '<?php echo "#".$divid;?>', {position:0, offsetX:0, offsetY:-65, effect:'slide'})">
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
    
	<!-- /// jQuery ////////  -->
	<script src="_layout/js/jQuery-2.1.3.min.js"></script>
	<script src="_layout/bootstrap/js/bootstrap.min.js"></script>
	<script src="_layout/js/knob/jquery.knob.js" type="text/javascript"></script>
	
	<script src="_layout/js/tooltip.js" type="text/javascript"></script>
	
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