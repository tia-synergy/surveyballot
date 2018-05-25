<?php
		include_once "db_connect.php";
		if(isset($_SESSION['clientid'])) 
		{
			$title = $_GET["title"];
			?>
			
		
		<div id="header-top">
		<!-- /// HEADER-TOP  //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #header-top -->
		<div id="header" style="top:30px;">
		<!-- /// HEADER  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
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
						<li class="<?php if($title == 'results') echo 'current'; else echo '';?>"><a href="results.php?title=results">Results</a></li>
						<li class="<?php if($title == 'customer') echo 'current'; else echo '';?>"><a href="customers.php?title=customer">Customers</a></li>
						<li class="<?php if($title == 'survey') echo 'current'; else echo '';?>"><a href="pulses.php?title=survey">Survey</a></li>
						<li class="<?php if($title == 'report') echo 'current'; else echo '';?>"><a href="report.php?title=report">Report</a></li>
						<!-- <li class="<?php if($title == 'logout') echo 'current'; else echo '';?>"><a href="logout.php?title=logout">Logout</a></li> -->
					</ul>
				</div><!-- end .span9 -->
			</div><!-- end .row -->         
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		</div><!-- end #header -->
<?php
		}
		else
		{
			?>
			<div id="header-top">
        <!-- /// HEADER-TOP  ///////////////////// -->
            
        </div><!-- end #header-top 
        <div id="header" style="top:30px;">-->
		 <div id="header" style="top:30px;">
        <!-- /// HEADER  ///////////////////////////// -->
			<div class="row">
				<div class="span4">
					<!-- // Logo // -->
					<a href="index.php" id="logo">
                    	<img class="responsive-img" src="_layout/images/logo.png" alt="">
                    </a>
				</div><!-- end .span3 -->
				<div class="span8">
					<!-- // Mobile menu trigger // -->
			    	<a href="#" id="mobile-menu-trigger"><i class="fa fa-bars"></i></a>
            		<!-- // Menu // -->
					<ul class="sf-menu fixed" id="menu">
						<!--<li class="dropdown current"><a href="index.php">Home</a></li>-->
                        <li class="dropdown"><a href="howitworks.php">How It Works</a></li>
                       <!-- <li class="dropdown"><a href="portfolio.php">Customers</a></li>
                        <li class="dropdown"><a href="blog.html">Blog</a></li>-->
						<!--<li><a href="signup.php">Sign Up</a></li>-->
                        <li><a href="login.php" class="btn" style="margin-top:20px; padding:25px 25px; color:white;">Sign In</a></li>
					</ul>
				</div><!-- end .span9 -->
			</div><!-- end .row -->
        </div><!-- end #header -->
			<?php
		}
?>