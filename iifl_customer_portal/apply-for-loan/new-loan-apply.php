<?php 
	$service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/newLoanApply?key=INDIGO';	
	$curl = curl_init($service_url);
	$curl_post_data = array(
	'Parameter' => 'value',
	'ProductType' => 'GL',
	'LoanType' => 'BT',
	'Amount' => '10230122',
	'UserId' => 'C143280',
	'requestCode' => 'INDIGONLA20',
	'key' => 'INDIGO'
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
	echo '<pre>';
	print_r(json_decode($curl_response));
	echo '</pre>';
?>

