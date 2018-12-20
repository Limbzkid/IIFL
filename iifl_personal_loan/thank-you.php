<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php if(!isset($_SESSION['personal_details'])) { redirect_to(HOME); } ?>
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
		<!-- Start Google Analytics Code -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
			ga('create', 'UA-690673-17', 'auto');
			ga('send', 'pageview');
		</script>
		<!-- End Google Analytics Code -->
		<!-- Start Facebook Pixel Code -->
		<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,'script','https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '1789326097974863');
			fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1789326097974863&ev=PageView&noscript=1"/>
		</noscript>
		<!-- DO NOT MODIFY -->
		<!-- End Facebook Pixel Code -->
	</head>
	<body class="bodyoverflow congratesbg" onLoad="form1.reset();">
	<!-- Final Conversion Pixel -->
	<img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Final-Conversion=<Final-Conversion>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
	<!-- END Final Conversion Pixel -->
	
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
						<div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
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


