<?php session_start(); ?>
<?php require_once('functions.php'); ?>
<?php
	session_destroy(); 
  $options = '';
  $service_url = 'http://ttavatar.iifl.in/PLcommonAPI/CommonAPI.svc/SearchFetchDropDown';
	$headers = array ("Content-Type: application/json");
	$curl_post_data = array("CategoryName"	=> "CityMaster");
	$decodeddata = json_encode($curl_post_data);
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $service_url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $decodeddata);
	$curl_response = json_decode(curl_exec($ch));
	curl_close($ch);
  $city_obj = $curl_response;
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
		<script type="text/javascript">
			var c=document.cookie;
			document.cookie='size='+Math.max(screen.width,screen.height)+';';
		</script>
  </head>
  <body style="font-family:'MyriadPro-Semibold';">
		<div class="overlays"></div>
		<div class="loader">
			<img src="images/loader.gif">
			<div class="loadtext">Processing...</div>
		</div>
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
      <div class="innerbody-home-affiliate" id="innBody"> 
        <!-- AADHAR BLOCK STARTS HERE -->
        <!--<div class="aadharblock">
          <div class="aadhar-heading aadhar-heading-font text-center">Auto-fill your application using your Aadhaar number<sup><span class="red1">*</span></sup>. <br>
          </div>
          <div class="inputbox centerinputbox">
            <label class="input">
            <span>Aadhar number</span>
            <input type="text" data-name="adhar" name="aadharslot" id="aadharslot" maxlength="12" onkeypress="return isNumberKey(event)" value="" />
            <div class="error-user">aadhar number</div>
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
            <div class="error-user">otp</div>
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
            <div class="error-user">First name is required</div>
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
            <div class="error-user">Last name is required</div>
            </label>
          </div>
          <div class="clear"></div>
					

          <div class="inputbox">
            <label class="input">
            <span>PAN Card Number*</span>
            <input type="text" data-name="pannumber" name="panslot1" id="panslot1" class="pannumber" maxlength="10" value=""/>
            <div class="error-user">Pan card is required</div>
            </label>
          </div>
          <div class="inputbox dob">
            <input name="slotdob" data-name="dates" id="datepicker" type="text" class="inputdob" value="Date of Birth*" readonly>
            <div class="error-user">Date of birth is required</div>
            <div class="clear"></div>
            <span class=note>(Minimum age 25 years old)</span>
					</div>
					
					<div class="inputbox marginright0">
            <label class="input">
							<!-- <select id="">
                              <option value=""></option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                            </select> -->

              <div class="selectContainer">
                <div class="innerContainer">
                  <div class="selectText">Select Gender*</div>
                  <select id="gender" class="gender">
										<option value="Select Gender">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>

							<div class="error-user">Gender is required</div>
            </label>
          </div>
          <h2 class="aadhar-heading clear margintop30 fl">Where can we reach you?</h2>
          <div class="clear"></div>
          <div class="inputbox">
            <label class="input">
            <span>Mobile number 1*</span>
            <input data-name="mobnumber" type="text" name="slotmob1" id="slotmob1" maxlength="10" minlength="10" value="" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Mobile number is required</div>
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
            <input type="text" data-name="emailing" maxlength="100" name="slotemail" id="slotemail" value="" />
            <div class="error-user">Email id is required</div>
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
            <input type="text" data-name="" maxlength="500" name="slotpadd1" id="slotpadd1" value="" />
            <div class="error-user">Permanent address is required</div>
            </label>
          </div>
          <div class="inputbox width100">
            <label class="input"><span>Permanent address 2</span>
              <input type="text" name="slotpadd2" maxlength="500" id="slotpadd2" value="" />
            </label>
          </div>
          <div class="inputbox width100">
            <label class="input"><span>Permanent address 3</span>
              <input type="text" name="slotpadd3" maxlength="500" id="slotpadd3" value="" />
            </label>
          </div>
          <div class="clear"></div>
          <div class="inputbox">
            <label class="input">
            <span>Pin code*</span>
            <input type="text" data-name="pinnumber" name="slotpin" id="slotpin" maxlength="6" value="" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Pin code is required</div>
            </label>
          </div>
          <!--<div class="inputbox">
            <label class="input">
            <span>City*</span>
            <input type="text" data-name="alpha" name="slotcity" id="slotcity" value="" />
            <div class="error-user">city</div>
            </label>
          </div>
          <div class="inputbox marginright0 phonelandscapeclear">
            <label class="input">
            <span>State*</span>
            <input type="text" data-name="alpha" name="slotstate" id="slotstate" value="" />
            <div class="error-user">state</div>
            </label>
          </div>-->
          <div class="clear"></div>
          <div class="edBottomTerms2 marginadjust martopt30 fl leftsidetext" style="text-align:center">
            <div class="edBottomCheckbox2">
              <input type="checkbox" value="1" id="addrCh" name="checkbox"/>
              <label for="addrCh">Current address is same as permanent address</label>
            </div>
          </div>
          <div class="clear"></div>
          <div class="inputbox width100 currAddr">
            <label class="input">
            <span>Current address 1*</span>
            <input type="text" data-name="" maxlength="500" name="slotcadd1" id="slotcadd1" value="" />
            <div class="error-user">Current address is required</div>
            </label>
          </div>
          <div class="inputbox width100 currAddr">
            <label class="input"><span>Current address 2</span>
              <input type="text" name="slotcadd2" maxlength="500" id="slotcadd2" value="" />
            </label>
          </div>
          <div class="inputbox width100 currAddr">
            <label class="input"><span>Current address 3</span>
              <input type="text" name="slotcadd3" maxlength="500" id="slotcadd3" value="" />
            </label>
          </div>
          <div class="clear"></div>
          <div class="inputbox currAddr">
            <label class="input">
            <span>Pin code*</span>
            <input type="text" data-name="pinnumber" name="slotpin2" id="slotpin2" maxlength="6" value="" onkeypress="return isNumberKey(event)" />
            <div class="error-user">Pin code is required</div>
            </label>
          </div>
          <!--<div class="inputbox">
            <label class="input">
            <span>City*</span>
            <input type="text" data-name="alpha" name="slotcity2" id="slotcity2" value="" />
            <div class="error-user">city</div>
            </label>
          </div>
          <div class="inputbox marginright0 phonelandscapeclear">
            <label class="input">
            <span>State*</span>
            <input type="text" data-name="alpha" name="slotstate2" id="slotstate2" value="" />
            <div class="error-user">state</div>
            </label>
          </div>-->
          <div class="clear"></div>
        </div>
        <!-- DATA BLOCK 2 ENDS HERE --> 
        <!-- DATA BLOCK 3 STARTS HERE -->

					<div class="data_block3 dtVersion">
						<h2 class="aadhar-heading clear fl">Just a few more questions about your</h2>
						<div class="clear"></div>
						<div class="inputbox">
							<label class="input">
							<span>Company Name*</span>
							<input type="text" class="companylist" data-name="" maxlength="150" name="slotcompname" id="slotcompname" value="" />
							<div class="error-user">Company name is required</div>
							</label>
						</div>
						<div class="inputbox marginright">
							<label class="input">
							<span>Monthly salary*</span>
							<input type="text" data-name="onlynum" name="slotmonthsal" id="slotmonthsal" maxlength="7" value="" onkeypress="return isNumberKey(event)" />
							<div class="error-user">Monthly salary is required</div>
							</label>
						</div>
						<div class="inputbox marginright0 phonelandscapeclear">
							<label class="input">
							<span>Current experience (in months)*</span>
							<input type="text" data-name="onlynum" name="cworkexpslot" id="cworkexpslot" value="" maxlength="3" onkeypress="return isNumberKey(event)" />
							<div class="error-user">Current work experience is required</div>
							</label>
						</div>
						<div class="dynamicworkyears  fl width100">
							<div class="inputbox marginright margin-right">
								<label class="input">
								<span>Total experience (in months)*</span>
								<input type="text" data-name="onlynum" name="slotyear" id="slotExp" maxlength="3" value="" onkeypress="return isNumberKey(event)" />
								<div class="error-user">Total work experience is required</div>
								</label>
							</div>
							<div class="inputbox marginright">
								<label class="input">
								<span>Monthly Obligations (if any)</span>
								<input type="text" data-name="onlynum" name="slotmonth2" maxlength="7" id="slotOblig" value="" onkeypress="return isNumberKey(event)" />
								</label>
							</div>
							<div class="inputbox marginright0">
								<label class="input">
								<!-- <select id=loanCity>
									<option value="">Select City*</option>
									<?php //echo $options; ?>
								</select> -->
	
								<div class="selectContainer">
									<div class="innerContainer">
										<div class="selectText">Select City*</div>
										<select id="loanCity" class="cityselect">
											<option val="Select City">Select City</option>
											<?php echo $options; ?>
										</select>
									</div>
								</div>
	
								<div class="error-user">City is required</div>
								</label>
							</div>
						</div>
					</div>
					
					<div class="data_block3 mobVersion">
						<h2 class="aadhar-heading clear fl">Just a few more questions about your</h2>
						<div class="clear"></div>
						<div class="dynamicworkyears  fl width100">
              <div class="inputbox">
  							<label class="input">
  							<span>Company Name*</span>
  							<input type="text" class="companylist" data-name="" maxlength="150" name="slotcompname" id="slotcompname" value="" />
  							<div class="error-user">Company name is required</div>
  							</label>
  						</div>
  						<div class="inputbox marginright0">
  							<label class="input">
  							<span>Monthly salary*</span>
  							<input type="text" data-name="onlynum" name="slotmonthsal" id="slotmonthsal" maxlength="7" value="" onkeypress="return isNumberKey(event)" />
  							<div class="error-user">Monthly salary is required</div>
  							</label>
  						</div>
            </div>
						<div class="dynamicworkyears  fl width100">
              <div class="inputbox phonelandscapeclear">
  							<label class="input">
  							<span>Current experience (in months)*</span>
  							<input type="text" data-name="onlynum" name="cworkexpslot" id="cworkexpslot" value="" maxlength="3" onkeypress="return isNumberKey(event)" />
  							<div class="error-user">Current work experience is required</div>
  							</label>
  						</div>
						
							<div class="inputbox marginright0">
								<label class="input">
								<span>Total experience (in months)*</span>
								<input type="text" data-name="onlynum" name="slotyear" id="slotExp" maxlength="3" value="" onkeypress="return isNumberKey(event)" />
								<div class="error-user">Total work experience is required</div>
								</label>
							</div>
            </div>
            <div class="dynamicworkyears  fl width100">
							<div class="inputbox">
								<label class="input">
								<span>Monthly Obligations (if any)</span>
								<input type="text" data-name="onlynum" name="slotmonth2" maxlength="7" id="slotOblig" value="" onkeypress="return isNumberKey(event)" />
								</label>
							</div>
							<div class="inputbox marginright0">
								<label class="input">
								<!-- <select id=loanCity>
									<option value="">Select City*</option>
									<?php //echo $options; ?>
								</select> -->
	
								<div class="selectContainer">
									<div class="innerContainer">
										<div class="selectText">Select City*</div>
										<select id="loanCity" class="cityselect">
											<option val="Select City">Select City</option>
											<?php echo $options; ?>
										</select>
									</div>
								</div>
	
								<div class="error-user">City is required</div>
								</label>
							</div>
						</div>
					</div>

        <!-- DATA BLOCK 3 ENDS HERE -->
        <div class="fl width100 submitBtn">
          <div class="next-home">
            <a href="javascript:;" id="subaffildetail" class="homesubmit">Submit</a>
          </div>
        </div>

        <div class="approval-right-container otpVerify">
          <div class="aadhar-wrap">
            <div class="aadhar-heading aadhar-heading-font">Mobile Number Verification<sup><span class="red1">*</span></sup>. <br>
              </div>
            <div class="companyname sceeen4form manual">
              <label class="input inputbox"> <span style="">Enter OTP</span>
                <input type="text" id="manualOTP" value="" name="manualOTP" onkeypress="return isNumberKey(event)" maxlength="6">
              </label>
            <div class="aadharbtn">
              <a href="javascript:;" id="verifyManMobNo" class="ios-btn">Verify OTP</a>
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