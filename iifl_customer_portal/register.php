<?php

	if(isset($_POST['user_id'])) {
		$user_id 	= $_POST['user_id'];
	} else {
		$user_id 	= "";
	}
	
	if(isset($_POST['password'])) {
		$password 	= $_POST['password'];
	} else {
		$password 	= "";
	}
	
	//if($user_id && $password) {
		$service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/login';
		$curl = curl_init($service_url);
		$curl_post_data = array(			
			"loanno"				=> "GL442823",
			"pwd"						=> "iifl@123",
			"RequestCode"		=> "INDIGO006",
			"Key"						=> "INDIGO",
			"AppVer"				=>	"1.0",
			"OsName"				=> "android",
			"OsVer"					=> "5.1"
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
			
		//}

?>