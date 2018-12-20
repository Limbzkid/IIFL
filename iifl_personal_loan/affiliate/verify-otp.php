<?php session_start(); ?>
<?php require_once("functions.php"); ?>

<?php
	$param = $_POST['param'];
	
	if($param == 'ver') {
		$otp = strip_tags($_POST['otp']);
		$curl_post_data = array(
			"CRMLeadID"	=> $_SESSION['personal_details']['CRMLeadID'],
			"OTP"				=> $otp
		);
		 $obj = call_api('common', 'VerifyOTP', $curl_post_data);
		//echo '<pre>'; print_r($obj); echo '</pre>';
		if($obj->Status == 'Y') {
			$status = '1';
			$msg = '';
		} else {
			$status = '0';
			$msg = 'Invalid OTP.';
		}
		echo json_encode(array('status'=>$status, 'msg'=>$msg));
	
	} else {
		$curl_post_data = array(
			"CRMLeadID"			=> $_SESSION['personal_details']['CRMLeadID'],
			"MobileNumber"	=> $_SESSION['personal_details']['mobileno'] 
		);
		$obj = call_api('common', 'SendOTP', $curl_post_data);
		if($obj->Status == 'Y') {
			$mob_no = substr($_SESSION['personal_details']['mobileno'], -4);
			$msg = 'OTP has been sent to your mobile ******'. $mob_no;
			$otp = $obj->OTP;
		} else {
			$otp = '';
			$msg = 'Failed to send OTP';
		}
		echo json_encode(array('status'=>$otp, 'msg'=> $msg));
		
		
	}
	
	//echo '<pre>'; print_r($obj); echo '</pre>'; exit;
	
	
?>