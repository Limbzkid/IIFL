<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	
	$mobile_no = xss_filter($_POST['mobileNo']);
	
	if(valid_mobile($mobile_no)) {
		$service_url = COMMON_API. 'SendOTP';
		$headers = array (
			"Content-Type: application/json"
		);
		$curl_post_data = array(
			"CRMLeadID"			=> $_SESSION['personal_details']['CRMLeadID'],
			"MobileNumber"	=> $mobile_no
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
		echo $curl_response;
	} else {
		echo '';
	}
	
	

?>

