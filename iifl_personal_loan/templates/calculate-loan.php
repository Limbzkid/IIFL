<?php require_once("includes/functions.php"); ?>
<?php session_start(); ?>
<?php
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
	$error = false;
	if(valid_company_name($_SESSION['personal_details']['companyname'])) {
		$company = xss_filter($_SESSION['personal_details']['companyname']);
	} else {
		$error = true;
	}
	if(is_numeric($_SESSION['personal_details']['salary'])) {
		$salary = xss_filter($_SESSION['personal_details']['salary']);
	}	else {
		$error = true;
	}
	if(is_numeric($_SESSION['personal_details']['obligation'])) {
		$obligation	= xss_filter($_SESSION['personal_details']['obligation']);
	}	else {
		$error = true;
	}
	if(is_numeric($_SESSION['personal_details']['CRMLeadID'])) {
		$crm_lead_id	= xss_filter($_SESSION['personal_details']['CRMLeadID']);
	}	else {
		$error = true;
	}
	
	if(valid_mail($_SESSION['personal_details']['emailid'])) {
		$email = xss_filter($_SESSION['personal_details']['emailid']);
	}	else {
		$error = true;
	}
	
	if(valid_mobile($_SESSION['personal_details']['mobileno'])) {
		$mobile_no = xss_filter($_SESSION['personal_details']['mobileno']);
	}	else {
		$error = true;
	}
	
	if(valid_location($_SESSION['personal_details']['city'])) {
		$city = xss_filter($_SESSION['personal_details']['city']);
	}	else {
		$error = true;
	}
	
	if($error) {
		redirect_to('resetpage');
	}

	
	//$loan_amount 			= $_SESSION['personal_details']['appliedloanamt'];
	$loan_emi					= xss_filter($_SESSION['personal_details']['actualloanEMI']);
	$max_loan_amt 		= xss_filter($_SESSION['personal_details']['maxloanamt']);
	$min_loan_amt 		= xss_filter($_SESSION['personal_details']['minloanamt']);
	$actual_tenure		= xss_filter($_SESSION['personal_details']['actual_tenure']);
	$tenure 					=	xss_filter($_SESSION['personal_details']['tenure']);
	$loan_tenure 			= $actual_tenure/12;
	$roi_actual 			= xss_filter($_SESSION['personal_details']['roi_actual']);
	$roi_default 			= xss_filter($_SESSION['personal_details']['roi_default']);
	$pro_fee_actual 	= xss_filter($_SESSION['personal_details']['processing_fee_actual']);
	$pro_fee_default 	= xss_filter($_SESSION['personal_details']['processing_fee_default']);
	$emi_difference		= xss_filter($_SESSION['personal_details']['emi_diff']);
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
		<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script>
		<script src="js/function.js" type="text/javascript"></script>
		<script>
			$(function() {
				$("#checkboxFiveInput").click();
				
				$( "#SliderPoint3").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"loan",<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');
					}
				});
		
				$( "#SliderPoint4").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"years",1,<?php echo $loan_tenure; ?>,' Years');
					}
				});
				//dragger points function
				setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');
				setPoint('years','SliderPoint4',1,<?php echo $loan_tenure; ?>,' Years');
				clickbar("SliderPoint3","loan",<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,"");
				clickbar("SliderPoint4","years",0,<?php echo $loan_tenure; ?>," Years");
			
				$("#applyBtn").click(function() {
					$("#submitBtn").trigger("click");
				});
			
			});

			function chkboxFn(e) {
				if(e.target.checked==true) {
					$("#submitBtn, #applyBtn").removeAttr("disabled");
					$("#submitBtn, #applyBtn").removeClass("disabled");
				} else {	
					$("#submitBtn, #applyBtn").prop("disabled","disabled");
					$("#submitBtn, #applyBtn").addClass("disabled");
				}
			}
	
			function calbackEmi() {
				var emiVal = parseInt(emical(str2int($("#loan").val()),str2int($("#years").val()),<?php echo $_SESSION['personal_details']['roi_actual']; ?>));
				var emiDef = parseInt(emical(str2int($("#loan").val()),str2int($("#years").val()),<?php echo $_SESSION['personal_details']['roi_default']; ?>));
			
				var youSave = emiDef - emiVal;
				$("#emidiv").html(' <b>`</b> '+ adcoma(emiVal));
				$("#emiVal").val(emiVal);
				$(".edcLine3").html('You save <b>`</b> '+ adcoma(youSave));
			}
			
				$(window).resize(function(){
					setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');
					setPoint('years','SliderPoint4',1,<?php echo $loan_tenure; ?>,' Years');
				},20);
			
		</script>
	</head>
	<body class="bodyoverflow calculate_loan">
		<div id="main-wrap">
      <div class="overlay"></div>
			<div class="tnc-popup">
				<div class="tnc-popup-txt">
					<p><strong>TERMS AND CONDITIONS</strong></p>
					<p>1.	I hereby declare that every information already provided by me or as may be provided hereinafter are true and updated. I have not withheld or modified any part of such information. </p>
					<p>2.	I agree that the right to grant any credit facility lies with IIFL at its sole discretion and IIFL holds the right to reject my application at any time. I agree that IIFL shall not be responsible for any such rejection or any delay in intimating its decision.</p>
					<p>3.	I agree and accept that IIFL may in its sole discretion, by itself or through authorised persons, advocate, agencies, bureau, etc. verify any information given, check credit references, employment details and obtain credit reports or other KYC related documents. </p>
					<p>4.	I hereby authorize IIFL to exchange, share or part with all the information as provided by me or as may be provided by me with any of the group companies, banks, financial institutions, credit bureaus, statutory bodies or any entity as may required from time to time as deem fit by IIFL. I shall not hold IIFL liable for sharing any such information.</p>
					<p>5.	I hereby undertake to immediately inform IIFL regarding any change in information provided to IIFL by me.</p>
					<p>6.	I would like to know through telephonic calls/SMSs on my mobile number mentioned in this application form or through any other communication mode, various loan schemes, promotional offers of IIFL and I authorise IIFL, its employees or its agents to act accordingly. I confirm that laws in relations to the unsolicited communications referred in 'National Do Not Call Registry' as laid down by Telecom Regulatory Authority of India shall not be applicable to such communications/ telephonic calls/SMSs received from IIFL, its employees or its agents</p>
					<p class="tc"><a href="javascript://" class="closepop">OK</a></p>
					<div class="closeicon"><a href="javascript://" class="closepop"><img src="images/close-icon.png" class="scale"></a></div>
				</div>
			</div>
			<header>
				<div class="header-inner knowmore">
					<div class="logo"><img src="images/logo.jpg" class="scale"></div>
					<div class="personal-loan"><img src="images/personal.png" class="scale"></div>
					<div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
					<div class="clr"></div>
					<div class="card-container-outerinner">
						<div class="pendulamline-inner"><img src="images/pendulamline.png" class="scale"></div>
						<div class="card-container1 effect__random card-container" data-id="1">
							<div class="card__front"> <img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">Express<br>Personal<br>Loan</p>
							</div>
							<div class="card__back"><img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>
							</div>
						</div>
					</div>
				</div>
			</header>
			<form id="form1" name="form1" method="post" action="aadhar-details">
				<div id="msform">
					<section class="body-home-outer myclass screen05bg">
						<div class="innerbody-home heightdesign2 screen5" >
							<div class="eligibleDetail"><!-- eligibleDetail part start -->
								<div class="edTop">
									<div>Company Name<strong class="companyedit">
										<input type="text" maxlength="50" name="company" id="CompanyNam" class="companylist companyname-changetop" value="<?php echo $company; ?>" disabled />
										<!--<span class="editarrow" onClick="editvalue(event);"><img src="images/editarrow.png" class="scale"></span>--> 
										</strong>
									</div>
									<div>Monthly Salary<strong><span class="rsmonthly">`</span>
										<input type="text" name="salary" id="texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($salary); ?>" disabled />
										<!--<span class="editarrow editarrow2" onClick="editvalue(event);"><img src="images/editarrow.png" class="scale"></span>--> 
										</strong>
									</div>
									<div>Current EMI<strong><span class="rsmonthly rstotalemi">`</span>
										<input type="text" name="obligation" id="texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($obligation); ?>" disabled />
										<!--<span class="editarrow" onClick="editvalue(event);"><img src="images/editarrow.png" class="scale"></span>--></strong>
									</div>
									<!--<div><input type="submit" name="cmpSubmit" value="Update"></div>	--> 
								</div>
								<div class="edNav"> <b class="blink-txt orange">Hurray!</b> <strong>You are eligible for a loan of</strong> &nbsp;<span class="rsapply">`</span> <?php echo to_rupee($max_loan_amt); ?>
									<input type="submit" name="applynow" id="applyBtn" value="APPLY NOW" class="applybtn" onClick="ga('send', 'event', 'Personal Loan', 'Apply-Loan-Click1', 'Like-quote1');">
								</div>
								<div class="clr"></div>
								<div class="edContant">
									<aside>
										<span class="edcLine1">Loan Amount</span> <span class="rsloanamuont">`</span>
										<input type="text" name="loanAmount" class="edcLine2" value="<?php echo to_rupee($max_loan_amt); ?>" id="loan"  maxlength="8" onkeypress="return isNumberKey(event)" onchange="setPoint('loan','SliderPoint3',<?php echo $min_loan_amt; ?>,<?php echo $max_loan_amt; ?>,'');">
										<div class="edcRange"><span class="edcRangeIcons" id="SliderPoint3"><img src="images/slider-icon.png" class="scale"></span></div>
										<span class="edcRangeLeft"><b>`</b> <?php echo $min_loan_amt; ?></span>
										<span class="edcRangeRight"><b>`</b> <?php echo $max_loan_amt; ?></span>
										<span class="edcAdjust">Adjust the loan amount to an<br>EMI that suits you.. </span>
									</aside>
									<aside>
										<span class="edcLine1">Loan tenure</span>
										<input type="text" name="loanTenure" class="edcLine2" value="<?php echo $loan_tenure; ?> Years" id="years"  maxlength="7" onkeypress="return isNumberKey(event)" onChange="setPoint('years','SliderPoint4',1,<?php echo $actual_tenure; ?>,' Years');">
										<div class="edcRange">
											<span class="edcRangeIcons" id="SliderPoint4"><img src="images/slider-icon.png" class="scale"></span>
										</div>
										<span class="edcRangeLeft">1 Year</span><span class="edcRangeRight"><?php echo $loan_tenure; ?> Years</span>
										<span class="edcAdjust">Adjust the loan tenure to an<br>EMI that suits you.. </span>
									</aside>
									<div class="clr1"></div>
									<aside class="design2emi">
										<span class="edcLine1">EMI</span>
										<span class="edcLine2 edcLine2noBorder" id="emidiv"><b>`</b> <?php echo $loan_emi; ?></span>
										<span class="edcLine3">You save <b>`</b> <?php echo to_rupee($emi_difference); ?></span>
									</aside>
									<div class="clr"></div>
									<input type="hidden" id="emiVal" name="emiVal" value="<?php echo $loan_emi; ?>">
								</div>
								<div class="edUperBott">
									<!--*You're eligible for a loan tenure of up to <?php echo $loan_tenure; ?> years,  but could reduce it if you like. -->
								</div>
								<div class="edBottom">
									<div class="edBottomBox">
										<h1>Rate of Interest</h1>
										<h2>Standard rate <del><?php echo $roi_default; ?>%</del></h2>
										<h3 id="roi">Your offer <?php echo $roi_actual; ?>%</h3>
										<input type="hidden" id="roiDef" value="<?php echo $roi_default; ?>" name="roiDef">
										<input type="hidden" id="roiAct" value="<?php echo $roi_actual; ?>" name="roiAct">
									</div>
									<div class="edBottomBox">
										<h1>Processing fee</h1>
										<h2>Standard rate <del><?php echo $pro_fee_default; ?>%</del></h2>
										<h3>Your offer <?php echo $pro_fee_actual; ?>%</h3>
										<input type="hidden" name="proFeeDefault" value="<?php echo $pro_fee_default; ?>" id="proFeeDefault">
										<input type="hidden" name="proFeeActual" value="<?php echo $pro_fee_actual; ?>" id="proFeeActual">
									</div>
									<div class="clr"></div>
									<div class="edBottomTerms">
										<div class="edBottomCheckbox">
											<input type="checkbox" value="1" id="checkboxFiveInput" onChange="chkboxFn(event);" name="" />
											<label for="checkboxFiveInput"></label>
										</div>
										<p><a href="javascript:;" class="tnc-btn">I agree to all the terms and conditions</a></p>
									</div>
									
									<div class="clr"></div>
								</div>
								<input type="hidden" name="webpageno" id="webpageno" value="2" />
								<input type="submit" name="applynow" id="submitBtn" value="APPLY NOW" class="edBottomSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Apply-Loan-Click1', 'Like-quote2');">
							</div>
							<div class="screen05img"> <img src="images/homescreen-05img.png" class="scale">
								<div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
								<div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
							</div>
						</div>
					</section>
				</div>
			</form>
  <?php require_once('includes/footer.php'); ?>