<?php require_once("includes/functions.php"); ?>
<?php session_start(); ?>
<?php
	if(!empty($_GET)) {
		$utm_content 	= $_GET['utm_content'];
		$utm_campaign = $_GET['utm_campaign'];
		$utm_term 		= $_GET['utm_term'];
		$utm_source 	= $_GET['utm_source'];
		$utm_medium 	= $_GET['utm_medium'];
	}	else {
		$utm_content 	= 'iifl';
		$utm_campaign = 'pl';
		$utm_term 		= '3';
		$utm_source 	= 'google';
		$utm_medium 	= 'web';
	}

	
	/* ----------------------------- Get City List   ---------------------------------------*/
	$output = '';
	$service_url = 'http://ttavatar.iifl.in/PLcommonAPI/CommonAPI.svc/SearchFetchDropDown';
	//echo $service_url;
	$headers = array (
		"Content-Type: application/json"
	);
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
	if($curl_response) {
		//echo '<pre>'; print_r($curl_response); echo '</pre>'; exit;
		foreach($curl_response->Body->MasterValues as $data) {
			$id = $data->dropdownid;
			$value = $data->dropdownvalue;
			$output .= '<div class="homecityradio"><input type="radio" name="radio" value="'.$id.'" id="'.$id.'"><label for="'.$id.'">'.$value.'</label></div>';
		}
	}
	/* ----------------------------- City List ends ---------------------------------------*/
	
	$nameErr = $mobileErr = $salaryErr = $emailErr = $mobileErr = $cityErr = $obErr = '';
	$error = false;
	
	if(isset($_POST['Submit'])) {
		$page_no			= xss_filter($_POST['webpageno']);
	
		if($_POST['companyname'] == '') {
			$nameErr = "Company Name is required";
			$_SESSION['errors'][] = 'Company Name';
			$error = true;
		} else {
			if(!valid_company_name($_POST['companyname'])) {
				$nameErr = "Invalid Company Name";
				$_SESSION['errors'][] = 'Company Name';
				$error = true;
			} else {
				$company_name = $_SESSION['personal_details']['companyname'] 	= xss_filter(trim($_POST['companyname']));
			}
		}
		if(empty($_POST['emailid'])) {
			$emailErr = "Email is required";
			$_SESSION['errors'][] = 'Email';
			$error = true;
		} else {
			if(!valid_mail($_POST['emailid'])) {
				$emailErr = "Invalid email id.";
				$_SESSION['errors'][] = 'Email';
				$error = true;
			} else {
				$email_id = $_SESSION['personal_details']['emailid'] = xss_filter(trim($_POST['emailid']));
			}
		}
		
		if(empty($_POST['salary'])) {
			$salaryErr = "Salary is required";
			$_SESSION['errors'][] = 'Salary';
			$error = true;
		} else {
			if(!is_numeric(num_only($_POST['salary']))) {
				$salaryErr = "Invalid salary.";
				$_SESSION['errors'][] = 'Salary';
				$error = true;
			}	else {
				$salary	= $_SESSION['personal_details']['salary']	=	xss_filter(num_only($_POST['salary']));
			}
		}
		
		if(empty($_POST['mobileno'])) {
			$mobileErr = "Mobile number is required";
			$_SESSION['errors'][] = 'Mobile number';
			$error = true;
		} else {
			if(!valid_mobile($_POST['mobileno'])) {
				$mobileErr = "Invalid mobile number";
				$_SESSION['errors'][] = 'Mobile number';
				$error = true;
			} else {
				$mobile_no = $_SESSION['personal_details']['mobileno'] = xss_filter(num_only($_POST['mobileno']));
			}
		}
		
		if($_POST['obligation'] != '') {
			if(!is_numeric(num_only($_POST['obligation']))) {
				$obErr = "Invalid characters present";
				$_SESSION['errors'][] = 'Obligation';
				$error = true;
			} else {
				$obligation	= $_SESSION['personal_details']['obligation']		=	xss_filter(num_only($_POST['obligation']));
			}
		}
		
		if(empty($_POST['radio'])) {
			$cityErr = "City is required";
			$_SESSION['errors'][] = 'City';
			$error = true;
		} else {
			if(!preg_match("/^[A-Z]{3}$/", $_POST['radio'])) {
				$cityErr = "Invalid City";
				$_SESSION['errors'][] = 'City';
				$error = true;
			}	else {
				$city	= $_SESSION['personal_details']['city'] = xss_filter(trim($_POST['radio']));
			}
		}

		if(!$error) {
			$service_url = API. 'CRMLeadCreate';
			$headers = array (
				"Content-Type: application/json"
			);
			$curl_post_data = array(
				"CompanyName"				=> $company_name,
				"OtherCompanyName"	=> "",
				"MonthlySalary"			=> $salary,
				"MonthlyObligation"	=> $obligation,
				"PersonalEmailID"		=> $email_id,
				"MobileNo"					=> $mobile_no,
				"City"							=> $city,
				"Source"						=> 'indigo',
				"ChannelName"				=> $utm_content,
				"PartnerName"				=> $utm_term,
				"CampaignName"			=> $utm_campaign,
				"UTMSource"					=> $utm_source,
				"UTMMedium"					=> $utm_medium,
				"PageNumber"				=> 1
			);
			
			$decodeddata = json_encode($curl_post_data);
			$_SESSION['request'] = $curl_post_data;
			echo '<pre>'; print_r($decodeddata); echo '</pre>'; 
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
			$json2 = array();
			$json2 = json_decode($json, true);
			$_SESSION['response'] = $curl_response;
			//echo '<pre>'; print_r($json); echo '</pre>'; 
			if(strtolower($json2[0]['Status']) == 'success') {
				$_SESSION['personal_details']['CRMLeadID'] = xss_filter($json2[0]['CRMLeadID']);
				$service_url = API. 'EmiCalc';
				$headers = array (
					"Content-Type: application/json"
				);
				$curl_post_data = array(
					"CRMLeadID"		=> xss_filter($json2[0]['CRMLeadID']),
					"PageNumber"	=> $page_no
				);
		
				$decodeddata = json_encode($curl_post_data);
				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, $service_url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POSTFIELDS, $decodeddata);
			
				$curl_resp = curl_exec($ch);
				curl_close($ch);
				$data = json_decode($curl_resp);
				$data = json_decode($data);
				//echo '<pre>'; print_r($data) ;echo'</pre>';exit;
				if(strtolower($data[0]->Status) == 'success') {
					$minimum_amt 						= xss_filter(ceil($data[0]->MinimumAmout));
					$maximum_amt 						= xss_filter(ceil($data[0]->MaxAmount));
					$max_tenure 						= xss_filter($data[0]->MaxTenure);
					$ROI_default 						= xss_filter($data[0]->ROIDefault);
					$ROI_actual 						= xss_filter($data[0]->ROIActual);
					$processing_fee_default = xss_filter($data[0]->ProcessingFeeDefault);
					$processing_fee_actual 	= xss_filter($data[0]->ProcessingFeeActual);
					
					$net_income = $salary - $obligation;
	
					$interest = $ROI_actual / 1200;
					$maximumloanamtemi = ceil($interest * -$maximum_amt * pow((1 + $interest), $max_tenure) / (1 - pow((1 + $interest), $max_tenure)));
					
					$interest_default = $ROI_default / 1200;
					$emi_default = ceil($interest_default * -$maximum_amt * pow((1 + $interest_default), $max_tenure) / (1 - pow((1 + $interest_default), $max_tenure)));
			
					$emi_difference = $emi_default -  $maximumloanamtemi;
			
					$actualloanEMI = $maximumloanamtemi;	
					if($minimum_amt < 100000){
						// Not eligible for loan
						redirect_to("declined");
					}
			
					$processing_fee = $processing_fee_actual;
					
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
					redirect_to("calculate-loan");
				} else {
					// redirect to failure page
					redirect_to('declined');
				}
			} else {
				// redirect to failure page
				redirect_to('resetpage');
			//	$msg = 'CRMLeadID could not be generated.';
			}
		}	else {
			// on error
			redirect_to('error');
		}
	} else {
		session_destroy();
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
		<title>IIFL : Sapna Aapka, Loan Hamara</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
		<link rel="shortcut icon" href="images/favicon.ico">
		<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<!--<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>-->
		<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script> 
		<script src="js/function.js" type="text/javascript"></script> 
    <script src="js/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>
		<script>
			$(window).on("load",function(){
				setTimeout(function () {	
					$(".ui-autocomplete").mCustomScrollbar({
						setHeight:200,
						autoHideScrollbar:true,
						autoExpandScrollbar:true
					});
				},1000);		
							
				$.ui.autocomplete.filter = function (array, term) {
					var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(term), "i");
					return $.grep(array, function (value) {
						return matcher.test(value.label || value.value || value);
					});
				};
			});
			$(function() {
				
				$( "#SliderPoint").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"salary",30000,1000000,'');
					}
				});
				clickbar("SliderPoint","salary",30000,1000000,"");
				
			});
			
			function calbackEmi()	{
				// use only emi page..but dont delete..
			}

			function emislid() {
				$("#mxemi").html(adcoma(str2int($("#salary").val())));
				$( "#SliderPoint2").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"emis",0,str2int($("#salary").val()),'');
					}
				});
				clickbar("SliderPoint2","emis",0,str2int($("#salary").val()),"");
			}
		</script>
		<script>
	
			$(function(){
				$('.mobie-errormsg').hide();
				$('.email-errormsg').hide();
				$('.city-errormsg').hide();
	
				var error_mobile = false;
				var error_email = false;
	
				$('#mobilefield').focusout(function() { chkmobile(); });
				$('#emailfield').focusout(function() { chkemail(); });
	
				function chkmobile(){
					var pattern = new RegExp(/^[7-9][0-9]{9}$/);
					if(pattern.test($('#mobilefield').val())){
						$('.mobie-errormsg').hide();
					}else{
						$('.mobie-errormsg').html('Please enter valid mobile number');
						$('.mobie-errormsg').show();
						error_mobile = true;
					}
				};
	
				function chkemail(){
					var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
					if(pattern.test($('#emailfield').val())){
						$('.email-errormsg').hide();
					}	else	{
						$('.email-errormsg').html('Please enter valid email id');
						$('.email-errormsg').show();
						error_email = true;
					}
				};
	
				$('#form1').submit(function(){
					error_mobile = false;
					error_email = false;
					chkmobile();
					chkemail();
					var ct=0;
		
					$("#citybox input").each(function() {
						var name = $(this).attr("name");
						if($("input:radio[name="+name+"]:checked").length == 0) {
							ct=1;
						}
					});	
		
					if(ct==1) {
						$('.city-errormsg').show();
					} else {
						$('.city-errormsg').hide();
					}
		
					if(error_mobile == false && error_email == false && ct==0){
						return true;
					}	else	{
						return false;	
					}
				});
			});
		</script>
	</head>
	<body class="bodyoverflow home" style="font-family:'MyriadPro-Semibold';">
		<div id="main-wrap">
			<header>
  <div class="header-inner">
					<div class="logo"><img src="images/logo.jpg" class="scale"></div>
					<div class="personal-loan"><img src="images/personal.png" class="scale"></div>
					<div class="clr"></div>
    <div class="card-container-outerhome">
						<div class="pendulamline-home"><img src="images/pendulamline.png" class="scale"></div>
						<div class="card-container1 effect__random" data-id="1">
							<div class="card__front">
								<img src="images/48hours.png" class="scale">
								<div class="express-home">Express<br>Personal<br>Loan</div>
							</div>
							<div class="card__back">
								<img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>
							</div>
						</div>
    </div>
				</div>
			</header>
			<form id="form1" name="form1" method="post" action="" autocomplete="off">
  <div id="msform">
    <section class="body-home-outer myclass">
      <div class="innerbody-home">
  <div class="hometop-container">
  <p class="title-heading">Answer 3 simple questions to get your Personal Loan EMI quote</p>
    <h1>Where do you work?</h1>
    <div class="companyname2">
									<label class="inputhome">
										<span>Type your company name</span>
										<input type="text" id="textfield" class="companylist" name="companyname" maxlength="50" />
          
									</label>
      
      <div id="error-user">&nbsp;</div>
      <!--<div class="error-tooltip">Seems entered company name is not in the list, recheck the list and select</div>-->
    </div>
    <div class="next-home">
									<a href="javascript:;" class="next1" onClick="ga('send', 'event', 'Personal Loan', 'Next-Click', 'Company');">NEXT<img src="images/arrownext.png" class="scale nxtarrow"></a>
								</div>
  </div>
							<div class="screen01img">
								<img src="images/homescreen-01img.png" class="scale">
								<div class="screen1c move-left1"><img src="images/screen1c.png" class="scale"></div>
								<div class="screen1c movetop"><img src="images/screen1b.png" class="scale"></div>
							</div>
      </div>
					</section>
					<section class="body-home-outer myclass screen02bg">
						<div class="innerbody-home">
							<div class="hometop-container">
								<h1>What is your net monthly salary?</h1>
								<div class="companyname">
									<b class="rupeeicon">`</b>
									<input type="text" name="salary" class="salaryinput" id="salary" value="30,000" maxlength="8"  onkeypress="return isNumberKey(event)" onChange="setPoint('salary','SliderPoint',30000,1000000,'');"/>      
								</div>
								<div class="salary-slider">
									<div class="slidericon" id="SliderPoint"><img src="images/slider-icon.png" class="scale"></div>
									<div class="leftvalue">30,000</div><div class="rightvalue">10,00,000</div>
								</div>
								<div class="next-home next-scr2">
									<a href="javascript:;" class="next" onClick="ga('send', 'event', 'Personal Loan', 'Next-Click', 'Salary');">NEXT <img src="images/arrownext.png" class="scale nxtarrow"></a>
								</div>
							</div>
							<div class="screen02img">
								<img src="images/homescreen-02img.png" class="scale">
								<div class="screen1c move-left1"><img src="images/screen2c.png" class="scale"></div>
							</div>
						</div>
					</section>
					<section class="body-home-outer myclass screen03bg">
						<div class="innerbody-home">
							<div class="hometop-container">
								<h1>What are your total existing EMIs, if any? </h1>
								<div class="companyname">
									<span class="rupeeicon">`</span>
									<input type="text" name="obligation" class="salaryinput" id="emis" value="0" maxlength="8"  onkeypress="return isNumberKey(event)" onChange="setPoint('emis','SliderPoint2',0,str2int($('#salary').val()),'');" />      
								</div>
								<div class="salary-slider">
									<div class="slidericon" id="SliderPoint2"><img src="images/slider-icon.png" class="scale"></div>
									<div class="leftvalue">0</div><div class="rightvalue" id="mxemi">10,000,00</div>
								</div>
								<div class="next-home next-scr2">
									<a href="javascript:;" class="next" onClick="ga('send', 'event', 'Personal Loan', 'Next-Click', 'Current-EMI');">NEXT <img src="images/arrownext.png" class="scale nxtarrow"></a>
								</div>
							</div>
							<div class="screen03img">
								<img src="images/homescreen-03img.png" class="scale">
								<div class="screen1c move-left1"><img src="images/screen3c.png" class="scale"></div>
							</div>
						</div>
					</section>
					<section class="body-home-outer myclass screen04bg">
						<div class="innerbody-home">
							<div class="hometop-container">
								<h1>Almost done!<span>Enter your contact information to receive a copy of your loan eligibility.</span></h1>
								<div class="companyname sceeen4form">
									<label class="inputhome"><span>Mobile Number</span>
										<input type="text" name="mobileno" onkeypress="return isNumberKey(event)" maxlength="10" id="mobilefield" />
									</label>
									<div class="mobie-errormsg">&nbsp;</div>
								</div>
								<div class="companyname sceeen4form">
									<label class="inputhome">
										<span>Email ID</span>
										<input type="text" id="emailfield" name="emailid" maxlength="50" />
									</label>
									<div class="email-errormsg">&nbsp;</div>
								</div>  
								<div class="companyname selectcity-homebox">
									<div class="selectcity-home">Select City</div>
									<div class="city-errormsg">Please select City</div>
									<div class="selecthome-radiobox" id="citybox">
										<?php echo $output; ?> 
										<div class="clr"></div>
									</div>
								</div> 
									  
									<input type="hidden" name="webpageno" id="webpageno" value="1"/>
									<div class="next-home next-scr2">
										<input type="submit" name="Submit" id="button" value="CRUNCH NUMBERS" class="homesubmit" onClick="ga('send', 'event', 'Personal Loan', 'Crunch-Numbers-Click', 'Lead');"/>
									</div>
									<div class="formterms">I authorize IIFL & its representatives to contact me including email, call or SMS.</div> 
							</div>
							<div class="screen04img">
								<img src="images/homescreen-04img.png" class="scale">
								<div class="screen1c move-left1"><img src="images/screen4c.png" class="scale"></div>
								<div class="screen1c movetop"><img src="images/screen4b.png" class="scale"></div>
							</div>
						</div>
					</section>
  </div>
    </form>
<script src="js/cards.js" type="text/javascript"></script> 
<?php require_once("includes/footer.php"); ?>