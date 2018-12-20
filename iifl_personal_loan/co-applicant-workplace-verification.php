<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>

<?php
 //echo "<pre>"; print_r($_SESSION); 
if(!isset($_SESSION['co_applicant_details']))
{
	$interest = xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
}
else
{
	$interest = xss_filter($_SESSION['co_applicant_details']['CIBIL']['ROIActual']) / 1200;
}
	$tenure = $_SESSION['personal_details']['tenure'];
	$emi = ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $tenure) / (1 - pow((1 + $interest), $tenure)));
if(!isset($_SESSION['co_applicant_details']))
{
	$processing_fee = ceil(($_SESSION['CIBIL']['revised_ProcessingFee']/100) * $_SESSION['personal_details']['appliedloanamt']);
}
else
{
	$processing_fee = $_SESSION['co_applicant_details']['CIBIL']['processing_fee'];
}
	$id_proof_options 			= '';
	$addr_proof_options 		= '';
	$bank_statement_options = '';
	$salary_slip_options		=	'';
	$property_ownership_options = '';
	$service_url = COMMON_API. 'SearchFetchDropDown';
	$headers = array (
		"Content-Type: application/json"
	);
	$curl_post_data = array("CategoryName"	=> "IDProof");
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
		$id_proof_options .= '<option value="'.$id.'">'.$value.'</option>';
	}

	$curl_post_data = array("CategoryName"	=> "AddressProof");
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
		$addr_proof_options .= '<option value="'.$id.'">'.$value.'</option>';
	}
	
	$curl_post_data = array("CategoryName"	=> "BankStatement");
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
		$bank_statement_options .= '<option value="'.$id.'">'.$value.'</option>';
	}
	
	$curl_post_data = array("CategoryName"	=> "SalarySatement");
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
		$salary_slip_options .= '<option value="'.$id.'">'.$value.'</option>';
	}
	
	$curl_post_data = array("CategoryName"	=> "OwnershipType");
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
		$property_ownership_options .= '<option value="'.$id.'">'.$value.'</option>';
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
<script type="text/javascript" src="js/css3mediaquery.js"></script>
<link href="css/fonts.css" rel="stylesheet" type="text/css">
<link href="css/iifl.css" rel="stylesheet" type="text/css">
<link href="css/media.css" rel="stylesheet" type="text/css">
<script src="js/jquery.easing.min.js" type="text/javascript"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/function.js" type="text/javascript"></script>
<script src="js/design18.js" type="text/javascript"></script>
<script>
	$(function() {
		
		$('.tablink-1 a').click(function() {
			$("#textfield").removeClass('dnone');
			$("#co_textfield").addClass('dnone');
			$("#texSal").removeClass('dnone');
			$("#co_texSal").addClass('dnone');
			$("#texEmi").removeClass('dnone');
			$("#co_texEmi").addClass('dnone');
		});
		
		$('.tablink-2 a').click(function() {
			$("#textfield").addClass('dnone');
			$("#co_textfield").removeClass('dnone');
			$("#texSal").addClass('dnone');
			$("#co_texSal").removeClass('dnone');
			$("#texEmi").addClass('dnone');
			$("#co_texEmi").removeClass('dnone');
		});
		
		$(".co-app-tab-header li a").click(function(){
      $(this).addClass("link-active").parent().siblings('li').find('a').removeClass("link-active");
      var getclassname = $(this).parent().attr('class');
      $('.co-app-tab-child[rel="'+getclassname+'"]').fadeIn();
      $('.co-app-tab-child[rel="'+getclassname+'"]').siblings().hide();
       //$('html, body').animate({ scrollTop: $(".popup-video-tabs").offset().top }, 500); 
		}).eq(1).click();

		$('#checkboxInput1').click(function(){
			$(this).next().toggleClass('activeCheckbox');
		});
				
		$("#pincode").blur(function() {
			$(this).closest('.detailfields').find("#error-user").remove();
			$(this).parent().find("#error-user").remove();
			var pin = $(this).val();
			var pinregs = /^[0-9]{5}$/;
			/*if(!pinregs.test(pin)) {
				$('#pincode').after('<div id="error-user">Invalid Pincode.</div>');
			}*/
			if( pin.length < 6 ){
				$(this).after('<div id="error-user">Invalid Pincode.</div>');
			} else {
				$(this).parent().find("#error-user").remove();
			}
			if(pin != '') {
    			$.ajax({
					url:"ajax/verify-pincode",
					type:"POST",
					data:{pincode:pin,type:'pincode', grp: 'AAA'},
					success: function(msg){
						var getData = JSON.parse(msg);
						console.log(getData.Status);
						if(getData.Status == "Success") {
							$(".city").css('visibility', 'hidden');
							$(".state").css('visibility', 'hidden');
							$('#city').val(getData.City).attr('readonly', 'readonly');
							$('#state').val(getData.State).attr('readonly', 'readonly');
							$('#cityCode').val(getData.CityCode);
							$('#stateCode').val(getData.StateCode);
						} else {
							$(this).after('<div id="error-user">'+getData.ErrorMsg+'</div>');
						}
					}
				});
  				} else {
				//$("#pincode").after('<div id="error-user">Please enter a pincode</div>');
				$(".city").css('visibility', 'visible');
				$(".state").css('visibility', 'visible');
				$('#city').val('');
				$('#state').val('');				
			}
		});

		$("#pincodecoapp2").blur(function() {
			$(this).closest('.detailfields').find("#error-user").remove();
			var pin = $(this).val();
			var pinregs = /^[0-9]{5}$/;
			//alert(pin);
			/*if(!pinregs.test(pin)) {
				alert(pin);
				$('#pincodecoapp2').after('<div id="error-user">Invalid Pincode.</div>');
			}*/
			if( pin.length < 6 ){
			//alert(pin)
				$(this).after('<div id="error-user">Invalid Pincode.</div>');
			} else{
				$(this).parent().find("#error-user").remove();
			}
			if(pin != '') {
    			$.ajax({
					url:"ajax/verify-pincode",
					type:"POST",
					data:{pincode:pin,type:'pincode', grp: 'AAA'},
					success: function(msg){
						var getData = JSON.parse(msg);
						console.log(getData.Status);
						if(getData.Status == "Success") {
							$(".cocity").css('visibility', 'hidden');
							$(".costate").css('visibility', 'hidden');
							$('#citycoapp2').val(getData.City).attr('readonly', 'readonly');
							$('#statecoapp2').val(getData.State).attr('readonly', 'readonly');
							$('#cityCodecoapp2').val(getData.CityCode);
							$('#stateCodecoapp2').val(getData.StateCode);
						} else {
							$(this).after('<div id="error-user">'+getData.ErrorMsg+'</div>');
						}
					}
				});
  				} else {
				//$("#pincodecoapp2").after('<div id="error-user">Please enter a pincode</div>');
				$(".cocity").css('visibility', 'visible');
				$(".costate").css('visibility', 'visible');
				$('#citycoapp2').val('');
				$('#statecoapp2').val('');				
			}
		});
	});			
