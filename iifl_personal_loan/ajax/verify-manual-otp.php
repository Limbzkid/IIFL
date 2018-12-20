<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	
	$otp = strip_tags($_POST['otp']);
	
	$service_url = COMMON_API. 'VerifyOTP';
	$headers = array (
		"Content-Type: application/json"
	);
	$curl_post_data = array(
		"CRMLeadID"	=> $_SESSION['personal_details']['CRMLeadID'],
		"OTP"				=> $otp
	);
	
	if(is_numeric($otp)) {
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
		echo $curl_response;
	}
	
	
?>

