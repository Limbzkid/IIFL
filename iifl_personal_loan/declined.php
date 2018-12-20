<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php //print_r($_SESSION['errors']); ?>


<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]--> 
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
		<title>IIFL : Sapna Aapka, Loan Hamara</title>
		<link rel="shortcut icon" href="images/favicon.ico">
		<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script> 
		<script src="js/function.js" type="text/javascript"></script>
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

<body class="bodyoverflow" onLoad="form1.reset();">
<!-- Loan Declined Pixel -->
<img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_loan_declined=<loan_declined>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
<!-- End Loan Declined Pixel -->

	<div class="dnone">
		ERROR MSG: <?php echo $_SESSION['error_msg']; ?>
		<pre>
			Request data <br>
			<?php print_r($_SESSION['request']); ?>
			Response data <br>
			<?php print_r($_SESSION['response']); ?>
		</pre>
	</div>
<form id="form1" name="form1" method="post" action="your-quote">
  <!--mainwrap-->
  <div id="main-wrap"> 
    <!--header-->
		<div class="overlay"></div>
  <div class="tnc-popup">
    <div class="tnc-popup-txt">
      <p><strong>TERMS AND CONDITIONS</strong></p>
      <p>1.	I hereby declare that every information already provided by me or as may be provided hereinafter are true and updated. I have not withheld or modified any part of such information. </p>
      <p>2.	I agree that the right to grant any credit facility lies with IIFL at its sole discretion and IIFL holds the right to reject my application at any time. I agree that IIFL shall not be responsible for any such rejection or any delay in intimating its decision.</p>
      <p>3.	I agree and accept that IIFL may in its sole discretion, by itself or through authorised persons, advocate, agencies, bureau, etc. verify any information given, check credit references, employment details and obtain credit reports or other KYC related documents. </p>
      <p>4.	I hereby authorize IIFL to exchange, share or part with all the information as provided by me or as may be provided by me with any of the group companies, banks, financial institutions, credit bureaus, statutory bodies or any entity as may required from time to time as deem fit by IIFL. I shall not hold IIFL liable for sharing any such information.</p>
      <p>5.	I hereby undertake to immediately inform IIFL regarding any change in information provided to IIFL by me.</p>
      <p>6.	I would like to know through telephonic calls/SMSs on my mobile number mentioned in this application form or through any other communication mode, various loan schemes, promotional offers of IIFL and I authorise IIFL, its employees or its agents to act accordingly. I confirm that laws in relations to the unsolicited communications referred in ‘National Do Not Call Registry’ as laid down by Telecom Regulatory Authority of India shall not be applicable to such communications/ telephonic calls/SMSs received from IIFL, its employees or its agents</p>
      <p class="tc"><a href="javascript://" class="closepop">OK</a></p>
      <div class="closeicon"><a href="javascript://" class="closepop"><img src="images/close-icon.png" class="scale"></a></div>
    </div>
  </div>
    <header>
      <div class="header-inner knowmore">
  <div class="logo"><img src="images/logo.jpg" class="scale"></div>
  <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
  <div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
  <div class="clr"></div>
  <div class="card-container-outerinner">
      <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
      <div class="card-container1 effect__random card-container" data-id="1">
  <div class="card__front"> <img src="images/48hours.png" class="scale"><p class="pendulamtxt">Express<br>Personal<br>Loan</p> </div>
  <div class="card__back"><img src="images/48hours.png" class="scale"><p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p></div>
      </div>
    </div>
      </div>
    </header>
    <!--header--> 
    <!--body home-->
    <div id="msform">
      <section class="body-home-outer myclass screen05bg">
  <div class="innerbody-home heightdesign2">
    <div class="eligibleDetail"><!-- eligibleDetail part start -->
						
      <div class="edNav thankspage">
							<strong> We are unable to process your Loan Application No <?php echo $_SESSION['personal_details']['CRMLeadID']; ?> as it doesn't meet IIFL Policy criteria. <br>
								Thank you for considering IIFL!
							</strong>
						</div>
						<div class="clr"></div>
      <!-- eligibleDetail part close -->
					</div>
    <!-- <div class="screen05img"> <img src="images/homescreen-05img.png" class="scale">
      <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
      <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
    </div> -->
  </div>
      </section>
    </div>
    <!--body home--> 
    
  </div>
  <!--mainwrap-->
</form>
<script src="js/cards1.js" type="text/javascript"></script> 
</body>