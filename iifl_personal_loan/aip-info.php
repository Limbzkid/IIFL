<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php if(!isset($_SESSION['personal_details'])) { redirect_to(HOME); } ?>
<?php
	//echo "<pre>"; print_r($_SESSION); echo '</pre>';
	$residence_list = '';
	$service_url = COMMON_API. 'SearchFetchDropDown';
	$headers = array (
		"Content-Type: application/json"
	);
	$curl_post_data = array("CategoryName"	=> "ResidenceType");
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
	foreach($curl_response->Body->MasterValues as $data) {
		$id = $data->dropdownid;
		$value = $data->dropdownvalue;
		$residence_list .= '<option value="'.$id.'">'.$value.'</option>';
	}
	
	$loan_purpose_list = '';
	$service_url = COMMON_API. 'SearchFetchDropDown';
	$headers = array (
		"Content-Type: application/json"
	);
	$curl_post_data = array("CategoryName"	=> "PurposeOfLoan");
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
	foreach($curl_response->Body->MasterValues as $data) {
		$id = $data->dropdownid;
		$value = $data->dropdownvalue;
		$loan_purpose_list .= '<option value="'.$id.'">'.$value.'</option>';
	}
	
	$education_list = '';
	$service_url = COMMON_API. 'SearchFetchDropDown';
	$headers = array (
		"Content-Type: application/json"
	);
	$curl_post_data = array("CategoryName"	=> "EducationMaster");
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
	foreach($curl_response->Body->MasterValues as $data) {
		$id = $data->dropdownid;
		$value = $data->dropdownvalue;
		$education_list .= '<div class="chkpersonal-info">
		<input type="radio" name="radioEdu" id="'.$id.'" value="'.$id.'"><label for="'.$id.'">'.$value.'</label></div>';
	}

	$rtype_err 	= '';
	$edu_err 	= '';
	$mar_err 	= '';
	$purp_err 	= '';
	$stabl_err 	= '';

	$tenure		= xss_filter($_SESSION['personal_details']['tenure']);
	$loan_tenure= $tenure/12;
	if(isset($_POST['aipSubmit'])) {
		$error = false;
		if(!preg_match("/[0-9]/", $_POST['residencetype'])) {
			$rtype_err = 'Invalid Residence type';
			$_SESSION['errors'][] = 'Residence type';
			$error = true;	
		} else {
			$residence_type = $_SESSION['personal_details']['residencetype'] = xss_filter($_POST['residencetype']);
		}
		
		if(!preg_match("/[A-Z]/", $_POST['radioEdu'])) {
			$edu_err = "Invalid Education type";
			$_SESSION['errors'][] = 'Education type';
			$error = true;
		} else {
			$education = $_SESSION['personal_details']['education'] = xss_filter($_POST['radioEdu']);
		}
		
		if(!preg_match("/[A-Z]$/", $_POST['radioMar'])) {
			$mar_err = "Invalid Marital Status";
			$_SESSION['errors'][] = 'Marital Status';
			$error = true;
		} else {
			$marriage = $_SESSION['personal_details']['marritalstatus'] = xss_filter($_POST['radioMar']);
		}
		
		if(!preg_match("/^[A-Z][A-Z][0-9][0-9]$/", $_POST['loanPurpose'])) {
			$purp_err = 'Invalid Loan Purpose';
			$_SESSION['errors'][] = 'Loan Purpose';
			$error = true;
		} else {
			$loan_purpose = $_SESSION['personal_details']['loanpurpose'] = xss_filter($_POST['loanPurpose']);
		}
		
		if(!preg_match("/[0-9]/", $_POST['residencestability'])) {
			$stabl_err = 'Invalid Residence stability';
			$_SESSION['errors'][] = 'Residence stability';
			$error = true;
		} else {
			$residence_stability = $_SESSION['personal_details']['residencestability'] = xss_filter($_POST['residencestability']);
		}
		
		if(!$error) {
			if($_POST['residencestability'] == 1) {
				$residence_stability = 1;
			} elseif($_POST['residencestability'] == 2) {
				$residence_stability = 6;
			}	elseif($_POST['residencestability'] == 3) {
				$residence_stability = 18;
			} elseif($_POST['residencestability'] == 4) {
				$residence_stability = 27;
			}
			
			//$residence_stability = 36; 
			$service_url = API. 'UpdateResidential';
			$headers = array (
				"Content-Type: application/json"
			);
		
			$curl_post_data = array(
				"CRMLeadID"						=> xss_filter($_SESSION['personal_details']['CRMLeadID']),
				"ProspectNumber"			=> xss_filter($_SESSION['personal_details']['ProspectNumber']),
				"ApplicantType"				=> "APPLICANT",
				"ResidenceType"				=> xss_filter($residence_type),
				"ResidenceStability"	=> xss_filter($residence_stability),
				"Education"						=> xss_filter($education),
				"MaritalStatus"				=> xss_filter($marriage)	,
				"PurposeofLoan"				=> xss_filter($loan_purpose),
				"PageNumber"					=> xss_filter($_POST['webpageno'])
			);
			$decodeddata = json_encode($curl_post_data);
			//echo "<pre>"; print_r($decodeddata); echo "</pre>"; //print_r($service_url); exit;
			$_SESSION['request'] = $curl_post_data;
			$handle = curl_init(); 
			curl_setopt($handle, CURLOPT_URL, $service_url);
			curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
			$curl_response = curl_exec($handle);
			//echo "<pre>"; print_r($curl_response); exit;
			$decoded = json_decode($curl_response);
			$response = json_decode($decoded);
			//echo "<pre>"; print_r($response); echo '</pre>'; exit;
			$_SESSION['response'] = $curl_response;

			if(strtolower($response[0]->ErrorMsg) == 'fail') {
				redirect_to('declined');
			} else {
				$cibil_response		= $_SESSION['CIBIL']['cibilResponse'] 	= xss_filter($response[0]->CibilResponse);
				$cibil_status			= $_SESSION['CIBIL']['status'] 					= xss_filter($response[0]->Status);
				$_SESSION['CIBIL']['revised_MaxAmount'] 									= xss_filter($response[0]->MaxAmount);
				$_SESSION['CIBIL']['revised_Tenure'] 											= xss_filter($response[0]->Tenure);
				$_SESSION['CIBIL']['revised_EMI'] 												= xss_filter($response[0]->EMI);
				$_SESSION['CIBIL']['revised_ProcessingFee'] 							= xss_filter($response[0]->ProcessingFee);
				$_SESSION['CIBIL']['revised_ROI'] 												= xss_filter($response[0]->ROI);
				/*---to bypass decline---*/
				//$cibil_response = '0-Yes';
				//$cibil_status = 'Approved in Principle';
				/*--to bypass decline ends----*/
				if($cibil_response == '0-Yes' && $cibil_status == 'Approved in Principle') {
					redirect_to('your-quote'); // congrats -> document_upload
				} elseif($cibil_response == '0-Yes' && $cibil_status == 'Average') {
					redirect_to('upload-non-financial-document'); 
				}	elseif($cibil_response == '0-Yes' && $cibil_status == 'Declined') {
					redirect_to('declined');
				} elseif($cibil_response == '0-Yes' && $cibil_status == 'Null') {
					redirect_to('upload-non-financial-document');
				}	elseif($cibil_response == '1-No' && $cibil_status == 'Declined') {
					redirect_to('declined');
				}	elseif($cibil_response == '2-Null' && $cibil_status == 'Null') {
					redirect_to('upload-non-financial-document');
				}	else {
					redirect_to('declined');
				}
			}
		} else {
			redirect_to('resetpage');
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
		<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script>
		<script src="js/function.js" type="text/javascript"></script> 
		<script>
			$(function() {
				$( "#SliderPoint5").draggable({ containment: "parent", axis: "x", drag: function(event, ui){PointerFN(event.target.id,"period",1,4,'');}});
				$( "#SliderPoint5").mouseup(function(){setPoint('period','SliderPoint5',1,4,'');});
	
				//$( "#SliderPoint3").draggable({ containment: "parent", axis: "x", drag: function(event, ui){PointerFN(event.target.id,"loan",0,1000000,'');}});
				//$( "#SliderPoint4").draggable({ containment: "parent", axis: "x", drag: function(event, ui){PointerFN(event.target.id,"years",1,5,' Years');}});
			
				//setPoint('loan','SliderPoint3',0,1000000,'');
				//setPoint('years','SliderPoint4',1,<?php echo $loan_tenure?>,' Years');	
				setPoint('period','SliderPoint5',1,4,'');
			
				//clickbar("SliderPoint3","loan",0,1000000,"");
				//clickbar("SliderPoint4","years",0,<?php echo $loan_tenure?>," Years");
				clickbar("SliderPoint5","period",1,4," ");
				
				$("#block2, #block3").hide();
				$("#block1 select").change(function(event) {
					block_FN2(event,"block1 select","block2");
				});
				/*
				$("#block1 select").change(function(event) {
					block_FN2(event,"block1 select","buttonElg");
				});*/
				$("#block2 input[type=radio]").change(function(event) {
					block_FN2(event,"block2 input[type=radio]","block3");
				});
				
				$("#block3 select").change(function(event){
					block_FN2(event,"block3 select","buttonElg");
				});
				
				
				
				
				$("#residencetype").change(function(){
					var residencetype = $("#residencetype option:selected").val();
					if(residencetype == "")
					{
						//$("#error_msg").after("Please select at least One option");
						$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
						$("#block2").fadeOut();
						
					}
					else if(residencetype == "Residence Type*"){
						$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
						$("#block2").fadeOut();						
					}
					else{
						$("#error-user").css('display','none');
						$("#block2").fadeIn();
					}
				});

				
			});

			
		
			function calbackEmi() {
				//$("#emidiv").html(emical(str2int($("#loan").val()),str2int($("#years").val()),<?php echo $_SESSION['personal_details']['roi_actual']; ?>));
				//$("#loanAmu").html($("#loan").val());
				//$("#tenure").html($("#years").val());
				//$("#totalAmu").html(adcoma(str2int($("#emidiv").html())*str2int($("#years").val())*12));
			}
			
		</script>
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
		<!-- Media Zotic: IIFL Personal Loan -->
		<script src="https://www.mediazotic.com/track/conversion.php?id=432&transaction_id=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>"></script> 
		<!-- Media Zotic: IIFL Personal Loan End-->
	</head>
	<body class="bodyoverflow">
	
	<!-- Piexel Code Start Here -->
	
		<!-- Digi Fusion Offer Conversion: IIFL Personal Loan -->
		<img src="https://adglobalfusion.go2cloud.org/aff_l?offer_id=305&adv_sub=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1" />
		<!-- // End Offer Conversion -->
		
		<!-- DGM Pixel code -->
			<script src="https://www.s2d6.com/js/globalpixel.js?x=sp&a=1713&h=69938&o=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>&g=&s=0.00&q=1"></script>
		<!-- end -->
		
		<!-- Pointific Pixel code -->
		<img src="https://pointificsecure.com/p.ashx?o=314&e=191&f=img&t=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1" border="0" />
		<!-- Pointific  end -->
		
		<!-- Valueleaf Offer Conversion:   -->
		<iframe src="https://valueleafservices.go2cloud.org/aff_l?offer_id=456&adv_sub=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
		<!-- // End Offer Conversion -->
		
		<!-- Netcore Offer Conversion: IIFL Personal Loan CPL -->
		<iframe src="https://tracking.affiliatehub.co.in/SL1XZ?adv_sub=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
		<!-- // Netcore End Offer Conversion -->

		<!-- Offer Conversion: IIFL Finance - CPL --> 
		<img src="https://digitalsamadhan.go2cloud.org/aff_l?offer_id=537&adv_sub=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1" /> 
		<!-- // End Offer Conversion -->
		
		<!-- White Dwarf Media: IIFL Finance  --> 
		<iframe src="https://wdaffiliate.go2cloud.org/SL2?adv_sub=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
		<!-- // End Offer Conversion -->
		
    <!-- Pixel code ends here -->
	
		<!-- Residence Info Pixel -->
		<img src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Res-Page=<Res-Page>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
		<!-- End Residence Info Pixel -->
		<div id="main-wrap"> 
			<header>
  <div class="header-inner knowmore">
    <div class="logo"><img src="images/logo.jpg" class="scale"></div>
    <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
    <div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
    <div class="clr"></div>
    <div class="card-container-outerinner">
      <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
      <div class="card-container1 effect__random card-container" data-id="1">
  <div class="card__front"> <img src="images/48hours.png" class="scale"><p class="pendulamtxt">Express<br>Personal<br>Loan</p> </div>
  <div class="card__back"><img src="images/48hours.png" class="scale"><p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>  </div>
      </div>
    </div>
  </div>
			</header>
			<form id="form1" name="form1" method="post" action="aip-info">
  <div id="msform">
    <section class="body-home-outer myclass screen04bg">
      <div class="innerbody-home ipadheight-auto" style="height:auto">
  <div class="eligibleDetail">
    <div class="edTop">
      <div>Company Name<strong class="strongcom-inner">
										<input type="text" name="textfield" id="textfield" class="companyname-changetop" value="<?php echo $_SESSION['personal_details']['companyname']; ?>" /></strong>
									</div>
      <div>Monthly Salary
										<strong class="strong-inner"><span class="rsmonthly">`</span>
											<input type="text" name="textfield" id="texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['salary']); ?>" />
										</strong>
									</div>
      <div>Total EMI
										<strong class="strong-inner"><span class="rsmonthly rstotalemi">`</span>
											<input type="text" name="textfield" id="texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['obligation']); ?>" />
										</strong>
									</div>
								</div>
    <div class="clr"></div>
  </div>
  <div id="updatehide">
	<div class="loan-detailbox">
		<div class="loan-details">Loan Details</div>
		<div class="loan-amount">Loan Amount - <span class="orange"><b class="rupee-symb">`</b> <b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b></span><br>Loan Tenure - <span class="orange" id="tenure"><?php echo $_SESSION['personal_details']['tenure']/12; ?> Years</span></div>
		<div class="loan-amount loanamout-small">Rate of Interest - <span class="orange"><?php echo $_SESSION['personal_details']['roi_actual']; ?>%</span><br>Processing Fees - <span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($_SESSION['personal_details']['processing_fee']); ?></span></div>
		<div class="total-emi">EMI - <span class="orange"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($_SESSION['personal_details']['actualloanEMI']); ?></b></span></div> 
		<div class="clr none"></div>         
	</div>	
    <div class="updateloadn-detailbox">
      <div class="edContant update-mar0">
		<aside class="update-mar1">
			<span class="edcLine1 flnone loanamt-white-visible">Loan Amount</span>
			<div class="loandetail-relative">
				<div class="rsicon">`</div>
				<input type="text" class="edcLine2 flnone" value="<?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?>" id="loan"  maxlength="8" onkeypress="return isNumberKey(event)" onChange="setPoint('loan','SliderPoint3',0,1000000,'');">
			</div>
			<div class="edcRange flnone">
				<span class="edcRangeIcons" id="SliderPoint3"><img src="images/slider-icon-orange.png" class="scale"></span>
				<span class="edcRangeLeft loanamt-white-visible mar6slierinner"><b>`</b> <?php echo $_SESSION['personal_details']['minloanamt']; ?></span>
				<span class="edcRangeRight loanamt-white-visible mar6slierinner"><b>`</b> <?php echo $_SESSION['personal_details']['maxloanamt']; ?></span>
			</div>
			<span class="edcAdjust background-position-arrow">Adjust the loan amount to an<br>EMI that suits you.. </span>
		</aside>
      
		<aside class="update-mar2">
        <span class="edcLine1 flnone loanamt-white-visible">Loan tenure</span>
        <input type="text" class="edcLine2 flnone" value="<?php echo $_SESSION['personal_details']['tenure']/12; ?> Years" id="years"  maxlength="7" onkeypress="return isNumberKey(event)" onChange="setPoint('years','SliderPoint4',1,<?php echo $_SESSION['personal_details']['tenure']/12; ?>,' Years');">
        <div class="edcRange flnone"><span class="edcRangeIcons" id="SliderPoint4"><img src="images/slider-icon-orange.png" class="scale"></span>
      <span class="edcRangeLeft loanamt-white-visible mar6slierinner">1 Year</span><span class="edcRangeRight loanamt-white-visible mar6slierinner"><?php echo $_SESSION['personal_details']['tenure']/12; ?> Years</span>    
        </div>
  <span class="edcAdjust background-position-arrow">Adjust the loan tenure to an<br>EMI that suits you.. </span>
      </aside>
      
      <aside class="updateside">
    <div class="updatebox"><input type="submit" name="button" id="button" value="UPDATE" class="updatebtn" /></div>
      </aside>
    </div>
      </div>
        </div>
      <div class="approval-wrap">
      <div class="approval-leftpoints">
  	<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
    EMI Quote</div>
  	<div class="lefticons-line"></div>
  	<div class="emi-quoteicon"><img src="images/detailicon-big.png" class="scale"><br>
    My Details</div>
  	<div class="lefticons-line"></div>
  	<div class="emi-quoteicon"><img src="images/eligible-icon-fade.png" class="scale"><br>
    Eligibility</div>
  	<div class="lefticons-line"></div>
  	<div class="emi-quoteicon lasticon"><img src="images/document-icon-fade.png" class="scale"><br>
    Documents</div>
  	<div class="clr"></div>
      </div>
        <div class="approval-right-container">
	    	<div id="block1">
	      <div class="aadhar-heading">Residence information</div>
	      <div class="detailwrap-line1">
	        <div class="detailfields">
	        <label class="input">
			<div class="select_valall"></div>
	        <select id="residencetype" name="residencetype" class="select_iconall">
	      <option value="">Residence Type*</option>
	      <?php echo $residence_list; ?>
	        </select>
	        </label>
									<?php if($rtype_err != ''): ?><?php echo $rtype_err; ?><?php endif; ?>
	        </div>
	        <div class="slider-residence">
	      <div class="slider-restxt">Period of residence:</div>
	          <div class="res-sliderbox">
	        <input type="hidden" name="residencestability" value="1" id="period"/>
	        <div class="res-slidericon" id="SliderPoint5"><img src="images/slider-icon.png" class="scale"></div>
	        <div id="periodtxt">
	        <div class="months5">O to<br>2 months</div>
	        <div class="months12">3 to<br>11 months</div>
	        <div class="years5">12 to<br>23 months</div>
	        <div class="year5a">More than<br>24 months</div>
	        </div>
	          </div>
										<?php if($stabl_err != ''): ?><?php echo $edu_err; ?><?php endif; ?>
          <div class="clr"></div>
	        </div>
	        <div class="clr"></div>
	      </div>
	        </div>
      <div class="detailwrap-line1" id="block2">
    <div class="aadhar-heading">Personal Information</div>
    <div class="personal-infoline1">
    <div class="eduhead">Education<span class="red">*</span></div>
	    <div class="personalinfo-radiobox">
	        <div class="inputcheckbx">
	      <?php echo $education_list; ?>
										<?php if($edu_err != ''): ?><?php echo $edu_err; ?><?php endif; ?>
	      <div class="clr"></div>
	        </div>
	    </div>

							<div class="eduhead">Marital status<span class="red">*</span></div>
      <div class="personalinfo-radiobox">
							<div class="inputcheckbx">
								<div class="chkpersonal-info">
								<input type="radio" name="radioMar" id="d" value="N">
								<label for="d">Single</label>
								</div>
								<div class="chkpersonal-info">
								<input type="radio" name="radioMar" id="e" value="Y">
								<label for="e">Married</label>
								</div>
								<?php if($mar_err != ''): ?><?php echo $mar_err; ?><?php endif; ?>
								<div class="clr"></div>
							</div>
      </div>
    </div>
        </div>
					<div id="block3">
						<div class="aadhar-heading">Purpose of Loan</div>
						<div class="detailwrap-line1">
							<div class="detailfields">
								<label class="input">
									<div class="select_valall"></div>
									<select name="loanPurpose" class="select_iconall">
										<option value="">Select*</option>
										<?php echo $loan_purpose_list; ?>
										<?php if($purp_err != ''): ?><?php echo $purp_err; ?><?php endif; ?>
									</select>
								</label>
							</div>
							<div class="clr"></div>
						</div>
					</div>
					<div class="next-home next-scr2 tc">
						<input type="hidden" name="webpageno" id="webpageno" value="5" />	
						<input type="submit" name="aipSubmit" id="buttonElg" disabled="true" value="CHECK ELIGIBILITY" class="homesubmit disabled" onClick="ga('send', 'event', 'Personal Loan', 'CHECK ELIGIBILITY', 'Residence-page');"/>
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

