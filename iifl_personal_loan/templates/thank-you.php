<?php require_once("includes/functions.php"); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
		<title>IIFL : Sapna Aapka, Loan Hamara</title>
		<link rel="shortcut icon" href="images/favicon.ico">
		<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script>
	</head>
	<body class="bodyoverflow congratesbg" onLoad="form1.reset();">
		<div class="dnone">
			<pre>
				<?php
					if(isset($_SESSION['disburse']['request'])) {
						print_r($_SESSION['disburse']['request']);
					}
					
					if(isset($_SESSION['disburse']['response'])) {
						print_r($_SESSION['disburse']['response']);
					}
					
					if(isset($_SESSION['office_details']['request'])) {
						print_r($_SESSION['office_details']['request']);
					}
					
					if(isset($_SESSION['office_details']['response'])) {
						print_r($_SESSION['office_details']['response']);
					}
			
				?>
			</pre>
		</div>
		<div id="main-wrap"> 
			<header>
				<div class="header-inner knowmore">
					<div class="logo"><img src="images/logo.jpg" class="scale"></div>
					<div class="personal-loan"><img src="images/personal.png" class="scale"></div>
					<div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
					<div class="clr"></div>
					<div class="card-container-outerinner">
						<div class="pendulamline-inner"><img src="images/pendulamline.png" class="scale"></div>
						<div class="card-container1 effect__random card-container" data-id="1">
							<div class="card__front">
								<img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">Express<br>Personal<br>Loan</p>
							</div>
							<div class="card__back">
								<img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div id="msform">
				<section class="body-home-outer myclass congratesbg">
					<div class="innerbody-home" style="height:auto">     
						<div class="approval-wrap congrates-padd">
							<div class="congrates-rightwrap">
								<div class="congrates-wrap">
									<div class="congratesimg">&nbsp;</div>
									<div class="congratesimg">&nbsp;</div>
									<div class="congratesimg">&nbsp;</div>
									<div class="congrates-loanamount thankspage">Thank You ! <br> Your application is under process our representative will get in touch with to you shortly.</div>
										<div class="congrates-copy">To learn more about IIFL Express Personal Loan <a href="javascript:;">Click here</a></div>
								</div>
							</div>     
							<div class="clr"></div>
						</div> 
					</div>
				</section>
			</div>
		</div>
		<script src="js/cards1.js" type="text/javascript"></script> 
	</body>
</html>


