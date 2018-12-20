<?php

	$service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/GenerateOTP?key=INDIGO';
	$curl = curl_init($service_url);
	$curl_post_data = array(
		'loanno' 			=> 'GL442823',
		'pwd' 				=> 'pass@5678',
		'RequestCode' => 'INDIGO006',
		'key' 				=> 'INDIGO',
		'AppVer' 				=> '1.0',
		'OsName' 				=> 'android',
		'OsVer' 				=> '5.1'
		



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