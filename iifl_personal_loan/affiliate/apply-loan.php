<?php session_start(); ?>
<?php require_once("functions.php"); ?>
<?php
	$temp = explode('-', $_SESSION['personal_details']['dob']);
	$birth_date = $temp[2].$temp[1].$temp[0];
	$curl_post_data = array(
		"CRMLeadID"					=> 	$_SESSION['personal_details']['CRMLeadID'],
		"ApplicantType"			=> 	"Applicant",
		"CompanyName"				=> 	$_SESSION['personal_details']['companyname'],
		"OtherCompanyName"	=> 	"",
		"Domain"						=> 	"",
		"MonthlySalary"			=> 	$_SESSION['personal_details']['salary'],
		"MonthlyObligation"	=> 	$_SESSION['personal_details']['obligation'],
		"PersonalEmailID"		=> 	$_SESSION['personal_details']['emailid'],
		"MobileNo"					=> 	$_SESSION['personal_details']['mobileno'],
		"AlternateMobileNo"	=> 	'', 
		"AadhaarNumber"			=> 	'', 
		"FName"							=> 	$_SESSION['personal_details']['applicantname'],
		"MName"							=> 	$_SESSION['personal_details']['lastname'],
		"LName"							=> 	$_SESSION['personal_details']['lastname'],
		"Gender"						=> 	$_SESSION['personal_details']['gender'],
		"PAN"								=> 	$_SESSION['personal_details']['panno'],
		"CurrentWorkExp"		=> 	$_SESSION['personal_details']['workexperiance'],
		"TotalWorkExp"			=> 	$_SESSION['personal_details']['totworkexperiance'],
		"DOB"								=> 	$birth_date,
		"PermanentAddress1"	=> 	$_SESSION['personal_details']['permanentaddress1'],
		"PermanentAddress2"	=> 	$_SESSION['personal_details']['permanentaddress2'],
		"PermanentAddress3"	=> 	$_SESSION['personal_details']['permanentaddress3'],
		"PermanentState"		=> 	$_SESSION['personal_details']['perm_state_code'],
		"PermanentCity"			=> 	$_SESSION['personal_details']['perm_city_code'],
		"PermanentPin"			=> 	$_SESSION['personal_details']['permanentpincode'],
		"CurrentAddress1"		=> 	$_SESSION['personal_details']['currentaddress1'],
		"CurrentAddress2"		=> 	$_SESSION['personal_details']['currentaddress2'],
		"CurrentAddress3"		=> 	$_SESSION['personal_details']['currentaddress3'],
		"CurrentState"			=> 	$_SESSION['personal_details']['curr_state_code'],
		"CurrentCity"				=> 	$_SESSION['personal_details']['curr_city_code'],
		"CurrentPin"				=> 	$_SESSION['personal_details']['currentpincode'],
		"KYCFlag"						=> 	0,
		"AppliedLoanamount"	=> 	$_SESSION['personal_details']['appliedloanamt'],
		"ROI"								=>	$_SESSION['personal_details']['roi_actual'],
		"Tenure"						=>	$_SESSION['personal_details']['tenure'],
		"Processingfee"			=>	$_SESSION['personal_details']['processing_fee_actual'],
		"Emi"								=>	$_SESSION['personal_details']['maxEMI'],
		"TotalPayableAmount"=>	(int)$_SESSION['personal_details']['appliedloanamt'] + (int)($_SESSION['personal_details']['maxEMI'] * $_SESSION['personal_details']['tenure']),
		"PageNumber"				=>	'4'
	);
	$loan_obj = json_decode(call_api('api', 'ApplyLoan', $curl_post_data));
	if(strtolower($loan_obj[0]->Status) == 'success') {
		$status = '1';
		$msg[] = '';
		$prospect_number        = $loan_obj[0]->ProspectNumber;
		$cibil_response         = $loan_obj[0]->CibilResponse;
		$cibil_max_amount       = $loan_obj[0]->MaxAmount;
		$cibil_max_tenure       = $loan_obj[0]->MaxTenure;
		$cibil_roi_default      = $loan_obj[0]->ROIDefault;
		$cibil_roi_actual       = $loan_obj[0]->ROIActual;
		$cibil_proc_fee_default = $loan_obj[0]->ProcessingFeeDefault;
		$cibil_proc_fee_actual  = $loan_obj[0]->ProcessingFeeActual;
		
		$_SESSION['personal_details']['ProspectNumber'] = $prospect_number; 
		
		if($cibil_response == '0-Yes') {
			$page = 'aip-info';
		} elseif($cibil_response == '1-N0') {
			$page = 'declined';
		} elseif($cibil_response == '2-Null') {
			$page = 'aip-info';
		} else {
			$page = 'declined';
		}
		
	} else {
		$status = '0';
		$msg[] = $loan_obj[0]->ErrorMsg;
	}
	
	echo json_encode(array('status'=>$status, 'msg'=>$msg));
?>