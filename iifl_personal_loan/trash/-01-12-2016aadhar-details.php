<?php require_once("includes/functions.php"); ?>
<?php session_start(); ?>
<?php
	$error = false;
	unset($_SESSION['customer']);
	if($_POST['loanAmount'] == '') {
		$error = true;
	}	else {
		if(!is_numeric(num_only($_POST['loanAmount']))) {
			$error = true;
		} else {
			$loan_amount = $_SESSION['personal_details']['appliedloanamt'] = num_only($_POST['loanAmount']);
		}
	}
	
	if($_POST['loanTenure'] == '') {
		$error = true;
	} else {
		if(!is_numeric(num_only($_POST['loanTenure']))) {
			$error = true;
		} else {
			$tenure = $_SESSION['personal_details']['tenure']	= num_only($_POST['loanTenure'])*12;
		}
	}
	
	if($_POST['emiVal'] == '') {
		$error = true;
	} else {
		if(!is_numeric(num_only($_POST['emiVal']))) {
			$error = true;
		} else {
			$emi = $_SESSION['personal_details']['actualloanEMI'] = num_only($_POST['emiVal']);
		}
	}
	
	if($error) { redirect_to('resetpage'); }
	
	$loan_tenure 			= $tenure/12;
	$company 					= xss_filter($_SESSION['personal_details']['companyname']);
	$salary 					= xss_filter($_SESSION['personal_details']['salary']);
	$obligation				= xss_filter($_SESSION['personal_details']['obligation']);	
	$crm_lead_id			= xss_filter($_SESSION['personal_details']['CRMLeadID']);
	$email 						= xss_filter($_SESSION['personal_details']['emailid']);
	$mobile_no 				= xss_filter($_SESSION['personal_details']['mobileno']);
	$city 						= xss_filter($_SESSION['personal_details']['city']);
	$max_loan_amt 		= xss_filter($_SESSION['personal_details']['maxloanamt']);
	$min_loan_amt 		= xss_filter($_SESSION['personal_details']['minloanamt']);
	$emi_difference		= xss_filter($_SESSION['personal_details']['emi_diff']);
	
	$processing_fee = ceil((xss_filter($_SESSION['personal_details']['processing_fee_actual']) * $loan_amount) / 100);
	
	$total_amount_payable = ceil((xss_filter($_SESSION['personal_details']['roi_actual']) / 100) * $loan_amount + ($loan_amount));
	$_SESSION['personal_details']['processing_fee'] 		= $processing_fee;
	$_SESSION['personal_details']['totalamountpayable'] = $total_amount_payable;
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
		
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
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script>
		<script src="js/function.js" type="text/javascript"></script>
		<script>
			$(function() {
				$("#termschk").click();
  $( "#SliderPoint3").draggable({
    containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"loan",<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');
					}
  });
  $( "#SliderPoint4").draggable({
    containment: "parent", axis: "x", drag: function(event, ui) {
      PointerFN(event.target.id,"years",1,<?php echo $loan_tenure; ?>,' Years');
    }
  });
  setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');
  setPoint('years','SliderPoint4',1,<?php echo $loan_tenure; ?>,' Years');	
			});
    
			function calbackEmi() {
				$("#emidiv").html(emical(str2int($("#loan").val()),str2int($("#years").val()),<?php echo $_SESSION['personal_details']['roi_actual']; ?>));
				$("#loanAmu").html($("#loan").val());
				$("#tenure").html($("#years").val());
				$("#totalAmu").html(str2int($("#emidiv").html())*str2int($("#years").val())*12);
			}
		</script>
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
<body class="bodyoverflow">
<div id="main-wrap"> 

