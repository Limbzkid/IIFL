<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	//echo "<pre>"; print_r($_SESSION); exit;
	if(isset($_SESSION['co_applicant_details'])) {
		$page_number = '14';
	} else {
		$page_number = '9';
	}
	$error 						= false;
	$disburse_success = false;
	$work_success 		= false;
	$msg 							= '';
	$app_type = $_POST['appType'];
	if($app_type == 'Applicant') {
		$addr1 						= xss_filter(trim($_POST['addr1']));
		$addr2 						= xss_filter(trim($_POST['addr2']));
		$addr3 						= xss_filter(trim($_POST['addr3']));
		$mail 						= xss_filter(trim($_POST['email']));
		$pin_code   			= xss_filter(trim($_POST['pin']));
		$state						= xss_filter(trim($_POST['state']));
		$city							= xss_filter(trim($_POST['city']));
		$state_code				= xss_filter(trim($_POST['stateCode']));
		$city_code				= xss_filter(trim($_POST['cityCode']));
		$nach							= xss_filter(trim($_POST['nach']));
		$app_type					= xss_filter(trim($_POST['appType']));	
		$page_no					= $page_number;
		//$coappaddr1 		= xss_filter(trim($_POST['coappaddr1']));
		
		if($addr1 == '') {
			$err[] = 'addr1-Address1 is required';
			$error = true;
		} else {
			if(!valid_address($addr1)) {
				// echo "<pre>"; print_r('hi'); exit;
				$err[] = 'addr1-Invalid address';
				$error = true;
			}
		}
		
		if($addr2 == '') {
			$err[] = 'addr2-Address2 is required';
			$error = true;
		} else {
			if(!valid_address($addr2)) {
				$err[] = 'addr2-Invalid address';
				$error = true;
			}
		}
	
		if($addr3 != '') {
			if(!valid_address($addr3)) {
				$err[] = 'addr3-Invalid address';
				$error = true;
			}
		}
	
		if($mail == '') {
			$err[] = 'email-Email is required';
			$error = true;
		} else {
			if(!valid_mail($mail)) {
				$err[] = 'email-Invalid email';
				$error = true;
			}
		}
		
		if($pin_code == '') {
			$err[] = 'pincode-Pincode is required';
			$error = true;
		}	else {
			if(!valid_pincode($pin_code)) {
				$err[] = 'pincode-Invalid pincode';
				$error = true;
			}
		}
		
		if($nach == 'checked') {
			$addr1 				= $_SESSION['personal_details']['currentaddress1'];
			$addr2 				= $_SESSION['personal_details']['currentaddress2'];
			$addr3 				= $_SESSION['personal_details']['currentaddress3'];
			$mail 				= $_SESSION['personal_details']['emailid'];
			$pin_code 		= $_SESSION['personal_details']['currentpincode'];
			$city_code 		= $_SESSION['personal_details']['curr_city_code'];
			$state_code 	= $_SESSION['personal_details']['curr_state_code'];
		}
		
		if(blacklisted_email($mail)) {
			$error = true;
			$err[] = 'email-Invalid email';
		}
	
		
		if(!$error) {
			$service_url = API. 'InsertOfficeDtls';
			$curl = curl_init($service_url);
			$curl_post_data = array(
				"CRMLeadID"				=> 	$_SESSION['personal_details']['CRMLeadID'],
				"ProspectNumber"	=> 	$_SESSION['personal_details']['ProspectNumber'],
				"ApplicantType"		=>	"APPLICANT",
				"OfficeEmailID"		=>	$mail,
				"CompanyAddress1"	=>	$addr1,
				"CompanyAddress2"	=>	$addr2,
				"CompanyAddress3"	=>	$addr3,
				"CompanyState"		=>	$state_code,
				"CompanyCity"			=>	$city_code,
				"CompanyPin"			=>	$pin_code,
				"PageNumber" 			=> 	$page_no
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
			//echo "<pre>"; print_r($curl_response); exit;
			$decoded = json_decode($curl_response);
			$_SESSION['office_details']['request'] = $curl_post_data;
			$_SESSION['office_details']['response'] = $curl_response;
			
			$data = json_decode($curl_response);
			$data = json_decode($data);
				
			if(strtolower($data[0]->Status) == 'success') {
				$status = '1';
				$msg = 'success';
			} else {
				$status = '0';
				$msg = $data[0]->ErrorMsg;
			}
	
			if(isset($_SESSION['personal_details']['ifsc_code'])) {
				$service_url = API. 'InsertDisbursementDtl';
				$curl = curl_init($service_url);
	
				$curl_post_data = array(
					'CRMLeadID'					=> $_SESSION['personal_details']['CRMLeadID'],
					'ProspectNumber' 		=> $_SESSION['personal_details']['ProspectNumber'],
					"NACHCommunication"	=> "test",
					"BankName" 					=> $_SESSION['ifsc']['bank'],
					"IFSC" 							=> $_SESSION['ifsc']['code'],
					"AccountNumber" 		=> $_SESSION['ifsc']['account_number'],
					"PageNumber" 				=> $page_no
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
				
				$data = json_decode($curl_response);
				$data = json_decode($data);
				$_SESSION['disburse']['request'] = $curl_post_data;
				$_SESSION['disburse']['response'] = $curl_response;
				if(strtolower($data[0]->Status) == 'success') {
					$status = '1';
					$msg = 'success';
				} else {
					$status = '0';
					$msg = $data[0]->ErrorMsg;
				}
		
			}
			
			echo json_encode(array('status' => $status, 'msg' => $msg));
		}
	}
	


	

	if(isset($_SESSION['co_applicant_details']) && $app_type == 'Borrower') {
		$coappaddr1 		= xss_filter(trim($_POST['coappaddr1']));
		$coappaddr2 		= xss_filter(trim($_POST['coappaddr2']));
		$coappaddr3 		= xss_filter(trim($_POST['coappaddr3']));
		$coappcity 			= xss_filter(trim($_POST['coappcity']));
		$coappstate 		= xss_filter(trim($_POST['coappstate']));
		$coapppincode 		= xss_filter(trim($_POST['coapppincode']));
		$coappcityCode 		= xss_filter(trim($_POST['coappcityCode']));
		$coappstateCode 	= xss_filter(trim($_POST['coappstateCode']));
		$coappemail			= xss_filter(trim($_POST['coappemail']));
		if($coappaddr1 == '') {
			$err[] = 'coappaddr1-Address1 is required';
			$error = true;
		} else {
			if(!valid_address($coappaddr1)) {
				// echo "<pre>"; print_r('hi'); exit;
				$err[] = 'coappaddr1-Invalid address';
				$error = true;
			}
		}

		if($coappaddr2 == '') {
			$err[] = 'coappaddr2-Address2 is required';
			$error = true;
		} else {
			if(!valid_address($coappaddr2)) {
				$err[] = 'coappaddr2-Invalid address';
				$error = true;
			}
		}

		if($coappaddr3 != '') {
			if(!valid_address($coappaddr3)) {
				$err[] = 'coappaddr3-Invalid address';
				$error = true;
			}
		}
		if($coappemail == '') {
			$err[] = 'coappemail-Email is required';
			$error = true;
		} else {
			if(!valid_mail($coappemail)) {
				$err[] = 'coappemail-Invalid email';
				$error = true;
			}
		}
		if($coapppincode == '') {
			$err[] = 'coapppincode-Pincode is required';
			$error = true;
		}	else {
			if(!valid_pincode($coapppincode)) {
				$err[] = 'pincode-Invalid pincode';
				$error = true;
			}
		}
		
		/*if($nach == 'checked') {
			$addr1 				= $_SESSION['co_applicant_details']['currentaddress1'];
			$addr2 				= $_SESSION['co_applicant_details']['currentaddress2'];
			$addr3 				= $_SESSION['co_applicant_details']['currentaddress3'];
			$mail 				= $_SESSION['co_applicant_details']['emailid'];
			$pin_code 		= $_SESSION['co_applicant_details']['currentpincode'];
			$city_code 		= $_SESSION['co_applicant_details']['curr_city_code'];
			$state_code 	= $_SESSION['co_applicant_details']['curr_state_code'];
		}*/
		
		if(blacklisted_email($coappemail)) {
			$error = true;
			$err[] = 'coappemail-Invalid email';
		}
		
		//$error = false; //to bypass
		
		if(!$error) {
			$service_url = API. 'InsertCoApplicantOfficeDtls';
			$curl = curl_init($service_url);
			$curl_post_data = array(
				"CRMLeadID"					=> 	$_SESSION['personal_details']['CRMLeadID'],
				"ProspectNumber"		=> 	$_SESSION['personal_details']['ProspectNumber'],
				"ApplicantType"			=>	"COBORROWER",
				"CoOfficeEmailID"		=>	$coappemail,
				"CoCompanyAddress1"	=>	$coappaddr1,
				"CoCompanyAddress2"	=>	$coappaddr2,
				"CoCompanyAddress3"	=>	$coappaddr3,
				"CoCompanyState"		=>	$coappstateCode,
				"CoCompanyCity"			=>	$coappcityCode,
				"CoCompanyPin"			=>	$coapppincode,
				"PageNumber" 				=> 	$page_number
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
			//echo "<pre>"; print_r($decoded); exit;
			$_SESSION['co_office_details']['request'] = $curl_post_data;
			$_SESSION['co_office_details']['response'] = $curl_response;
			
			$data = json_decode($curl_response);
			$data = json_decode($data);

			$_SESSION['disburse']['request'] = $curl_post_data;
			$_SESSION['disburse']['response'] = $curl_response;
			if(strtolower($data[0]->Status) == 'success') {
				$status = '1';
				$msg = 'success';
			} else {
				$status = '0';
				$msg = $data[0]->ErrorMsg;
			}
			
			/*if(isset($_SESSION['co-applicant_details']['ifsc_code'])) {
				$service_url = API. 'InsertDisbursementDtl';
				$curl = curl_init($service_url);
	
				$curl_post_data = array(
					'CRMLeadID'					=> $_SESSION['personal_details']['CRMLeadID'],
					'ProspectNumber' 		=> $_SESSION['co_applicant_details']['ProspectNumber'],
					"NACHCommunication"	=> "test",
					"BankName" 					=> $_SESSION['ifsc']['bank'],
					"IFSC" 							=> $_SESSION['ifsc']['code'],
					"AccountNumber" 		=> $_SESSION['ifsc']['account_number'],
					"PageNumber" 				=> $page_no
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
				
				$data = json_decode($curl_response);
				$data = json_decode($data);
				$_SESSION['disburse']['request'] = $curl_post_data;
				$_SESSION['disburse']['response'] = $curl_response;
				if(strtolower($data[0]->Status) == 'success') {
					$status = '1';
					$msg = 'success';
				} else {
					$status = '0';
					$msg = $data[0]->ErrorMsg;
				}
		
			}*/
			
			echo json_encode(array('status' => $status, 'msg' => $msg));
			exit;
		
			$work_success = true; // to bypass
		}

		$error = false;
		
		if($disburse_success) {
			
			$status = '1';
		} else {
			$msg = 'failed';
			$status = '0';
		}
		
		if($error) {
			// echo "<pre>"; print_r(($err)); exit;
			for ($i=0; $i < count($err) ; $i++) { 
				$var[] = array('status' => '0', 'msg' => $err[$i]);
			}
			//echo json_encode($var);
			//exit;
		} else {
			echo json_encode(array('status' => $status, 'msg' => $msg));
			//exit;
		}
	}
	
	
	/*
	// to bypass
	$disburse_success = true;
	$work_success = true;
	$error = false;

	if($work_success && $disburse_success) {
		$msg = 'success';
	} else {
		//echo "<pre>"; print_r('1'); 
		if($ifsc_code != '' && $ifsc_bank != '') {
			//echo "<pre>"; print_r('2');
			if($work_success && !$disburse_success) {
				//echo "<pre>"; print_r('3');
				$msg = 'failed';
			} elseif(!$work_success && $disburse_success) {
				//echo "<pre>"; print_r('4');
				$msg = 'failed';
			}
		} else {
			if($work_success) {
				$msg = 'success';
			}
		}
	}
	$msg = 'success';
	if($error) {
		for ($i=0; $i < count($err) ; $i++) { 
			$var1[] = array('status' => '0', 'msg' => $err);
		}
		//echo json_encode($var1);
		//exit;
	} else {
		echo json_encode(array('status' => '1', 'msg' => $msg));
		exit;
	}*/
	

	

?>

