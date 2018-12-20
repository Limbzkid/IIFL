<?php session_start(); ?>
<?php
  require_once('functions.php');
  
  $error = false;
  $msg = array();
  
  $address_checked = $_POST['addrChk'];
  
  if($_POST['fName'] == '') {
    $msg[] = 'nameslot1-First name is required.';
    $error = true;
  } else {
    if(!valid_name($_POST['fName'])) {
      $msg[] = 'nameslot1-Invalid characters entered.';
      $error = true;
    } else {
      $first_name = $_POST['fName'];
    }
  }
  
  if($_POST['mName'] != '') {
    if(!valid_name($_POST['mName'])) {
      $msg[] = 'nameslot2-Invalid characters entered.';
      $error = true;
    } else {
      $middle_name = $_POST['mName'];
    }
  } else {
    $middle_name = '';
  }
  
  if($_POST['lName'] == '') {
    $msg[] = 'nameslot3-Last name is required.';
    $error = true;
  } else {
    if(!valid_name($_POST['lName'])) {
      $msg[] = 'nameslot3-Invalid characters entered.';
      $error = true;
    } else {
      $last_name = $_POST['lName'];
    }
  }
  
  if($_POST['panNo'] == '') {
    $msg[] = 'panslot1-PAN is required.';
    $error = true;
  } else {
    if(!valid_PAN($_POST['panNo'])) {
      $msg[] = 'panslot1-Invalid PAN.';
      $error = true;
    } else {
      $pan_number = $_POST['panNo'];
    }
  }
  
  if($_POST['dob'] == '' || $_POST['dob'] == 'Date of Birth*') {
    $msg[] = 'datepicker-Date of Birth is required.';
    $error = true;
  } else {
    if(!valid_date($_POST['dob'])) {
      $msg[] = 'datepicker-Invalid Date of Birth.';
      $error = true; 
    } else {
      $temp = explode('/', $_POST['dob']);
      $birth_date = $temp[2].'/'.$temp[1].'/'.$temp[0];
      $birth_date = new DateTime($birth_date);
      $cur_date   = new DateTime('today');
      $age        = $birth_date->diff($cur_date)->y;
      if($age < 25) {
        $msg[] = 'datepicker-You should be above 25 years to avail a Loan.';
        $error = true;
      } else {
        $birth_date = $temp[0].$temp[1].$temp[2];
        $session_dob = $temp[2].'-'.$temp[1].'-'.$temp[0];
      }
    }
  }
  
  if($_POST['mobNo'] == '') {
    $msg[] = 'slotmob1-Mobile number is required.';
    $error = true;
  } else {
    if(!valid_mobile($_POST['mobNo'])) {
      $msg[] = 'slotmob1-Invalid Mobile number.';
      $error = true;
    } else {
      $mobile_number = $_POST['mobNo'];
    }
  }
  
  if($_POST['altNo'] != '') {
    if(!valid_mobile($_POST['altNo'])) {
      $msg[] = 'slotmob2-Invalid Mobile number.';
      $error = true;
    } else {
      $alternate_number = $_POST['altNo'];
    }
  } else {
    $alternate_number = '';
  }
  
  if($_POST['email'] == '') {
    $msg[] = 'slotemail-Email is required.';
    $error = true;
  } else {
    if(!valid_mail($_POST['email'])) {
      $msg[] = 'slotemail-Invalid Email.';
      $error = true;
    } else {
      $email = $_POST['email'];
    }
  }
  
  if($_POST['pAddr1'] == '') {
    $msg[] = 'slotpadd1-Permanent Address is required.';
    $error = true;
  } else {
    if(!valid_address($_POST['pAddr1'])) {
      $msg[] = 'slotpadd1-Invalid characters in address field.';
      $error = true;
    } else {
      $perm_address1 = $_POST['pAddr1'];
    }
  }
  
  if($_POST['pAddr2'] != '') {
    if(!valid_address($_POST['pAddr2'])) {
      $msg[] = 'slotpadd2-Invalid characters in address field.';
      $error = true;
    } else {
      $perm_address2 = $_POST['pAddr2'];
    }
  } else {
    $perm_address2 = '';
  }
  
  if($_POST['pAddr3'] != '') {
    if(!valid_address($_POST['pAddr3'])) {
      $msg[] = 'slotpadd3-Invalid characters in address field.';
      $error = true;
    } else {
      $perm_address3 = $_POST['pAddr3'];
    }
  } else {
    $perm_address3 = '';
  }

  if($_POST['pPin'] == '') {
    $msg[] = 'slotpin-Pincode is required.';
    $error = true;
  } else {
    if(!valid_pincode($_POST['pPin'])) {
      $msg[] = 'slotpin-Invalid characters in Pincode.';
      $error = true;
    } elseif((int)$_POST['pPin'] <= 99999) {
      $msg[] = 'slotpin-Invalid Pincode.';
      $error = true;
    } else {
      $perm_pincode = $_POST['pPin'];
    }
  }
  
  if($_POST['cAddr1'] == '') {
    $msg[] = 'slotcadd1-Current Address is required.';
    $error = true;
  } else {
    if(!valid_address($_POST['cAddr1'])) {
      $msg[] = 'slotcadd1-Invalid characters in address field.';
      $error = true;
    } else {
      $curr_address1 = $_POST['cAddr1'];
    }
  }
  
  if($_POST['cAddr2'] != '') {
    if(!valid_address($_POST['cAddr2'])) {
      $msg[] = 'slotcadd2-Invalid characters in address field.';
      $error = true;
    } else {
      $curr_address2 = $_POST['cAddr2'];
    }
  } else {
    $curr_address2 = '';
  }
  
  if($_POST['cAddr3'] != '') {
    if(!valid_address($_POST['cAddr3'])) {
      $msg[] = 'slotcadd3-Invalid characters in address field.';
      $error = true;
    } else {
      $curr_address3 = $_POST['cAddr3'];
    }
  } else {
    $curr_address3 = '';
  }
  
  if($_POST['cPin'] == '') {
    $msg[] = 'slotpin2-Pincode is required.';
    $error = true;
  } else {
    if(!valid_pincode($_POST['cPin'])) {
      $msg[] = 'slotpin2-Invalid characters in Pincode.';
      $error = true;
    } elseif((int)$_POST['cPin'] <= 99999) {
      $msg[] = 'slotpin2-Invalid Pincode.';
      $error = true;
    } else {
      $curr_pincode = $_POST['cPin'];
    }
  }
  
  if($_POST['compName'] == '') {
    $msg[] = 'slotcompname-Company name is required.';
    $error = true;
  } else {
    if(!valid_company_name($_POST['compName'])) {
      $msg[] = 'slotcompname-Invalid characters in Company name.';
      $error = true;
    } else {
      $company_name = $_POST['compName'];
    }
  }
  
  if($_POST['monthSal'] == '') {
    $msg[] = 'slotcompname-Monthly salary is required.';
    $error = true;
  } else {
    if(!is_numeric($_POST['monthSal'])) {
      $msg[] = 'slotmonthsal-Invalid characters in salary.';
      $error = true;
    } elseif($_POST['monthSal'] < 35000 || $_POST['monthSal'] > 1000000) {
      $msg[] = 'slotmonthsal-Salary must be in the range of 35000 and 1000000.';
      $error = true;
    } else {
      $month_sal = $_POST['monthSal'];
    }
  }
  
  if($_POST['curExp'] == '') {
    $msg[] = 'cworkexpslot-Current experiemce is required.';
    $error = true;
  } else {
    if(!is_numeric($_POST['curExp'])) {
      $msg[] = 'cworkexpslot-Invalid characters in Work experience.';
      $error = true;
    } else {
      $current_exp = $_POST['curExp'];
    }
  }
  
  if($_POST['totalExp'] == '') {
    $msg[] = 'slotExp-Total experiemce is required.';
    $error = true;
  } else {
    if(!is_numeric($_POST['totalExp'])) {
      $msg[] = 'slotExp-Invalid characters in Work experience.';
      $error = true;
    } elseif($_POST['curExp'] > $_POST['totalExp']) {
      $msg[] = 'slotExp-Total experience cannot be less than current experience.';
      $error = true;
    } else {
      $total_exp = $_POST['totalExp'];
    }
  }
    
  if($_POST['oblige'] != '') {
    if(!is_numeric($_POST['oblige'])) {
      $msg[] = 'slotOblig-Invalid characters in Monthly obligation.';
      $error = true;
    } elseif($_POST['oblige'] > $_POST['monthSal']) {
      $msg[] = 'slotOblig-Obligation should be between 0 and Rs.'. $_POST['monthSal'];
      $error = true;
    } else {
      $monthly_obligation = $_POST['oblige'];
    }
  } else {
    $monthly_obligation = '';
  }
  
  if($_POST['city'] == '') {
    $msg[] = 'loanCity-City is required.';
    $error = true;
  } else {
    if(!valid_location($_POST['city'])) {
      $msg[] = 'loanCity-Invalid characters in City.';
      $error = true;
    } else {
      $loan_city = $_POST['city'];
    }
  }
  
  if($_POST['gender'] == '') {
    $msg[] = 'gender-Gender is required.';
    $error = true;
  } else {
    if($_POST['gender'] == 'Male' || $_POST['gender'] == 'Female') {
      $gender = $_POST['gender'];
    } else {
      $msg[] = 'gender-Invalid Gender.';
      $error = true;
    }
  }
  
  //echo 'Error: ' . $error. '<br/>';
  //print_r($msg);
    
  if(!$error) {
    $status = '1';
    
    $_SESSION['personal_details']['applicantname']      = $first_name;
    $_SESSION['personal_details']['lastname']           = $last_name;
    $_SESSION['personal_details']['gender']             = $gender;
    $_SESSION['personal_details']['panno']              = $pan_number;
    $_SESSION['personal_details']['dob']                = $session_dob;
    $_SESSION['personal_details']['permanentaddress1']  = $perm_address1;
    $_SESSION['personal_details']['permanentaddress2']  = $perm_address2;
    $_SESSION['personal_details']['permanentaddress3']  = $perm_address3;
    $_SESSION['personal_details']['currentaddress1']    = $curr_address1;
    $_SESSION['personal_details']['currentaddress2']    = $curr_address2;
    $_SESSION['personal_details']['currentaddress3']    = $curr_address3;
    $_SESSION['personal_details']['workexperiance']     = $current_exp;
    $_SESSION['personal_details']['webpageno']          = '4';
    $_SESSION['personal_details']['totworkexperiance']  = $total_exp;
    $_SESSION['personal_details']['kycflag']            = 0;
    
    // Create CRM Lead ID
    $curl_post_data = array(
      "CompanyName"				=> $company_name,
      "OtherCompanyName"	=> "",
      "MonthlySalary"			=> $month_sal,
      "MonthlyObligation"	=> $monthly_obligation,
      "PersonalEmailID"		=> $email,
      "MobileNo"					=> $mobile_number,
      "City"							=> $loan_city,
      "Source"						=> 'indigo',
      "ChannelName"				=> 'iifl',
      "PartnerName"				=> '3',
      "CampaignName"			=> 'pl',
      "UTMSource"					=> 'google',
      "UTMMedium"					=> 'web',
      "PageNumber"				=> 1
    );
    if(isset($_SESSION['personal_details']['CRMLeadID'])) {
      $crm_lead_id = $_SESSION['personal_details']['CRMLeadID'];
      $max_emi          = calculate_emi($_SESSION['personal_details']['maxloanamt'], $_SESSION['personal_details']['roi_actual'], $_SESSION['personal_details']['actual_tenure']/12);
      $def_emi          = calculate_emi($_SESSION['personal_details']['maxloanamt'], $_SESSION['personal_details']['roi_default'] , $_SESSION['personal_details']['actual_tenure']/12);
      $emi_diff         = $def_emi - $max_emi;
      $max_proc_fee     = ceil($_SESSION['personal_details']['maxloanamt'] * ($_SESSION['personal_details']['processing_fee_actual']/100));
    
    } else { 
      $lead_obj = json_decode(call_api('api', 'CRMLeadCreate', $curl_post_data));
      if(strtolower($lead_obj[0]->Status) == 'success') {
        // calculate EMI
        $_SESSION['personal_details']['companyname']  = $company_name;
        $_SESSION['personal_details']['emailid']      = $email;
        $_SESSION['personal_details']['salary']       = $month_sal;
        $_SESSION['personal_details']['mobileno']     = $mobile_number;
        $_SESSION['personal_details']['obligation']   = $monthly_obligation;
        $_SESSION['personal_details']['city']         = $loan_city;
        $_SESSION['personal_details']['CRMLeadID']    = $crm_lead_id = $lead_obj[0]->CRMLeadID;
      } else {
        $status = '0';
        $msg[] = 'innBody-'.$lead_obj[0]->ErrorMsg;
      }
      
      $curl_post_data = array(
        "CRMLeadID"		=> $crm_lead_id,
        "PageNumber"	=> 1
      );
      $emi_obj = json_decode(call_api('api', 'EmiCalc', $curl_post_data));
      
      if(strtolower($emi_obj[0]->Status) == 'success') {
        $_SESSION['personal_details']['maxloanamt']              = $max_amount        = $emi_obj[0]->MaxAmount; 
        $_SESSION['personal_details']['minloanamt']              = $min_amount        = $emi_obj[0]->MinimumAmout;
        $_SESSION['personal_details']['roi_actual']              = $roi_actual        = $emi_obj[0]->ROIActual;
        $_SESSION['personal_details']['roi_default']             = $roi_default       = $emi_obj[0]->ROIDefault;
        $_SESSION['personal_details']['actual_tenure']           = $max_tenure        = $emi_obj[0]->MaxTenure;
        $_SESSION['personal_details']['tenure']                  = $max_tenure        = $emi_obj[0]->MaxTenure;
        $_SESSION['personal_details']['processing_fee_actual']   = $proc_fee_actual   = $emi_obj[0]->ProcessingFeeActual;
        $_SESSION['personal_details']['processing_fee_default']  = $proc_fee_default  = $emi_obj[0]->ProcessingFeeDefault;
        
        $max_emi          = calculate_emi($max_amount, $roi_actual, $max_tenure/12);
        $def_emi          = calculate_emi($max_amount, $roi_default, $max_tenure/12);
        $emi_diff         = $def_emi - $max_emi;
        $max_proc_fee     = ceil($max_amount * ($proc_fee_actual/100));
        
        $_SESSION['personal_details']['maxEMI']             = $max_emi;
        $_SESSION['personal_details']['actualloanEMI']      = $max_emi;
        $_SESSION['personal_details']['emi_diff']           = $emi_diff;
        $_SESSION['personal_details']['appliedloanamt']     = $max_amount;
        $_SESSION['personal_details']['processing_fee']     = $max_proc_fee;
        $_SESSION['personal_details']['totalamountpayable'] = (int)$max_amount + (int)($max_emi * $max_tenure);
      } else {
        // emicalc error
        $status = '0';
        $msg[] = 'innBody-'.$emi_obj[0]->ERRMsg;
      }
    }
    
      
      
        // Verify pincode
        $curl_post_data = array(
          'CRMLeadID'	=> $crm_lead_id,
          'Pincode' 	=> $perm_pincode
        );
        $perm_pin_obj = call_api('common', 'GetDetailByPincode', $curl_post_data);
        //echo '<pre>'; print_r($perm_pin_obj); echo '</pre>';
        if(strtolower($perm_pin_obj->Status) == 'success') {
          $perm_city_name   = $perm_pin_obj->City;
          $perm_city_code   = $perm_pin_obj->CityCode;
          $perm_state_name  = $perm_pin_obj->State;
          $perm_state_code  = $perm_pin_obj->StateCode;
          
          $_SESSION['personal_details']['permanentpincode'] = $perm_pincode;
          $_SESSION['personal_details']['perm_city_code']   = $perm_city_code   = $perm_pin_obj->CityCode;
          $_SESSION['personal_details']['perm_state_code']  = $perm_state_code  = $perm_pin_obj->StateCode;
          $_SESSION['personal_details']['permanentcity']    = $perm_city_name   = $perm_pin_obj->City;
          $_SESSION['personal_details']['permanentstate']   = $perm_state_name  = $perm_pin_obj->State;
          
          if($address_checked) {
            $_SESSION['personal_details']['currentpincode']   = $curr_pincode;
            $_SESSION['personal_details']['curr_state_code']  = $curr_state_code  = $perm_state_code;
            $_SESSION['personal_details']['curr_city_code']   = $curr_city_code   = $perm_city_code;
            $_SESSION['personal_details']['currentstate']     = $curr_state_name  = $perm_state_name;
            $_SESSION['personal_details']['currentcity']      = $curr_city_name   = $perm_city_name;
          } else {
            $curl_post_data = array(
              'CRMLeadID'	=> $crm_lead_id,
              'Pincode' 	=> $curr_pincode
            );
            $curr_pin_obj = call_api('common', 'GetDetailByPincode', $curl_post_data);
            if(strtolower($curr_pin_obj->Status) == 'success') {
              $_SESSION['personal_details']['currentpincode']   = $curr_pincode;
              $_SESSION['personal_details']['curr_state_code']  = $curr_state_code  = $curr_pin_obj->StateCode;
              $_SESSION['personal_details']['curr_city_code']   = $curr_city_code   = $curr_pin_obj->CityCode;
              $_SESSION['personal_details']['currentstate']     = $curr_state_name  = $curr_pin_obj->State;
              $_SESSION['personal_details']['currentcity']      = $curr_city_name   = $curr_pin_obj->City;
            } else {
              $status = '0';
              $msg[] = 'innBody-'.$curr_pin_obj->ErrorMsg;
            }            
          }
        } else {
          $status = '0';
          $msg[] = 'slotpin-'.$perm_pin_obj->ErrorMsg;
          if($address_checked) {
            $msg[] = 'slotpin2-'.$perm_pin_obj->ErrorMsg;
          }
        }
        
      
      
    
    //echo '<pre>'; print_r($lead_obj); echo '</pre>';
  } else {
    // error on form
    $status = '0';
  }
  //echo $status;
  if($status == 1) {
    $curl_post_data = array(
      "CRMLeadID"			=> $crm_lead_id,
      "MobileNumber"	=> $mobile_number
    );
    $otp_obj = call_api('common', 'SendOTP', $curl_post_data);
    //echo '<pre>'; print_r($otp_obj); echo '</pre>';
    if(strtolower($otp_obj->Status) == 'y') {
      
      
    } else {
      $status = '0';
      $msg[] = 'innBody-'.$otp_obj->ErrMsg;
    }
  }
  
 
  
  echo json_encode(array('status'=>$status, 'msg'=>$msg, 'exec' => $_SESSION['exec']));

?>
