<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	$co_app_found 	= false;
	$crmLeadIdType 	= xss_filter($_POST['crmLeadIDType']);
	$crmLeadId 				= xss_filter($_POST['crmLeadID']);
	if($crmLeadIdType) {
		if($crmLeadIdType == 'OTP') {
			if(alphanumerix($crmLeadId)) {
				$otpUrl = COMMON_API.'BreakJourneyOTP';
				$curl_post_data = array(
					'CRMLeadID' => $crmLeadId
				);
				$headers = array (
					"Content-Type: application/json"
				);
				$encodeddata = json_encode($curl_post_data);
				$handle = curl_init(); 
				curl_setopt($handle, CURLOPT_URL, $otpUrl);
				curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, $encodeddata);
				$curl_response = curl_exec($handle);
				$json = json_decode($curl_response);
				curl_close($handle);
				
				if($json->Status == 'Y')  {
					$_SESSION['resume_applicant']['otp'] = $json->OTP;
					$_SESSION['personal_details']['CRMLeadID'] = $_SESSION['resume_applicant']['CRMLeadID'] = $json->CRMLeadId;
					$_SESSION['personal_details']['mobileno'] = $_SESSION['resume_applicant']['MobileNumber'] = $json->MobileNumber;
				}
				echo $curl_response; exit();
			} else {
				echo 0;
			}
		} else {
			if(alphanumerix($crmLeadId)) {
				$OTP = xss_filter($_POST['OTP']);
				$otpUrl = COMMON_API.'BreakJourneyVerifyOTP_indigo';
				$curl_post_data = array(
					'CRMLeadID' => $crmLeadId,
					'OTP' 		=> $OTP
				);
				$headers = array (
					"Content-Type: application/json"
				);
			
				$encodeddata = json_encode($curl_post_data);
				$handle = curl_init(); 
				curl_setopt($handle, CURLOPT_URL, $otpUrl);
				curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, $encodeddata);
				$curl_response = curl_exec($handle);
				//echo "<pre>"; print_r($curl_response); echo '</pre>'; exit;
				curl_close($handle);
				$jsonDecode 	= json_decode($curl_response);
				//echo "<pre>"; print_r($jsonDecode); echo '</pre>';
				
				
				
				$requestJson 	= json_decode($jsonDecode->RequestJson);
				$responseJson 	= json_decode($jsonDecode->ResponseJson);
				//echo "<pre>"; print_r($requestJson); echo '</pre>';
				//echo "<pre>"; print_r($responseJson); echo '</pre>';
				
				if(isset($requestJson[3]->ApplicantType) && $requestJson[3]->ApplicantType == 'COBORROWER') {
					$co_app_found = true;
				}
				
				$page = '';
				foreach($requestJson as $arr) {
					//if(array_key_exists('PageNumber', $arr)) {
						if($page == '') {
							$page = $arr->PageNumber;
						} else {
							if(array_key_exists('PageNumber', $arr)) {
								if($arr->PageNumber > $page) {
									$page = $arr->PageNumber;
								}
							} else {
								if($arr->PageNo > $page) {
									$page = $arr->PageNo;
								}
							}
							
						}
					//}
				}
				$jsonDecode->PageNumber = $page;
				
				//echo $jsonDecode->PageNumber; exit;
				
				if($jsonDecode->Status == 'Y') {
					$service_url = API. 'EmiCalc';
					$headers = array ("Content-Type: application/json");
					$curl_post_data = array(
						"CRMLeadID"		=> $crmLeadId,
						"PageNumber"	=> 1
					);
			
					$decodeddata = json_encode($curl_post_data);
					$ch = curl_init(); 
					curl_setopt($ch, CURLOPT_URL, $service_url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
					curl_setopt($ch, CURLOPT_POSTFIELDS, $decodeddata);
				
					$curl_resp = json_decode(curl_exec($ch));
					curl_close($ch);
					$data = json_decode($curl_resp);
					if(strtolower($data[0]->Status) == 'success') {
						$minimum_amount 		= $data[0]->MinimumAmout;
						$maximum_amount 		= $data[0]->MaxAmount;
						$maximum_tenure 		= $data[0]->MaxTenure;
						$roi_default 				= $data[0]->ROIDefault;
						$roi_actual 				= $data[0]->ROIActual;
						$processing_fee_act = $data[0]->ProcessingFeeActual;
						$processing_fee_def = $data[0]->ProcessingFeeDefault;
					}
						
					//echo "<pre>"; print_r($data); echo "</pre>";  exit;
					
					if(isset($requestJson[1]->PermanentPin) && isset($requestJson[1]->CurrentPin)) {
						$service_url = COMMON_API. 'GetDetailByPincode';
						$curl = curl_init($service_url);
						$curl_post_data = array(
							'CRMLeadID'	=> $crmLeadId,
							'Pincode' 	=> xss_filter($requestJson[1]->PermanentPin)
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
						$_SESSION['personal_details']['permanentpincode'] 	= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_city_code'] 	= $decoded->CityCode;
						$_SESSION['personal_details']['perm_state_code'] 	= $decoded->StateCode;
						$permanentCity = $_SESSION['personal_details']['permanentcity']	= $decoded->City;
						$permanentState = $_SESSION['personal_details']['permanentstate'] 	= $decoded->State;

						$service_url = COMMON_API. 'GetDetailByPincode';
						$curl = curl_init($service_url);
						$curl_post_data = array(
							'CRMLeadID'	=> $crmLeadId,
							'Pincode' 	=> xss_filter($requestJson[1]->CurrentPin)
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
						$_SESSION['personal_details']['currentpincode'] 	= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_city_code'] 	= $decoded->CityCode;
						$_SESSION['personal_details']['curr_state_code'] 	= $decoded->StateCode;
						$currentCity = $_SESSION['personal_details']['currentcity'] 		= $decoded->City;
						$currentState = $_SESSION['personal_details']['currentstate'] 		= $decoded->State;
					}
					if($jsonDecode->PageNumber == '15' || $jsonDecode->PageNumber == '16') {
						
						//if(!$co_app_found) {
							$service_url = API. 'UpdateResidential';
							$curl = curl_init($service_url);
							$curl_post_data = array(
								"CRMLeadID"						=> $requestJson[1]->CRMLeadID,
								"ProspectNumber"			=> $requestJson[2]->ProspectNumber,
								"ApplicantType"				=> "APPLICANT",
								"ResidenceType"				=> $requestJson[2]->ResidenceType,
								"ResidenceStability"	=> $requestJson[2]->ResidenceStability,
								"Education"						=> $requestJson[2]->Education,
								"MaritalStatus"				=> $requestJson[2]->MaritalStatus,
								"PurposeofLoan"				=> $requestJson[2]->PurposeofLoan,
								"PageNumber"					=> 5
							);
							$decodeddata = json_encode($curl_post_data);
							$handle = curl_init(); 
							curl_setopt($handle, CURLOPT_URL, $service_url);
							curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
							curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
							$curl_response = json_decode(curl_exec($handle));
							curl_close($handle);
							$obj = json_decode($curl_response);
						//}
					}
					if($jsonDecode->PageNumber == '1') {
						if($responseJson->Status == 'Success') {
							$obligation 						= xss_filter($requestJson[0]->MonthlyObligation);
							$salary 								= xss_filter($requestJson[0]->MonthlySalary);
							$max_tenure 						= xss_filter($responseJson->MaxTenure);
							$ROI_default 						= xss_filter($responseJson->ROIDefault);
							$ROI_actual 						= xss_filter($responseJson->ROIActual);
							$processing_fee_default = xss_filter($responseJson->ProcessingFeeDefault);
							$processing_fee_actual 	= xss_filter($responseJson->ProcessingFeeActual);
							$minimum_amt 						= xss_filter(ceil($responseJson->MinimumAmout));
							$maximum_amt 						= xss_filter(ceil($responseJson->MaxAmount));
							$processing_fee 				= $processing_fee_actual;
							$interest 							= $ROI_actual;
						
							$net_income 			= $salary - $obligation;
							$maximumloanamtemi 		= calculate_emi($maximum_amt, $ROI_actual, $max_tenure);
							
							$interest_default 		= $ROI_default / 1200;
							$emi_default 			= ceil($interest_default * -$maximum_amt * pow((1 + $interest_default), $max_tenure) / (1 - pow((1 + $interest_default), $max_tenure)));
							$emi_difference 		= $emi_default -  $maximumloanamtemi;
							$actualloanEMI 			= $maximumloanamtemi;

							$_SESSION['personal_details']['companyname'] 						= xss_filter($requestJson[0]->CompanyName);
							$_SESSION['personal_details']['emailid'] 								= xss_filter($requestJson[0]->PersonalEmailID);
							$_SESSION['personal_details']['salary'] 								= $salary;
							$_SESSION['personal_details']['mobileno'] 							= xss_filter($requestJson[0]->MobileNo);
							$_SESSION['personal_details']['obligation'] 						= $obligation;
							$_SESSION['personal_details']['city'] 									= xss_filter($requestJson[0]->City);
							$_SESSION['personal_details']['maxloanamt'] 						= $maximum_amt;
							$_SESSION['personal_details']['minloanamt'] 						= $minimum_amt;
							$_SESSION['personal_details']['actualloanEMI'] 					= $actualloanEMI;
							$_SESSION['personal_details']['roi_actual'] 						= $ROI_actual;
							$_SESSION['personal_details']['roi_default'] 						= $ROI_default;
							$_SESSION['personal_details']['actual_tenure']					= $max_tenure;
							$_SESSION['personal_details']['tenure'] 								= $max_tenure;
							$_SESSION['personal_details']['processing_fee_actual'] 	= $processing_fee_actual;
							$_SESSION['personal_details']['processing_fee_default'] = $processing_fee_default;
							$_SESSION['personal_details']['emi_diff'] 							= $emi_difference;
							$_SESSION['personal_details']['CRMLeadID'] 							= xss_filter($responseJson->CRMLeadID);
							echo "page1";
							exit;
						}
					}
					if($jsonDecode->PageNumber == '4') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						
						$birth_date = $requestJson[1]->DOB;
						$birth_date = substr($birth_date,4,4).'-'. substr($birth_date,2,2) .'-'. substr($birth_date,0,2);
						$max_emi = calculate_emi($maximum_amount, $roi_actual, $maximum_tenure);
						
						$_SESSION['personal_details']['companyname'] 						= $requestJson[0]->CompanyName;
            $_SESSION['personal_details']['emailid'] 								= $requestJson[0]->PersonalEmailID;
            $_SESSION['personal_details']['salary'] 								= $requestJson[0]->MonthlySalary;
            $_SESSION['personal_details']['mobileno'] 							= $requestJson[0]->MobileNo;
            $_SESSION['personal_details']['obligation'] 						= $requestJson[0]->MonthlyObligation;
            $_SESSION['personal_details']['city'] 									= $requestJson[0]->City;
            $_SESSION['personal_details']['CRMLeadID'] 							= $requestJson[1]->CRMLeadID;
            $_SESSION['personal_details']['maxloanamt'] 						= $maximum_amount;
            $_SESSION['personal_details']['minloanamt'] 						= $minimum_amount; 
            $_SESSION['personal_details']['maxEMI'] 								= $max_emi;
            $_SESSION['personal_details']['actualloanEMI'] 					= $requestJson[1]->Emi;
            $_SESSION['personal_details']['roi_actual'] 						= $roi_actual;
            $_SESSION['personal_details']['roi_default'] 						= $roi_default;
            $_SESSION['personal_details']['actual_tenure'] 					= $maximum_tenure;
            $_SESSION['personal_details']['tenure'] 								= $requestJson[1]->Tenure;
            $_SESSION['personal_details']['processing_fee_actual'] 	= $processing_fee_act ;
            $_SESSION['personal_details']['processing_fee_default'] = $processing_fee_def;
            $_SESSION['personal_details']['emi_diff'] 							= '';
            $_SESSION['personal_details']['appliedloanamt'] 				= $requestJson[1]->AppliedLoanamount;
            $_SESSION['personal_details']['processing_fee'] 				= $requestJson[1]->Processingfee;
            $_SESSION['personal_details']['totalamountpayable'] 		= '';
            $_SESSION['personal_details']['permanentpincode'] 			= $requestJson[1]->PermanentPin;
            $_SESSION['personal_details']['perm_city_code'] 				= $requestJson[1]->PermanentCity;
            $_SESSION['personal_details']['perm_state_code'] 				= $requestJson[1]->PermanentState;
            $_SESSION['personal_details']['permanentcity'] 					= $permanentCity;
            $_SESSION['personal_details']['permanentstate'] 				= $permanentState;
            $_SESSION['personal_details']['curr_state_code'] 				= $requestJson[1]->CurrentState;
            $_SESSION['personal_details']['curr_city_code'] 				= $requestJson[1]->CurrentCity;
            $_SESSION['personal_details']['applicantname'] 					= $requestJson[1]->FName;
						if(isset($requestJson[1]->MName)) {
							$_SESSION['personal_details']['middlename'] 					= $requestJson[1]->MName;
						} else {
							$_SESSION['personal_details']['middlename'] 					= '';
						}
            $_SESSION['personal_details']['lastname'] 							= $requestJson[1]->LName;
            $_SESSION['personal_details']['gender'] 								= $requestJson[1]->Gender;
            $_SESSION['personal_details']['panno'] 									= $requestJson[1]->PAN;
            $_SESSION['personal_details']['dob'] 										= $birth_date;
            $_SESSION['personal_details']['permanentaddress1'] 			= $requestJson[1]->PermanentAddress1;
            $_SESSION['personal_details']['permanentaddress2'] 			= $requestJson[1]->PermanentAddress2;
            $_SESSION['personal_details']['permanentaddress3'] 			= $requestJson[1]->PermanentAddress3;
            $_SESSION['personal_details']['currentaddress1'] 				= $requestJson[1]->CurrentAddress1;
            $_SESSION['personal_details']['currentaddress2'] 				= $requestJson[1]->CurrentAddress2;
            $_SESSION['personal_details']['currentaddress3'] 				= $requestJson[1]->CurrentAddress3;
            $_SESSION['personal_details']['currentpincode'] 				= $requestJson[1]->CurrentPin;
            $_SESSION['personal_details']['currentstate'] 					= $currentState;
            $_SESSION['personal_details']['currentcity'] 						= $currentCity;
            $_SESSION['personal_details']['workexperiance'] 				= $requestJson[1]->CurrentWorkExp;
            $_SESSION['personal_details']['webpageno'] 							= 4;
            $_SESSION['personal_details']['totworkexperiance'] 			= $requestJson[1]->TotalWorkExp;
            $_SESSION['personal_details']['kycflag'] 								= $requestJson[1]->KYCFlag;
            $_SESSION['personal_details']['ProspectNumber'] 				= $responseJson->ProspectNumber;
						$_SESSION['personal_details']['post'] 									= 'NEXT';

						echo "page4";
						exit;
					}
					if($jsonDecode->PageNumber == '5') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						/*------------------------------------------------------------------------------------*/
						
						/*Array(
								[personal_details] =&gt; Array
										(
												[companyname] =&gt; IIFL HOLDINGS LTD.
												[emailid] =&gt; asasdasd@asdasd.com
												[salary] =&gt; 135000
												[mobileno] =&gt; 8882838485
												[obligation] =&gt; 10000
												[city] =&gt; BOM
												[CRMLeadID] =&gt; 1731450
												[maxloanamt] =&gt; 2500000
												[minloanamt] =&gt; 100000
												[maxEMI] =&gt; 58821
												[actualloanEMI] =&gt; 55156
												[roi_actual] =&gt; 14.5
												[roi_default] =&gt; 18
												[actual_tenure] =&gt; 60
												[tenure] =&gt; 48
												[processing_fee_actual] =&gt; 1
												[processing_fee_default] =&gt; 3
												[emi_diff] =&gt; 4663
												[appliedloanamt] =&gt; 2000000
												[processing_fee] =&gt; 20000
												[totalamountpayable] =&gt; 2290000
												[permanentpincode] =&gt; 400012
												[perm_city_code] =&gt; MBAI
												[perm_state_code] =&gt; MH
												[permanentcity] =&gt; Mumbai
												[permanentstate] =&gt; Maharashtra
												[curr_state_code] =&gt; MH
												[curr_city_code] =&gt; MBAI
												[applicantname] =&gt; Elvis
												[lastname] =&gt; Presley
												[gender] =&gt; M
												[panno] =&gt; ELVIS7654P
												[dob] =&gt; 1985-04-24
												[permanentaddress1] =&gt; saasdas
												[permanentaddress2] =&gt; asd
												[permanentaddress3] =&gt; asdasd
												[currentaddress1] =&gt; saasdas
												[currentaddress2] =&gt; asd
												[currentaddress3] =&gt; asdasd
												[currentpincode] =&gt; 400012
												[currentstate] =&gt; Maharashtra
												[currentcity] =&gt; Mumbai
												[workexperiance] =&gt; 83
												[webpageno] =&gt; 4
												[totworkexperiance] =&gt; 83
												[kycflag] =&gt; 0
												[ProspectNumber] =&gt; SL909250
												[residencetype] =&gt; 1
												[education] =&gt; PGRAD
												[marritalstatus] =&gt; Y
												[loanpurpose] =&gt; LH25
												[residencestability] =&gt; 4
										)
						

						
								[response] =&gt; "[{\"ProspectNumber\":\"SL909250\",\"CRMLeadID\":\"1731450\",\"CibilResponse\":\"0-Yes\",\"Status\":\"Approved in Principle\",\"MaxAmount\":2500000.00,\"Tenure\":60,\"EMI\":71000.00,\"ProcessingFee\":\"1.00\",\"ROI\":14.75,\"ErrorMsg\":\"\"}]"
								[slider_value] =&gt; 2038000
								[error_msg] =&gt; Pancard- Unable to Validate
								[post] =&gt; NEXT
								[manual] =&gt; Array
										(
												[otp] =&gt; 826398
										)

						[CIBIL] =&gt; Array
								(
										[cibilResponse] =&gt; 0-Yes
										[status] =&gt; Approved in Principle
										[revised_MaxAmount] =&gt; 2500000
										[revised_Tenure] =&gt; 60
										[revised_EMI] =&gt; 71000
										[revised_ProcessingFee] =&gt; 1.00
										[revised_ROI] =&gt; 14.75
								)
				
				)*/

						
						
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']							= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 						= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 								= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 						= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']								= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']								= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']			= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 								= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']					= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']								= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']							= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']									= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']									= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']										= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 			= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 			= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']			= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']				= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']				= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']					= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']				= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']				= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']				= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']					= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']				= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']					= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']					= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']			= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 								= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 							= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 				= xss_filter($requestJson[1]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 						= 100000;
						$_SESSION['personal_details']['tenure'] 								= $_SESSION['personal_details']['actual_tenure'] = xss_filter($requestJson[1]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 						= xss_filter($requestJson[1]->ROI);
						$_SESSION['personal_details']['processing_fee_actual'] 	= xss_filter($requestJson[1]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 					= xss_filter($requestJson[1]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 		= xss_filter($requestJson[1]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 				= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 					= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']							= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']					= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']						= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']			= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/
						$_SESSION['CIBIL']['cibilResponse'] 				= xss_filter($responseJson->CibilResponse);
						$_SESSION['CIBIL']['status'] 								= xss_filter($responseJson->Status);
						$_SESSION['CIBIL']['revised_MaxAmount'] 		= round(xss_filter($responseJson->MaxAmount));
						$_SESSION['CIBIL']['revised_Tenure'] 				= xss_filter($responseJson->Tenure);
						$_SESSION['CIBIL']['revised_EMI'] 					= round(xss_filter($responseJson->EMI));
						$_SESSION['CIBIL']['revised_ProcessingFee'] = round(xss_filter($responseJson->ProcessingFee));
						$_SESSION['CIBIL']['revised_ROI'] 					= xss_filter($responseJson->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/
						echo "page5";
						exit;
					}
					
					if($jsonDecode->PageNumber == '6') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']							= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 						= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 								= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 						= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']								= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']								= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']			= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 								= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']					= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']								= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']							= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']									= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']									= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']										= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 			= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 			= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']			= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']				= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']				= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']					= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']				= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']				= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']				= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']					= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']				= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']					= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']					= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']			= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 								= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 							= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 				= xss_filter($requestJson[3]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 						= 100000;
						$_SESSION['personal_details']['tenure'] 								= xss_filter($requestJson[3]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 						= xss_filter($requestJson[3]->ROI);
						$_SESSION['personal_details']['processing_fee_actual']	= xss_filter($requestJson[3]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 					= xss_filter($requestJson[3]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 		= xss_filter($requestJson[3]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']					= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']				= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']	= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/

						$_SESSION['personal_details']['appliedloanamt'] 				= round(xss_filter($requestJson[3]->AppliedLoanamount));
						$_SESSION['personal_details']['tenure'] 								= xss_filter($requestJson[3]->Tenure);
						$_SESSION['personal_details']['actualloanEMI'] 					= round(xss_filter($requestJson[3]->Emi));
						$_SESSION['personal_details']['processing_fee'] 				= round(xss_filter($requestJson[3]->Processingfee));
						$_SESSION['CIBIL']['revised_ROI'] 											= xss_filter($requestJson[3]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/
						echo "page6";
						exit;
					}
					
					if($jsonDecode->PageNumber == '8') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						$_SESSION['doc_uploads'] = '';
						$count = count($requestJson);
						for($i=4; $i<$count; $i++) {
							$_SESSION['doc_uploads'][] = $requestJson[$i];
						}
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']				= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 			= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 				= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 			= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']				= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']				= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']		= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 				= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']			= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']				= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']				= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']					= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']					= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']					= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 		= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 		= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']		= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']		= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']		= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']			= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']		= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']		= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']		= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']			= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']		= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']			= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']			= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']		= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 				= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 				= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 		= xss_filter($requestJson[3]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 			= 100000;
						$_SESSION['personal_details']['tenure'] 				= xss_filter($requestJson[3]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 			= xss_filter($requestJson[3]->ROI);
						$_SESSION['personal_details']['processing_fee_actual'] 	= xss_filter($requestJson[3]->Processingfee);
						$_SESSION['personal_details']['processing_fee'] 		= xss_filter($requestJson[3]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 			= xss_filter($requestJson[3]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 	= xss_filter($requestJson[3]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']				= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']			= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']		= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/

						 $_SESSION['CIBIL']['revised_MaxAmount'] 				= round(xss_filter($requestJson[3]->AppliedLoanamount));
						 $_SESSION['CIBIL']['revised_Tenure'] 					= xss_filter($requestJson[3]->Tenure);
						 $_SESSION['CIBIL']['revised_EMI'] 						= round(xss_filter($requestJson[3]->Emi));
						 $_SESSION['CIBIL']['revised_ProcessingFee'] 			= round(xss_filter($requestJson[3]->Processingfee));
						 $_SESSION['CIBIL']['revised_ROI'] 						= xss_filter($requestJson[3]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/


						echo "page8";
						exit;
					}
					
					if($jsonDecode->PageNumber == '9') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						$_SESSION['doc_uploads'] = '';
						$count = count($requestJson);
						for($i=4; $i<$count; $i++) {
							$_SESSION['doc_uploads'][] = $requestJson[$i];
						}
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']				= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 			= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 				= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 			= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']				= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']				= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']		= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 				= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']			= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']				= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']				= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']					= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']					= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']					= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 		= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 		= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']		= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']		= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']		= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']			= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']		= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']		= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']		= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']			= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']		= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']			= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']			= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']		= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 				= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 				= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 		= xss_filter($requestJson[3]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 			= 100000;
						$_SESSION['personal_details']['tenure'] 				= xss_filter($requestJson[3]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 			= xss_filter($requestJson[3]->ROI);
						$_SESSION['personal_details']['processing_fee_actual'] 	= xss_filter($requestJson[3]->Processingfee);
						$_SESSION['personal_details']['processing_fee'] 		= xss_filter($requestJson[3]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 			= xss_filter($requestJson[3]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 	= xss_filter($requestJson[3]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']				= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']			= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']		= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/

						 $_SESSION['CIBIL']['revised_MaxAmount'] 				= round(xss_filter($requestJson[3]->AppliedLoanamount));
						 $_SESSION['CIBIL']['revised_Tenure'] 					= xss_filter($requestJson[3]->Tenure);
						 $_SESSION['CIBIL']['revised_EMI'] 						= round(xss_filter($requestJson[3]->Emi));
						 $_SESSION['CIBIL']['revised_ProcessingFee'] 			= round(xss_filter($requestJson[3]->Processingfee));
						 $_SESSION['CIBIL']['revised_ROI'] 						= xss_filter($requestJson[3]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/


						echo "page9";
						exit;
					}	
					
					
					if($jsonDecode->PageNumber == '10') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']							= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 						= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 								= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 						= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']								= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']								= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']			= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 								= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']					= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']								= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']							= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']									= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']									= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']										= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 			= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 			= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']			= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']				= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']				= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']					= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']				= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']				= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']				= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']					= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']				= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']					= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']					= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']			= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 								= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 							= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 				= xss_filter($requestJson[1]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 						= 100000;
						$_SESSION['personal_details']['tenure'] 								= xss_filter($requestJson[1]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 						= xss_filter($requestJson[1]->ROI);
						$_SESSION['personal_details']['processing_fee_actual']	= xss_filter($requestJson[1]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 					= xss_filter($requestJson[1]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 		= xss_filter($requestJson[1]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']					= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']				= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']	= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						$_SESSION['CIBIL']['revised_MaxAmount']			= '';
						$_SESSION['CIBIL']['revised_Tenure']				= '';
						$_SESSION['CIBIL']['revised_EMI']						= '';
						$_SESSION['CIBIL']['revised_ProcessingFee']	= '';
						$_SESSION['CIBIL']['revised_ROI']						= '';
						$_SESSION['CIBIL']['revised_ROI']						= '';
						/*-----------------CIBIL SESSION STARTS-----------------*/
						// $_SESSION['CIBIL']['cibilResponse'] 					= xss_filter($requestJson[4]->CibilResponse);
						// $_SESSION['CIBIL']['status'] 							= xss_filter($requestJson[4]->Status);
						// $_SESSION['CIBIL']['revised_MaxAmount'] 				= round(xss_filter($requestJson[4]->MaxAmount));
						// $_SESSION['CIBIL']['revised_Tenure'] 					= xss_filter($requestJson[4]->Tenure);
						// $_SESSION['CIBIL']['revised_EMI'] 						= round(xss_filter($requestJson[4]->EMI));
						// $_SESSION['CIBIL']['revised_ProcessingFee'] 			= round(xss_filter($requestJson[4]->ProcessingFee));
						// $_SESSION['CIBIL']['revised_ROI'] 						= xss_filter($requestJson[4]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/
						/*--------------co-applicant sessions----------------*/
						$_SESSION['co_applicant_details']['companyName'] 									= xss_filter($requestJson[3]->CoCompanyName);
						$_SESSION['co_applicant_details']['otherCompanyName'] 						= xss_filter($requestJson[3]->CoOtherCompanyName);
						$_SESSION['co_applicant_details']['relationType'] 								= xss_filter($requestJson[3]->RelationwithApplicant);
						$_SESSION['co_applicant_details']['monthlySalary']								= xss_filter($requestJson[3]->CoMonthlySalary);
						$_SESSION['co_applicant_details']['currentEmi']										= xss_filter($requestJson[3]->CoMonthlyObligation);
						$_SESSION['co_applicant_details']['applicantname']								= xss_filter($requestJson[3]->CoFName);
						$_SESSION['co_applicant_details']['lastname']											= xss_filter($requestJson[3]->CoLName);
						$_SESSION['co_applicant_details']['middlename']										= xss_filter($requestJson[3]->CoMName);
						$_SESSION['co_applicant_details']['gender']												= xss_filter($requestJson[3]->CoGender);
						$_SESSION['co_applicant_details']['panno']												= xss_filter($requestJson[3]->CoPAN);
						$_SESSION['co_applicant_details']['dob']													= xss_filter($requestJson[3]->CoDOB);
						$_SESSION['co_applicant_details']['mobileno']											= xss_filter($requestJson[3]->CoMobileNo);
						$_SESSION['co_applicant_details']['alternatemobileno']						= xss_filter($requestJson[3]->CoAlternateMobileNo);
						$_SESSION['co_applicant_details']['emailid']											= xss_filter($requestJson[3]->CoPersonalEmailID);
						$_SESSION['co_applicant_details']['permanentaddress1']						= xss_filter($requestJson[3]->CoPermanentAddress1);
						$_SESSION['co_applicant_details']['permanentaddress2']						= xss_filter($requestJson[3]->CoPermanentAddress2);
						$_SESSION['co_applicant_details']['permanentaddress3']						= xss_filter($requestJson[3]->CoPermanentAddress3);
						$_SESSION['co_applicant_details']['permanentpincode']							= xss_filter($requestJson[3]->CoPermanentPin);
						$_SESSION['co_applicant_details']['permanentstate']								= '';
						$_SESSION['co_applicant_details']['permanentcity']								= '';
						$_SESSION['co_applicant_details']['perm_state_code']							= xss_filter($requestJson[3]->CoPermanentState);
						$_SESSION['co_applicant_details']['perm_city_code']								= xss_filter($requestJson[3]->CoPermanentCity);
						$_SESSION['co_applicant_details']['currentaddress1']							= xss_filter($requestJson[3]->CoCurrentAddress1);
						$_SESSION['co_applicant_details']['currentaddress2']							= xss_filter($requestJson[3]->CoCurrentAddress2);
						$_SESSION['co_applicant_details']['currentaddress3']							= xss_filter($requestJson[3]->CoCurrentAddress3);
						$_SESSION['co_applicant_details']['currentpincode']								= xss_filter($requestJson[3]->CoCurrentPin);
						$_SESSION['co_applicant_details']['currentstate']									= '';
						$_SESSION['co_applicant_details']['currentcity']									= '';
						$_SESSION['co_applicant_details']['curr_state_code'] 							= xss_filter($requestJson[3]->CoCurrentState);
						$_SESSION['co_applicant_details']['curr_city_code']  							= xss_filter($requestJson[3]->CoCurrentCity);
						$_SESSION['co_applicant_details']['workexperiance']								= xss_filter($requestJson[3]->CoCurrentWorkExp);
						$_SESSION['co_applicant_details']['totworkexperiance']						= xss_filter($requestJson[3]->CoTotalWorkExp);
						$_SESSION['co_applicant_details']['occupation']										= xss_filter($requestJson[3]->EmploymentType);
						$_SESSION['co_applicant_details']['cnamecoappnature']							= xss_filter($requestJson[3]->NatureOfBusiness);
						$_SESSION['co_applicant_details']['cnamecoappnatureprofession']		= xss_filter($requestJson[3]->Profession);
						$_SESSION['co_applicant_details']['cnamecoappnatureconstitution']	= xss_filter($requestJson[3]->ConstitutionType);
						/*-------------------------CIBIL response for co applicant----------------------------*/

						if($responseJson->CibilResponse == '0-Yes') {
							$_SESSION['co_applicant_details']['CIBIL']['flag'] 					= 'Yes';
						} else if($responseJson->CibilResponse == '1-NO') {
							$_SESSION['co_applicant_details']['CIBIL']['flag'] 					= 'No';
						} else if($responseJson->CibilResponse == '2-Null'){
							$_SESSION['co_applicant_details']['CIBIL']['flag'] 					= 'Null';
						} else {
							$_SESSION['co_applicant_details']['CIBIL']['flag'] 					= 'No';
						}
						$_SESSION['co_applicant_details']['CIBIL']['CibilResponse'] 				= xss_filter($responseJson->CibilResponse);
						$_SESSION['co_applicant_details']['CIBIL']['CIBILTotalEMI'] 				= round(xss_filter($responseJson->CIBILTotalEMI));
						$_SESSION['co_applicant_details']['CIBIL']['MaxAmount']							= round(xss_filter($responseJson->MaxAmount));
						$_SESSION['co_applicant_details']['CIBIL']['MaxTenure'] 						= round(xss_filter($responseJson->MaxTenure));
						$_SESSION['co_applicant_details']['CIBIL']['ROIDefault']						= round(xss_filter($responseJson->ROIDefault), 2);
						$_SESSION['co_applicant_details']['CIBIL']['ROIActual']							= round(xss_filter($responseJson->ROIActual), 2 );
						$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeDefault'] 	= round(xss_filter($responseJson->ProcessingFeeDefault));
						$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual']		= round(xss_filter($responseJson->ProcessingFeeActual));
						if($_SESSION['co_applicant_details']['CIBIL']['flag'] == 'Null') {
							echo "page10upload";
						} else {
							echo "page10";
						}						
						exit;
					}
					
					if($jsonDecode->PageNumber == '11') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']				= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 			= xss_filter($requestJson[1]->CompanyName);
						$_SESSION['personal_details']['salary'] 				= xss_filter($requestJson[1]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 			= xss_filter($requestJson[1]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']				= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']				= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']		= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 				= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']			= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']				= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']				= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']					= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']					= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']					= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 		= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 		= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']		= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']		= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']		= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']			= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']		= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']		= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']		= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']			= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']		= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']			= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']			= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']		= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 				= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 				= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 		= xss_filter($requestJson[4]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 			= 100000;
						$_SESSION['personal_details']['tenure'] 				= xss_filter($requestJson[4]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 			= xss_filter($requestJson[1]->ROI);
						$_SESSION['personal_details']['processing_fee_actual'] 	= xss_filter($requestJson[1]->Processingfee);
						$_SESSION['personal_details']['processing_fee'] 		= xss_filter($requestJson[1]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 			= xss_filter($requestJson[1]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 	= xss_filter($requestJson[1]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']				= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']			= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']		= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/
						// $_SESSION['CIBIL']['cibilResponse'] 					= xss_filter($requestJson[4]->CibilResponse);
						// $_SESSION['CIBIL']['status'] 							= xss_filter($requestJson[4]->Status);
						// $_SESSION['CIBIL']['revised_MaxAmount'] 				= round(xss_filter($requestJson[4]->MaxAmount));
						// $_SESSION['CIBIL']['revised_Tenure'] 					= xss_filter($requestJson[4]->Tenure);
						// $_SESSION['CIBIL']['revised_EMI'] 						= round(xss_filter($requestJson[4]->EMI));
						// $_SESSION['CIBIL']['revised_ProcessingFee'] 			= round(xss_filter($requestJson[4]->ProcessingFee));
						// $_SESSION['CIBIL']['revised_ROI'] 						= xss_filter($requestJson[4]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/

						$_SESSION['co_applicant_details']['companyName'] 					= xss_filter($requestJson[3]->CoCompanyName);
						$_SESSION['co_applicant_details']['otherCompanyName'] 				= xss_filter($requestJson[3]->CoOtherCompanyName);
						$_SESSION['co_applicant_details']['relationType'] 					= xss_filter($requestJson[3]->RelationwithApplicant);
						$_SESSION['co_applicant_details']['monthlySalary']					= xss_filter($requestJson[3]->CoMonthlySalary);
						$_SESSION['co_applicant_details']['currentEmi']						= xss_filter($requestJson[3]->CoMonthlyObligation);
						$_SESSION['co_applicant_details']['applicantname']					= xss_filter($requestJson[3]->CoFName);
						$_SESSION['co_applicant_details']['lastname']						= xss_filter($requestJson[3]->CoLName);
						$_SESSION['co_applicant_details']['middlename']						= xss_filter($requestJson[3]->CoMName);
						$_SESSION['co_applicant_details']['gender']							= xss_filter($requestJson[3]->CoGender);
						$_SESSION['co_applicant_details']['panno']							= xss_filter($requestJson[3]->CoPAN);
						$_SESSION['co_applicant_details']['dob']							= xss_filter($requestJson[3]->CoDOB);
						$_SESSION['co_applicant_details']['mobileno']						= xss_filter($requestJson[3]->CoMobileNo);
						$_SESSION['co_applicant_details']['alternatemobileno']				= xss_filter($requestJson[3]->CoAlternateMobileNo);
						$_SESSION['co_applicant_details']['emailid']						= xss_filter($requestJson[3]->CoPersonalEmailID);
						$_SESSION['co_applicant_details']['permanentaddress1']				= xss_filter($requestJson[3]->CoPermanentAddress1);
						$_SESSION['co_applicant_details']['permanentaddress2']				= xss_filter($requestJson[3]->CoPermanentAddress2);
						$_SESSION['co_applicant_details']['permanentaddress3']				= xss_filter($requestJson[3]->CoPermanentAddress3);
						$_SESSION['co_applicant_details']['permanentpincode']				= xss_filter($requestJson[3]->CoPermanentPin);
						$_SESSION['co_applicant_details']['permanentstate']					= '';
						$_SESSION['co_applicant_details']['permanentcity']					= '';
						$_SESSION['co_applicant_details']['perm_state_code']				= xss_filter($requestJson[3]->CoPermanentState);
						$_SESSION['co_applicant_details']['perm_city_code']					= xss_filter($requestJson[3]->CoPermanentCity);
						$_SESSION['co_applicant_details']['currentaddress1']				= xss_filter($requestJson[3]->CoCurrentAddress1);
						$_SESSION['co_applicant_details']['currentaddress2']				= xss_filter($requestJson[3]->CoCurrentAddress2);
						$_SESSION['co_applicant_details']['currentaddress3']				= xss_filter($requestJson[3]->CoCurrentAddress3);
						$_SESSION['co_applicant_details']['currentpincode']					= xss_filter($requestJson[3]->CoCurrentPin);
						$_SESSION['co_applicant_details']['currentstate']					= '';
						$_SESSION['co_applicant_details']['currentcity']					= '';
						$_SESSION['co_applicant_details']['curr_state_code'] 				= xss_filter($requestJson[3]->CoCurrentState);
						$_SESSION['co_applicant_details']['curr_city_code']  				= xss_filter($requestJson[3]->CoCurrentCity);
						$_SESSION['co_applicant_details']['workexperiance']					= xss_filter($requestJson[3]->CoCurrentWorkExp);
						$_SESSION['co_applicant_details']['totworkexperiance']				= xss_filter($requestJson[3]->CoTotalWorkExp);
						$_SESSION['co_applicant_details']['occupation']						= xss_filter($requestJson[3]->EmploymentType);
						$_SESSION['co_applicant_details']['cnamecoappnature']				= xss_filter($requestJson[3]->NatureOfBusiness);
						$_SESSION['co_applicant_details']['cnamecoappnatureprofession']		= xss_filter($requestJson[3]->Profession);
						$_SESSION['co_applicant_details']['cnamecoappnatureconstitution']	= xss_filter($requestJson[3]->ConstitutionType);
						
						
						$_SESSION['co_applicant_details']['CIBIL']['ROIActual']				= xss_filter($requestJson[4]->ROI);
						$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual']	= xss_filter($requestJson[4]->Processingfee);
						$_SESSION['co_applicant_details']['CIBIL']['MaxTenure']				= xss_filter($requestJson[4]->Tenure);
						$_SESSION['co_applicant_details']['CIBIL']['MaxAmount']				= xss_filter($requestJson[4]->AppliedLoanamount);
						
						
						echo "page11";
						exit;
					}
					
					if($jsonDecode->PageNumber == '12') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						
						$_SESSION['doc_uploads'] = '';
						$count = count($requestJson);
						for($i=5; $i<$count; $i++) {
							$_SESSION['doc_uploads'][] = $requestJson[$i];
						}
						
						
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']							= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 						= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 								= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 						= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']								= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']								= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']			= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 								= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']					= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']								= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']							= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']									= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']									= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']										= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 			= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 			= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']			= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']				= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']				= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']					= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']				= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']				= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']				= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']					= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']				= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']					= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']					= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']			= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 								= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 							= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 				= xss_filter($requestJson[4]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 						= 100000;
						$_SESSION['personal_details']['tenure'] 								= xss_filter($requestJson[4]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 						= xss_filter($requestJson[1]->ROI);
						$_SESSION['personal_details']['processing_fee_actual']	= xss_filter($requestJson[1]->Processingfee);
						$_SESSION['personal_details']['processing_fee'] 				= xss_filter($requestJson[1]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 					= xss_filter($requestJson[1]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 		= xss_filter($requestJson[1]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']					= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']				= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']	= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/
						// $_SESSION['CIBIL']['cibilResponse'] 					= xss_filter($requestJson[4]->CibilResponse);
						// $_SESSION['CIBIL']['status'] 							= xss_filter($requestJson[4]->Status);
						// $_SESSION['CIBIL']['revised_MaxAmount'] 				= round(xss_filter($requestJson[4]->MaxAmount));
						// $_SESSION['CIBIL']['revised_Tenure'] 					= xss_filter($requestJson[4]->Tenure);
						// $_SESSION['CIBIL']['revised_EMI'] 						= round(xss_filter($requestJson[4]->EMI));
						// $_SESSION['CIBIL']['revised_ProcessingFee'] 			= round(xss_filter($requestJson[4]->ProcessingFee));
						// $_SESSION['CIBIL']['revised_ROI'] 						= xss_filter($requestJson[4]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/

						$_SESSION['co_applicant_details']['companyName'] 									= xss_filter($requestJson[3]->CoCompanyName);
						$_SESSION['co_applicant_details']['otherCompanyName'] 						= xss_filter($requestJson[3]->CoOtherCompanyName);
						$_SESSION['co_applicant_details']['relationType'] 								= xss_filter($requestJson[3]->RelationwithApplicant);
						$_SESSION['co_applicant_details']['monthlySalary']								= xss_filter($requestJson[3]->CoMonthlySalary);
						$_SESSION['co_applicant_details']['currentEmi']										= xss_filter($requestJson[3]->CoMonthlyObligation);
						$_SESSION['co_applicant_details']['applicantname']								= xss_filter($requestJson[3]->CoFName);
						$_SESSION['co_applicant_details']['lastname']											= xss_filter($requestJson[3]->CoLName);
						$_SESSION['co_applicant_details']['middlename']										= xss_filter($requestJson[3]->CoMName);
						$_SESSION['co_applicant_details']['gender']												= xss_filter($requestJson[3]->CoGender);
						$_SESSION['co_applicant_details']['panno']												= xss_filter($requestJson[3]->CoPAN);
						$_SESSION['co_applicant_details']['dob']													= xss_filter($requestJson[3]->CoDOB);
						$_SESSION['co_applicant_details']['mobileno']											= xss_filter($requestJson[3]->CoMobileNo);
						$_SESSION['co_applicant_details']['alternatemobileno']						= xss_filter($requestJson[3]->CoAlternateMobileNo);
						$_SESSION['co_applicant_details']['emailid']											= xss_filter($requestJson[3]->CoPersonalEmailID);
						$_SESSION['co_applicant_details']['permanentaddress1']						= xss_filter($requestJson[3]->CoPermanentAddress1);
						$_SESSION['co_applicant_details']['permanentaddress2']						= xss_filter($requestJson[3]->CoPermanentAddress2);
						$_SESSION['co_applicant_details']['permanentaddress3']						= xss_filter($requestJson[3]->CoPermanentAddress3);
						$_SESSION['co_applicant_details']['permanentpincode']							= xss_filter($requestJson[3]->CoPermanentPin);
						$_SESSION['co_applicant_details']['permanentstate']								= '';
						$_SESSION['co_applicant_details']['permanentcity']								= '';
						$_SESSION['co_applicant_details']['perm_state_code']							= xss_filter($requestJson[3]->CoPermanentState);
						$_SESSION['co_applicant_details']['perm_city_code']								= xss_filter($requestJson[3]->CoPermanentCity);
						$_SESSION['co_applicant_details']['currentaddress1']							= xss_filter($requestJson[3]->CoCurrentAddress1);
						$_SESSION['co_applicant_details']['currentaddress2']							= xss_filter($requestJson[3]->CoCurrentAddress2);
						$_SESSION['co_applicant_details']['currentaddress3']							= xss_filter($requestJson[3]->CoCurrentAddress3);
						$_SESSION['co_applicant_details']['currentpincode']								= xss_filter($requestJson[3]->CoCurrentPin);
						$_SESSION['co_applicant_details']['currentstate']									= '';
						$_SESSION['co_applicant_details']['currentcity']									= '';
						$_SESSION['co_applicant_details']['curr_state_code'] 							= xss_filter($requestJson[3]->CoCurrentState);
						$_SESSION['co_applicant_details']['curr_city_code']  							= xss_filter($requestJson[3]->CoCurrentCity);
						$_SESSION['co_applicant_details']['workexperiance']								= xss_filter($requestJson[3]->CoCurrentWorkExp);
						$_SESSION['co_applicant_details']['totworkexperiance']						= xss_filter($requestJson[3]->CoTotalWorkExp);
						$_SESSION['co_applicant_details']['occupation']										= xss_filter($requestJson[3]->EmploymentType);
						$_SESSION['co_applicant_details']['cnamecoappnature']							= xss_filter($requestJson[3]->NatureOfBusiness);
						$_SESSION['co_applicant_details']['cnamecoappnatureprofession']		= xss_filter($requestJson[3]->Profession);
						$_SESSION['co_applicant_details']['cnamecoappnatureconstitution']	= xss_filter($requestJson[3]->ConstitutionType);
						$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual']	= xss_filter($requestJson[4]->Processingfee);
						$_SESSION['co_applicant_details']['CIBIL']['ROIActual']						= $_SESSION['CIBIL']['revised_ROI']	= xss_filter($requestJson[4]->ROI);
						$_SESSION['co_applicant_details']['CIBIL']['processing_fee'] 			= $_SESSION['CIBIL']['revised_ProcessingFee'] = xss_filter($requestJson[4]->Processingfee);

						echo "page12";
						exit;
					}
					
					if($jsonDecode->PageNumber == '13') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						$_SESSION['doc_uploads'] = '';
						$count = count($requestJson);
						for($i=5; $i<$count; $i++) {
							$_SESSION['doc_uploads'][] = $requestJson[$i];
						}
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']				= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 			= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 				= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 			= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']				= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']				= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']		= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 				= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']			= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']				= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']				= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']					= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']					= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']					= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 		= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 		= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']		= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']		= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']		= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']			= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']		= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']		= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']		= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']			= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']		= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']			= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']			= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']		= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 				= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 				= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 		= xss_filter($requestJson[4]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 			= 100000;
						$_SESSION['personal_details']['tenure'] 				= xss_filter($requestJson[4]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 			= xss_filter($requestJson[4]->ROI);
						$_SESSION['personal_details']['processing_fee_actual'] 	= xss_filter($requestJson[4]->Processingfee);
						$_SESSION['personal_details']['processing_fee'] 		= xss_filter($requestJson[4]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 			= xss_filter($requestJson[4]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 	= xss_filter($requestJson[4]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']				= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']			= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']		= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/
						// $_SESSION['CIBIL']['cibilResponse'] 					= xss_filter($requestJson[4]->CibilResponse);
						// $_SESSION['CIBIL']['status'] 							= xss_filter($requestJson[4]->Status);
						// $_SESSION['CIBIL']['revised_MaxAmount'] 				= round(xss_filter($requestJson[4]->MaxAmount));
						// $_SESSION['CIBIL']['revised_Tenure'] 					= xss_filter($requestJson[4]->Tenure);
						// $_SESSION['CIBIL']['revised_EMI'] 						= round(xss_filter($requestJson[4]->EMI));
						// $_SESSION['CIBIL']['revised_ProcessingFee'] 			= round(xss_filter($requestJson[4]->ProcessingFee));
						// $_SESSION['CIBIL']['revised_ROI'] 						= xss_filter($requestJson[4]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/

						$_SESSION['co_applicant_details']['companyName'] 					= xss_filter($requestJson[3]->CoCompanyName);
						$_SESSION['co_applicant_details']['otherCompanyName'] 				= xss_filter($requestJson[3]->CoOtherCompanyName);
						$_SESSION['co_applicant_details']['relationType'] 					= xss_filter($requestJson[3]->RelationwithApplicant);
						$_SESSION['co_applicant_details']['monthlySalary']					= xss_filter($requestJson[3]->CoMonthlySalary);
						$_SESSION['co_applicant_details']['currentEmi']						= xss_filter($requestJson[3]->CoMonthlyObligation);
						$_SESSION['co_applicant_details']['applicantname']					= xss_filter($requestJson[3]->CoFName);
						$_SESSION['co_applicant_details']['lastname']						= xss_filter($requestJson[3]->CoLName);
						$_SESSION['co_applicant_details']['middlename']						= xss_filter($requestJson[3]->CoMName);
						$_SESSION['co_applicant_details']['gender']							= xss_filter($requestJson[3]->CoGender);
						$_SESSION['co_applicant_details']['panno']							= xss_filter($requestJson[3]->CoPAN);
						$_SESSION['co_applicant_details']['dob']							= xss_filter($requestJson[3]->CoDOB);
						$_SESSION['co_applicant_details']['mobileno']						= xss_filter($requestJson[3]->CoMobileNo);
						$_SESSION['co_applicant_details']['alternatemobileno']				= xss_filter($requestJson[3]->CoAlternateMobileNo);
						$_SESSION['co_applicant_details']['emailid']						= xss_filter($requestJson[3]->CoPersonalEmailID);
						$_SESSION['co_applicant_details']['permanentaddress1']				= xss_filter($requestJson[3]->CoPermanentAddress1);
						$_SESSION['co_applicant_details']['permanentaddress2']				= xss_filter($requestJson[3]->CoPermanentAddress2);
						$_SESSION['co_applicant_details']['permanentaddress3']				= xss_filter($requestJson[3]->CoPermanentAddress3);
						$_SESSION['co_applicant_details']['permanentpincode']				= xss_filter($requestJson[3]->CoPermanentPin);
						$_SESSION['co_applicant_details']['permanentstate']					= '';
						$_SESSION['co_applicant_details']['permanentcity']					= '';
						$_SESSION['co_applicant_details']['perm_state_code']				= xss_filter($requestJson[3]->CoPermanentState);
						$_SESSION['co_applicant_details']['perm_city_code']					= xss_filter($requestJson[3]->CoPermanentCity);
						$_SESSION['co_applicant_details']['currentaddress1']				= xss_filter($requestJson[3]->CoCurrentAddress1);
						$_SESSION['co_applicant_details']['currentaddress2']				= xss_filter($requestJson[3]->CoCurrentAddress2);
						$_SESSION['co_applicant_details']['currentaddress3']				= xss_filter($requestJson[3]->CoCurrentAddress3);
						$_SESSION['co_applicant_details']['currentpincode']					= xss_filter($requestJson[3]->CoCurrentPin);
						$_SESSION['co_applicant_details']['currentstate']					= '';
						$_SESSION['co_applicant_details']['currentcity']					= '';
						$_SESSION['co_applicant_details']['curr_state_code'] 				= xss_filter($requestJson[3]->CoCurrentState);
						$_SESSION['co_applicant_details']['curr_city_code']  				= xss_filter($requestJson[3]->CoCurrentCity);
						$_SESSION['co_applicant_details']['workexperiance']					= xss_filter($requestJson[3]->CoCurrentWorkExp);
						$_SESSION['co_applicant_details']['totworkexperiance']				= xss_filter($requestJson[3]->CoTotalWorkExp);
						$_SESSION['co_applicant_details']['occupation']						= xss_filter($requestJson[3]->EmploymentType);
						$_SESSION['co_applicant_details']['cnamecoappnature']				= xss_filter($requestJson[3]->NatureOfBusiness);
						$_SESSION['co_applicant_details']['cnamecoappnatureprofession']		= xss_filter($requestJson[3]->Profession);
						$_SESSION['co_applicant_details']['cnamecoappnatureconstitution']	= xss_filter($requestJson[3]->ConstitutionType);
						$_SESSION['co_applicant_details']['CIBIL']['ROIActual']	= $_SESSION['CIBIL']['revised_ROI']	= xss_filter($requestJson[4]->ROI);
						$_SESSION['co_applicant_details']['CIBIL']['processing_fee'] = $_SESSION['CIBIL']['revised_ProcessingFee'] = xss_filter($requestJson[4]->Processingfee);
						$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual']	= xss_filter($requestJson[4]->Processingfee);
						echo "page13";
						exit;
					}
					
					if($jsonDecode->PageNumber == '14') {
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
						$_SESSION['doc_uploads'] = '';
						$count = count($requestJson);
						for($i=5; $i<$count; $i++) {
							$_SESSION['doc_uploads'][] = $requestJson[$i];
						}
						/*------------------From 2nd object of the array------------------------*/
						$_SESSION['personal_details']['CRMLeadID']				= xss_filter($requestJson[1]->CRMLeadID);
						$_SESSION['personal_details']['companyname'] 			= xss_filter($requestJson[0]->CompanyName);
						$_SESSION['personal_details']['salary'] 				= xss_filter($requestJson[0]->MonthlySalary);
						$_SESSION['personal_details']['obligation'] 			= xss_filter($requestJson[0]->MonthlyObligation);
						$_SESSION['personal_details']['emailid']				= xss_filter($requestJson[0]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno']				= xss_filter($requestJson[0]->MobileNo);
						$_SESSION['personal_details']['alternatemobileno']		= xss_filter($requestJson[1]->AlternateMobileNo);
						$_SESSION['personal_details']['kycflag'] 				= xss_filter($requestJson[1]->KYCFlag);
						$_SESSION['personal_details']['applicantname']			= xss_filter($requestJson[1]->FName);
						$_SESSION['personal_details']['lastname']				= xss_filter($requestJson[1]->LName);
						$_SESSION['personal_details']['middlename']				= xss_filter($requestJson[1]->MName);
						$_SESSION['personal_details']['gender']					= xss_filter($requestJson[1]->Gender);
						$_SESSION['personal_details']['panno']					= xss_filter($requestJson[1]->PAN);
						$_SESSION['personal_details']['dob']					= xss_filter($requestJson[1]->DOB);
						$_SESSION['personal_details']['permanentaddress1'] 		= xss_filter($requestJson[1]->PermanentAddress1);
						$_SESSION['personal_details']['permanentaddress2'] 		= xss_filter($requestJson[1]->PermanentAddress2);
						$_SESSION['personal_details']['permanentaddress3']		= xss_filter($requestJson[1]->PermanentAddress3);
						$_SESSION['personal_details']['permanentpincode']		= xss_filter($requestJson[1]->PermanentPin);
						$_SESSION['personal_details']['perm_state_code']		= xss_filter($requestJson[1]->PermanentState);
						$_SESSION['personal_details']['perm_city_code']			= xss_filter($requestJson[1]->PermanentCity);
						$_SESSION['personal_details']['currentaddress1']		= xss_filter($requestJson[1]->CurrentAddress1);
						$_SESSION['personal_details']['currentaddress2']		= xss_filter($requestJson[1]->CurrentAddress2);
						$_SESSION['personal_details']['currentaddress3']		= xss_filter($requestJson[1]->CurrentAddress3);
						$_SESSION['personal_details']['currentpincode']			= xss_filter($requestJson[1]->CurrentPin);
						$_SESSION['personal_details']['curr_state_code']		= xss_filter($requestJson[1]->CurrentState);
						$_SESSION['personal_details']['curr_city_code']			= xss_filter($requestJson[1]->CurrentCity);
						$_SESSION['personal_details']['workexperiance']			= xss_filter($requestJson[1]->CurrentWorkExp);
						$_SESSION['personal_details']['totworkexperiance']		= xss_filter($requestJson[1]->TotalWorkExp);
						$_SESSION['personal_details']['emailid'] 				= xss_filter($requestJson[1]->PersonalEmailID);
						$_SESSION['personal_details']['mobileno'] 				= xss_filter($requestJson[1]->MobileNo);
						$_SESSION['personal_details']['appliedloanamt'] 		= xss_filter($requestJson[4]->AppliedLoanamount);
						$_SESSION['personal_details']['minloanamt'] 			= 100000;
						$_SESSION['personal_details']['tenure'] 				= xss_filter($requestJson[4]->Tenure);
						$_SESSION['personal_details']['roi_actual'] 			= xss_filter($requestJson[4]->ROI);
						$_SESSION['personal_details']['processing_fee_actual'] 	= xss_filter($requestJson[4]->Processingfee);
						$_SESSION['personal_details']['processing_fee'] 		= xss_filter($requestJson[4]->Processingfee);
						$_SESSION['personal_details']['actualloanEMI'] 			= xss_filter($requestJson[4]->Emi);
						$_SESSION['personal_details']['totalamountpayable'] 	= xss_filter($requestJson[4]->TotalPayableAmount);
						/*------------------From 2nd object of the array Ends------------------------*/
						/* ---------------From 3rd object of an array starts. ------------------------*/
						$_SESSION['personal_details']['ProspectNumber'] 		= xss_filter($requestJson[2]->ProspectNumber);
						$_SESSION['personal_details']['residencetype'] 			= xss_filter($requestJson[2]->ResidenceType);
						$_SESSION['personal_details']['education']				= xss_filter($requestJson[2]->Education);
						$_SESSION['personal_details']['marritalstatus']			= xss_filter($requestJson[2]->MaritalStatus);
						$_SESSION['personal_details']['loanpurpose']			= xss_filter($requestJson[2]->PurposeofLoan);
						$_SESSION['personal_details']['residencestability']		= xss_filter($requestJson[2]->ResidenceStability);
							/* ---------------From 3rd object of an array ends-------------*/
						/*-----------------CIBIL SESSION STARTS-----------------*/
						// $_SESSION['CIBIL']['cibilResponse'] 					= xss_filter($requestJson[4]->CibilResponse);
						// $_SESSION['CIBIL']['status'] 							= xss_filter($requestJson[4]->Status);
						// $_SESSION['CIBIL']['revised_MaxAmount'] 				= round(xss_filter($requestJson[4]->MaxAmount));
						// $_SESSION['CIBIL']['revised_Tenure'] 					= xss_filter($requestJson[4]->Tenure);
						// $_SESSION['CIBIL']['revised_EMI'] 						= round(xss_filter($requestJson[4]->EMI));
						// $_SESSION['CIBIL']['revised_ProcessingFee'] 			= round(xss_filter($requestJson[4]->ProcessingFee));
						// $_SESSION['CIBIL']['revised_ROI'] 						= xss_filter($requestJson[4]->ROI);
						/*-----------------CIBIL SESSION ENDS--------------------*/

						$_SESSION['co_applicant_details']['companyName'] 					= xss_filter($requestJson[3]->CoCompanyName);
						$_SESSION['co_applicant_details']['otherCompanyName'] 				= xss_filter($requestJson[3]->CoOtherCompanyName);
						$_SESSION['co_applicant_details']['relationType'] 					= xss_filter($requestJson[3]->RelationwithApplicant);
						$_SESSION['co_applicant_details']['monthlySalary']					= xss_filter($requestJson[3]->CoMonthlySalary);
						$_SESSION['co_applicant_details']['currentEmi']						= xss_filter($requestJson[3]->CoMonthlyObligation);
						$_SESSION['co_applicant_details']['applicantname']					= xss_filter($requestJson[3]->CoFName);
						$_SESSION['co_applicant_details']['lastname']						= xss_filter($requestJson[3]->CoLName);
						$_SESSION['co_applicant_details']['middlename']						= xss_filter($requestJson[3]->CoMName);
						$_SESSION['co_applicant_details']['gender']							= xss_filter($requestJson[3]->CoGender);
						$_SESSION['co_applicant_details']['panno']							= xss_filter($requestJson[3]->CoPAN);
						$_SESSION['co_applicant_details']['dob']							= xss_filter($requestJson[3]->CoDOB);
						$_SESSION['co_applicant_details']['mobileno']						= xss_filter($requestJson[3]->CoMobileNo);
						$_SESSION['co_applicant_details']['alternatemobileno']				= xss_filter($requestJson[3]->CoAlternateMobileNo);
						$_SESSION['co_applicant_details']['emailid']						= xss_filter($requestJson[3]->CoPersonalEmailID);
						$_SESSION['co_applicant_details']['permanentaddress1']				= xss_filter($requestJson[3]->CoPermanentAddress1);
						$_SESSION['co_applicant_details']['permanentaddress2']				= xss_filter($requestJson[3]->CoPermanentAddress2);
						$_SESSION['co_applicant_details']['permanentaddress3']				= xss_filter($requestJson[3]->CoPermanentAddress3);
						$_SESSION['co_applicant_details']['permanentpincode']				= xss_filter($requestJson[3]->CoPermanentPin);
						$_SESSION['co_applicant_details']['permanentstate']					= '';
						$_SESSION['co_applicant_details']['permanentcity']					= '';
						$_SESSION['co_applicant_details']['perm_state_code']				= xss_filter($requestJson[3]->CoPermanentState);
						$_SESSION['co_applicant_details']['perm_city_code']					= xss_filter($requestJson[3]->CoPermanentCity);
						$_SESSION['co_applicant_details']['currentaddress1']				= xss_filter($requestJson[3]->CoCurrentAddress1);
						$_SESSION['co_applicant_details']['currentaddress2']				= xss_filter($requestJson[3]->CoCurrentAddress2);
						$_SESSION['co_applicant_details']['currentaddress3']				= xss_filter($requestJson[3]->CoCurrentAddress3);
						$_SESSION['co_applicant_details']['currentpincode']					= xss_filter($requestJson[3]->CoCurrentPin);
						$_SESSION['co_applicant_details']['currentstate']					= '';
						$_SESSION['co_applicant_details']['currentcity']					= '';
						$_SESSION['co_applicant_details']['curr_state_code'] 				= xss_filter($requestJson[3]->CoCurrentState);
						$_SESSION['co_applicant_details']['curr_city_code']  				= xss_filter($requestJson[3]->CoCurrentCity);
						$_SESSION['co_applicant_details']['workexperiance']					= xss_filter($requestJson[3]->CoCurrentWorkExp);
						$_SESSION['co_applicant_details']['totworkexperiance']				= xss_filter($requestJson[3]->CoTotalWorkExp);
						$_SESSION['co_applicant_details']['occupation']						= xss_filter($requestJson[3]->EmploymentType);
						$_SESSION['co_applicant_details']['cnamecoappnature']				= xss_filter($requestJson[3]->NatureOfBusiness);
						$_SESSION['co_applicant_details']['cnamecoappnatureprofession']		= xss_filter($requestJson[3]->Profession);
						$_SESSION['co_applicant_details']['cnamecoappnatureconstitution']	= xss_filter($requestJson[3]->ConstitutionType);
						$_SESSION['co_applicant_details']['CIBIL']['ROIActual']	= $_SESSION['CIBIL']['revised_ROI']	= xss_filter($requestJson[4]->ROI);
						$_SESSION['co_applicant_details']['CIBIL']['processing_fee'] = $_SESSION['CIBIL']['revised_ProcessingFee'] = xss_filter($requestJson[4]->Processingfee);

						echo "page14";
						exit;
					}
					
					if($jsonDecode->PageNumber == '15') {
						
						//$count = count($requestJson);
						//$requestJson = my_array_unique($requestJson);
						//$count = count($requestJson);
						
						echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						echo '<pre>'; print_r($requestJson); echo '</pre>';
						echo '<pre>'; print_r($responseJson); echo '</pre>';
						exit;
						
						$_SESSION['personal_details']['companyname'] 						= $requestJson[0]->CompanyName;
						$_SESSION['personal_details']['emailid'] 								= $requestJson[0]->PersonalEmailID;
						$_SESSION['personal_details']['salary'] 								= $requestJson[0]->MonthlySalary;
						$_SESSION['personal_details']['mobileno'] 							= $requestJson[0]->MobileNo;
						$_SESSION['personal_details']['obligation'] 						= $requestJson[0]->MonthlyObligation;
						$_SESSION['personal_details']['city'] 									= $requestJson[0]->City;
						$_SESSION['personal_details']['CRMLeadID'] 							= $requestJson[1]->CRMLeadID;
						$_SESSION['personal_details']['maxloanamt'] 						= $obj[0]->MaxAmount;
						$_SESSION['personal_details']['minloanamt'] 						= $minimum_amount;
						$_SESSION['personal_details']['maxEMI'] 								= '';
						$_SESSION['personal_details']['actualloanEMI'] 					= $requestJson[3]->Emi;
						$_SESSION['personal_details']['roi_actual'] 						= $obj[0]->ROI;
						$_SESSION['personal_details']['roi_default'] 						= '';
						$_SESSION['personal_details']['actual_tenure'] 					= $obj[0]->Tenure;
						$_SESSION['personal_details']['tenure'] 								= $requestJson[3]->Tenure;
						$_SESSION['personal_details']['processing_fee_actual'] 	= $obj[0]->ProcessingFee;
						$_SESSION['personal_details']['processing_fee_default'] = '';
						$_SESSION['personal_details']['emi_diff'] 							= '';
						$_SESSION['personal_details']['appliedloanamt'] 				= $requestJson[3]->AppliedLoanamount;
						$_SESSION['personal_details']['processing_fee'] 				= $requestJson[3]->Processingfee;
						$_SESSION['personal_details']['totalamountpayable'] 		= $requestJson[3]->TotalPayableAmount;
						$_SESSION['personal_details']['permanentpincode'] 			= $requestJson[1]->PermanentPin;
						$_SESSION['personal_details']['perm_city_code'] 				= $requestJson[1]->PermanentCity;
						$_SESSION['personal_details']['perm_state_code'] 				= $requestJson[1]->PermanentState;
						$_SESSION['personal_details']['permanentcity'] 					= $requestJson[1]->PermanentCity;
						$_SESSION['personal_details']['permanentstate'] 				= $requestJson[1]->PermanentState;
						$_SESSION['personal_details']['curr_state_code'] 				= $requestJson[1]->CurrentState;
						$_SESSION['personal_details']['curr_city_code'] 				= $requestJson[1]->CurrentCity;
						$_SESSION['personal_details']['applicantname'] 					= $requestJson[1]->FName;
						$_SESSION['personal_details']['lastname'] 							= $requestJson[1]->LName;
						$_SESSION['personal_details']['gender'] 								= $requestJson[1]->Gender;
						$_SESSION['personal_details']['panno'] 									= $requestJson[1]->PAN;
						$_SESSION['personal_details']['dob'] 										= $requestJson[1]->DOB;
						$_SESSION['personal_details']['permanentaddress1'] 			= $requestJson[1]->PermanentAddress1;
						$_SESSION['personal_details']['permanentaddress2'] 			= $requestJson[1]->PermanentAddress2;
						$_SESSION['personal_details']['permanentaddress3']	 		= $requestJson[1]->PermanentAddress3;
						$_SESSION['personal_details']['currentaddress1'] 				= $requestJson[1]->CurrentAddress1;
						$_SESSION['personal_details']['currentaddress2'] 				= $requestJson[1]->CurrentAddress2;
						$_SESSION['personal_details']['currentaddress3'] 				= $requestJson[1]->CurrentAddress3;
						$_SESSION['personal_details']['currentpincode'] 				= $requestJson[1]->CurrentPin;
						$_SESSION['personal_details']['currentstate'] 					= $requestJson[1]->CurrentState;
						$_SESSION['personal_details']['currentcity'] 						= $requestJson[1]->CurrentCity;
						$_SESSION['personal_details']['workexperiance'] 				= $requestJson[1]->CurrentWorkExp;
						$_SESSION['personal_details']['webpageno'] 							= $requestJson[1]->PageNumber;
						$_SESSION['personal_details']['totworkexperiance'] 			= $requestJson[1]->TotalWorkExp;
						$_SESSION['personal_details']['kycflag'] 								= $requestJson[1]->KYCFlag;
						$_SESSION['personal_details']['ProspectNumber'] 				= $requestJson[2]->ProspectNumber;
						$_SESSION['personal_details']['residencetype'] 					= $requestJson[2]->ResidenceType;
						$_SESSION['personal_details']['education'] 							= $requestJson[2]->Education;
						$_SESSION['personal_details']['marritalstatus'] 				= $requestJson[2]->MaritalStatus;
						$_SESSION['personal_details']['loanpurpose'] 						= $requestJson[2]->PurposeofLoan;
						
						switch($requestJson[2]->ResidenceStability) {
							case 1:  $_SESSION['personal_details']['residencestability'] = 1;
											 break;
							case 6:	 $_SESSION['personal_details']['residencestability'] = 2;
											 break;
							case 18: $_SESSION['personal_details']['residencestability'] = 3;
											 break;
							case 27: $_SESSION['personal_details']['residencestability'] = 4;
											 break;
						}
						
						$_SESSION['CIBIL']['cibilResponse'] 				= $obj[0]->CibilResponse;
						$_SESSION['CIBIL']['status'] 								= $obj[0]->Status;
						$_SESSION['CIBIL']['revised_MaxAmount'] 		= $obj[0]->MaxAmount;
						$_SESSION['CIBIL']['revised_Tenure'] 				= $obj[0]->Tenure;
						$_SESSION['CIBIL']['revised_EMI'] 					= '';
						$_SESSION['CIBIL']['revised_ProcessingFee'] = $obj[0]->ProcessingFee;
						$_SESSION['CIBIL']['revised_ROI'] 					= $obj[0]->ROI;
						

						$_SESSION['perfios']['status'] 					= 'Failed';
            $_SESSION['perfios']['transaction_id'] 	= $responseJson->TransactionId;
            $_SESSION['perfios']['bank_name'] 			= $requestJson[4]->InstitutionName;
						
						echo "page15";
						exit;
					}
					
					
					if($jsonDecode->PageNumber == '16') {
						$requestJson = my_array_unique($requestJson);
						$count = count($requestJson);
						
						//echo '<pre>'; print_r($jsonDecode); echo '</pre>';
						//echo '<pre>'; print_r($requestJson); echo '</pre>';
						//echo '<pre>'; print_r($responseJson); echo '</pre>';
						//exit;
											
						$_SESSION['personal_details']['companyname'] 						= $requestJson[0]->CompanyName;
						$_SESSION['personal_details']['emailid'] 								= $requestJson[0]->PersonalEmailID;
						$_SESSION['personal_details']['salary'] 								= $requestJson[0]->MonthlySalary;
						$_SESSION['personal_details']['mobileno'] 							= $requestJson[0]->MobileNo;
						$_SESSION['personal_details']['obligation'] 						= $requestJson[0]->MonthlyObligation;
						$_SESSION['personal_details']['city'] 									= $requestJson[0]->City;
						$_SESSION['personal_details']['CRMLeadID'] 							= $requestJson[1]->CRMLeadID;
						$_SESSION['personal_details']['maxloanamt'] 						= $obj[0]->MaxAmount;
						$_SESSION['personal_details']['minloanamt'] 						= $minimum_amount;
						$_SESSION['personal_details']['maxEMI'] 								= '';
						$_SESSION['personal_details']['roi_actual'] 						= $obj[0]->ROI;
						$_SESSION['personal_details']['roi_default'] 						= '';
						$_SESSION['personal_details']['actual_tenure'] 					= $obj[0]->Tenure;
						$_SESSION['personal_details']['processing_fee_actual'] 	= $obj[0]->ProcessingFee;
						$_SESSION['personal_details']['processing_fee_default'] = '';
						$_SESSION['personal_details']['emi_diff'] 							= '';
						$_SESSION['personal_details']['permanentpincode'] 			= $requestJson[1]->PermanentPin;
						$_SESSION['personal_details']['perm_city_code'] 				= $requestJson[1]->PermanentCity;
						$_SESSION['personal_details']['perm_state_code'] 				= $requestJson[1]->PermanentState;
						$_SESSION['personal_details']['permanentcity'] 					= $requestJson[1]->PermanentCity;
						$_SESSION['personal_details']['permanentstate'] 				= $requestJson[1]->PermanentState;
						$_SESSION['personal_details']['curr_state_code'] 				= $requestJson[1]->CurrentState;
						$_SESSION['personal_details']['curr_city_code'] 				= $requestJson[1]->CurrentCity;
						$_SESSION['personal_details']['applicantname'] 					= $requestJson[1]->FName;
						$_SESSION['personal_details']['lastname'] 							= $requestJson[1]->LName;
						$_SESSION['personal_details']['gender'] 								= $requestJson[1]->Gender;
						$_SESSION['personal_details']['panno'] 									= $requestJson[1]->PAN;
						$_SESSION['personal_details']['dob'] 										= $requestJson[1]->DOB;
						$_SESSION['personal_details']['permanentaddress1'] 			= $requestJson[1]->PermanentAddress1;
						$_SESSION['personal_details']['permanentaddress2'] 			= $requestJson[1]->PermanentAddress2;
						$_SESSION['personal_details']['permanentaddress3']	 		= $requestJson[1]->PermanentAddress3;
						$_SESSION['personal_details']['currentaddress1'] 				= $requestJson[1]->CurrentAddress1;
						$_SESSION['personal_details']['currentaddress2'] 				= $requestJson[1]->CurrentAddress2;
						$_SESSION['personal_details']['currentaddress3'] 				= $requestJson[1]->CurrentAddress3;
						$_SESSION['personal_details']['currentpincode'] 				= $requestJson[1]->CurrentPin;
						$_SESSION['personal_details']['currentstate'] 					= $requestJson[1]->CurrentState;
						$_SESSION['personal_details']['currentcity'] 						= $requestJson[1]->CurrentCity;
						$_SESSION['personal_details']['workexperiance'] 				= $requestJson[1]->CurrentWorkExp;
						$_SESSION['personal_details']['webpageno'] 							= $requestJson[1]->PageNumber;
						$_SESSION['personal_details']['totworkexperiance'] 			= $requestJson[1]->TotalWorkExp;
						$_SESSION['personal_details']['kycflag'] 								= $requestJson[1]->KYCFlag;
						$_SESSION['personal_details']['ProspectNumber'] 				= $requestJson[2]->ProspectNumber;
						$_SESSION['personal_details']['residencetype'] 					= $requestJson[2]->ResidenceType;
						$_SESSION['personal_details']['education'] 							= $requestJson[2]->Education;
						$_SESSION['personal_details']['marritalstatus'] 				= $requestJson[2]->MaritalStatus;
						$_SESSION['personal_details']['loanpurpose'] 						= $requestJson[2]->PurposeofLoan;
						
						switch($requestJson[2]->ResidenceStability) {
							case 1:  $_SESSION['personal_details']['residencestability'] = 1;
											 break;
							case 6:	 $_SESSION['personal_details']['residencestability'] = 2;
											 break;
							case 18: $_SESSION['personal_details']['residencestability'] = 3;
											 break;
							case 27: $_SESSION['personal_details']['residencestability'] = 4;
											 break;
						}
						
						$_SESSION['CIBIL']['cibilResponse'] 				= $obj[0]->CibilResponse;
						$_SESSION['CIBIL']['status'] 								= $obj[0]->Status;
						$_SESSION['CIBIL']['revised_MaxAmount'] 		= $obj[0]->MaxAmount;
						$_SESSION['CIBIL']['revised_Tenure'] 				= $obj[0]->Tenure;
						$_SESSION['CIBIL']['revised_EMI'] 					= '';
						$_SESSION['CIBIL']['revised_ProcessingFee'] = $obj[0]->ProcessingFee;
						$_SESSION['CIBIL']['revised_ROI'] 					= $obj[0]->ROI;
						
						if($co_app_found) {
							$_SESSION['personal_details']['actualloanEMI'] 					= $requestJson[4]->Emi;
							$_SESSION['personal_details']['tenure'] 								= $requestJson[4]->Tenure;
							$_SESSION['personal_details']['appliedloanamt'] 				= $requestJson[4]->AppliedLoanamount;
							$_SESSION['personal_details']['processing_fee'] 				= ($requestJson[4]->Processingfee * $requestJson[4]->AppliedLoanamount)/100;
							$_SESSION['personal_details']['totalamountpayable'] 		= $requestJson[4]->TotalPayableAmount;
						} else {
							$_SESSION['personal_details']['actualloanEMI'] 					= $requestJson[3]->Emi;
							$_SESSION['personal_details']['tenure'] 								= $requestJson[3]->Tenure;
							$_SESSION['personal_details']['appliedloanamt'] 				= $requestJson[3]->AppliedLoanamount;
							$_SESSION['personal_details']['processing_fee'] 				= $requestJson[3]->Processingfee;
							$_SESSION['personal_details']['totalamountpayable'] 		= $requestJson[3]->TotalPayableAmount;
						}
						
						if($requestJson[$count-2]->TransactionStatus == '') {
							$transaction_status = $requestJson[$count-1]->TransactionStatus;
						} else {
							$transaction_status = $requestJson[$count-2]->TransactionStatus;
						}
						
						if($transaction_status == 'Success') {
							$_SESSION['perfios']['status'] = 'Success';
						} else {
							$_SESSION['perfios']['status'] = 'Failed';
						}
						
						if($requestJson[$count-2]->TransactionId == '') {
							$transaction_id = $requestJson[$count-1]->TransactionId;
						} else {
							$transaction_id = $requestJson[$count-2]->TransactionId;
						}
						
						if($requestJson[$count-2]->InstitutionName != '') {
							$institution_name = $requestJson[$count-2]->InstitutionName;
						} else {
							$institution_name = $requestJson[$count-3]->InstitutionName;
						}
						
						if($requestJson[$count-2]->ApplicantType == 'COBORROWER') {
							$app_type = 'CB';
						} else {
							$app_type = 'AP';
						}
						

            $_SESSION['perfios']['transaction_id'] 	= $transaction_id;
            $_SESSION['perfios']['bank_name'] 			= $institution_name;
						
						
						if($co_app_found) {
						  $dob = substr($requestJson[3]->CoDOB,-4).'-'.substr($requestJson[3]->CoDOB,-6,2).'-'.substr($requestJson[3]->CoDOB,-8,2);
							$_SESSION['co_applicant_details']['monthlySalary'] 									= $requestJson[3]->CoMonthlySalary;
							$_SESSION['co_applicant_details']['currentEmi'] 										= $requestJson[3]->CoMonthlyObligation;
							$_SESSION['co_applicant_details']['companyName'] 										= $requestJson[3]->CoCompanyName;
							$_SESSION['co_applicant_details']['relationType'] 									= $requestJson[3]->RelationwithApplicant;
							$_SESSION['co_applicant_details']['occupation'] 										= $requestJson[3]->EmploymentType;
							$_SESSION['co_applicant_details']['cnamecoappnature'] 							= $requestJson[3]->NatureOfBusiness;
							$_SESSION['co_applicant_details']['cnamecoappnatureprofession'] 		= $requestJson[3]->Profession;
							$_SESSION['co_applicant_details']['cnamecoappnatureconstitution'] 	= $requestJson[3]->ConstitutionType;
							$_SESSION['co_applicant_details']['permanentpincode'] 							= $requestJson[3]->CoPermanentPin;
							$_SESSION['co_applicant_details']['perm_city_code'] 								= $requestJson[3]->CoPermanentCity;
							$_SESSION['co_applicant_details']['perm_state_code'] 								= $requestJson[3]->CoPermanentCity;
							$_SESSION['co_applicant_details']['permanentcity'] 									= $requestJson[3]->CoPermanentState;
							$_SESSION['co_applicant_details']['permanentstate'] 								= $requestJson[3]->CoPermanentState;
							$_SESSION['co_applicant_details']['applicantname'] 									= $requestJson[3]->CoFName;
							$_SESSION['co_applicant_details']['middlename'] 										= $requestJson[3]->CoMName;
							$_SESSION['co_applicant_details']['lastname'] 											= $requestJson[3]->CoLName;
							$_SESSION['co_applicant_details']['gender'] 												= $requestJson[3]->CoGender;
							$_SESSION['co_applicant_details']['panno'] 													= $requestJson[3]->CoPAN;
							$_SESSION['co_applicant_details']['dob'] 														= $dob;
							$_SESSION['co_applicant_details']['mobileno'] 											= $requestJson[3]->CoMobileNo;
							$_SESSION['co_applicant_details']['emailid'] 												= $requestJson[3]->CoPersonalEmailID;
							$_SESSION['co_applicant_details']['permanentaddress1'] 							= $requestJson[3]->CoPermanentAddress1;
							$_SESSION['co_applicant_details']['permanentaddress2'] 							= $requestJson[3]->CoPermanentAddress2;
							$_SESSION['co_applicant_details']['permanentaddress3'] 							= $requestJson[3]->CoPermanentAddress3;
							$_SESSION['co_applicant_details']['currentaddress1'] 								= $requestJson[3]->CoCurrentAddress1;
							$_SESSION['co_applicant_details']['currentaddress2'] 								= $requestJson[3]->CoCurrentAddress2;
							$_SESSION['co_applicant_details']['currentaddress2'] 								= $requestJson[3]->CoCurrentAddress3;
							$_SESSION['co_applicant_details']['currentpincode'] 								= $requestJson[3]->CoCurrentPin;
							$_SESSION['co_applicant_details']['currentstate'] 									= $requestJson[3]->CoCurrentState;
							$_SESSION['co_applicant_details']['currentcity'] 										= $requestJson[3]->CoCurrentCity;
							$_SESSION['co_applicant_details']['workexperiance'] 								= $requestJson[3]->CoCurrentWorkExp;
							$_SESSION['co_applicant_details']['totworkexperiance'] 							= $requestJson[3]->CoTotalWorkExp;
							$_SESSION['co_applicant_details']['curr_state_code'] 								= $requestJson[3]->CoCurrentState;
							$_SESSION['co_applicant_details']['curr_city_code'] 								= $requestJson[3]->CoCurrentCity;
							$_SESSION['co_applicant_details']['kycflag'] 												= $requestJson[3]->CoKYCFlag;
							$_SESSION['co_applicant_details']['ProspectNumber'] 								= $requestJson[3]->ProspectNumber;
							$_SESSION['co_applicant_details']['CIBIL']['flag'] 									= '';
							$_SESSION['co_applicant_details']['CIBIL']['CibilResponse'] 				= '';
							$_SESSION['co_applicant_details']['CIBIL']['CIBILTotalEMI'] 				= 0;
							$_SESSION['co_applicant_details']['CIBIL']['MaxAmount'] 						= $requestJson[4]->AppliedLoanamount;
							$_SESSION['co_applicant_details']['CIBIL']['MaxTenure'] 						= $requestJson[4]->Tenure;
							$_SESSION['co_applicant_details']['CIBIL']['ROIDefault'] 						= '';
							$_SESSION['co_applicant_details']['CIBIL']['ROIActual'] 						= 14.75;
							$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeDefault'] 	= '';
							$_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual'] 	= $requestJson[4]->Processingfee;
							$_SESSION['co_applicant_details']['CIBIL']['processing_fee'] 				= ($requestJson[4]->Processingfee * $requestJson[4]->AppliedLoanamount)/100;;

						}
						if($app_type == 'AP') {
							echo "page16";
						} else {
							echo "page17";
						}
						
						exit;
					}
				}
				echo 'Curl Response'. $curl_response; exit();
			} else {
				echo 0;
				exit();
			}
		}
	} else {
		echo 2;
	}
	echo $crmLeadIdType;
	
	function my_array_unique($array, $keep_key_assoc = false) {
    $duplicate_keys = array();
    $tmp         = array();       
    foreach ($array as $key=>$val){
        // convert objects to arrays, in_array() does not support objects
        if (is_object($val))
            $val = (array)$val;

        if (!in_array($val, $tmp))
            $tmp[] = $val;
        else
            $duplicate_keys[] = $key;
    }

    foreach ($duplicate_keys as $key)
        unset($array[$key]);

    return $keep_key_assoc ? $array : array_values($array);
	}
?>