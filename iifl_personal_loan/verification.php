<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php if(!isset($_SESSION['personal_details'])) { redirect_to(HOME); } ?>
<?php
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
	$interest 			= xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
	$tenure 				= $_SESSION['personal_details']['tenure'];
	$emi 						= ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $tenure) / (1 - pow((1 + $interest), $tenure)));
	$processing_fee = ceil(($_SESSION['CIBIL']['revised_ProcessingFee']/100) * $_SESSION['personal_details']['appliedloanamt']);
	
	$service_url = PERFIOS_API. 'StartApi_Response';
	$headers = array ("Content-Type: application/json");
	
	
	if(isset($_GET['q'])) {
		$temp = explode('_', $_GET['q']);
		$transaction_id = $temp[0];
		if($temp[1] == 'true') {
			$status = 'Success';
		} else {
			$status = 'Failed';
		}
		//if($_SESSION['perfios']['transaction_id'] == $transaction_id && $status == 'Success') {
			$curl_post_data = array(
				"TransactionId"			=> $transaction_id,
				"TransactionStatus" => $status,
				"PageNo"						=> "16"
			);
			$decodeddata = json_encode($curl_post_data);
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $service_url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $decodeddata);
			$curl_response = json_decode(json_decode(curl_exec($ch)));
			curl_close($ch);
			//echo '<pre>'; print_r($curl_response); echo '</pre>'; exit;
			if($curl_response[0]->Status == 'Updated Successfully') {
				if(isset($_SESSION['co_applicant_details']['ProspectNumber'])) {
					$url = HOME. '/co-applicant-upload-financial-document';	
				} else {
					$url = HOME. '/workplace-verification';	
				}
			} 
			
		//} 
		
	} else {
		if(isset($_SESSION['perfios']['status'])) {
			$status = $_SESSION['perfios']['status'];
			$transaction_id = $_SESSION['perfios']['transaction_id'];
			if($status == 'Failed') {
				if(isset($_SESSION['co_applicant_details']['ProspectNumber'])) {
					$url = HOME. '/co-applicant-upload-financial-document';	
				} else {
					$url = HOME. '/upload-financial-document';	
				}
			} else {
				if(isset($_SESSION['co_applicant_details']['ProspectNumber'])) {
					$url = HOME. '/co-applicant-upload-financial-document';	
				} else {
					$url = HOME. '/workplace-verification';	
				}
			}
		} else {
			redirect_to(HOME);
		}
		
	}
		
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
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script>
		<script src="js/jquery.form.js" type="text/javascript"></script>
		<script src="js/function.js" type="text/javascript"></script>
		<script src="js/design18.js" type="text/javascript"></script>

		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
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

	<body class="bodyoverflow	">
		<!-- Upload Document Pixel --> 
		<img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Documents-Page=<Documents-Page>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/> 
		<!-- End Uplaod Document Pixel -->
		<div class="dnone">
			<pre>Request data <br><?php print_r($_SESSION['request']); ?>Response data <br><?php print_r($_SESSION['response']); ?></pre>
		</div>
		<div id="main-wrap"><!--mainwrap-->
			<header>
				<div class="header-inner knowmore"><!--header-->
					<div class="logo"><img src="images/logo.jpg" class="scale"></div>
					<div class="personal-loan"><img src="images/personal.png" class="scale"></div>
					<div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
					<div class="clr"></div>
					<div class="card-container-outerinner">
						<div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
						<div class="card-container1 effect__random card-container" data-id="1">
							<div class="card__front"> <img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">Express<br>Personal<br>Loan</p>
							</div>
							<div class="card__back"><img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">DISBURSAL<br>IN<br>8 HOURS* <br/><small> T&C Apply</small></p>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div id="msform">
				<section class="body-home-outer myclass screen04bg">
					<div class="innerbody-home ipadheight-auto" style="height:auto">
						<div class="eligibleDetail">
							<div class="edTop">
								<div>Company Name <strong class="strongcom-inner">
									<input type="text" name="textfield" id="textfield" class="companyname-changetop" value="<?php echo xss_filter($_SESSION['personal_details']['companyname']); ?>" disabled />
									</strong>
								</div>
								<div>Monthly Salary <strong class="strong-inner"> <span class="rsmonthly">`</span>
									<input type="text" name="textfield" id="texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['salary']); ?>" disabled />
									</strong>
								</div>
								<div>Current EMI <strong class="strong-inner"> <span class="rsmonthly rstotalemi">`</span>
									<input type="text" name="textfield" id="texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['obligation']); ?>" disabled />
									</strong>
								</div>
							</div>
							<div class="clr"></div>
						</div>
						<div id="updatehide">
							<div class="loan-detailbox">
								<div class="loan-details">Loan Details</div>
								<div class="loan-amount">
									Loan Amount -
									<span class="orange">
										<b class="rupee-symb">`</b>
										<b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b>
									</span> <br>
									Loan Tenure -
									<span class="orange" id="tenure"><?php echo $_SESSION['personal_details']['tenure']/12; ?> Years</span> </div>
									<div class="loan-amount loanamout-small">
										Rate of Interest -
										<span class="orange"><?php echo $_SESSION['CIBIL']['revised_ROI']; ?>%</span> <br>
										Processing Fees -
										<span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span>
									</div>
									<div class="total-emi">
										EMI - <span class="orange"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b></span>
									</div>
								<div class="clr none"></div>
							</div>
						</div>
						<div class="approval-wrap">
							<div class="approval-leftpoints">
								<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>EMI Quote</div>
								<div class="lefticons-line"></div>
								<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>My Details</div>
								<div class="lefticons-line"></div>
								<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>Eligibility</div>
								<div class="lefticons-line"></div>
								<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>Non-Financial Documents</div>
								<div class="lefticons-line"></div>
								<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>Financial Documents</div>
								<div class="lefticons-line"></div>
								<div class="emi-quoteicon lasticon"><img src="images/verify-blue.png" class="scale"><br>Verification</div>
								<div class="clr"></div>
							</div>
							<div class="approval-right-container Verify">
								<div class="design18">
									<div class="design18Head">Verifications</div>
									<div class="verifyWrap">
										<div class="loandetail-congrates">
											<div class="congrates-percent transWidth">Transaction ID&nbsp;- <span><?php echo $transaction_id; ?> </span> </div>
											<div class="congrates-percent bn">Bank Name &nbsp;- <span><?php echo $_SESSION['perfios']['bank_name']; ?></span> </div>
											<div class="congrates-percent status">Status &nbsp;- <span><?php echo $status; ?></span> </div>
											<div class="clr"></div>
										</div>
									</div>
									<div class="clr"></div>
									<form action="verification" method="post">
										<div class="verifymainsubmit">
											<input type="hidden" name="tranId" value="<?php echo isset($transaction_id)?$transaction_id:''; ?>">
											<input type="hidden" name="status" value="<?php echo isset($status)?$status:''; ?>">
											<a href="<?php echo $url; ?>" id="button" class="homesubmit" />Proceed</a>
											<a href="<?php echo HOME; ?>/upload-financial-document" class="homesubmit">Add Another Bank</a>
										</div>
									</form>
								</div>
							</div>
							<div class="clr"></div>
						</div>
						<div class="screen05img"> <img src="images/homescreen-05img.png" class="scale">
							<div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
							<div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<script src="js/cards1.js" type="text/javascript"></script>
		<script>
			$(function() {
				$(document).on('click', '.homesubmit', function() {
					window.location = 'workplace-verification';
				});
			});			
		</script>
	</body>
</html>
