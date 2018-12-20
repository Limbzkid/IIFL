<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php

	$aadhar_type = xss_filter($_POST['type']);
	
	if(alpha($aadhar_type)) {
		if($aadhar_type == 'aadhar') {
			$aadhar_no = xss_filter($_POST['aadharcode']);
			if(valid_aadhar($aadhar_no)) {
				$service_url = COMMON_API. 'GenerateOTPForAadhar';
				$curl = curl_init($service_url);
				$curl_post_data = array(
					'CRMLeadID' 	=> xss_filter($_SESSION['personal_details']['CRMLeadID']),
					'AadhaarNumber' => $aadhar_no
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
				echo $curl_response;
			} else {
				echo '0';
			}
		} else {
			$otp 			= xss_filter($_POST['aadharcodeotp']);
			$aadhar_no 		= xss_filter($_POST['aadharno']);
			if(is_numeric($otp) && valid_aadhar($aadhar_no)) {
				$service_url 		= COMMON_API. 'VerifyOTPForAadhar_Online';
				$curl 				= curl_init($service_url);				
				$curl_post_data = array(
					'CRMLeadID'			=> xss_filter($_SESSION['personal_details']['CRMLeadID']),
					'requestCode' 	=> 'WARPGO31',
					'key' 					=> 'MOADIIFL',
					'appVer' 				=> '1.0',
					'osName' 				=> 'android',
					'osVer' 				=> '9.0',
					'ProspectNo' 		=> 'GL3914820',
					'UserId' 				=> 'PLONLINE',
					'OTP' 					=> $otp,
					'AadhaarNumber' => $aadhar_no
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
				$decoded = json_decode($curl_response);
				//echo '<pre>'; print_r($curl_response); echo '</pre>';
			
				if(strtoupper($decoded->Status) == 'Y') {
					$_SESSION['customer']['aadharNo'] 	= $_SESSION['personal_details']['aadharNo'] = $aadhar_no;
					$_SESSION['customer']['ADD1'] 			= xss_filter($decoded->Jsonresponse->ADD1);
					$_SESSION['customer']['ADD2'] 			= xss_filter($decoded->Jsonresponse->ADD2);
					$_SESSION['customer']['ADD3'] 			= xss_filter($decoded->Jsonresponse->ADD3);
					$_SESSION['customer']['AddharNo'] 	= xss_filter($decoded->Jsonresponse->AddharNo);
					$_SESSION['customer']['City'] 			= xss_filter($decoded->Jsonresponse->City);
					$_SESSION['customer']['Dob'] 				= xss_filter($decoded->Jsonresponse->Dob);
					$_SESSION['customer']['Email'] 			= xss_filter($decoded->Jsonresponse->Email);
					$_SESSION['customer']['Firstname'] 	= xss_filter($decoded->Jsonresponse->Firstname);
					$_SESSION['customer']['Lastname'] 	= xss_filter($decoded->Jsonresponse->Lastname);
					$_SESSION['customer']['Gender'] 		= xss_filter($decoded->Jsonresponse->Gender);
					$_SESSION['customer']['Middlename'] = xss_filter($decoded->Jsonresponse->Middlename);
					$_SESSION['customer']['Mobile'] 		= xss_filter($decoded->Jsonresponse->Mobile);
					$_SESSION['customer']['Pincode'] 		= xss_filter($decoded->Jsonresponse->Pincode);
					$_SESSION['customer']['Prospectno'] = xss_filter($decoded->Jsonresponse->Prospectno);
					$_SESSION['customer']['State'] 			= xss_filter($decoded->Jsonresponse->State);
					
					$service_url = COMMON_API. 'GetDetailByPincode';
					$curl_post_data = array(
						'CRMLeadID'	=> $_SESSION['personal_details']['CRMLeadID'],
						'Pincode' 	=> $decoded->Jsonresponse->Pincode
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
					$pin_obj = curl_exec($handle);
					curl_close($handle);
					$obj = json_decode($pin_obj);
					if(strtolower($obj->Status) == 'success') {
						$_SESSION['personal_details']['perm_city_code'] 	= $obj->CityCode;
						$_SESSION['personal_details']['perm_state_code'] 	= $obj->StateCode;
					}
				}
				echo $decoded->Status;
			}	else {
				echo '0';
			}
		}
	}

?>