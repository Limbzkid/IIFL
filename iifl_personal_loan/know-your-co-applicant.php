<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php //if(!isset($_SESSION['personal_details']['CRMLeadID'])) { redirect_to('index'); } ?>

<?php
// echo "<pre>"; print_r($_SESSION); exit;
// echo "<pre>"; print_r($_POST); exit;
    
    $applicantFirstName = '';
    if(isset($_SESSION['personal_details']['applicantname']))
    {
        $applicantFirstName = $_SESSION['personal_details']['applicantname'];
    }
    $applicantMiddleName = '';
    if(isset($_SESSION['personal_details']['middlename']))
    {
        $applicantMiddleName = $_SESSION['personal_details']['middlename'];
    }
    $applicantLastName = '';
    if(isset($_SESSION['personal_details']['lastname']))
    {
        $applicantLastName = $_SESSION['personal_details']['lastname'];
    }
    $applicantPanNo = '';
    if(isset($_SESSION['personal_details']['panno']))
    {
        $applicantPanNo = $_SESSION['personal_details']['panno'];
    }
    $applicantDob = '';
    if(isset($_SESSION['personal_details']['dob']))
    {
        $applicantDob = date('d-M-Y', strtotime($_SESSION['personal_details']['dob']) );
    }
    $applicantEmailId = '';
    if(isset($_SESSION['personal_details']['emailid']))
    {
        $applicantEmailId = ($_SESSION['personal_details']['emailid']);
    }
    $applicantGender = '';

    if(isset($_SESSION['personal_details']['gender']))
    {
        $applicantGender = $_SESSION['personal_details']['gender'];
        if($applicantGender == 'M')
        {
            $applicantGender = 'Male';
        }
        else
        {
            $applicantGender = 'Female';
        }
    }
    $applicantMobileNumber = '';
    if(isset($_SESSION['personal_details']['mobileno']))
    {
        $applicantMobileNumber = $_SESSION['personal_details']['mobileno'];
    }
    $applicantPermanentAddress = '';
    if(isset($_SESSION['personal_details']['permanentaddress1']) && isset($_SESSION['personal_details']['permanentaddress2']) && isset($_SESSION['personal_details']['permanentaddress3']))
    {
        $applicantPermanentAddress = $_SESSION['personal_details']['permanentaddress1'].', '.$_SESSION['personal_details']['permanentaddress2'].', '.$_SESSION['personal_details']['permanentaddress3'];
    }
    $applicantPermanentPincode = '';
    if(isset($_SESSION['personal_details']['permanentpincode']))
    {
        $applicantPermanentPincode = $_SESSION['personal_details']['permanentpincode'];
    }
    $applicantPermanentCity = '';
    if(isset($_SESSION['personal_details']['permanentcity']))
    {
        $applicantPermanentCity = $_SESSION['personal_details']['permanentcity'];
    }
    $applicantPermanentState = '';
    if(isset($_SESSION['personal_details']['permanentstate']))
    {
        $applicantPermanentState = $_SESSION['personal_details']['permanentstate'];
    }

    $error = '';
    $pan_error = '';
    $err_fn = '';
    $err_mn = '';
    $err_ln = '';
    $err_mob      = '';
    $err_mob_alt  = '';
    $err_pan      = '';
    $err_mail     = '';
    $err_ppin     = '';
    $err_cpin     = '';
    $err_paddr1   = '';
    $err_paddr2   = '';
    $err_paddr3   = '';
    $err_caddr1   = '';
    $err_caddr2   = '';
    $err_caddr3   = '';
    $err_pstate   = '';
    $err_pcity    = '';
    $err_cstate   = '';
    $err_ccity    = '';
    $err_dob      = '';
    $err_join     = '';
    $err_month    = '';
    $err_year     = '';
    $err_gender   = '';
  
    $current_work_experience = 0;
  
    $coApplicantFirstName = '';
    $coApplicantMiddleName = '';
    $coApplicantLastName = '';
    $panno = '';
    $dob = '';
    $coApplicantGender = '';
    $coApplicantMobileNumber = '';
    $coApplicantMobileNumber2 = '';
    $email_id = xss_filter($_SESSION['personal_details']['emailid']);
    $coApplicantPermanentAddr1 =  $coApplicantPermanentAddr2 = $coApplicantPermanentAddr3 = '';
    $coApplicantPermanentCity = '';
    $coApplicantPermanentState = '';
    $coApplicantPermanentPincode = '';
    $coApplicantCurrentAddr1 =    $coApplicantCurrentAddr2 = $coApplicantCurrentAddr3 = '';
    $coApplicantCurrenCity = '';
    $coApplicantCurrentState = '';
    $coApplicantCurrentPincode = '';  

    if(isset($_SESSION['customer']['AddharNo'])) {
  $coApplicantAadharNo = xss_filter($_SESSION['customer']['AddharNo']);
    if(isset($_SESSION['customer']['Firstname'])) {
      $coApplicantFirstName = xss_filter($_SESSION['customer']['Firstname']);
  } 
    if(isset($_SESSION['customer']['Middlename'])) {
      $coApplicantMiddleName = $_SESSION['customer']['Middlename'];
  } 
    if(isset($_SESSION['customer']['Lastname'])) {
      $coApplicantLastName = xss_filter($_SESSION['customer']['Lastname']);
  } 
    if(isset($_SESSION['customer']['ADD1'])) {
      $coApplicantPermanentAddr1 = $_SESSION['customer']['ADD1'];
  } 
    if(isset($_SESSION['customer']['ADD2'])) {
      $coApplicantPermanentAddr2 = xss_filter($_SESSION['customer']['ADD2']);
  } 
    if(isset($_SESSION['customer']['ADD3'])) {
      $coApplicantPermanentAddr3 = xss_filter($_SESSION['customer']['ADD3']);
  } 
    
    if(isset($_SESSION['customer']['City'])) {
        $coApplicantPermanentCity = xss_filter($_SESSION['customer']['City']);
        $_SESSION['co_applicant_details']['perm_city_code'] = xss_filter($_SESSION['customer']['City']);
        $_SESSION['co_applicant_details']['perm_city_code'] = xss_filter($_SESSION['customer']['City']);
  } 
      
    if(isset($_SESSION['customer']['State'])) {
        $coApplicantPermanentState = xss_filter($_SESSION['customer']['State']);
        $_SESSION['co_applicant_details']['perm_state_code'] = xss_filter($_SESSION['customer']['State']);
        $_SESSION['co_applicant_details']['perm_state_code'] = xss_filter($_SESSION['customer']['State']);
  } 
  
    if(isset($_SESSION['customer']['Pincode'])) {
        $coApplicantPermanentPincode = xss_filter($_SESSION['customer']['Pincode']);
        $_SESSION['co_applicant_details']['permanentpincode'] = xss_filter($_SESSION['customer']['Pincode']);
  } 
  
    if(isset($_SESSION['customer']['Mobile'])) {
        $coApplicantMobileNumber = xss_filter($_SESSION['customer']['Mobile']);
        if(isset($_SESSION['customer']['mobileno']))
        {
    $coApplicantMobileNumber2 = xss_filter($_SESSION['customer']['mobileno']);
        }
  } 
    
    if(isset($_SESSION['customer']['Dob'])) {
        $coApplicantdob = xss_filter($_SESSION['customer']['Dob']);
        $temp = explode('-', $coApplicantdob);
        $coApplicantdob = $temp[2].'-'.$temp[1].'-'.$temp[0];
  }
  
    if($_SESSION['customer']['Email'] != '') {
        $coApplicantEmailId = xss_filter($_SESSION['customer']['Email']);
  } 
    
    if(isset($_SESSION['customer']['Gender'])) {
        $coApplicantGender = $_SESSION['customer']['Gender'];
  } 
    } else {
  $coApplicantAadharNo = '';
    }

    if(isset($_POST['kycSubmit'])) 
    {
        $_SESSION['post'] = $_POST['kycSubmit'];
        $error = false; 
        if($_POST['applicantname'] == '') 
        {
            $err_fn = 'First name is required.';
            $_SESSION['errors'][] = 'First name';
            $error = true; 
        } 
        else 
        {
            if(!valid_name($_POST['applicantname'])) 
            {
                $err_fn = 'Invalid characters in First name.';
                $_SESSION['errors'][] = 'First name';
                $error = true; 
            } 
            else 
            {
                $coApplicantFirstName = $_SESSION['co_applicant_details']['applicantname'] = xss_filter($_POST['applicantname']);
            }
        }
    
        if($_POST['lastname'] == '') 
        {
            $err_ln = 'Last name is required.';
            $_SESSION['errors'][] = 'Last name';
            $error = true; 
        } 
        else 
        {
            if(!valid_name($_POST['lastname'])) 
            {
                $err_ln = 'Invalid characters in Last name.';
                $_SESSION['errors'][] = 'Last name';
                $error = true; 
            } 
            else 
            {
                $last_name = $_SESSION['co_applicant_details']['lastname'] = xss_filter($_POST['lastname']);;
            }
        }
    
        if($_POST['middlename'] != '') 
        {
            if(!valid_name($_POST['middlename'])) 
            {
                $err_mn = 'Invalid characters in Middle name.';
                $_SESSION['errors'][] = 'Middle name';
                $error = true; 
            } 
            else 
            {
                $middle_name = $_SESSION['co_applicant_details']['middlename'] = xss_filter($_POST['middlename']);;
            }
        }
    
        if(isset($_SESSION['customer']['Gender'])) 
        {
            $gender = $_SESSION['personal_details']['gender'] = $_SESSION['customer']['Gender'];
        } 
        else 
        {
            if($_POST['radioGe'] == '') 
            {
                $error = true;
                $_SESSION['errors'][] = 'Gender123';
            } 
            else 
            {
                if(!valid_gender($_POST['radioGe'])) 
                {
                    $err_gender = 'Invalid character in Gender.';
                    $_SESSION['errors'][] = 'Genderdfgdsf';
                } 
                else 
                {
                    $gender = $_SESSION['co_applicant_details']['gender'] = xss_filter($_POST['radioGe']);
                }
            }
        }
    
    
        if($_POST['panno'] == '') 
        {
            $err_pan = 'PAN is required.';
            $_SESSION['errors'][] = 'PAN';
            $error = true; 
        } 
        else 
        {
            if(!valid_PAN($_POST['panno'])) 
            {
                $err_pan = 'Invalid PAN';
                $_SESSION['errors'][] = 'PAN';
                $error = true; 
            } 
            else 
            {
                $panno = $_SESSION['co_applicant_details']['panno'] = xss_filter($_POST['panno']); ;
            }
        }
    
    if($coApplicantAadharNo == '') 
    {
        if($_POST['dob'] == '') 
        {
            $error = true;
            $_SESSION['errors'][] = 'D__OB';
        } 
        else 
        {
            if(!valid_date($_POST['dob'])) 
            {
                $error = true;
                $_SESSION['errors'][] = 'DOB';
            } 
            else 
            {
                $temp_dob = explode('-', xss_filter($_POST['dob']));
                $dob = $temp_dob[2].$temp_dob[1].$temp_dob[0];
                $_SESSION['co_applicant_details']['dob'] = xss_filter($_POST['dob']);
            }
        }
    } 
    else 
    {
        if($_POST['kycDob'] == '') 
        {
            $error = true;
            $_SESSION['errors'][] = 'KYC__DOB';
        } 
        else 
        {
            if(!valid_date($_POST['kycDob'])) 
            {
                $error = true;
                $_SESSION['errors'][] = 'KYCDOB';
            } 
            else 
            {
                $temp_dob = explode('-', xss_filter($_POST['kycDob']));
                $dob = $temp_dob[2].$temp_dob[1].$temp_dob[0];
                $_SESSION['co_applicant_details']['dob'] = xss_filter($_POST['kycDob']);
            }
        }
    }
    
        if($_POST['mobileno'] == '') 
        {
          $err_mob = 'Mobile no is required.';
          $_SESSION['errors'][] = 'Mobile no';
          $error = true; 
        } 
        else 
        {
            if(!valid_mobile($_POST['mobileno'])) 
            {
                $err_mob = 'Mobile no';
                $_SESSION['errors'][] = 'Mobile no ';
                $error = true; 
            } 
            else 
            {
                $mobile_no = $_SESSION['co_applicant_details']['mobileno'] = xss_filter($_POST['mobileno']);
            }
        }
  
        if($_POST['alternatemobileno'] != '') 
        {
            if(!valid_mobile($_POST['alternatemobileno'])) 
            {
                $err_mob_alt = 'Invalid Mobile no';
                $_SESSION['errors'][] = 'Alt Mobile no';
                $error = true; 
            } 
            else 
            {
                $alt_mobile = $_SESSION['co_applicant_details']['alternatemobileno']  = xss_filter($_POST['alternatemobileno']);
            }
        }
        if($_POST['emailId'] == '') 
        {
            $err_mail = 'Email Id is required.';
            $_SESSION['errors'][] = 'Email Id';
            $error = true; 
        } 
        else 
        {
            if(!valid_mail($_POST['emailId'])) 
            {
                $err_mail = 'Invalid Email Id';
                $_SESSION['errors'][] = 'Email Id';
                $error = true; 
            } 
            else 
            {
                $email_id = $_SESSION['co_applicant_details']['emailid']  = xss_filter($_POST['emailId']);
            }
        }
    
        if($_POST['permanentaddress1'] == '') 
        {
            $err_paddr1 = 'Address is required.';
            $_SESSION['errors'][] = 'Permanent Address3';
            $error = true; 
        } 
        else 
        {
            // echo "<pre>"; print_r('hi');
            if(!valid_address($_POST['permanentaddress1'])) 
            {
                // echo "<pre>"; print_r('issue'); exit;
                $err_paddr1 = 'Invalid permanentaddress1';
                $_SESSION['errors'][] = 'Permanent Address1';
                $error = true; 
            } 
            else 
            {
                $addr1 = $_SESSION['co_applicant_details']['permanentaddress1'] = xss_filter($_POST['permanentaddress1']);
            }
        }
    
        if($_POST['permanentaddress2'] != '') 
        {
            if(!valid_address($_POST['permanentaddress2'])) 
            {
                $err_paddr2 = 'permanentaddress2 invalid';
                $_SESSION['errors'][] = 'Permanent Address2';
                $error = true; 
            } 
            else 
            {
                $addr2 = $_SESSION['co_applicant_details']['permanentaddress2'] = xss_filter($_POST['permanentaddress2']);
            }
        }
    
        if($_POST['permanentaddress3'] != '') 
        {
            if(!valid_address($_POST['permanentaddress3'])) 
            {
                $err_paddr3 = 'Invalid permanentaddress3';
                $_SESSION['errors'][] = 'Permanent Address3';
                $error = true; 
            } 
            else 
            {
                $addr3 = $_SESSION['co_applicant_details']['permanentaddress3'] = xss_filter($_POST['permanentaddress3']);
            }
        }
    
        if($_POST['permanentpincode'] == '') 
        {
            $err_ppin = 'Pincode is required.';
            $_SESSION['errors'][] = 'Permanent Pincode';
            $error = true; 
        } 
        else 
        {
            if(!valid_pincode($_POST['permanentpincode'])) 
            {
                $err_ppin = 'Invalid Pincode';
                $_SESSION['errors'][] = 'Permanent Pincode';
                $error = true; 
            } 
            else 
            {
                $pin = $_SESSION['co_applicant_details']['permanentpincode'] = xss_filter($_POST['permanentpincode']);
            }
        }
    
        if($_POST['permanentstate'] == '') 
        {
            $err_pstate = 'State is required.';
            $_SESSION['errors'][] = 'Permannet State';
            $error = true; 
        } 
        else 
        {
            if(!valid_location($_POST['permanentstate'])) 
            {
                $err_pstate = 'Invalid State';
                $_SESSION['errors'][] = 'Permannet State';
                $error = true; 
            } 
            else 
            {
                $state = $_SESSION['co_applicant_details']['permanentstate'] = xss_filter($_POST['permanentstate']);
            }
        }

        if($_POST['permanentcity'] == '') 
        {
            $err_pcity = 'City is required.';
            $_SESSION['errors'][] = 'Permanent City Field';
            $error = true; 
        } 
        else 
        {
            if(!valid_location($_POST['permanentcity'])) 
            {
                $err_pcity = 'Invalid city';
                $_SESSION['errors'][] = 'Permanent City Field';
                $error = true; 
            } 
            else 
            {
                $city = $_SESSION['co_applicant_details']['permanentcity'] = xss_filter($_POST['permanentcity']);
            }
        }
    
        $state_code = $_SESSION['co_applicant_details']['perm_state_code'];
        $city_code  = $_SESSION['co_applicant_details']['perm_city_code'];
        
        if($_POST['currentaddress1'] == '') 
        {
            $err_caddr1 = 'Address is required.';
            $_SESSION['errors'][] = 'Current Address';
            $error = true; 
        } 
        else 
        {
            if(!valid_address($_POST['currentaddress1'])) 
            {
                $err_caddr1 = 'Invalid Characters';
                $_SESSION['errors'][] = 'Current Address';
                $error = true; 
            } 
            else 
            {
                $coApplicantCurrentAddr1 = $_SESSION['co_applicant_details']['currentaddress1'] = xss_filter($_POST['currentaddress1']);
            }
        }
    
        if($_POST['currentaddress2'] != '') 
        {
            if(!valid_address($_POST['currentaddress2'])) 
            {
                $err_caddr2 = 'Invalid Characters';
                $_SESSION['errors'][] = 'Current Address2';
                $error = true; 
            } 
            else 
            {
                $coApplicantCurrentAddr2 = $_SESSION['co_applicant_details']['currentaddress2'] = xss_filter($_POST['currentaddress2']);
            }
        }
    
        if($_POST['currentaddress3'] != '') 
        {
            if(!valid_address($_POST['currentaddress3'])) 
            {
                $err_caddr3 = 'Invalid Characters';
                $_SESSION['errors'][] = 'Current Address3';
                $error = true; 
            } 
            else 
            {
                $coApplicantCurrentAddr3 = $_SESSION['co_applicant_details']['currentaddress3'] = xss_filter($_POST['currentaddress3']);
            }
        }
    
        if($_POST['currentpincode'] == '') 
        {
            $err_cpin = 'Pincode is required.';
            $_SESSION['errors'][] = 'Current pincode';
            $error = true; 
        } 
        else 
        {
            if(!valid_pincode($_POST['currentpincode'])) 
            {
                $err_cpin = 'Invalid Pincode';
                $_SESSION['errors'][] = 'Current pincode';
                $error = true; 
            } 
            else 
            {
                $c_pin = $_SESSION['co_applicant_details']['currentpincode'] = xss_filter($_POST['currentpincode']);
            }
        }
    
        if($_POST['currentstate'] == '') 
        {
            $err_cstate = 'State is required.';
            $_SESSION['errors'][] = 'Current State';
            $error = true; 
        } 
        else 
        {
            if(!valid_location($_POST['currentstate'])) 
            {
                $err_cstate = 'Invalid State';
                $_SESSION['errors'][] = 'Current State';
                $error = true; 
            } 
            else 
            {
                $c_state = $_SESSION['co_applicant_details']['currentstate'] = xss_filter($_POST['currentstate']);
            }
        }
    
        if($_POST['currentcity'] == '') 
        {
            $err_ccity = 'City is required.';
            $_SESSION['errors'][] = 'Current City';
            $error = true; 
        } 
        else 
        {
            if(!valid_location($_POST['currentcity'])) 
            {
                $err_ccity = 'Invalid city';
                $_SESSION['errors'][] = 'Current City';
                $error = true; 
            } 
            else 
            {
                $c_city = $_SESSION['co_applicant_details']['currentcity'] = xss_filter($_POST['currentcity']);
            }
        }
  
        if($_POST['curWorkPlace'] == '') 
        {
            $err_join = 'Joining Date is required.';
            $_SESSION['errors'][] = 'Join Date';
            $error = true; 
        } 
        else 
        {
            if(!valid_date($_POST['curWorkPlace'])) 
            {
                $err_join = 'Invalid Date';
                $_SESSION['errors'][] = 'Join Date';
                $error = true; 
            } 
            else 
            {
                $current_work_experience = $_SESSION['co_applicant_details']['workexperiance'] = to_months(xss_filter($_POST['curWorkPlace']));
            }
        }
    
    if($error) 
    {
        redirect_to('resetpage');
    } 
    
    if(!$error) 
    {
        if($current_work_experience < 60) 
        {
            if($_POST['totworkexperianceY'] == '' && $_POST['totworkexperianceM'] == '') 
            {
                $err_year = 'Either Year or Month is required for Total Work Experience.';
                $error = true;
            } 
            else 
            {
                if($_POST['totworkexperianceY'] != '') 
                {
                    if(!valid_year($_POST['totworkexperianceY'])) 
                    {
                        $err_year = 'Invalid Year';
                        $error = true; 
                    }
                }  
                if($_POST['totworkexperianceM'] != '') 
                {
                    if(!valid_month($_POST['totworkexperianceM'])) 
                    {
                        $err_month = 'Invalid Month';
                        $error = true; 
                    }
                }
            }
        }
      
  if($current_work_experience < 60) 
  {
      $_SESSION['co_applicant_details']['totworkexperianceY']   = xss_filter($_POST['totworkexperianceY']);
      $_SESSION['co_applicant_details']['totworkexperianceM']   = xss_filter($_POST['totworkexperianceM']);
      $total_work_experience = ($_SESSION['co_applicant_details']['totworkexperianceY'] * 12) + $_SESSION['co_applicant_details']['totworkexperianceM'];
      $_SESSION['co_applicant_details']['totworkexperiance'] = $total_work_experience;
  } 
  else 
  {
      $total_work_experience = $current_work_experience;
      $_SESSION['co_applicant_details']['totworkexperiance'] = $total_work_experience;
  }

  if(isset($_SESSION['co_applicant_details']['aadharNo'])) 
  {
  
  }
      
    if(isset($_SESSION['customer']['aadharNo'])) 
    {
        $_SESSION['co_applicant_details']['aadharNo']         = $_SESSION['customer']['aadharNo'];
        $_SESSION['co_applicant_details']['permanentstate']   = $state;
        $_SESSION['co_applicant_details']['permanentcity']    = $city;
        $_SESSION['co_applicant_details']['perm_state_code']  = $state;
        $_SESSION['co_applicant_details']['perm_city_code']   = $city;
        $_SESSION['co_applicant_details']['currentstate']     = $c_state;
        $_SESSION['co_applicant_details']['currentcity']      = $c_city;
        $_SESSION['co_applicant_details']['curr_state_code']  = $c_state;
        $_SESSION['co_applicant_details']['curr_city_code']   = $c_city;
    } 
    else 
    {
        if($_SESSION['currChk'] == '1') 
        {
            $_SESSION['co_applicant_details']['currentaddress1']  = $addr1;
            $_SESSION['co_applicant_details']['currentaddress2']  = $addr2;
            $_SESSION['co_applicant_details']['currentaddress3']  = $addr3;
            $_SESSION['co_applicant_details']['curr_state_code']  = $state_code;
            $_SESSION['co_applicant_details']['curr_city_code']   = $city_code;
        }
    }
      
    if(isset($_SESSION['customer']['aadharNo'])) 
    {
        $_SESSION['co_applicant_details']['kycflag'] = 1;
    } 
    else 
    {
        $_SESSION['co_applicant_details']['kycflag'] = 0;
    }
      //****************************************************getLoan API*************************************************
    if(isset($_SESSION['customer']['aadharNo'])) 
    {
        if($_SESSION['currChk'] == '1') 
        {
            $_SESSION['co_applicant_details']['curr_state_code']      =   $state_code;
            $_SESSION['co_applicant_details']['curr_city_code'] =   $city_code;
            unset($_SESSION['currChk']);
        }
  
        $service_url = API. 'InsertCoApplicant';
        $headers = array (
            "Content-Type: application/json"
        );
      
        $curl_post_data = array(
            "CRMLeadID"                 => xss_filter($_SESSION['personal_details']['CRMLeadID']),
            "ApplicantType"             => "COBORROWER",
            "ProspectNumber"            => xss_filter($_SESSION['personal_details']['ProspectNumber']),
            "CoCompanyName"             => xss_filter($_SESSION['co_applicant_details']['companyName']),
            "CoOtherCompanyName"        => "",
            "RelationwithApplicant"     => xss_filter($_SESSION['co_applicant_details']['relationType']),
            "CoDomain"                  => "",
            "CoMonthlySalary"           => xss_filter($_SESSION['co_applicant_details']['monthlySalary']),
            "CoMonthlyObligation"       => xss_filter($_SESSION['co_applicant_details']['currentEmi']),
            "CoPersonalEmailID"         => xss_filter($email_id),
            "CoMobileNo"                => xss_filter($coApplicantMobileNumber),
            "CoAlternateMobileNo"       => xss_filter($coApplicantMobileNumber2),
            "CoAadhaarNumber"           => xss_filter($_SESSION['customer']['AddharNo']),
            "CoFName"                   => xss_filter($coApplicantFirstName),
            "CoMName"                   => xss_filter($coApplicantMiddleName),
            "CoLName"                   => xss_filter($coApplicantLastName),
            "CoGender"                  => xss_filter($coApplicantGender),
            "CoPAN"                     => xss_filter($panno),
            "CoCurrentWorkExp"          => xss_filter($_SESSION['co_applicant_details']['workexperiance']),
            "CoTotalWorkExp"            => xss_filter($_SESSION['co_applicant_details']['totworkexperiance']),
            "CoDOB"                     => $dob,
            "CoPermanentAddress1"       => xss_filter($coApplicantPermanentAddr1),
            "CoPermanentAddress2"       => xss_filter($coApplicantPermanentAddr2),
            "CoPermanentAddress3"       => xss_filter($coApplicantPermanentAddr3),
            "CoPermanentState"          => xss_filter($coApplicantPermanentState),
            "CoPermanentCity"           => xss_filter($coApplicantPermanentCity),
            "CoPermanentPin"            => xss_filter($coApplicantPermanentPincode),
            "CoCurrentAddress1"         => xss_filter($coApplicantCurrentAddr1),
            "CoCurrentAddress2"         => xss_filter($coApplicantCurrentAddr2),
            "CoCurrentAddress3"         => xss_filter($coApplicantCurrentAddr3),
            "CoCurrentState"            => xss_filter($_SESSION['co_applicant_details']['curr_state_code']),
            "CoCurrentCity"             => xss_filter($_SESSION['co_applicant_details']['curr_city_code']),
            "CoCurrentPin"              => xss_filter($_SESSION['co_applicant_details']['currentpincode']),
            "CoKYCFlag"                 => xss_filter($_SESSION['co_applicant_details']['kycflag']),
            "PageNumber"                => "10",
            "EmploymentType"            => xss_filter($_SESSION['co_applicant_details']['occupation']   ),
            "NatureOfBusiness"          => xss_filter($_SESSION['co_applicant_details']['cnamecoappnature']),
            "Profession"                => xss_filter($_SESSION['co_applicant_details']['cnamecoappnatureprofession']),
            "ConstitutionType"          => xss_filter($_SESSION['co_applicant_details']['cnamecoappnatureconstitution']),
        );
        $decodeddata = json_encode($curl_post_data);
        // echo "<pre>"; print_r($service_url); echo "<pre>"; print_r($decodeddata); exit;
        $_SESSION['request'] = $decodeddata;
        $handle = curl_init(); 
        curl_setopt($handle, CURLOPT_URL, $service_url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
        
        $curl_response = curl_exec($handle);
        
        curl_close($handle);
        //echo '<pre>'; echo print_r($curl_response); echo '</pre>'; 
        $_SESSION['response'] = $curl_response;
        $json = json_decode($curl_response);
        $json2 = array();
        $json2 = json_decode($json, true);
      
        if(strtolower($json2[0]['Status']) == 'success') 
        {
            $_SESSION['co_applicant_details']['ProspectNumber'] = xss_filter($json2[0]['ProspectNumber']);
            //$_SESSION['personal_details']['ProspectNumber'] = xss_filter($json2[0]['ProspectNumber']);
            if($_SESSION['personal_details']['ProspectNumber'] == $json2[0]['ProspectNumber'])
            {
                if($json2[0]['CibilResponse'] == '0-Yes') 
                {
                    $_SESSION['co_applicant_details']['CIBIL']['flag']  = 'Yes';
                    $_SESSION['co_applicant_details']['CIBIL']['CibilResponse']     = $json2[0]['CibilResponse'];
                    $_SESSION['co_applicant_details']['CIBIL']['CIBILTotalEMI']     = $json2[0]['CIBILTotalEMI'];
                    $_SESSION['co_applicant_details']['CIBIL']['MaxAmount']   = $json2[0]['MaxAmount'];
                    $_SESSION['co_applicant_details']['CIBIL']['MaxTenure']   = $json2[0]['MaxTenure'];
                    $_SESSION['co_applicant_details']['CIBIL']['ROIDefault']  = $json2[0]['ROIDefault'];
                    $_SESSION['co_applicant_details']['CIBIL']['ROIActual']   = $json2[0]['ROIActual'];
                    $_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeDefault']  = $json2[0]['ProcessingFeeDefault'];
                    $_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual']   = $json2[0]['ProcessingFeeActual'];
                    redirect_to('your-quote');
                } 
                elseif($json2[0]['CibilResponse'] == '1-N0') 
                {
                    $_SESSION['co_applicant_details']['CIBIL']['flag']  = 'No';
                    redirect_to('your-quote');
                }   
                elseif($json2[0]['CibilResponse'] == '2-Null') 
                {
                    $_SESSION['co_applicant_details']['CIBIL']['flag']  = 'Null';
                    $_SESSION['co_applicant_details']['CIBIL']['CibilResponse']     = $json2['CibilResponse'];
                    $_SESSION['co_applicant_details']['CIBIL']['CIBILTotalEMI']     = $json2['CIBILTotalEMI'];
                    $_SESSION['co_applicant_details']['CIBIL']['MaxAmount']   = $json2['MaxAmount'];
                    $_SESSION['co_applicant_details']['CIBIL']['MaxTenure']   = $json2['MaxTenure'];
                    $_SESSION['co_applicant_details']['CIBIL']['ROIDefault']  = $json2['ROIDefault'];
                    $_SESSION['co_applicant_details']['CIBIL']['ROIActual']   = $json2['ROIActual'];
                    $_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeDefault']  = $json2['ProcessingFeeDefault'];
                    $_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual']   = $json2['ProcessingFeeActual'];
                    redirect_to('co-applicant-upload-document');
                } 
                else 
                {
                    $_SESSION['co_applicant_details']['CIBIL']['flag']  = 'No';
                    redirect_to('your-quote');
                }
            }
            else 
            {
                $_SESSION['co_applicant_details']['CIBIL']['flag']  = 'No';
                redirect_to('your-quote');
            }
        }   
        else 
        {
            $_SESSION['co_applicant_details']['CIBIL']['flag']  = 'No';
            redirect_to('your-quote');
        } 
    }
    else 
    {    
        $service_url = COMMON_API. 'SendOTP';
        $headers = array (
          "Content-Type: application/json"
        );
        $curl_post_data = array(
          "CRMLeadID"     => xss_filter($_SESSION['personal_details']['CRMLeadID']),
          "MobileNumber"  => $mobile_no
        );
        $decodeddata = json_encode($curl_post_data);
        $handle = curl_init(); 
        curl_setopt($handle, CURLOPT_URL, $service_url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
      
        $curl_response = curl_exec($handle);
        curl_close($handle);
        $json = json_decode($curl_response);
        if($json->Status == 'Y') 
        {
            $_SESSION['manual']['otp'] = $json->OTP;
            redirect_to('manual-verification');
        }
    }
}
}
  
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
  <title>IIFL : Sapna Aapka, Loan Hamara</title>
  <link rel="shortcut icon" href="images/favicon.ico">
  <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  <script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
  <script type="text/javascript" src="js/css3mediaquery.js"></script>
  <link href="css/fonts.css" rel="stylesheet" type="text/css">
  <link href="css/iifl.css" rel="stylesheet" type="text/css">
  <link href="css/media.css" rel="stylesheet" type="text/css">
  <script src="js/jquery.easing.min.js" type="text/javascript"></script>
  <script src="js/function.js" type="text/javascript"></script>
  
  <link rel="stylesheet" href="css/default.css" type="text/css">
  <!--<script type="text/javascript" src="js/zebra_datepicker.js"></script>  -->
  <script type="text/javascript" src="js/core.js"></script>

  <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!-- -->
  <style>
    .join-date #error-user{/*position:relative; left:196px;*/ display: block;}
    .dob #error-user{position:relative;}
  </style>
  <script>
    $(function() {
        $(".co-app-tab-header li a").click(function(){
            $(this).addClass("link-active").parent().siblings('li').find('a').removeClass("link-active");
            var getclassname = $(this).parent().attr('class');
            $('.co-app-tab-child[rel="'+getclassname+'"]').fadeIn();
            $('.co-app-tab-child[rel="'+getclassname+'"]').siblings().hide();
        }).eq(1).click();

        if(!$("input[name=radioGe]").is(":checked")) {
            $("#f").click();
        } 

        $( "#datepicker-example2" ).datepicker({
			yearRange: '1977:2017',
            //maxDate: '-24Y',
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $( "#datepicker-example1" ).datepicker({
			yearRange: '1952:2017',
            maxDate: 0,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
        $("#block2, #block3, #block4").hide();
        $("#block1 input").change(function(event){ block_FN(event,"block1","block2"); });
        $("#block2 input").change(function(event){ block_FN(event,"block2","block3"); });
        $("#block3 input").change(function(event){ block_FN(event,"block3","block4"); });
    });

    function calbackEmi() { 
      //$("#emidiv").html(emical(str2int($("#loan").val()),str2int($("#years").val()),9.5));
      $("#loanAmu").html($("#loan").val());
      $("#tenure").html($("#years").val()); 
      $("#totalAmu").html(adcoma(str2int($("#emidiv").html())*str2int($("#years").val())*12));
    }

    function chkboxFn2(e) {
        var inputChecked = 0;
        if(e.target.checked==true) 
        {
            inputChecked = 1;
            if($("#permanentaddress1").val() != "" && $("#copermanentpincode").val() != "") 
            {
                $("#currentaddress1").val($("#permanentaddress1").val());
                $("#currentaddress2").val($("#permanentaddress2").val());
                $("#currentaddress3").val($("#permanentaddress3").val());
                $("#cocurrentpincode").val($("#copermanentpincode").val());
                $("#currentstate").val($("#permanentstate").val());
                $("#currentcity").val($("#permanentcity").val());
                $("#CoDivCA input").each(function() {
                    $(this).closest(".input").find("span").css("visibility", "hidden");
                });
                $("#CoDivCA").find("input").each(function() {
                    $(this).attr("readonly", "readonly");
                });
            } 
            else 
            {
                e.target.checked=false;
            }
        } 
        else 
        {
            inputChecked = 0;
            $("#CoDivCA input").each(function() {
                $(this).removeAttr("disabled");
                $(this).val("");
                $(this).prev().css("visibility","visible");
            });
            $("#CoDivCA input").each(function() {
                $(this).removeAttr("disabled");
                $(this).removeAttr("readonly");
            });
        }
        $.ajax({
            url:"ajax/checkbox",
            type:"POST",
            async: false,
            data:{'inChk':inputChecked},
            success: function(msg) {
        }
        });
        $("#currentaddress1").next("#error-user").remove();
        $("#currentaddress2").next("#error-user").remove();
        $("#currentaddress3").next("#error-user").remove();
        $("#cocurrentpincode").next("#error-user").remove();
        $("#currentstate").next("#error-user").remove();
        $("#currentcity").next("#error-user").remove();
    }

    function chkdateFN() {
      //console.log($("#block3").css("display"));
      if($("#block3").css("display")  ==  "block") {
  $("#block4").show(500);
      } 
    }
  
  
  
  
  </script>
  <?php if(isset($_SESSION['co_applicant_details']['aadharNo'])): ?>
    <script>
      $(window).load(function(){
  $("#block2").show();
  $("#block3").show();
  $("#block4").show();
      });     
    </script>
  <?php else: ?>
    <script>
      $(window).load(function(){
  $("#block2, #block3, #block4").hide();
      }); 
    </script>
  <?php endif; ?>
    <!-- Start Google Analytics Code -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-690673-17', 'auto');
      ga('send', 'pageview');
    </script>
    <!-- End Google Analytics Code -->
    <!-- Start Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
      n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
      document,'script','https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '1789326097974863');
      fbq('track', 'PageView');
    </script>
    <noscript>
      <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1789326097974863&ev=PageView&noscript=1"/>
    </noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->
  </head>
  <body class="bodyoverflow kyc">
  <!-- PAN CARD Pixel -->
  <img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Pan-Card=<Pan-Card>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
  <!-- PAN CARD PIxel End -->
    <div class="dnone">
    <?php
      if(isset($_POST)) {
  //print_r($_POST);
  if($curl_post_data) {
    echo '<pre>Request Data: <br>'; echo print_r($curl_post_data); echo '</pre>';
  }
  if($curl_response) {
    echo '<pre> Response Data <br>'; echo print_r($curl_response); echo '</pre>';
  }
      }
    ?>
    
  </div>
  
<div id="main-wrap">
 <!--popup-->
   <div class="overlay"></div>
  <div class="tnc-popup">
    <div class="tnc-popup-txt">
      <p><strong>TERMS AND CONDITIONS</strong></p>
      <p>1. I hereby declare that every information already provided by me or as may be provided hereinafter are true and updated. I have not withheld or modified any part of such information. </p>
      <p>2. I agree that the right to grant any credit facility lies with IIFL at its sole discretion and IIFL holds the right to reject my application at any time. I agree that IIFL shall not be responsible for any such rejection or any delay in intimating its decision.</p>
      <p>3. I agree and accept that IIFL may in its sole discretion, by itself or through authorised persons, advocate, agencies, bureau, etc. verify any information given, check credit references, employment details and obtain credit reports or other KYC related documents. </p>
      <p>4. I hereby authorize IIFL to exchange, share or part with all the information as provided by me or as may be provided by me with any of the group companies, banks, financial institutions, credit bureaus, statutory bodies or any entity as may required from time to time as deem fit by IIFL. I shall not hold IIFL liable for sharing any such information.</p>
      <p>5. I hereby undertake to immediately inform IIFL regarding any change in information provided to IIFL by me.</p>
      <p>6. I would like to know through telephonic calls/SMSs on my mobile number mentioned in this application form or through any other communication mode, various loan schemes, promotional offers of IIFL and I authorise IIFL, its employees or its agents to act accordingly. I confirm that laws in relations to the unsolicited communications referred in ‘National Do Not Call Registry’ as laid down by Telecom Regulatory Authority of India shall not be applicable to such communications/ telephonic calls/SMSs received from IIFL, its employees or its agents</p>
      <p class="tc"><a href="javascript://" class="closepop">OK</a></p>
      <div class="closeicon"><a href="javascript://" class="closepop"><img src="images/close-icon.png" class="scale"></a></div>
    </div>
  </div>
  <!--popup-->
  <header>
    <div class="header-inner knowmore">
      <div class="logo"><img src="images/logo.jpg" class="scale"></div>
      <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
      <div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
      <div class="clr"></div>
      <div class="card-container-outerinner">
  <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
  <div class="card-container1 effect__random card-container" data-id="1">
    <div class="card__front"> <img src="images/48hours.png" class="scale">
      <p class="pendulamtxt">Express<br>
  Personal<br>
  Loan</p>
    </div>
    <div class="card__back"><img src="images/48hours.png" class="scale">
      <p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>
    </div>
  </div>
      </div>
    </div>
  </header>
  <form id="kycFrm1" name="form1" method="post" action="know-your-co-applicant" autocomplete="off">
    <div id="msform" onLoad="form1.reset();" class="knowyour">
      <section class="body-home-outer myclass screen04bg bgpink">
      <ul class="co-app-tab-header">
  <li class="tablink-1"><a href="#">1st applicant</a></li>
  <li class="tablink-2"><a href="#" class="link-active">co-applicant</a></li>
      </ul>
  <div class="innerbody-home height-ipad-812" style="height:auto; min-height:790px;"> 
    
    <div class="approval-wrap">
      <div class="approval-leftpoints visibleall margintop5per centerall">
    <div class="emi-quoteicon width57"><img src="images/emiicon.png" class="scale"><br />
      <span class="pagin-detail">EMI Quote</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57"><img src="images/emiicon.png" class="scale"><br />
      <span class="pagin-detail">My Details</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57"><img src="images/detailicon-big.png" class="scale"><br />
      <span class="pagin-detail">Co-applicant's Details</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57"><img src="images/eligible-icon-fade.png" class="scale"><br />
      <span class="pagin-detail">Eligibility</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57 lasticon"><img src="images/document-icon-fade.png" class="scale"><br />
      <span class="pagin-detail">Documents</span></div>
    <div class="clr"></div>
  </div>
      <?php if($error): ?>
      <div class="error"><?php //echo $error; ?></div>
      <?php endif; ?>
      <div class="approval-right-container">
      <div class="co-app-tab-child width100 coappknowcusttab1" rel="tablink-1">
  <div class="appdetails-coapp">
    <div class="aadhar-heading paddtop40 margin-bott20 paddtp0">Applicant's details</div>
    <div class="detailwrap-line1">
      <div class="detailfields">
      <div class="placholderval">First Name</div>
        <label class="input"> <span>First Name*</span>
    <input type="text" class="textup" name="applicantnamecoapp" maxlength="20" id="applicantname" value="<?php echo $applicantFirstName;?>" disabled />
        </label>
      </div>
      <div class="detailfields">
      <div class="placholderval">Middle Name</div>
        <label class="input"> <span>Middle Name</span>
    <input type="text" class="textup" name="middlename" id="middlename" maxlength="20" value="<?php echo $applicantMiddleName?>" disabled /></label>
      </div>
      <div class="detailfields">
      <div class="placholderval">Last Name</div>
        <label class="input"> <span>Last Name*</span>
    <input type="text" class="textup" name="lastname" id="lastname" maxlength="20" value="<?php echo $applicantLastName;?>" disabled /></label>
      </div>   
      <div class="detailfields">
      <div class="placholderval">Pan card number</div>
        <label class="input"> <span>Pan card number*</span>
    <input type="text" class="textup" name="pcnocoapp" id="pcnocoapp" value="<?php echo $applicantPanNo;?>" disabled /></label>
      </div> 
      <div class="detailfields">
      <div class="placholderval">birth date</div>
        <label class="input"> <span>birth date*</span>
    <input type="text" class="textup" name="coappbdate" id="coappbdate" value="<?php echo $applicantDob;?>" disabled /></label>
      </div>    
      <div class="detailfields">
        <div class="placholderval">gender</div>
        <label class="input"> <span>gender*</span>
            <input type="text" class="textup" name="coappgender" id="coappgender" value="<?php echo $applicantGender;?>" disabled />
        </label>
        
      </div>  
       <div class="detailfields">
      <div class="placholderval">Mobile number</div>
        <label class="input"> <span>Mobile number*</span>
    <input type="text" class="textup" name="coappmob" id="coappmob" value="<?php echo $applicantMobileNumber;?>" disabled /></label>
      </div>  
      <div class="detailfields">
      <div class="placholderval">email id</div>
        <label class="input"> <span>email id*</span>
    <input type="text" class="textup" name="coappemailid" id="coappemailid" value="<?php echo $applicantEmailId;?>" disabled /></label>
      </div>  
      <!-- <div class="detailfields">
      <div class="placholderval">Date of company join</div>
        <label class="input"> <span>Date of company join*</span>
    <input type="text" class="textup" name="coappdcomjoin" id="coappdcomjoin" value="22-nov-1985" disabled /></label>
      </div>  -->
      <div class="detailfields">
      <div class="placholderval">permanent address</div>
        <label class="input"> <span></span>
    <input type="text" class="textup" name="coapppadd" id="coapppadd" maxlength="100" value="<?php echo $applicantPermanentAddress;?>" disabled /></label>
      </div>
      <div class="detailfields">
      <div class="placholderval">pin code</div>
        <label class="input"> <span></span>
    <input type="text" class="textup" name="coapppin" id="coapppin" value="<?php echo $applicantPermanentPincode;?>" disabled /></label>
      </div>   
      <div class="detailfields">
      <div class="placholderval">State</div>
        <label class="input"> <span></span>
    <input type="text" class="textup" name="coappstate" id="coappstate" value="<?php echo $applicantPermanentState;?>" disabled /></label>
      </div> 
      <div class="detailfields">
      <div class="placholderval">City</div>
        <label class="input"> <span></span>
    <input type="text" class="textup" name="coappcity" id="coappcity" value="<?php echo $applicantPermanentCity?>" disabled /></label>
      </div>      
      <div class="clr"></div>
    </div>
  </div>
      </div>
      <div class="co-app-tab-child width100" rel="tablink-2">
      <div id="block1" class="paddtop40 paddtp0">
    <div class="aadhar-heading">Tell us a bit about yourself</div>
    <div class="detailwrap-line1">
      <div class="detailfields">
        <label class="input"> <span>First Name*</span>
    <input type="text" name="applicantname" id="applicantnamecoapp" value="<?php if(isset($_SESSION['customer']['aadharNo'])) echo $coApplicantFirstName; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'readonly':''; ?> maxlength="20"/>
    <?php if($err_fn != ''): ?><div id="error-user"><?php echo $err_fn; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>Middle Name</span>
    <input type="text" name="middlename" id="middlenamecoapp" value="<?php if(isset($_SESSION['customer']['aadharNo'])) echo $coApplicantMiddleName; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'readonly':''; ?> maxlength="20" />
    <?php if($err_mn != ''): ?><div id="error-user"><?php echo $err_mn; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>Last Name*</span>
    <input type="text" name="lastname" id="lastnamecoapp" value="<?php if(isset($_SESSION['customer']['aadharNo'])) echo $coApplicantLastName; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'readonly':''; ?> maxlength="20" />
    <?php if($err_ln != ''): ?><div id="error-user"><?php echo $err_ln; ?></div><?php endif; ?>
        </label>
      </div><div class="clr"></div>
      <div class="detailfields">
        <label class="input"> <span>PAN Card Number*</span>
    <input type="text" name="panno" id="panno" class="pannumber" maxlength="10" value="<?php echo $panno; ?>"/>
    <?php if(!empty($pan_error)): ?>
      <div id="error-user" class="api-err"><?php echo $pan_error; ?></div>
    <?php else: ?>
      <?php if($err_pan != ''): ?><div id="error-user"><?php echo $err_pan; ?></div><?php endif; ?>
    <?php endif; ?>
        </label>
      </div>
      <div class="detailfields dob">
        <input name="dob" type="text" class="inputdob" value="<?php echo !empty($coApplicantdob)?$coApplicantdob:'Date of Birth*'; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'disabled':''; ?> onFocus="if (this.value=='Date of Birth*') this.value = ''" onBlur="if (this.value=='') this.value = 'Date of Birth*'" id="datepicker-example2" readonly>
        <?php if($err_dob != ''): ?><div id="error-user"><?php echo $err_dob; ?></div><?php endif; ?>
        <div class="clr"></div>
        <input type="hidden" name="kycDob" value="<?php echo !empty($coApplicantdob)?$coApplicantdob:'Date of Birth*'; ?>" id="kycDob"/>
        <span class=note>(Minimum age 25 years old)</span>
      </div>
      <div class="clr"></div>
        <div class="eduhead">Gender<span class="red">*</span></div>
      <div class="personalinfo-radiobox">
        <div class="inputcheckbx notValidate">
            <div class="chkpersonal-info">
                <?php if(isset($_SESSION['customer']['aadharNo'])): ?>
                    <?php if($coApplicantGender == 'F'): ?>
                        <input type="radio" name="radioGe" id="f" value="M" disabled="disabled" maxlength="1" >
                    <?php else: ?>
                        <input type="radio" name="radioGe" id="f" value="M" checked="checked" maxlength="1" >
                    <?php endif; ?>
                <?php else: ?>
                    <input type="radio" name="radioGe" id="f" value="M" maxlength="1" >
                <?php endif; ?>
                <label for="f">Male</label>
            </div>
        <div class="chkpersonal-info">
            <?php if(isset($_SESSION['customer']['aadharNo'])): ?>
                <?php if($coApplicantGender == 'M'): ?>
                        <input type="radio" name="radioGe" id="f" value="F" disabled="disabled" maxlength="1" >
                    <?php else: ?>
                        <input type="radio" name="radioGe" id="f" value="F" checked="checked" maxlength="1" >
                    <?php endif; ?>
            <?php else: ?>
                <input type="radio" name="radioGe" id="g" value="F" maxlength="1">
            <?php endif; ?>
            <label for="g">Female</label>
        </div>
        <?php if($err_gender != ''): ?><div id="error-user"><?php echo $err_gender; ?></div><?php endif; ?>
    </div>
      </div>      
      <div class="clr"></div>
    </div>
  </div>
  <div id="block2">
    <div class="aadhar-heading">Where can we reach you?</div>
    <div class="detailwrap-line1">
      <div class="detailfields">
        <label class="input"> <span <?php echo !empty($coApplicantMobileNumber)?'style="visibility:hidden"':''; ?>>Mobile Number1*</span>
    <input  name="mobileno" id="mobileno" type="text" maxlength="10" onkeypress="return isNumberKey(event)" value="<?php echo $coApplicantMobileNumber; ?>" />
    <?php if($err_mob != ''): ?><div id="error-user"><?php echo $err_mob; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>Mobile Number2</span>
    <input name="alternatemobileno" value="<?php echo $coApplicantMobileNumber2;?>" id="alternatemobileno" onkeypress="return isNumberKey(event)" type="text" maxlength="10"/>
    <?php if($err_mob_alt != ''): ?><div id="error-user"><?php echo $err_mob_alt; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span <?php echo !empty($coApplicantEmailId)?'style="visibility:hidden"':''; ?>>Email ID*</span>
    <input type="text" maxlength="100" name="emailId" id="emailId" value=""/>
    <?php if($err_mail != ''): ?><div id="error-user"><?php echo $err_mail; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div id="block3">
    <div class="aadhar-heading"><?php if(isset($_SESSION['co_applicant_details']['occupation']) && $_SESSION['co_applicant_details']['occupation'] =='semp') echo 'Organization'; else 'Employment';?> Details</div>
    <div class="detailwrap-line1 join-date">
      <div class="empdetail-box"> When did you join <?php if(isset($_SESSION['co_applicant_details']['occupation']) && $_SESSION['co_applicant_details']['occupation'] =='semp') echo strtoupper($_SESSION['co_applicant_details']['companyName']); else echo $_SESSION['co_applicant_details']['companyName']; ?>: <span class="empdetail-date"><span class="mandatory">*</span>
        <input type="text" name="curWorkPlace" class="empdate inputdob" id="datepicker-example1" readonly /> 
        <?php if($err_join != ''): ?><div id="error-user"><?php echo $err_join; ?></div><?php endif; ?>
        <!--<label class="input"><span></span>
            <input type="text" name="curWorkPlace" class="empdate" id="datepicker-example1"/></label>--> 
        </span> </div>
      <div class="empdetail-box dnone" id="empjoin">Total work experience*
        <label class="input input_exp_work">
    <span>Year</span>
      <input type="text" name="totworkexperianceY" id="totworkexperianceY" class="empdate inputdob" maxlength="2" onkeypress="return isNumberKey(event)"/>
    </label>
    <label class="input input_exp_work">
      <span>Month</span>
      <input type="text" name="totworkexperianceM" id="totworkexperianceM" class="empdate inputdob" id="limitNumber" maxlength="2" onkeypress="return isNumberKeylimit(event)"/>
    </label>
      </div>
      <!--<div class="detailfields totalwork dnone" id="empjoin">
        <label class="input"> <span>Total work experience*</span> 
    <input type="text" name="totworkexperiance" id="totworkexperiance" class="empdate" onkeypress="return isNumberKey(event)" /
    <input type="text" name="totworkexperiance" id="totworkexperiance" class="" onkeypress="return isNumberKey(event)" />
        </label>
      </div>-->
      <div class="clr"></div>
    </div>
  </div>
  <div id="block4" class="remain-detail">
    <div class="aadhar-heading">Where do you stay?</div>
    <div class="detailwrap-line1" id="CoDivPA">
      <div class="datafieldone">
        <label class="input"> <span id="spnAP">Permanent Address1*</span>
    <input type="text" id="permanentaddress1" name="permanentaddress1" value="<?php echo $coApplicantPermanentAddr1; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'readonly':''; ?> maxlength="100" />
    <?php if($err_paddr1 != ''): ?><div id="error-user"><?php echo $err_paddr1; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="datafieldone">
        <label class="input"> <span id="spnAP">Permanent Address2</span>
    <input type="text" id="permanentaddress2" name="permanentaddress2" value="<?php echo $coApplicantPermanentAddr2; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'readonly':''; ?> maxlength="100" />
    <?php if($err_paddr2 != ''): ?><div id="error-user"><?php echo $err_paddr2; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="datafieldone">
        <label class="input"> <span id="spnAP">Permanent Address3 </span>
    <input type="text" id="permanentaddress3" name="permanentaddress3" value="<?php echo $coApplicantPermanentAddr3; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'readonly':''; ?> maxlength="100" />
    <?php if($err_paddr3 != ''): ?><div id="error-user"><?php echo $err_paddr3; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>Pincode*</span>
    <input type="text" name="permanentpincode" id="copermanentpincode" onkeypress="return isNumberKey(event)" maxlength="6" value="<?php echo $coApplicantPermanentPincode; ?>" <?php echo isset($_SESSION['customer']['aadharNo'])?'readonly':''; ?>/>
    <?php if($err_ppin != ''): ?><div id="error-user"><?php echo $err_ppin; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>State*</span>
    <input type="text" name="permanentstate" id="permanentstate" value="<?php echo $coApplicantPermanentState; ?>" readonly  />
    <?php if($err_pstate != ''): ?><div id="error-user"><?php echo $err_pstate; ?></div><?php endif; ?>
      </div>
      <div class="detailfields">
        <label class="input"> <span>City*</span>
    <input type="text" name="permanentcity" id="permanentcity" value="<?php echo $coApplicantPermanentCity; ?>" readonly  />
    <?php if($err_pcity != ''): ?><div id="error-user"><?php echo $err_pcity; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="clr"></div>
      <div class="edBottomTerms2 marginadjust" style="text-align:center">
        <div class="edBottomCheckbox2">
    <input type="checkbox" value="1" id="addrCh" name="checkbox" onChange="chkboxFn2(event)" />
    <label for="addrCh"></label>
        </div>
        <p>Current address is same as permanent address</p>
      </div>
    </div>
    <div class="detailwrap-line1" id="CoDivCA">
      <div class="datafieldone">
        <label class="input"><span>Current Address1*</span>
    <input type="text" id="currentaddress1" name="currentaddress1" value="" maxlength="100"/>
    <?php if($err_caddr1 != ''): ?><div id="error-user"><?php echo $err_caddr1; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="datafieldone">
        <label class="input"><span>Current Address2</span>
    <input type="text" id="currentaddress2" name="currentaddress2" value="" maxlength="100" />
    <?php if($err_caddr2 != ''): ?><div id="error-user"><?php echo $err_caddr2; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="datafieldone">
        <label class="input"><span>Current Address3</span>
    <input type="text" id="currentaddress3" name="currentaddress3" value="" maxlength="100" />
    <?php if($err_caddr3 != ''): ?><div id="error-user"><?php echo $err_caddr3; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>Pincode*</span>
    <input type="text" name="currentpincode" id="cocurrentpincode" value="" onkeypress="return isNumberKey(event)" maxlength="6" />
    <?php if($err_cpin != ''): ?><div id="error-user"><?php echo $err_cpin; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>State*</span>
    <input type="text" name="currentstate" id="currentstate" value="" readonly/>
    <?php if($err_cstate != ''): ?><div id="error-user"><?php echo $err_cstate; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="detailfields">
        <label class="input"> <span>City*</span>
    <input type="text" name="currentcity" id="currentcity" value="" readonly/>
    <?php if($err_ccity != ''): ?><div id="error-user"><?php echo $err_ccity; ?></div><?php endif; ?>
        </label>
      </div>
      <div class="clr"></div>
    </div>
    <div class="edBottomTerms2" style="text-align:center">
      <div class="edBottomCheckbox2">
        <input type="checkbox"  id="termschk" name="" checked="true" disabled />
        <label for="termschk"></label>
      </div>
      <p><a href="javascript:;" class="tnc-btn">I agree to all the terms and conditions</a></p>
      <div class="clr"></div>
    </div>
  </div>
  <div class="next-home next-scr2 tc"> 
  <!--<input type="submit" name="button" id="submitBtn" value="CHECK ELIGIBILITY" disabled="true"  class="homesubmit disabled" />-->
  <input type="hidden" name="kycflag" id="kycflag" />
  <input type="hidden" name="webpageno" id="webpageno" value="3" />
  <input type="submit" name="kycSubmit" id="submitBtn" value="NEXT"  class="homesubmit" onClick="ga('send', 'event', 'Personal Loan', 'Next-Click', 'Details-set1');"/>
      </div>
      </div>
      </div>
      <div class="clr"></div>
      
    </div>
    <div class="screen05img"> <img src="images/homescreen-05img.png" class="scale">
      <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
      <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
    </div>
  </div>
      </section>
    </div>
  </form>
  <script src="js/cards1.js" type="text/javascript"></script>
  <?php require_once('includes/footer.php'); ?>
    <script>
     $("#kycFrm1").bind('submit', function() {

        $("#error-user").remove();
        $(".detailfields").each(function() {
            $(this).find('#error-user').remove();
        });
        $(".datafieldone").each(function() {
            $(this).find('#error-user').remove();
        });
        var error = false;
        if($("#totworkexperianceY").is(":visible")) 
        {
            if($("#totworkexperianceY").val() != '' ||  $("#totworkexperianceM").val() != '') 
            {
                var joinDate = $("#datepicker-example1").val();
                var tempDate = joinDate.split('-');
                var curJoinDate = tempDate[0]+','+tempDate[1]+','+tempDate[2];  
                var currentDate = now();
                var temp = currentDate.split('-')
                currentDate = temp[0]+','+temp[1]+','+temp[2];
                var currWorkMonths = monthDiff(curJoinDate,currentDate);
  
                if($("#totworkexperianceY").val() == '') 
                {
                    var totalWorkY = 0;
                } 
                else 
                {
                    var totalWorkY = $("#totworkexperianceY").val() *12;
                }
  
                if ($("#totworkexperianceM").val() == '') 
                {
                    var totalWorkM = 0;
                } 
                else 
                {
                    var totalWorkM = $("#totworkexperianceM").val();
                }
  
                var totalWorkExp = parseInt(totalWorkY) + parseInt(totalWorkM);
                if(currWorkMonths > totalWorkExp) 
                {
                    $("#totworkexperianceM").after('<div id="error-user">Current Work experience cannot be greater than Total experience</div>');
                    error = true;
                }
            }
        }
          
        if($("#applicantnamecoapp").val() == '') {
            $("#applicantnamecoapp").after('<div id="error-user">First Name is required.</div>');
            error = true;
        } 
        if($("#lastnamecoapp").val() == '') {
            $("#lastnamecoapp").after('<div id="error-user">Last Name is required.</div>');
            error = true;
        } 
        if($("#panno").val() == '') {
            $("#panno").after('<div id="error-user">Pan Card Number is required.</div>');
            error = true;
        }
        if($("#datepicker-example2").val() == 'Date of Birth*') {
            $("#datepicker-example2").after('<div id="error-user">Birth Date is required.</div>');
            error = true;
        }
        if($("#datepicker-example1").val() == '') {
            $(".error-user-join").remove();
            $("#datepicker-example1").after('<div id="error-user" class="error-user-join">Joining Date is required.</div>');
            error = true;
        } 
        if($("#mobileno").val() == '') {
            $("#mobileno").after('<div id="error-user">Mobile Number is required.</div>');
            error = true;
        }
        if($("#emailId").val() == '') {
            $("#emailId").after('<div id="error-user">Email Id is required.</div>');
            error = true;
        }
            
        

        
        if($("#currentaddress1").val() == '') {
            $("#currentaddress1").after('<div id="error-user">Current Address is required.</div>');
            error = true;
        } 
        if($("#currentpincode").val() == '') {
            $("#currentpincode").after('<div id="error-user">Pincode is required.</div>');
            error = true;
        }
        if($("#cocurrentpincode").val() == '') {
            $("#cocurrentpincode").after('<div id="error-user">Pincode is required.</div>');
            error = true;
        } 
        
        if($("#currentstate").val() == '') {
            $("#currentstate").after('<div id="error-user">State is required.</div>');
            error = true;
        }
        if($("#currentcity").val() == '') {
            $("#currentcity").after('<div id="error-user">City is required.</div>');
            error = true;
        } 
        if($("#permanentaddress1").val() == '') {
            $("#permanentaddress1").after('<div id="error-user">Permanent Address is required.</div>');
            error = true;
        } 
        if($("#permanentpincode").val() == '') {
            $("#permanentpincode").after('<div id="error-user">Pincode is required.</div>');
            error = true;
        } 
        if($("#copermanentpincode").val() == '') {
            $("#copermanentpincode").after('<div id="error-user">Pincode is required.</div>');
            error = true;
        }
        if($("#permanentstate").val() == '') {
            $("#permanentstate").after('<div id="error-user">State is required.</div>');
            error = true;
        } 
        if($("#permanentcity").val() == '') {
            $("#permanentcity").after('<div id="error-user">City is required.</div>');
            error = true;
        }
        
        if(($("#totworkexperianceY:visible").length>0 && $('#totworkexperianceY').val() == '') && ($("#totworkexperianceM:visible").length>0 && $('#totworkexperianceM').val() == '')) {
            $("#totworkexperianceY").after('<span id="error-user">Either Year or Month is required</span>');
            error = true;
        } else {
            $("#totworkexperianceY").parent().find('#error-user').remove();
        }
        
        //console.log(panErr, error, bdErr, cpErr, cpErr, caErr, paErr, lnErr, mnErr, fnErr, weErr);
        //if(error || bdErr || cpErr || ppErr || caErr || paErr || panErr || mnErr || lnErr || mnErr || fnErr){
        if(error || bdErr || cpErr || cpErr || caErr || paErr  || lnErr || mnErr || fnErr || weErr){
            $(window).scrollTop($("#error-user:visible").offset().top-50);
            return false;
        }
		
  });
/*
	$(document).ready(function(){
		$("#permanentaddress1").blur(function() 
		{
			var permanentaddress1 = $(this).val();
			var pattern = new RegExp(/<[^>]/);
				if(!pattern.test(permanentaddress1)) 
				{
				
					$(this).after('<div id="error-user">Invalid Address.</div>');
					error = true;
				}	
				else 
				{
					error = false;
				}
		
		});	
	});*/
    
	</script>
