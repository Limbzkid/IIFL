<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
		
	$app_type = $_POST['appType'];	
	$ifsc_code = strip_tags($_POST['ifsc']);
	$service_url = COMMON_API. 'IFSC';
	$curl = curl_init($service_url);
	if($ifsc_code == '') {
		unset($_SESSION['upload_doc']['ifsc_code']);
		unset($_SESSION['upload_doc']['BankName']);
		unset($_SESSION['upload_doc']['BankBranch']);
		echo '0';
		
	} else {	
		$curl_post_data = array(
			//'CRMLeadID'	=>	'1720531',
			'IFSCcode' 	=> $ifsc_code
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
		
		$json = json_decode($curl_response);
		if($json->Status == 'Y') {
			if($app_type == 'Applicant') {
				$_SESSION['personal_details']['ifsc_code'] 	= $json->IFSCcode;
				$_SESSION['personal_details']['BankName'] 	= $json->BankName;
				$_SESSION['personal_details']['BankBranch'] = $json->BankBranch;
			} else {
				$_SESSION['co_applicant_details']['ifsc_code'] 	= $json->IFSCcode;
				$_SESSION['co_applicant_details']['BankName'] 	= $json->BankName;
				$_SESSION['co_applicant_details']['BankBranch'] = $json->BankBranch;
			}
		}
		echo $curl_response;
	}
?>

