<?php require_once("includes/functions.php"); ?>
<?php session_start(); ?>
<?php
	$revised_tenure = xss_filter($_SESSION['CIBIL']['revised_Tenure'])/12;
	$interest 			= xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
	$emi 						= ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $_SESSION['CIBIL']['revised_Tenure']) / (1 - pow((1 + $interest), $_SESSION['CIBIL']['revised_Tenure'])));
?>
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
	<body class="bodyoverflow congratesbg">
		<div id="main-wrap"> 
			<header>
				<div class="header-inner knowmore">
					<div class="logo"><img src="images/logo.jpg" class="scale"></div>
					<div class="personal-loan"><img src="images/personal.png" class="scale"></div>
					<div class="headerRefID">Application Reference No: <strong><?php echo xss_filter($_SESSION['personal_details']['CRMLeadID']); ?></strong></div>
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
									<div class="congratesimg"><img src="images/congratesimg.png" class="scale blink-image"></div>
									<div class="congrates-loanamount">Your Personal Loan of
										<span><b>`</b><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></span> is approved in principle
									</div>
									<div class="loandetail-congrates">
										<div class="congrates-percent">Rate of Interest &nbsp;- &nbsp;
											<span><?php echo $_SESSION['CIBIL']['revised_ROI']; ?>%</span>
										</div>
										<div class="congrates-percent">Processing Fees &nbsp;- &nbsp;
											<span><b>`</b> <?php echo to_rupee($_SESSION['personal_details']['processing_fee']); ?></span>
										</div>
										<div class="congrates-percent">EMI &nbsp;- &nbsp;
											<span><b>`</b> <?php echo to_rupee($emi); ?></span>
										</div>
										<div class="congrates-percent">Loan Tenure &nbsp;- &nbsp;
											<span><?php echo $_SESSION['personal_details']['tenure']/12; ?> Years</span>
										</div>
										<div class="clr"></div>
									</div>
									<div class="congrates-copy">To help us process your loan application faster click on Next to upload your documents.</div>
									<div class="next-home tc">
										<a class="upload-document" href="upload-document" onClick="ga('send', 'event', 'Personal Loan', 'Next-Click Upload Document', 'AIP - accept');">NEXT
											<img class="scale nxtarrow" src="images/arrownext.png">
										</a>
									</div>
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


