<?php require_once("includes/functions.php"); ?>
<?php session_start(); ?>
<?php
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
	$crm_lead_id 		= xss_filter($_SESSION['personal_details']['CRMLeadID']);
	$loan_tenure 		= xss_filter($_SESSION['personal_details']['tenure'])/12;
	$processing_fee = ceil(xss_filter($_SESSION['personal_details']['appliedloanamt']) * xss_filter(($_SESSION['personal_details']['processing_fee_actual'])/100));
	$interest 			= xss_filter($_SESSION['personal_details']['roi_actual']) / 1200;
	$emi 						= ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $_SESSION['personal_details']['tenure']) / (1 - pow((1 + $interest), $_SESSION['personal_details']['tenure'])));
	$msg = '';
	if(isset($_POST['submit'])) {
		$otp = xss_filter($_POST['manualOTP']);
		if(isset($_SESSION['currChk'])) {
			$_SESSION['personal_details']['curr_state_code']			= 	$_SESSION['personal_details']['perm_state_code'];
			$_SESSION['personal_details']['curr_city_code']				= 	$_SESSION['personal_details']['perm_city_code'];
			unset($_SESSION['currChk']);
		}
		
		if(is_numeric($otp)) {
		
			$service_url = COMMON_API. 'VerifyOTP';
			$headers = array (
				"Content-Type: application/json"
			);
			$curl_post_data = array(
				"CRMLeadID"	=> $crm_lead_id,
				"OTP"				=> $otp
			);
			$decodeddata = json_encode($curl_post_data);
			$handle = curl_init(); 
			curl_setopt($handle, CURLOPT_URL, $service_url);
			curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
		
			$curl_response = curl_exec($handle);
			curl_close($handle);
			$json = json_decode($curl_response);
	
			if($json->Status == 'Y') {
				
				$temp = explode('-', $_SESSION['personal_details']['dob']);
				$birth_date = $temp[2].$temp[1].$temp[0];
				
				$service_url = API. 'ApplyLoan';
				$headers = array (
					"Content-Type: application/json"
				);
				$curl_post_data = array(
					"CRMLeadID"						=> 	xss_filter($crm_lead_id),
					"ApplicantType"				=> 	xss_filter("Applicant"),
					"CompanyName"					=> 	xss_filter($_SESSION['personal_details']['companyname']),
					"OtherCompanyName"		=> 	"",
					"Domain"							=> 	"",
					"MonthlySalary"				=> 	xss_filter($_SESSION['personal_details']['salary']),
					"MonthlyObligation"		=> 	xss_filter($_SESSION['personal_details']['obligation']),
					"PersonalEmailID"			=> 	xss_filter($_SESSION['personal_details']['emailid']),
					"MobileNo"						=> 	xss_filter($_SESSION['personal_details']['mobileno']),
					"AlternateMobileNo"		=> 	xss_filter($_SESSION['personal_details']['alternatemobileno']),
					"AadhaarNumber"				=> 	'', 
					"FName"								=> 	xss_filter($_SESSION['personal_details']['applicantname']),
					"MName"								=> 	xss_filter($_SESSION['personal_details']['middlename']),
					"LName"								=> 	xss_filter($_SESSION['personal_details']['lastname']),
					"Gender"							=> 	xss_filter($_SESSION['personal_details']['gender']),
					"PAN"									=> 	xss_filter($_SESSION['personal_details']['panno']),
					"CurrentWorkExp"			=> 	xss_filter($_SESSION['personal_details']['workexperiance']),
					"TotalWorkExp"				=> 	xss_filter($_SESSION['personal_details']['totworkexperiance']),
					"DOB"									=> 	$birth_date,
					"PermanentAddress1"		=> 	xss_filter($_SESSION['personal_details']['permanentaddress1']),
					"PermanentAddress2"		=> 	xss_filter($_SESSION['personal_details']['permanentaddress2']),
					"PermanentAddress3"		=> 	xss_filter($_SESSION['personal_details']['permanentaddress3']),
					"PermanentState"			=> 	xss_filter($_SESSION['personal_details']['perm_state_code']),
					"PermanentCity"				=> 	xss_filter($_SESSION['personal_details']['perm_city_code']),
					"PermanentPin"				=> 	xss_filter($_SESSION['personal_details']['permanentpincode']),
					"CurrentAddress1"			=> 	xss_filter($_SESSION['personal_details']['currentaddress1']),
					"CurrentAddress2"			=> 	xss_filter($_SESSION['personal_details']['currentaddress2']),
					"CurrentAddress3"			=> 	xss_filter($_SESSION['personal_details']['currentaddress3']),
					"CurrentState"				=> 	xss_filter($_SESSION['personal_details']['curr_state_code']),
					"CurrentCity"					=> 	xss_filter($_SESSION['personal_details']['curr_city_code']),
					"CurrentPin"					=> 	xss_filter($_SESSION['personal_details']['currentpincode']),
					"KYCFlag"							=> 	xss_filter($_SESSION['personal_details']['kycflag']),
					"AppliedLoanamount"		=> 	xss_filter($_SESSION['personal_details']['appliedloanamt']),
					"ROI"									=>	xss_filter($_SESSION['personal_details']['roi_actual']),
					"Tenure"							=>	xss_filter($_SESSION['personal_details']['tenure']),
					"Processingfee"				=>	str_replace(',', '', $_SESSION['personal_details']['processing_fee']),
					"Emi"									=>	xss_filter($_SESSION['personal_details']['actualloanEMI']),
					"TotalPayableAmount"	=>	xss_filter($_SESSION['personal_details']['totalamountpayable']),
					"PageNumber"					=>	2
				);
				
				$decodeddata = json_encode($curl_post_data);
				//echo '<pre>'; echo print_r($curl_post_data); echo '</pre>'; exit;
	
				//echo '<pre>'; echo print_r($curl_post_data); echo '</pre>';
				$_SESSION['request'] = $decodeddata;
				$handle = curl_init(); 
				curl_setopt($handle, CURLOPT_URL, $service_url);
				curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
				
				$curl_response = curl_exec($handle);
				curl_close($handle);
				$_SESSION['request'] 	= $curl_post_data;
				$_SESSION['response'] = $curl_response;
				//echo '<pre>'; echo print_r($curl_response); echo '</pre>'; exit;
				$json = json_decode($curl_response);
				
				$json2 = array();
				$json2 = json_decode($json, true);
				if(strtolower($json2[0]['Status']) == 'success') {
					$_SESSION['personal_details']['ProspectNumber'] = xss_filter($json2[0]['ProspectNumber']);
					//$_SESSION['personal_details']['ProspectNumber'] = $json2[0]['ProspectNumber'];
					if($json2[0]['CibilResponse'] == '0-Yes') {
						redirect_to('aip-info');
					} elseif($json2[0]['CibilResponse'] == '1-N0') {
						redirect_to('declined');
					}	elseif($json2[0]['CibilResponse'] == '2-Null') {
						redirect_to('aip-info');
					} else {
						redirect_to('declined');
					}
				}	else {
					redirect_to('declined');
				}
			} else {
				$msg = $json->ErrMsg;
			}
		}	else {
			$msg = 'Invalid OTP';
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
		<script src="js/function.js" type="text/javascript"></script>
		<script>
			$(function() {
				if ($("#error-user").html() != '') {
					$("#error-user").show();
				}
			});
		</script>
		

	</head>
<body class="bodyoverflow">
<div id="main-wrap"> 
  <!--popup-->

  <header>
    <div class="header-inner knowmore">
      <div class="logo"><img src="images/logo.jpg" class="scale"></div>
      <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
      <div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
      <div class="clr"></div>
      <div class="card-container-outerinner">
  <div class="pendulamline-inner"><img src="images/pendulamline.png" class="scale"></div>
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
	<form method="POST" action="manual-verification">
    <div id="msform">
      <section class="body-home-outer myclass aadharbg">
  <div class="innerbody-home manualvarification" style="height:auto"> 
    <div class="eligibleDetail">
      <div class="edTop">
  <div>Company Name<strong class="strongcom-inner"><?php echo $_SESSION['personal_details']['companyname']; ?></strong></div>
  <div>Monthly Salary<strong class="strong-inner">
								<span class="rsmonthly">`</span><?php echo to_rupee($_SESSION['personal_details']['salary']); ?></strong>
							</div>
  <div>Current EMI
								<strong class="strong-inner"><span class="rsmonthly rstotalemi">`</span><?php echo to_rupee($_SESSION['personal_details']['obligation']); ?></strong>
							</div>
      </div>
      <div class="clr"></div>
    </div>
    <div id="updatehide"> 
      <div class="loan-detailbox">
  <div class="loan-details">Loan Details</div>
  <div class="loan-amount">Loan Amount -
								<span class="orange"><b class="rupee-symb">`</b> <b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b></span><br>
    Loan Tenure - <span class="orange" id="tenure"><?php echo $loan_tenure; ?> Years</span>
							</div>
  <div class="loan-amount loanamout-small">Rate of Interest -
								<span class="orange"><?php echo $_SESSION['personal_details']['roi_actual']; ?>%</span><br>
    Processing Fees - <span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span>
							</div>
  <div class="total-emi">EMI -
								<span class="orange"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b></span>
							</div>
  <div class="clr none"></div>
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
    <div class="aadhar-heading aadhar-heading-font">Mobile Number Verification<sup><span class="red1">*</span></sup>. <br>
      </div>
								<div class="companyname sceeen4form manual">
      <label class="input"> <span style="<?php echo !empty($msg)?'visibility:hidden':''; ?>">Enter OTP</span>
        <input type="text" id="manualOTP" name="manualOTP" onkeypress="return isNumberKey(event)" value="<?php echo !empty($msg)?$otp:''; ?>" maxlength="6" />
										<?php if(!empty($msg)): ?><div id="error-user"><?php echo $msg; ?></div><?php endif; ?>
										<div class="dnone"><?php echo $_SESSION['manual']['otp']; ?></div>
      </label>
									<div class="aadharbtn">
      <input type="submit" name="submit" id="verifyManMobNo" onClick="ga('send', 'event', 'Personal Loan', 'Verify-OTP-Click', 'Manual-OTP');" value="Verify OTP" class="">
									<a href="javascript:;" class="text-link resendManOtp"> Resend OTP</a>
									</div>
    </div>
								
								
    
  </div>
      </div>
      <div class="clr"></div>
    </div>
    <!--approval wrap-->
    <div class="screen05img"> <img src="images/homescreen-05img.png" class="scale">
      <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
      <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
    </div>
  </div>
      </section>
    </div>
	</form>
  <script src="js/cards1.js" type="text/javascript"></script>
  <?php require_once('includes/footer.php'); ?>
