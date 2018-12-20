<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php

	$crmIdValue	= xss_filter($_POST['crmLeadID']);
	$crmIdValue =  num_only($crmIdValue);
	$companyname = xss_filter($_POST['companyName']);
	if(preg_match("/^[0-9]*$/", $_POST['monthlySalary']))
	{
	// echo "<pre>"; print_r($_POST['monthlySalary']); exit;
		$monthSal = xss_filter($_POST['monthlySalary']);
	}
	else
	{
		echo '7';
		exit;
	}		
	$monthSal = num_only($monthSal);
	if(preg_match("/^[0-9]*$/", $_POST['monthlyObligation']))
	{
		$currentEmi = xss_filter($_POST['monthlyObligation']);
	}
	else
	{
		echo '8';
		exit;
	}
	$currentEmi = num_only($currentEmi);
	$pageNumber = xss_filter($_POST['pageNumber']);

	if(!empty($crmIdValue) && !empty($companyname) && !empty($monthSal) /*&& !empty($currentEmi)*/ && !empty($pageNumber))	
	{
		if(is_numeric($crmIdValue) && is_numeric($monthSal) && is_numeric($currentEmi))
		{
			if($monthSal < 35000 || $monthSal > 1000000)
			{
				echo '3';
				exit;
			}
			/*if($currentEmi < 0 || $currentEmi > 35000)
			{
				echo '4';
				exit;
			}*/
			if($monthSal < $currentEmi)
			{
				echo '5';
				exit;
			}
			if(valid_company_name($companyname))
			{
				$service_url = API.'EditCRMDtails';
				$curl = curl_init($service_url);
				$curl_post_data = array(
					'CRMLeadID' 		=> $crmIdValue,
					'CompanyName'		=> $companyname,
					'OtherCompanyName'	=> '',
					'MonthlySalary' 	=> $monthSal,
					'MonthlyObligation'	=> $currentEmi,
					'PageNumber' 		=> '1'
				);
			
				$headers = array (
					"Content-Type: application/json"
				);
			
				$decodeddata = json_encode($curl_post_data);
				// echo "<pre>"; print_r($decodeddata); echo "<pre>"; print_r($service_url); exit;
				$handle = curl_init(); 
				curl_setopt($handle, CURLOPT_URL, $service_url);
				curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
				$curl_response = curl_exec($handle);
				$curl_response = json_decode(json_decode($curl_response));
				if(strtolower($curl_response[0]->Status) == 'success') 
				{
					$minimum_amt 			= xss_filter(ceil($curl_response[0]->MinimumAmout));
					$maximum_amt 			= xss_filter(ceil($curl_response[0]->MaxAmount));
					$max_tenure 			= xss_filter($curl_response[0]->MaxTenure);
					$ROI_default 			= xss_filter($curl_response[0]->ROIDefault);
					$ROI_actual 			= xss_filter($curl_response[0]->ROIActual);
					$processing_fee_default = xss_filter($curl_response[0]->ProcessingFeeDefault);
					$processing_fee_actual 	= xss_filter($curl_response[0]->ProcessingFeeActual);
					
					$net_income = $monthSal - $currentEmi;
					$interest = $ROI_actual / 1200;
					$maximumloanamtemi = ceil($interest * -$maximum_amt * pow((1 + $interest), $max_tenure) / (1 - pow((1 + $interest), $max_tenure)));
					$interest_default = $ROI_default / 1200;
					$emi_default = ceil($interest_default * -$maximum_amt * pow((1 + $interest_default), $max_tenure) / (1 - pow((1 + $interest_default), $max_tenure)));
					$emi_difference = $emi_default -  $maximumloanamtemi;			
					$actualloanEMI = $maximumloanamtemi;

					if($minimum_amt < 100000)
					{
						redirect_to("declined");
					}
			
					$processing_fee = $processing_fee_actual;					
					$_SESSION['personal_details']['maxloanamt'] 			= $maximum_amt;
					$_SESSION['personal_details']['minloanamt'] 			= $minimum_amt;
					$_SESSION['personal_details']['actualloanEMI'] 			= $actualloanEMI;
					$_SESSION['personal_details']['roi_actual'] 			= $ROI_actual;
					$_SESSION['personal_details']['roi_default'] 			= $ROI_default;
					$_SESSION['personal_details']['actual_tenure']			= $max_tenure;
					$_SESSION['personal_details']['tenure'] 				= $max_tenure;
					$_SESSION['personal_details']['processing_fee_actual'] 	= $processing_fee_actual;
					$_SESSION['personal_details']['processing_fee_default'] = $processing_fee_default;
					$_SESSION['personal_details']['emi_diff'] 				= $emi_difference;
					$_SESSION['personal_details']['salary'] 				= $monthSal;
					$_SESSION['personal_details']['obligation'] 			= $currentEmi;
					$_SESSION['personal_details']['companyname'] 			= $companyname;
					echo 'Y';
					exit;
				}
				else
				{
					echo '6';
					exit();
				}
			}
			else
			{
				echo '0';
				exit;
			}
		}
		else
		{
			echo '1';
			exit;
		}
	}
	else
	{
		echo '2';
		exit;
	}	
?>