<!-- AAdhar page pixel-->
<img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Aadhar-Card=<Aadhar-Card>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
<!--end Aadhar card pixel -->
  <!--popup-->
  <div class="overlay"></div>
  <div class="tnc-popup">
    <div class="tnc-popup-txt">
      <p><strong>Consent for Authentication</strong></p>
      <p>I hereby give my consent to India Infoline Finance Limited to obtain my Aadhaar number, Name and Fingerprint/ Iris for authentication with UIDAI. India Infoline Finance Limited has informed me that my identity information would only be used for Undertaking eKYC for my loan application and also informed that my biometrics will not be stored / shared and will be submitted to CIDR only for the purpose of authentication</p>
      <p class="tc"><a href="javascript://" class="closepop">OK</a></p>
      <div class="closeicon"><a href="javascript://" class="closepop"><img src="images/close-icon.png" class="scale"></a></div>
    </div>
  </div>
  <!--popup-->
  <header>
    <div class="header-inner knowmore">
      <div class="logo"><img src="images/logo.jpg" class="scale"></div>
      <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
      <div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
      <div class="clr"></div>
      <div class="card-container-outerinner">
  <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
  <div class="card-container1 effect__random card-container" data-id="1">
    <div class="card__front"> <img src="images/48hours.png" class="scale">
      <p class="pendulamtxt">Express<br>
  Personal<br>
  Loan</p>
    </div>
    <div class="card__back"><img src="images/48hours.png" class="scale">
     <p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>
    </div>
  </div>
      </div>
    </div>
  </header>
  <form id="form1" name="form1" method="post" action="" autocomplete="off">
    <div id="msform">
      <section class="body-home-outer myclass aadharbg">
  <div class="innerbody-home for-mob-height height-ipad-812 full-height" style="height:auto;"> 
    <div class="eligibleDetail">
      <div class="edTop">
  <div>Company Name<strong class="strongcom-inner"><?php echo $company; ?></strong></div>
  <div>Monthly Salary<strong class="strong-inner">
								<span class="rsmonthly">`</span><?php echo to_rupee($salary); ?></strong>
							</div>
  <div>Current EMI
								<strong class="strong-inner"><span class="rsmonthly rstotalemi">`</span><?php echo to_rupee($obligation); ?></strong>
							</div>
      </div>
      <div class="clr"></div>
    </div>
    <div id="updatehide"> 
      <div class="loan-detailbox">
  <div class="loan-details">Loan Details</div>
  <div class="loan-amount">Loan Amount -
								<span class="orange"><span class="disp-in-block"><b class="rupee-symb">`</b> <b id="loanAmu"><?php echo to_rupee($loan_amount); ?></b></span></span>
								<br>
    Loan Tenure -
								<span class="orange" id="tenure"><?php echo $loan_tenure; ?> Years</span>
							</div>
  <div class="loan-amount loanamout-small">Rate of Interest -
								<span class="orange"><?php echo $_SESSION['personal_details']['roi_actual']; ?>%</span>
								<br>
    Processing Fees -&nbsp;<span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span>
							</div>
  <div class="total-emi">EMI -
								<span class="orange">
									<span class="disp-in-block"><b class="rupee-symb">`</b>
									<b id="emidiv"><?php echo to_rupee($emi); ?></b></span>
								</span>
							</div>
  <div class="clr none"></div>
      </div>
      <div class="updateloadn-detailbox">
  <div class="edContant update-mar0">
    <aside class="update-mar1"> <span class="edcLine1 flnone loanamt-white-visible">Loan Amount</span>
      <div class="loandetail-relative">
        <div class="rsicon">`</div>
        <input type="text" class="edcLine2 flnone" value="<?php echo to_rupee($loan_amount); ?>" id="loan"  maxlength="8" onkeypress="return isNumberKey(event)" onChange="setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');">
      </div>
      <div class="edcRange flnone"><span class="edcRangeIcons" id="SliderPoint3"><img src="images/slider-icon-orange.png" class="scale"></span></div>
      <span class="edcRangeLeft"><b>`</b> <?php echo $_SESSION['personal_details']['minloanamt']; ?></span><span class="edcRangeRight"><b>`</b> <?php echo $_SESSION['personal_details']['maxloanamt']; ?></span> <span class="edcAdjust">Adjust the loan amount to an<br>
      EMI that suits you.. </span> </aside>
    <aside class="update-mar2"> <span class="edcLine1 flnone loanamt-white-visible">Loan tenure</span>
      <input type="text" class="edcLine2 flnone" value="<?php echo $loan_tenure; ?> Years" id="years"  maxlength="7" onkeypress="return isNumberKey(event)" onChange="setPoint('years','SliderPoint4',1,5,' Years');">
      <div class="edcRange flnone"><span class="edcRangeIcons" id="SliderPoint4"><img src="images/slider-icon-orange.png" class="scale"></span></div>
      <span class="edcRangeLeft">1 Years</span><span class="edcRangeRight">5 Years</span> <span class="edcAdjust">Adjust the loan tenure to an<br>
      EMI that suits you.. </span> </aside>
    <aside class="updateside">
      <div class="updatebox">
        <input type="submit" name="button" id="button" value="UPDATE" class="updatebtn" />
      </div>
    </aside>
  </div>
      </div>
    </div>
    <div class="approval-wrap">
      <div class="approval-leftpoints">
  <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>EMI Quote</div>
  <div class="lefticons-line"></div>
  <div class="emi-quoteicon"><img src="images/detailicon-big.png" class="scale"><br>My Details</div>
  <div class="lefticons-line"></div>
  <div class="emi-quoteicon"><img src="images/eligible-icon-fade.png" class="scale"><br>
    Eligibility</div>
  <div class="lefticons-line"></div>
  <div class="emi-quoteicon lasticon"><img src="images/document-icon-fade.png" class="scale"><br>
    Documents</div>
  <div class="clr"></div>
      </div>
      <div class="approval-right-container">
  <div class="aadhar-wrap">
    <div class="aadhar-heading aadhar-heading-font">Auto-fill your application using your Aadhar number<sup><span class="red1">*</span></sup>. <br>
      </div>
    <div class="companyname sceeen4form">
    <!-- <span style="color:#D44242">eKYC services will not be available till 11th Nov 2016</span> <br></br> -->
      <label class="input"><span>Aadhaar Number</span>
        <input type="text" onkeypress="return isNumberKey(event)" maxlength="12"/>
										<input type="hidden" id="theOtp" value=""/>
      </label>
    </div>
    <div class="aadharbtn">
      <input type="button" id="aadharNo" value="Get OTP" class="aadharsubmit" name="noAadharSbmit" onClick="ga('send', 'event', 'Personal Loan', 'Get-OTP-Click', 'Yes-Aadhar');">
    </div>
    <div class="companyname sceeen4form dnone">
      <label class="input"> <span>Enter OTP</span>
        <input type="text" maxlength="6" id="OTP" onkeypress="return isNumberKey(event)"/>
      </label>
    </div>
    <div class="aadharbtn dnone">
      <input type="button" id="verifyOTP" maxlength="12" value="CONFIRM" class="aadharsubmit verifyOTP" onClick="ga('send', 'event', 'Personal Loan', 'Confirm-OTP-Click', 'Confirm-Aadhar');"/>
      <a href="javascript:;" class="text-link resendOtp"> Resend OTP</a>
								</div>
    <div class="aadhar-tcbox dnone dnonenew authentication-line authentication-linerev">
      <div class="edBottomTerms2">
        <div class="edBottomCheckbox2">
    <input type="checkbox" id="termschk" name=""/>
    <label for="termschk"></label>
        </div>
        <p><a href="javascript:;" class="tnc-btn"> I hereby give my consent to IIFL to do EKYC through Aadhar authentication</a></p>
        <div class="clr"></div>
      </div>
    </div>
    <div class="dontremember">Proceed without Aadhar number.</div>
    <div class="aadharbtn">
      <input type="button" id="noAadharSbmit" value="CLICK HERE" class="aadharsubmit" onClick="ga('send', 'event', 'Personal Loan', 'Click-Here', 'No-Aadhar');" name="noAadharSbmit"/>
    </div>
  </div>
      </div>
      <div class="clr"></div>
    </div>
    <!--approval wrap-->
    <div class="screen05img pos-abs"> <img src="images/homescreen-05img.png" class="scale">
      <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
      <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
    </div>
  </div>
      </section>
    </div>
  </form>
  <script src="js/cards1.js" type="text/javascript"></script>
  <?php require_once('includes/footer.php'); ?>
