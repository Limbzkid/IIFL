<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	require_once("../includes/config.php");
	
	$bank_name 	= $_POST['banknm'];
	$bank_code 	= $_POST['bankcd'];
	$acct_type 	= $_POST['type'];
	$p_type			= $_POST['ptype'];  
	
	if($acct_type == 'Applicant') {
		$return_url = APPL_RETURN_URL;
	} else {
		$return_url = COAPP_RETURN_URL;
	}
	
	$service_url = PERFIOS_API. 'Perfios_StartApi';
	
	if($p_type == 'NBF') {
		$destination = 'netbankingFetch';
	} else {
		$destination = 'statement';
	}
	//echo $service_url;
	$curl = curl_init($service_url);
	$curl_post_data = array(
		'ApplicantType'		=> $acct_type,
		'Destination' 		=> $destination,
		'CRMLeadID'				=> $_SESSION['personal_details']['CRMLeadID'],
		'ProspectNumber' 	=> $_SESSION['personal_details']['ProspectNumber'],
		'InstitutionID'		=> $bank_code,
		'InstitutionName' => $bank_name,
		'ReturnURL'				=> $return_url,
		'Source' 					=> 'PL',
		'PageNo'					=> '15'
	);
	
	$headers = array (
		"Content-Type: application/json"
	);

	$decodeddata = json_encode($curl_post_data);
	
	//echo '<pre>'; print_r($decodeddata); echo '</pre>';
	$handle = curl_init(); 
	curl_setopt($handle, CURLOPT_URL, $service_url);
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
	$curl_response = curl_exec($handle);
	curl_close($handle);
	
	$decoded = json_decode(json_decode($curl_response));
	
	$file = '../perfios.php';
	file_put_contents($file, $decoded[0]->HTMLPayLoad);
	
	$_SESSION['perfios']['transaction_id'] = $decoded[0]->TransactionId;
	$_SESSION['perfios']['bank_name'] = $bank_name;

	echo json_encode($decoded);

?>