</script>
<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
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

<body class="bodyoverflow	">
<!-- Upload Document Pixel --> 
<img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Documents-Page=<Documents-Page>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/> 
<!-- End Uplaod Document Pixel -->
<div class="dnone">
  <pre>Request data <br><?php print_r($_SESSION['request']); ?>Response data <br><?php print_r($_SESSION['response']); ?></pre>
</div>
<div id="main-wrap"><!--mainwrap-->
  	<header>
    	<div class="header-inner knowmore"><!--header-->
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
	      	<p class="pendulamtxt">DISBURSAL<br>
	  	IN<br>
	  	8 HOURS* <br/>
	  	<small> T&C Apply</small></p>
	    	</div>
  	</div>
      	</div>
    	</div>
  </header>
<div id="msform">
    <section class="body-home-outer myclass screen04bg bgpink coappcontainer">
      	<div class="heightdesign2 screen5 height-ipad-812" >
  <ul class="co-app-tab-header">
    <li class="tablink-1"><a href="javascript:;"><?php echo $_SESSION['personal_details']['applicantname']. ' ' .$_SESSION['personal_details']['lastname'] ;?></a></li>
    <li class="tablink-2"><a href="javascript:;" class="link-active"><?php echo $_SESSION['co_applicant_details']['applicantname']. ' '. $_SESSION['co_applicant_details']['lastname'] ;?></a></li>
  </ul>
  <div class="innerbody-home ipadheight-auto" style="height:auto">
    <div class="eligibleDetail clr">
      <div class="edTop">
  <div>Company Name <strong class="strongcom-inner">
    <input type="text" name="textfield" id="textfield" class="companyname-changetop dnone" value="<?php echo xss_filter($_SESSION['personal_details']['companyname']); ?>" disabled />
		<input type="text" name="textfield" id="co_textfield" class="companyname-changetop" value="<?php echo xss_filter($_SESSION['co_applicant_details']['companyName']); ?>" disabled />
	</strong> 
    <div id="error-user">Company name must be more than 3 characters long</div></div>
  <div>Monthly Salary <strong class="strong-inner"> <span class="rsmonthly">`</span>
    <input type="text" name="textfield" id="texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop dnone" value="<?php echo to_rupee($_SESSION['personal_details']['salary']); ?>" disabled />
    <input type="text" name="textfield" id="co_texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['co_applicant_details']['monthlySalary']); ?>" disabled />
	</strong> </div>
  <div>Current EMI <strong class="strong-inner"> <span class="rsmonthly rstotalemi">`</span>
    <input type="text" name="textfield" id="texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop dnone" value="<?php echo to_rupee($_SESSION['personal_details']['obligation']); ?>" disabled />
		<input type="text" name="textfield" id="co_texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['co_applicant_details']['currentEmi']); ?>" disabled />
		
    </strong> </div>
      </div>
      <div class="clr"></div>
    </div>
    <div id="updatehide">
      <div class="loan-detailbox">
  <div class="loan-details">Loan Details</div>
  <div class="loan-amount">Loan Amount - <span class="orange"> <b class="rupee-symb">`</b> <b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b> </span> <br>
    Loan Tenure - <span class="orange" id="tenure"><?php echo $_SESSION['personal_details']['tenure']/12; ?> Years</span> </div>
    <?php if(!isset($_SESSION['co_applicant_details'])) { ?>
  <div class="loan-amount loanamout-small">Rate of Interest - <span class="orange"><?php echo $_SESSION['CIBIL']['revised_ROI']; ?>%</span> <br>
    Processing Fees - <span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span> </div>
<?php } else { ?>
<div class="loan-amount loanamout-small">Rate of Interest - <span class="orange"><?php echo $_SESSION['co_applicant_details']['CIBIL']['ROIActual']; ?>%</span> <br>
    Processing Fees - <span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span> </div>
<?php } ?>
  <div class="total-emi">EMI - <span class="orange"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b></span> </div>
  <div class="clr none"></div>
      </div>
    </div>
    <div class="approval-wrap align-left CoWorkplaceVerify">
      <div class="approval-leftpoints">
  <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
    EMI Quote</div>
  <div class="lefticons-line"></div>
  <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
    My Details</div>
  <div class="lefticons-line"></div>
  <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
    Eligibility</div>
  <div class="lefticons-line"></div>
  <div class="emi-quoteicon lasticon"><img src="images/documenticon-big.png" class="scale"><br>
    Documents</div>
  <div class="clr"></div>
      </div>

      <!-- Co-Applicant Document upload starts -->
      <div class="co-app-tab-child centerpanel centerall co_app" rel="tablink-2">
				<div class="approval-right-container width100">
					<div class="design18">
										<div class="design18Head">Workplace Verifications</div>
										<!--<div class="accordionButton">
											<div class="docUpload">Workplace  verification</div>
										</div>-->
										<div class="accordionContent docUploadBox wpv uploadbgcoapp">
        <div class="datafieldone marrightnone">
					<label class="input"><span class="addr1">Address1*</span>
						<input type="text" id="addr1coapp2" maxlength="100"/>
					</label>
        </div>
        <div class="datafieldone marrightnone">
					<label class="input"><span class="addr2">Address2*</span>
						<input type="text" id="addr2coapp2" maxlength="100"/>
					</label>
        </div>
        <div class="datafieldone marrightnone">
					<label class="input"><span class="addr3">Address3</span>
						<input type="text" id="addr3coapp2" maxlength="100"/>
					</label>
        </div>
        <div class="detailwrap-line1">
					<div class="detailfields detailfields-veri marrightnone">
						<label class="input"><span class="pin">Pincode*</span>
							<input type="text" id="pincodecoapp2" class="pin_code_app" maxlength="6" onkeypress="return isNumberKey(event)"/>
						</label>
					</div>
					<div class="detailfields detailfields-veri marrightnone space_right">
						<label class="input"><span class="cocity">City*</span>
							<input type="text" id="citycoapp2" rel=""/>
						</label>
					</div>
					<div class="detailfields detailfields-veri marright-field marrightnone space_right">
						<label class="input"><span class="costate">State*</span>
							<input type="text" id="statecoapp2" rel=""/>
						</label>
					</div>
					<input type="hidden" id="stateCodecoapp2">
					<input type="hidden" id="cityCodecoapp2">
					<div class="clr"></div>
					<!--<div class="verifymail-line">Verify official email id to ensure faster disbursal</div>-->
					<div class="veryfymail-box marrightnone">
						<div class="verymailtxt">Work email*</div>
						<div class="verifymail-field">
							<label class="input"><span>Work email id</span>
								<input type="text" id="emailcoapp2" maxlength="50"/>
							</label>
						</div>
						<!--<div class="verifybtn">
										<input type="submit" name="" value="Verify" class="uploadverify">
									</div>-->
						<div class="clr"></div>
					</div>
					<?php if(isset($_SESSION['co_applicant_details']['ifsc_code'])): ?>
						<div class="docUBprimary naChkBox">
							<aside class="docUBcheckbox">
								<input type="checkbox" name="checkboxInput" id="checkboxInput1" class="naChk"/>
								<label for="checkboxInput1" class="naChkLbl"></label>
							</aside>
							<p><strong>NACH</strong><br>
								<small>Use this address for NACH pick up.</small></p>
						</div>
					<?php endif; ?>
    <!--<div class="veryfymail-box">
							<div class="verifymail-field">
								<label class="input"><span>OTP</span><input type="text" /></label>
							</div>
							<div class="verifybtn">
								<input type="submit" name="" value="Resend" class="uploadverify">
							</div>
							<div class="clr"></div>
						</div>--> 
        </div>
      </div>
										<div class="clr"></div>
										<div class="clr"></div>
									 <!-- <div class="verifymainsubmit">
											<input type="hidden" id="pageNo" value="8" />
											<input type="submit" name="button" id="button" value="Proceed" class="homesubmit" />
										</div>-->
									</div>
				</div>
				<!-- <div class="verifymainsubmit uploadsubmit">
					<input type="hidden" id="pageNo" value="8" />
					<input type="submit" name="button" id="button" value="SUBMIT" class="homesubmit coapp_btnsubmit" onClick="ga('send', 'event', 'Personal Loan', 'Submit', 'Document-complete');" />
				</div> -->
      </div>
	  
		<div class="verifymainsubmit uploadsubmit">
			<input type="hidden" id="pageNo" value="16" />
			<input type="submit" name="button" id="button" value="SUBMIT" class="homesubmit coapp_btnsubmit" />
		</div>
		
    </div>
  </div>

  <div class="clr"></div>
  	  
  <div class="screen05img"> <img src="images/homescreen-05img.png" class="scale">
    <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
    <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
  </div>
      </div>
    </section>
	    
  </div>
  

  
</div>
<script src="js/cards1.js" type="text/javascript"></script> 
<script>
$(function() {
	var err = false;
	var ifscErr = false;



	$("#addr1").blur(function() {
		$(this).closest(".marrightnone").find("#error-user").remove();
		if($(this).val() == '') {
			$(this).after('<div id="error-user">Address1 is required</div>');
			err = true;
		} else {
			err = false;
		}
	});

	$("#addr1coapp2").blur(function() {
		$(this).closest(".marrightnone").find("#error-user").remove();
		if($(this).val() == '') {
			$(this).after('<div id="error-user">Address1 is required</div>');
			err = true;
		} else {
			err = false;
		}
	});

	$("#addr2").blur(function() {
		$(this).closest(".marrightnone").find("#error-user").remove();
		if($(this).val() == '') {
			$(this).after('<div id="error-user">Address2 is required</div>');
			err = true;
		}	else {
			err = false;
		}
	});

	$("#addr2coapp2").blur(function() {
		$(this).closest(".marrightnone").find("#error-user").remove();
		if($(this).val() == '') 
		{
			$(this).after('<div id="error-user">Address2 is required</div>');
			err = true;
		}	
		else 
		{
			err = false;
		}
	});

	$("#email").blur(function() {
		$(this).closest('.verifymail-field').find("#error-user").remove();
		var eMail = $("#email").val();
		if(eMail == '') {
			$(this).after('<div id="error-user">Email field is required.</div>');
			err = true;
		} else {
			var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
			if(!pattern.test(eMail)) {
				$(this).after('<div id="error-user">Invalid email id.</div>');
				err = true;
			}	else {
				err = false;
			}
		}
	});

	/*$("#emailcoapp2").blur(function() {
		$(this).closest('.verifymail-field').find("#error-user").remove();
		var eMail = $("#email").val();
		if(eMail == '') 
		{
			$(this).after('<div id="error-user">Email field is required.</div>');
			err = true;
		} 
		else 
		{
		//alert();
			var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
			if(!pattern.test(eMail)) 
			{
				$(this).after('<div id="error-user">Invalid email id.</div>');
				err = true;
			}	
			else 
			{
				err = false;
			}
		}
	});*/
	
	$("#ifsccoapp2").blur(function() {
		$(this).closest('.verifymail-field').find("#error-user").remove();
		var ifsccode = $("#ifsccoapp2").val();
		if(ifsccode == '') {
			$(this).after('<div id="error-user">ifsc code field is required.</div>');
			err = true;
		} else {
			var pattern = new RegExp("^[^\s]{4}\d{7}$");
			if(!pattern.test(ifsccode)) {
				$(this).after('<div id="error-user">Invalid ifsc code.</div>');
				err = true;
			}	else {
				err = false;
			}
		}
	});
	
	var flag_app = false;
	
	
	var isSubmit = false;
	
	$("#button").click(function() {
		if(!isSubmit) {
			isSubmit = true;
			$("div[id=error-user]").remove();
			var err = false;
			
			if($("#pincodecoapp2").val() == '') {
				$("#pincodecoapp2").after('<div id="error-user">Pincode is required</div>');
				err = true;
			}
			
			if($("#addr1coapp2").val() == '') {
				$("#addr1coapp2").after('<div id="error-user">Address1 is required</div>');
				err = true;
			}	else {
				err = false;
			}
			
			if($("#addr2coapp2").val() == '') {
				$("#addr2coapp2").after('<div id="error-user">Address2 is required</div>');
				err = true;
			}
		
			if($("#emailcoapp2").val() == '') {
				$("#emailcoapp2").after('<div id="error-user">Email is required</div>');
				err = true;
			}	else {
				var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
				if(!pattern.test($("#emailcoapp2").val())) {
					$('#emailcoapp2').after('<div id="error-user">Invalid email id.</div>');
					err = true;
				}
			}
			
	
			if(!err) {
	
				var coappaddr1 			= $("#addr1coapp2").val();
				var coappaddr2 			= $("#addr2coapp2").val();
				var coappaddr3 			= $("#addr3coapp2").val();
				var coappcity  			= $("#citycoapp2").val();
				var coappcityCode 	= $("#cityCodecoapp2").val();
				var coappstate 			= $("#statecoapp2").val();
				var coappstateCode 	= $("#stateCodecoapp2").val();
				var coapppincode 		= $("#pincodecoapp2").val();
				var coappemail			= $("#emailcoapp2").val();
				
				if($('.naChkLbl').hasClass('activeCheckbox')) {
					var nach = 'checked';
				} else {
					var nach = 'unchecked';
				}
				
				//alert(nach);
	
				$.ajax({
					dataType: 'json',
					url:"ajax/disburse-loan",
					type:"POST",
					data:{
						nach:nach,
						//bank:ifscBnk,
						//acct:ifscAcctNo,
						//ifsc:ifsc,
						//ifscBranch:ifscBranch,
						//cityCode:cityCode,
						//stateCode:stateCode,
	
						coappaddr1:coappaddr1,
						coappaddr2:coappaddr2,
						coappaddr3:coappaddr3,
						coappcity:coappcity,
						coappstate:coappstate,
						coapppincode:coapppincode,
						coappcityCode:coappcityCode,
						coappstateCode,
						coappemail:coappemail,
						appType: 'Borrower'
					},
					success: function(data) {
						console.log(data);
						if(data.status == '1') {
							var temp = $.trim(data.msg);
							if (temp == "success") {
								window.location = 'thank-you';
							} else {
								window.location = 'resetpage';
							}
						} else {
							 $('.docUploadBox').after('<div id="error-user">'+ data.msg +'</div>')
						}
					}
				});
			} else {
				$(".wpv").css('display', 'block');
			}
			isSubmit = false;
		}
	});
	

	/*".coapp_btnsubmit").click(function(){
		var pin1 = $("#pincode").val();
		var pin2 = $("#pincodecoapp2").val();
		if( pin1.length < 6 || pin2.length < 6 ){
		alert("hi")
			$(this).after('<div id="error-user">Invalid Pincode.</div>');
		}
		else{
			$(this).parent().find("#error-user").remove();
		}
			
	});*/
	/*
	$(".coapp_btnsubmit").click(function(){
		var pin = $(".pin_code_app").val();
		if($('.co-app-tab-child:visible').length)
		{
		     if( pin.length < 6 ){
			 pin.after('<div id="error-user">Invalid Pincode.</div>');
			 }
		}
			
	});*/
	
});
</script>
</body>
</html>
