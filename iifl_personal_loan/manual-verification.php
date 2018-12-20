<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php if(!isset($_SESSION['personal_details'])) { redirect_to(HOME); } ?>
<?php
	//echo "<pre>"; print_r($_SESSION); exit;
	$crm_lead_id 		= xss_filter($_SESSION['personal_details']['CRMLeadID']);
	$loan_tenure 		= xss_filter($_SESSION['personal_details']['tenure'])/12;
	$processing_fee = ceil(xss_filter($_SESSION['personal_details']['appliedloanamt']) * xss_filter(($_SESSION['personal_details']['processing_fee_actual'])/100));
	$interest 			= xss_filter($_SESSION['personal_details']['roi_actual']) / 1200;
	$emi 						= ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $_SESSION['personal_details']['tenure']) / (1 - pow((1 + $interest), $_SESSION['personal_details']['tenure'])));
	$msg 						= '';
	if(isset($_POST['submit'])) {
		$otp = xss_filter($_POST['manualOTP']);
		if(isset($_SESSION['currChk'])) {
			$_SESSION['personal_details']['curr_state_code'] = 	$_SESSION['personal_details']['perm_state_code'];
			$_SESSION['personal_details']['curr_city_code']	 = 	$_SESSION['personal_details']['perm_city_code'];
			unset($_SESSION['currChk']);
		}
		
		if(is_numeric($otp)) {		
			$service_url = COMMON_API. 'VerifyOTP';
			$headers = array (
				"Content-Type: application/json"
			);
			$curl_post_data = array(
				"CRMLeadID"	=> $crm_lead_id,
				"OTP"		=> $otp
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
			
			//echo '<pre>'; print_r($json); echo '</pre>'; exit;
	
			if($json->Status == 'Y') {
				if(!isset($_SESSION['co_applicant_details'])) {
					$temp = explode('-', $_SESSION['personal_details']['dob']);
					$birth_date = $temp[2].$temp[1].$temp[0];
					$alternateMobileno = '';
					if($_SESSION['personal_details']['alternatemobileno']){
						$alternateMobileno = $_SESSION['personal_details']['alternatemobileno'];
					}
					$middleName = '';
					if(isset($_SESSION['personal_details']['middlename'])){
						$middleName = $_SESSION['personal_details']['middlename'];
					}
					$permAdd2 = '';
					if(isset($_SESSION['personal_details']['permanentaddress2'])){
						$permAdd2 = $_SESSION['personal_details']['permanentaddress2'];
					}
					$permAdd3 = '';
					if(isset($_SESSION['personal_details']['permanentaddress3'])){
						$permAdd3 = $_SESSION['personal_details']['permanentaddress3'];
					}
					$currAdd2 = '';
					if(isset($_SESSION['personal_details']['currentaddress2'])){
						$currAdd2 = $_SESSION['personal_details']['currentaddress2'];
					}
					$currAdd3 = '';
					if(isset($_SESSION['personal_details']['currentaddress3'])){
						$currAdd3 = $_SESSION['personal_details']['currentaddress3'];
					}

					$service_url = API. 'ApplyLoan';
					$headers = array (
						"Content-Type: application/json"
					);
					$curl_post_data = array(
						"CRMLeadID"					=> 	xss_filter($crm_lead_id),
						"ApplicantType"			=> 	xss_filter("Applicant"),
						"CompanyName"				=> 	xss_filter($_SESSION['personal_details']['companyname']),
						"OtherCompanyName"	=> 	"",
						"Domain"						=> 	"",
						"MonthlySalary"			=> 	xss_filter($_SESSION['personal_details']['salary']),
						"MonthlyObligation"	=> 	xss_filter($_SESSION['personal_details']['obligation']),
						"PersonalEmailID"		=> 	xss_filter($_SESSION['personal_details']['emailid']),
						"MobileNo"					=> 	xss_filter($_SESSION['personal_details']['mobileno']),
						"AlternateMobileNo"	=> 	xss_filter($alternateMobileno),
						"AadhaarNumber"			=> 	'', 
						"FName"							=> 	xss_filter($_SESSION['personal_details']['applicantname']),
						"MName"							=> 	xss_filter($middleName),
						"LName"							=> 	xss_filter($_SESSION['personal_details']['lastname']),
						"Gender"						=> 	xss_filter($_SESSION['personal_details']['gender']),
						"PAN"								=> 	xss_filter($_SESSION['personal_details']['panno']),
						"CurrentWorkExp"		=> 	xss_filter($_SESSION['personal_details']['workexperiance']),
						"TotalWorkExp"			=> 	xss_filter($_SESSION['personal_details']['totworkexperiance']),
						"DOB"								=> 	$birth_date,
						"PermanentAddress1"	=> 	xss_filter($_SESSION['personal_details']['permanentaddress1']),
						"PermanentAddress2"	=> 	xss_filter($permAdd2),
						"PermanentAddress3"	=> 	xss_filter($permAdd3),
						"PermanentState"		=> 	xss_filter($_SESSION['personal_details']['perm_state_code']),
						"PermanentCity"			=> 	xss_filter($_SESSION['personal_details']['perm_city_code']),
						"PermanentPin"			=> 	xss_filter($_SESSION['personal_details']['permanentpincode']),
						"CurrentAddress1"		=> 	xss_filter($_SESSION['personal_details']['currentaddress1']),
						"CurrentAddress2"		=> 	xss_filter($currAdd2),
						"CurrentAddress3"		=> 	xss_filter($currAdd3),
						"CurrentState"			=> 	xss_filter($_SESSION['personal_details']['curr_state_code']),
						"CurrentCity"				=> 	xss_filter($_SESSION['personal_details']['curr_city_code']),
						"CurrentPin"				=> 	xss_filter($_SESSION['personal_details']['currentpincode']),
						"KYCFlag"						=> 	xss_filter($_SESSION['personal_details']['kycflag']),
						"AppliedLoanamount"	=> 	xss_filter($_SESSION['personal_details']['appliedloanamt']),
						"ROI"								=>	xss_filter($_SESSION['personal_details']['roi_actual']),
						"Tenure"						=>	xss_filter($_SESSION['personal_details']['tenure']),
						"Processingfee"			=>	str_replace(',', '', $_SESSION['personal_details']['processing_fee']),
						"Emi"								=>	xss_filter($_SESSION['personal_details']['actualloanEMI']),
						"TotalPayableAmount"=>	xss_filter($_SESSION['personal_details']['totalamountpayable']),
						"PageNumber"				=>	xss_filter($_SESSION['personal_details']['webpageno'])
					);
					
					//echo '<pre>'; print_r($curl_post_data); echo '</pre>';
					$decodeddata = json_encode($curl_post_data);
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
					$json = json_decode($curl_response);
					//echo '<pre>'; print_r($curl_response); echo '</pre>'; exit;
					$json2 = array();
					$json2 = json_decode($json, true);
					//$json2[0]['CibilResponse'] = '0-Yes';
					if(strtolower($json2[0]['Status']) == 'success') {
						$_SESSION['personal_details']['ProspectNumber'] = xss_filter($json2[0]['ProspectNumber']);
						//echo '<pre>'; print_r($_SESSION); echo '</pre>'; exit;
						if($json2[0]['CibilResponse'] == '0-Yes') {
							redirect_to('aip-info');
						} elseif($json2[0]['CibilResponse'] == '1-N0') {
							redirect_to('declined');
						} elseif($json2[0]['CibilResponse'] == '2-Null') {
							redirect_to('aip-info');
						} else {
							redirect_to('declined');
						}
					}	else {
						redirect_to('declined');
					}
				} else {
					// echo "<pre>"; print_r('hi'); exit;
					$temp = explode('-', $_SESSION['co_applicant_details']['dob']);
					$birth_date = $temp[2].$temp[1].$temp[0];
					$occupationType = $_SESSION['co_applicant_details']['occupation'];
					$panno = $_SESSION['co_applicant_details']['panno'];
					$email_id = $_SESSION['co_applicant_details']['emailid'];
					$coApplicantFirstName = '';
					$coApplicantMiddleName = '';
					$coApplicantLastName = '';
					$coApplicantGender = '';
					$coApplicantMobileNumber = '';
					$coApplicantMobileNumber2 = '';
					$companyName = '';
					$otherCompanyName = '';
					$coApplicantPermanentAddr1 = '';
					$coApplicantPermanentAddr2 = '';
					$coApplicantPermanentAddr3 = '';
					$coApplicantPermanentState = '';
					$coApplicantPermanentCity = '';
					$coApplicantPermanentPincode = '';
					$coApplicantCurrentAddr1 = '';
					$coApplicantCurrentAddr2 = '';
					$coApplicantCurrentAddr3 = '';
					$coApplicantCurrentState = '';
					$coApplicantCurrentCity = '';
					$coApplicantCurrentPincode = '';
					$coApplicantAadharNo = '';
					if(isset($_SESSION['co_applicant_details']['mobileno'])) {
						$coApplicantMobileNumber = $_SESSION['co_applicant_details']['mobileno'];
					}
					if(isset($_SESSION['co_applicant_details']['Mobile'])) {
						$coApplicantMobileNumber2 = $_SESSION['co_applicant_details']['Mobile'];
					}
					if(isset($_SESSION['co_applicant_details']['applicantname'])) {
						$coApplicantFirstName = $_SESSION['co_applicant_details']['applicantname'];
					}
					if(isset($_SESSION['co_applicant_details']['middlename'])) {
						$coApplicantMiddleName = $_SESSION['co_applicant_details']['middlename'];
					}
					if(isset($_SESSION['co_applicant_details']['lastname'])) {
						$coApplicantLastName = $_SESSION['co_applicant_details']['lastname'];
					}
					if(isset($_SESSION['co_applicant_details']['gender'])) {
						$coApplicantGender = $_SESSION['co_applicant_details']['gender'];
					}
					if(isset($_SESSION['co_applicant_details']['companyName'])) {
						$companyName = $_SESSION['co_applicant_details']['companyName'];
					}
					if(isset($_SESSION['co_applicant_details']['otherCompanyName'])) {
						$otherCompanyName = $_SESSION['co_applicant_details']['otherCompanyName'];
					}
					if(isset($_SESSION['co_applicant_details']['permanentaddress1'])) {
						$coApplicantPermanentAddr1 = $_SESSION['co_applicant_details']['permanentaddress1'];
					}
					if(isset($_SESSION['co_applicant_details']['permanentaddress2'])) {
						$coApplicantPermanentAddr2 = $_SESSION['co_applicant_details']['permanentaddress2'];
					}
					if(isset($_SESSION['co_applicant_details']['permanentaddress3'])){
						$coApplicantPermanentAddr3 = $_SESSION['co_applicant_details']['permanentaddress3'];
					}
					if(isset($_SESSION['co_applicant_details']['permanentpincode'])) {
						$coApplicantPermanentPincode = $_SESSION['co_applicant_details']['permanentpincode'];
					}
					if(isset($_SESSION['co_applicant_details']['permanentstate'])) {
						$coApplicantPermanentState = $_SESSION['co_applicant_details']['perm_state_code'];
					}
					if(isset($_SESSION['co_applicant_details']['permanentcity'])) {
						$coApplicantPermanentCity = $_SESSION['co_applicant_details']['perm_city_code'];
					}
					if(isset($_SESSION['co_applicant_details']['currentaddress1'])) {
						$coApplicantCurrentAddr1 = $_SESSION['co_applicant_details']['currentaddress1'];
					}
					if(isset($_SESSION['co_applicant_details']['currentaddress2'])) {
						$coApplicantCurrentAddr2 = $_SESSION['co_applicant_details']['currentaddress2'];
					}
					if(isset($_SESSION['co_applicant_details']['currentaddress3']))
					{
						$coApplicantCurrentAddr3 = $_SESSION['co_applicant_details']['currentaddress3'];
					}
					if(isset($_SESSION['co_applicant_details']['currentpincode']))
					{
						$coApplicantCurrentPincode = $_SESSION['co_applicant_details']['currentpincode'];
					}
					if(isset($_SESSION['co_applicant_details']['currentstate']))
					{
						$coApplicantCurrentState = $_SESSION['co_applicant_details']['curr_state_code'];
					}
					if(isset($_SESSION['co_applicant_details']['currentcity'])) {
						$coApplicantCurrentCity = $_SESSION['co_applicant_details']['curr_city_code'];
					}
					if(isset($_SESSION['customer']['AddharNo'])) {
						$coApplicantAadharNo = $_SESSION['customer']['AddharNo'];
					}

					if($occupationType == 'semp') {
						$occupationType = 'Self employed';
					} else {
						$occupationType = 'Salaried';
					}
					$service_url = API. 'InsertCoApplicant';
					$headers = array (
						"Content-Type: application/json"
					);
					$curl_post_data = array(
						"CRMLeadID"     		=> xss_filter($_SESSION['personal_details']['CRMLeadID']),
						"ApplicantType"       	=> "COBORROWER",
						"ProspectNumber"      	=> xss_filter($_SESSION['personal_details']['ProspectNumber']),
						"CoCompanyName"       	=> xss_filter($companyName),
						"CoOtherCompanyName"  	=> xss_filter($otherCompanyName),
						"RelationwithApplicant" => xss_filter($_SESSION['co_applicant_details']['relationType']),
						"CoDomain"      		=> "",
						"CoMonthlySalary"     	=> xss_filter($_SESSION['co_applicant_details']['monthlySalary']),
						"CoMonthlyObligation" 	=> xss_filter($_SESSION['co_applicant_details']['currentEmi']),
						"CoPersonalEmailID"   	=> xss_filter($email_id),
						"CoMobileNo"    		=> xss_filter($coApplicantMobileNumber),
						"CoAlternateMobileNo" 	=> xss_filter($coApplicantMobileNumber2),
						"CoAadhaarNumber"    	=> xss_filter($coApplicantAadharNo),
						"CoFName"       		=> xss_filter($coApplicantFirstName),
						"CoMName"       		=> xss_filter($coApplicantMiddleName),
						"CoLName"       		=> xss_filter($coApplicantLastName),
						"CoGender"      		=> xss_filter($coApplicantGender),
						"CoPAN"   				=> xss_filter($panno),
						"CoCurrentWorkExp"    	=> xss_filter($_SESSION['co_applicant_details']['workexperiance']),
						"CoTotalWorkExp"      	=> xss_filter($_SESSION['co_applicant_details']['totworkexperiance']),
						"CoDOB"   				=> $birth_date,
						"CoPermanentAddress1" 	=> xss_filter($coApplicantPermanentAddr1),
						"CoPermanentAddress2" 	=> xss_filter($coApplicantPermanentAddr2),
						"CoPermanentAddress3" 	=> xss_filter($coApplicantPermanentAddr3),
						"CoPermanentState"    	=> xss_filter($coApplicantPermanentState),
						"CoPermanentCity"     	=> xss_filter($coApplicantPermanentCity),
						"CoPermanentPin"      	=> xss_filter($coApplicantPermanentPincode),
						"CoCurrentAddress1"   	=> xss_filter($coApplicantCurrentAddr1),
						"CoCurrentAddress2"   	=> xss_filter($coApplicantCurrentAddr2),
						"CoCurrentAddress3"   	=> xss_filter($coApplicantCurrentAddr3),
						"CoCurrentState"      	=> xss_filter($coApplicantCurrentState),
						"CoCurrentCity"       	=> xss_filter($coApplicantCurrentCity),
						"CoCurrentPin"  		=> xss_filter($coApplicantCurrentPincode),
						"CoKYCFlag"     		=> "1",
						"PageNumber"    		=> "10",
						"EmploymentType"      	=> xss_filter($_SESSION['co_applicant_details']['occupation']   ),
						"NatureOfBusiness"    	=> xss_filter($_SESSION['co_applicant_details']['cnamecoappnature']),
						"Profession"    		=> xss_filter($_SESSION['co_applicant_details']['cnamecoappnatureprofession']),
						"ConstitutionType"    	=> xss_filter($_SESSION['co_applicant_details']['cnamecoappnatureconstitution']),
					);
					$decodeddata = json_encode($curl_post_data);
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
					$_SESSION['response'] 	= $curl_response;
					$json = json_decode($curl_response);
					
					$json2 = array();
					$json2 = json_decode($json, true);
					//echo "<pre>"; print_r($json2); echo '</pre>'; exit;
					// $json2[0]['CibilResponse'] = '2-Null';
					if(strtolower($json2[0]['Status']) == 'success') 
					{
						$_SESSION['co_applicant_details']['ProspectNumber'] = xss_filter($json2[0]['ProspectNumber']);
						if($_SESSION['personal_details']['ProspectNumber'] == $json2[0]['ProspectNumber'])
						{
							if($json2[0]['CibilResponse'] == '0-Yes') 
							{
								$_SESSION['co_applicant_details']['CIBIL']['flag'] 				= 'Yes';
								$_SESSION['co_applicant_details']['CIBIL']['CibilResponse'] 	= $json2[0]['CibilResponse'];
								$_SESSION['co_applicant_details']['CIBIL']['CIBILTotalEMI'] 	= $json2[0]['CIBILTotalEMI'];
								$_SESSION['co_applicant_details']['CIBIL']['MaxAmount'] 		= $json2[0]['MaxAmount'];
								$_SESSION['co_applicant_details']['CIBIL']['MaxTenure'] 		= $json2[0]['MaxTenure'];
								$_SESSION['co_applicant_details']['CIBIL']['ROIDefault'] 		= $json2[0]['ROIDefault'];
								$_SESSION['co_applicant_details']['CIBIL']['ROIActual'] 		= $json2[0]['ROIActual'];
								$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeDefault'] 	= $json2[0]['ProcessingFeeDefault'];
								$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual'] 	= $json2[0]['ProcessingFeeActual'];
								redirect_to('your-quote');
							} 
							elseif($json2[0]['CibilResponse'] == '1-N0') 
							{
								$_SESSION['co_applicant_details']['CIBIL']['flag'] 	= 'No';
								redirect_to('your-quote');
							}	
							elseif($json2[0]['CibilResponse'] == '2-Null') 
							{
								$_SESSION['co_applicant_details']['CIBIL']['flag'] 				= 'Null';
								$_SESSION['co_applicant_details']['CIBIL']['CibilResponse'] 	= $json2[0]['CibilResponse'];
								$_SESSION['co_applicant_details']['CIBIL']['CIBILTotalEMI'] 	= $json2[0]['CIBILTotalEMI'];
								$_SESSION['co_applicant_details']['CIBIL']['MaxAmount'] 		= $json2[0]['MaxAmount'];
								$_SESSION['co_applicant_details']['CIBIL']['MaxTenure'] 		= $json2[0]['MaxTenure'];
								$_SESSION['co_applicant_details']['CIBIL']['ROIDefault'] 		= $json2[0]['ROIDefault'];
								$_SESSION['co_applicant_details']['CIBIL']['ROIActual'] 		= $json2[0]['ROIActual'];
								$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeDefault'] 	= $json2[0]['ProcessingFeeDefault'];
								$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual'] 	= $json2[0]['ProcessingFeeActual'];
								redirect_to('co-applicant-upload-upload-non-financial-document');
							} 
							else 
							{
								$_SESSION['co_applicant_details']['CIBIL']['flag'] 	= 'No';
								redirect_to('your-quote');
							}
						}
						else 
						{
							$_SESSION['co_applicant_details']['CIBIL']['flag'] 	= 'No';
							redirect_to('your-quote');
						}
					}	
					else 
					{
						$_SESSION['co_applicant_details']['CIBIL']['flag'] 	= 'No';
						redirect_to('your-quote');
					}
				}
			} 
			else 
			{
				$msg = $json->ErrMsg;
			}
		}	
		else 
		{
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
		<script type="text/javascript"> dataLayer = []; </script>
		<script type="text/javascript">
			function pushGoogleAnalytics(category, action, label, event) {
				dataLayer.push({ 'category': category, 'action': action, 'label': label, 'event': event });
			}
		</script>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PNTWH9J');</script>
		<!-- End Google Tag Manager -->	
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
				if ($("#error-user").html() != '') {
					$("#error-user").show();
				}
			});
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
<body class="bodyoverflow manual_verify">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PNTWH9J"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	
	<!-- No Aadhar OTP Pixel -->
	<img src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_No-Aadhar-OTP=<No-Aadhar-OTP>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
    <!-- No Aadhar OTP End -->
	
<div id="main-wrap"> 
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
	<form method="POST" action="manual-verification">
    <div id="msform">
      <section class="body-home-outer myclass aadharbg">
  <div class="innerbody-home manualvarification" style="height:auto;"> 
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
								<span class="orange"><span class="disp-in-block"><b class="rupee-symb">`</b> <b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b></span></span><br>
    Loan Tenure - <span class="orange" id="tenure"><?php echo $loan_tenure; ?> Years</span>
							</div>
  <div class="loan-amount loanamout-small">Rate of Interest -
								<span class="orange"><?php echo $_SESSION['personal_details']['roi_actual']; ?>%</span><br>
    Processing Fees - <span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span>
							</div>
  <div class="total-emi">EMI -
								<span class="orange"><span class="disp-in-block"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b></span></span>
							</div>
  <div class="clr none"></div>
      </div>

    </div>
    <div class="approval-wrap">
      <div class="approval-leftpoints">
              <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
                EMI Quote</div>
              <div class="lefticons-line"></div>
              <div class="emi-quoteicon"><img src="images/detailicon-big.png" class="scale"><br>
                My Details</div>
              <div class="lefticons-line"></div>
              <div class="emi-quoteicon"><img src="images/eligible-icon-fade.png" class="scale"><br>
                Eligibility<!--<br>&nbsp;--></div>
              <div class="lefticons-line"></div>
              <div class="emi-quoteicon"><img src="images/nonFinance-fade.png" class="scale"><br>
                Non-Financial Documents</div>
              <div class="lefticons-line"></div>
              <div class="emi-quoteicon"><img src="images/finance-fade.png" class="scale"><br>
                Financial Documents<!--<br>&nbsp;--></div>
              <div class="lefticons-line"></div>
              <div class="emi-quoteicon lasticon"><img src="images/verify-fade.png" class="scale"><br>
                Work Verification<!--<br>&nbsp;--></div>
              <div class="clr"></div>
            </div>
      <div class="approval-right-container">
		  <div class="aadhar-wrap">
		    <div class="aadhar-heading aadhar-heading-font">Mobile Number Verification<sup><span class="red1">*</span></sup>. <br>
		      </div>
				<div class="companyname sceeen4form manual">
		      <label class="input"> <span style="<?php echo !empty($msg)?'visibility:hidden':''; ?>">Enter OTP</span>
		        <input type="text" id="manualOTP" value="<?php echo $_SESSION['manual']['otp']; ?>" name="manualOTP" onkeypress="return isNumberKey(event)" value="<?php echo !empty($msg)?$otp:''; ?>" maxlength="6" />
				<?php if(!empty($msg)): ?><div id="error-user"><?php echo $msg; ?></div><?php endif; ?>
				<div class="dnone"><?php echo $_SESSION['manual']['otp']; ?></div>
		      </label>
				<div class="aadharbtn">
		      <input type="submit" name="submit" id="verifyManMobNo" onClick="ga('send', 'event', 'Personal Loan', 'Verify-OTP-Click', 'Manual-OTP');" value="Verify OTP" class="ios-btn">
				<a href="javascript:;" class="text-link resendManOtp"> Resend OTP</a>
				</div>
		    </div>
		  </div>
      </div>
      <div class="clr"></div>
    </div>
    <!--approval wrap-->
    <div class="screen05img ipadposabs"> <img src="images/homescreen-05img.png" class="scale">
      <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
      <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
    </div>
  </div>
      </section>
    </div>
	</form>
  <script src="js/cards1.js" type="text/javascript"></script>
  <?php require_once('includes/footer.php'); ?>
