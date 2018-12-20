<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	
	$pan_number = strip_tags($_POST['panNo']);
	
	$service_url = COMMON_API. 'VerifyPanCard';
	$headers = array (
		"Content-Type: application/json"
	);

	$curl_post_data = array(
		"CRMLeadID"	=>	$_SESSION['personal_details']['CRMLeadID'],
		"PAN"				=>	$pan_number
	);

	$decodeddata = json_encode($curl_post_data);
	$handle = curl_init(); 
	curl_setopt($handle, CURLOPT_URL, $service_url);
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
	
	$curl_response1 = curl_exec($handle);
	curl_close($handle);
	$pan_curl = json_decode($curl_response1);
	$_SESSION['error_msg'] = 'Pancard- '. $pan_curl->ErrorMsg;
	echo $curl_response1;

?>

