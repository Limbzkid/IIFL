<?php
	//session_start();
	//require_once("../includes/functions.php");
		

	$service_url = 'http://ttavatar.iifl.in/DigitalFinance/perfios/Service1.svc';
	$curl = curl_init($service_url);
	$curl_post_data = array(
		'ApplicantType'		=> 'Applicant',
		'Destination' 		=> 'netbankingFetch',
		'CRMLeadID'				=> '1725919',
		'ProspectNumber' 	=> 'SL905978',
		'InstitutionID'		=> '02',
		'InstitutionName' => 'Axis Bank, India',
		'ReturnURL'				=> 'http://indigoconsulting.in/iifl-finance/loans/personal_loan/upload-document',
		'Source' 					=> 'PL',
	);
	
	$headers = array (
		"Content-Type: application/json"
	);

	$decodeddata = json_encode($curl_post_data);
	$handle = curl_init(); 
	curl_setopt($handle, CURLOPT_URL, $service_url);
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
	$curl_response = curl_exec($handle);
	curl_close($handle);
	
	$decoded = json_decode($curl_response);

	//echo '<pre>'; print_r($decoded); echo '</pre>'; 
	//$curl_response;
	
	echo json_encode($decoded);

	

?>

