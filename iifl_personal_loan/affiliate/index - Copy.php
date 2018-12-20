<?php require_once('functions.php'); ?>
<?php
  $options = '';
  $curl_post_data = array("CategoryName"	=> "CityMaster");
  $city_obj = json_decode(call_api('common', 'SearchFetchDropDown', $curl_post_data));
  if($city_obj) {
    foreach($city_obj->Body->MasterValues as $city) {
      $name = ucwords(strtolower($city->dropdownvalue));
      $code = $city->dropdownid;
      $options .= '<option value="'.$code.'">'.$name.'</option>';
    }
  }
  
  //echo $options;
  



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
    <title>IIFL</title>
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/media.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
  </head>
  <body style="font-family:'MyriadPro-Semibold';">
  <div id="main-wrap">
    <header>
      <div class="header-inner">
        <div class="logo"><img src="images/logo.jpg" class="scale"></div>
        <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
        <div class="clr"></div>
        <div class="continue-journey-link"><a href="continue-your-journey.php">Resume your previously saved form</a></div>
        <div class="card-container-outerinner">
          <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
          <div class="card-container1 effect__random card-container" data-id="1">
            <div class="card__front"> <img src="images/48hours.png" class="scale">
              <p class="pendulamtxt">Express<br>Personal<br>Loan</p>
            </div>
            <div class="card__back"><img src="images/48hours.png" class="scale">
              <p class="pendulamtxt">DISBURSAL<br>IN<br>8 HOURS* <br/><small> T&C Apply</small></p>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="clear"></div>
    <section class="body-home-outer myclass">
      <div class="innerbody-home-affiliate"> 
        <!-- AADHAR BLOCK STARTS HERE -->
        <!--<div class="aadharblock">
          <div class="aadhar-heading aadhar-heading-font text-center">Auto-fill your application using your Aadhaar number<sup><span class="red1">*</span></sup>. <br>
          </div>
          <div class="inputbox centerinputbox">
            <label class="input">
            <span>Aadhar number</span>
            <input type="text" data-name="adhar" name="aadharslot" id="aadharslot" maxlength="12" onkeypress="return isNumberKey(event)" value="" />
            <div class="error-user">Please enter aadhar number</div>
            </label>
          </div>
          <div class="clear"></div>
          <div class="aadharbtn centerinputbox martopt30">
            <input type="button" id="aadharNoslot" value="Get OTP" class="aadharsubmit" name="aadharNoslot" disabled="disable" >
          </div>
          <div class="clear"></div>
          <div class="enterotpsection fl width100">
          <div class="inputbox centerinputbox">
            <label class="input">
            <span>Enter OTP</span>
            <input type="text" data-name="onlynum" name="enteroptslot" maxlength="7" id="enteroptslot" onkeypress="return isNumberKey(event)" value="" />
            <div class="error-user">Please enter otp</div>
            </label>
          </div>
          <div class="clear"></div>
          <div class="aadharbtn centerinputbox martopt30">
            <input type="button" id="confirmslot" value="CONFIRM" class="aadharsubmit verifyOTP" />
            <a href="javascript:;" class="text-link resendOtp"> Resend OTP</a>
          </div>
          </div>
          <div class="aadhar-tcbox authentication-line authentication-linerev centerinputbox fl width100">
            <div class="edBottomTerms2 dnone">
              <div class="edBottomCheckbox2">
                <input type="checkbox" id="termschk" name=""/>
                <label for="termschk"></label>
              </div>
              <p><a href="javascript:;" class="tnc-btn"> I hereby give my consent to IIFL to do EKYC through Aadhaar authentication</a></p>
              <div class="clr"></div>
            </div>
          </div>
          <div class="dontremember fl width100">Proceed without Aadhaar number.</div>
          <div class="aadharbtn centerinputbox marbott30">
            <input type="button" id="noAadharSbmit1" value="CLICK HERE" class="aadharsubmit" name="noAadharSbmit1"/>
          </div>
        </div>
        <div class="clear"></div>-->
        <!-- AADHAR BLOCK ENDS HERE --> 
        <!-- DATA BLOCK 1 STARTS HERE -->
        <div class="data_block1">
          <h2 class="aadhar-heading">Tell us a bit about yourself</h2>
          <div class="inputbox">
            <label class="input">
            <span>First Name*</span>
            <input data-name="alpha" type="text" name="nameslot1" id="nameslot1" maxlength="20" value="" />
            <div class="error-user">Please enter first name</div>
            </label>
          </div>
          <div class="inputbox">
            <label class="input"> <span>Middle Name</span>
              <input type="text" name="nameslot2" id="nameslot2" maxlength="20" value="" />
            </label>
          </div>
          <div class="inputbox marginright0 phonelandscapeclear">
            <label class="input">
            <span>Last Name*</span>
            <input data-name="alpha" type="text" name="nameslot3" id="nameslot3" maxlength="20" value="" />
            <div class="error-user">Please enter last name</div>
            </label>
          </div>
          <div class="clear"></div>
          <div class="inputbox">
            <label class="input">
            <span>PAN Card Number*</span>
            <input type="text" data-name="pannumber" name="panslot1" id="panslot1" class="pannumber" maxlength="10" value=""/>
            <div class="error-user">Please enter pan card number</div>
            </label>
          </div>
          <div class="inputbox dob">
            <input name="slotdob" data-name="dates" id="datepicker" type="text" class="inputdob" value="Date of birth" >
            <div class="error-user">Please enter date of birth</div>
            <div class="clear"></div>
            <span class=note>(Minimum age 25 years old)</span> </div>
          <h2 class="aadhar-heading clear margintop30 fl">Where can we reach you?</h2>
          <div class="clear"></div>
          <div class="inputbox">
            <label class="input">
            <span>Mobile number 1*</span>
            <input data-name="mobnumber" type="text" name="slotmob1" id="slotmob1" maxlength="10" minlength="10" value="" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Please enter mobile number</div>
            </label>
          </div>
          <div class="inputbox">
            <label class="input"> <span>Mobile number 2</span>
              <input type="text" name="slotmob2" id="slotmob2" maxlength="10" value="" onkeypress="return isNumberKey(event)" />
            </label>
          </div>
          <div class="inputbox marginright0 phonelandscapeclear">
            <label class="input">
            <span>Email id*</span>
            <input type="text" data-name="emailing" name="slotemail" id="slotemail" value="" />
            <div class="error-user">Please enter email id</div>
            </label>
          </div>
          <div class="clear"></div>
        </div>
        <!-- DATA BLOCK 1 ENDS HERE --> 
        <!-- DATA BLOCK 2 STARTS HERE -->
        <div class="data_block2">
          <h2 class="aadhar-heading clear margintop30 fl">Where do you stay?</h2>
          <div class="clear"></div>
          <div class="inputbox width100">
            <label class="input">
            <span>Permanent address 1*</span>
            <input type="text" data-name="alphanumeric" name="slotpadd1" id="slotpadd1" value="" />
            <div class="error-user">Please enter permanent address</div>
            </label>
          </div>
          <div class="inputbox width100">
            <label class="input"><span>Permanent address 2</span>
              <input type="text" name="slotpadd2" id="slotpadd2" value="" />
            </label>
          </div>
          <div class="inputbox width100">
            <label class="input"><span>Permanent address 3</span>
              <input type="text" name="slotpadd3" id="slotpadd3" value="" />
            </label>
          </div>
          <div class="clear"></div>
          <div class="inputbox">
            <label class="input">
            <span>Pin code*</span>
            <input type="text" data-name="pinnumber" name="slotpin" id="slotpin" maxlength="7" value="" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Please enter pin code</div>
            </label>
          </div>
          <div class="inputbox">
            <label class="input">
            <span>City*</span>
            <input type="text" data-name="alpha" name="slotcity" id="slotcity" value="" />
            <div class="error-user">Please enter city</div>
            </label>
          </div>
          <div class="inputbox marginright0 phonelandscapeclear">
            <label class="input">
            <span>State*</span>
            <input type="text" data-name="alpha" name="slotstate" id="slotstate" value="" />
            <div class="error-user">Please enter state</div>
            </label>
          </div>
          <div class="clear"></div>
          <div class="edBottomTerms2 marginadjust martopt30 fl leftsidetext" style="text-align:center">
            <div class="edBottomCheckbox2">
              <input type="checkbox" value="1" id="addrCh" name="checkbox" onChange="chkboxFn2(event)" />
              <label for="addrCh"></label>
            </div>
            <p>Current address is same as permanent address</p>
          </div>
          <div class="clear"></div>
          <div class="inputbox width100">
            <label class="input">
            <span>Current address 1*</span>
            <input type="text" data-name="alphanumeric" name="slotcadd1" id="slotcadd1" value="" />
            <div class="error-user">Please enter current address</div>
            </label>
          </div>
          <div class="inputbox width100">
            <label class="input"><span>Current address 2</span>
              <input type="text" name="slotcadd2" id="slotcadd2" value="" />
            </label>
          </div>
          <div class="inputbox width100">
            <label class="input"><span>Current address 3</span>
              <input type="text" name="slotcadd3" id="slotcadd3" value="" />
            </label>
          </div>
          <div class="clear"></div>
          <div class="inputbox">
            <label class="input">
            <span>Pin code*</span>
            <input type="text" data-name="pinnumber" name="slotpin2" id="slotpin2" maxlength="7" value="" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Please enter pin code</div>
            </label>
          </div>
          <div class="inputbox">
            <label class="input">
            <span>City*</span>
            <input type="text" data-name="alpha" name="slotcity2" id="slotcity2" value="" />
            <div class="error-user">Please enter city</div>
            </label>
          </div>
          <div class="inputbox marginright0 phonelandscapeclear">
            <label class="input">
            <span>State*</span>
            <input type="text" data-name="alpha" name="slotstate2" id="slotstate2" value="" />
            <div class="error-user">Please enter state</div>
            </label>
          </div>
          <div class="clear"></div>
        </div>
        <!-- DATA BLOCK 2 ENDS HERE --> 
        <!-- DATA BLOCK 3 STARTS HERE -->
        <div class="data_block3">
          <h2 class="aadhar-heading clear fl">Just a few more questions about your</h2>
          <div class="clear"></div>
          <div class="inputbox">
            <label class="input">
            <span>Company Name*</span>
            <input type="text" class="companylist" data-name="alphanumeric" name="slotcompname" id="slotcompname" value="" />
            <div class="error-user">Please enter company name</div>
            </label>
          </div>
          <div class="inputbox">
            <label class="input">
            <span>Monthly salary*</span>
            <input type="text" data-name="onlynum" name="slotmonthsal" id="slotmonthsal" maxlength="10" value="" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Please enter monthly salary</div>
            </label>
          </div>
          <div class="inputbox marginright0 phonelandscapeclear">
            <label class="input">
            <span>Current work experience (in months)*</span>
            <input type="text" data-name="onlynum" name="cworkexpslot" id="cworkexpslot" value="" maxlength="7" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Please enter current work experience</div>
            </label>
          </div>
          <div class="dynamicworkyears fl width100">
            <div class="inputbox">
              <label class="input">
              <span>Total work experience (in months)*</span>
              <input type="text" data-name="onlynum" name="slotyear" id="slotyear" maxlength="2" value="" onkeypress="return isNumberKey(event)" />
              <div class="error-user">Please enter number of years</div>
              </label>
            </div>
            <div class="inputbox">
              <label class="input">
              <span>Monthly Obligations (if any)</span>
              <input type="text" data-name="onlynum" name="slotmonth2" maxlength="6" id="slotmonth2" value="" onkeypress="return isNumberKey(event)" />
              <div class="error-user">Please enter number of month</div>
              </label>
            </div>
            <div class="inputbox marginright0">
              <label class="input">
              <!-- <span>Select a city</span> -->
              <!--<input type="text" data-name="onlynum" name="slotmonth2" maxlength="6" id="slotmonth2" value="" onkeypress="return isNumberKey(event)" />-->
              <select>
                <option value="">Select City</option>
                <?php echo $options; ?>
              </select>
              <div class="error-user">Please enter number of month</div>
              </label>
            </div>
          </div>
        </div>
        <!-- DATA BLOCK 3 ENDS HERE -->
        <div class="fl width100">
          <div class="next-home">
            <input type="submit" name="subaffildetail" id="subaffildetail" value="SUBMIT" class="homesubmit" />
          </div>
        </div>

        <div class="approval-right-container">
          <div class="aadhar-wrap">
            <div class="aadhar-heading aadhar-heading-font">Mobile Number Verification<sup><span class="red1">*</span></sup>. <br>
              </div>
            <div class="companyname sceeen4form manual">
              <label class="input"> <span style="">Enter OTP</span>
                <input type="text" id="manualOTP" value="" name="manualOTP" onkeypress="return isNumberKey(event)" maxlength="6">
                    <div class="dnone">110329</div>
              </label>
            <div class="aadharbtn">
              <input type="submit" name="submit" id="verifyManMobNo" value="Verify OTP" class="ios-btn">
            <a href="javascript:;" class="text-link resendManOtp"> Resend OTP</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script src="js/cards.js" type="text/javascript"></script>
  </body>
</html>