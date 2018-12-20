<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	
	$pincodevalue = xss_filter($_POST['pincode']);
	$group 				= xss_filter($_POST['grp']);
	
	if(valid_pincode($pincodevalue) && alpha($group)) {
		$service_url = COMMON_API. 'GetDetailByPincode';
		$curl = curl_init($service_url);
		$curl_post_data = array(
			'CRMLeadID'	=> $_SESSION['personal_details']['CRMLeadID'],
			'Pincode' 	=> $pincodevalue
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
		//print_r($decoded);
		if(strtolower($decoded->Status) == 'success') {
			if($group == 'DivCA') {
				$_SESSION['personal_details']['currentpincode'] 	= $pincodevalue;
				$_SESSION['personal_details']['curr_city_code'] 	= $decoded->CityCode;
				$_SESSION['personal_details']['curr_state_code'] 	= $decoded->StateCode;
				$_SESSION['personal_details']['currentcity'] 			= $decoded->City;
				$_SESSION['personal_details']['currentstate'] 		= $decoded->State;
			} else if($group == 'DivPA') {
				$_SESSION['personal_details']['permanentpincode'] 	= $pincodevalue;
				$_SESSION['personal_details']['perm_city_code'] 	= $decoded->CityCode;
				$_SESSION['personal_details']['perm_state_code'] 	= $decoded->StateCode;
				$_SESSION['personal_details']['permanentcity'] 		= $decoded->City;
				$_SESSION['personal_details']['permanentstate'] 	= $decoded->State;
			} else if($group == 'CoDivPA')  {
				$_SESSION['co_applicant_details']['permanentpincode'] 	= $pincodevalue;
				$_SESSION['co_applicant_details']['perm_city_code'] 	= $decoded->CityCode;
				$_SESSION['co_applicant_details']['perm_state_code'] 	= $decoded->StateCode;
				$_SESSION['co_applicant_details']['permanentcity'] 		= $decoded->City;
				$_SESSION['co_applicant_details']['permanentstate'] 	= $decoded->State;
			}	else if($group == 'CoDivCA') {
				$_SESSION['co_applicant_details']['currentpincode'] 	= $pincodevalue;
				$_SESSION['co_applicant_details']['curr_city_code'] 	= $decoded->CityCode;
				$_SESSION['co_applicant_details']['curr_state_code'] 	= $decoded->StateCode;
				$_SESSION['co_applicant_details']['currentcity'] 		= $decoded->City;
				$_SESSION['co_applicant_details']['currentstate'] 		= $decoded->State;
			}	else {

			}
		}
		echo $curl_response;
	}	else {
		echo '';
	}
	

?>

