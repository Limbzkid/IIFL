<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php

	$loan_amount				= xss_filter($_SESSION['personal_details']['appliedloanamt']);
	$tenure							= xss_filter($_SESSION['personal_details']['tenure']);
	$revised_max_amount	= xss_filter($_SESSION['CIBIL']['revised_MaxAmount']);
	$revised_tenure			=	xss_filter($_SESSION['CIBIL']['revised_Tenure']);
	$cibil_tenure				= $revised_tenure/12;
	$revised_emi				= xss_filter($_SESSION['CIBIL']['revised_EMI']);
	$revised_pro_fee		= xss_filter($_SESSION['CIBIL']['revised_ProcessingFee']);
	$revised_roi				= xss_filter($_SESSION['CIBIL']['revised_ROI']);
	
	$interest = $revised_roi / 1200;
	$emi = ceil($interest * -$loan_amount * pow((1 + $interest), $tenure) / (1 - pow((1 + $interest), $tenure)));
		
	$error = false;
	
	if(isset($_POST['submit'])) {

		$loan_amount = xss_filter(num_only($_POST['loanAmount']));
		if(!is_numeric($loan_amount)) {
			$error = true;
		}	
		
		$temp = $_POST['loanTenure'];
		$temp = explode(' ', $temp);
		$loan_tenure = $temp[0];
		
		if(!is_numeric($loan_tenure)) {
			$error = true;
		} 
		
		$_SESSION['personal_details']['appliedloanamt'] = $loan_amount;
		$_SESSION['personal_details']['tenure'] = $loan_tenure;

		$loan_interest = xss_filter($_SESSION['CIBIL']['revised_ROI']);
		$processing_fee = $_SESSION['personal_details']['processing_fee'] = ceil(($_SESSION['CIBIL']['revised_ProcessingFee'] * $loan_amount) / 100);
		$interest = $loan_interest / 1200;
		$emi = ceil($interest * -$loan_amount * pow((1 + $interest), ($loan_tenure*12)) / (1 - pow((1 + $interest), ($loan_tenure*12))));
		$_SESSION['personal_details']['actualloanEMI'] = $emi;
		$total_amt_payable = ceil(($loan_interest / 100) * $loan_amount + ($loan_amount));
		$_SESSION['personal_details']['tenure'] = $loan_tenure * 12;
		
		
		if(!$error) {
			$service_url = API. 'UpdateResivedQuotation';
			$headers = array (
				"Content-Type: application/json"
			);
			
			$curl_post_data = array(
				"CRMLeadID"						=> xss_filter($_SESSION['personal_details']['CRMLeadID']),
				"ProspectNumber"			=> xss_filter($_SESSION['personal_details']['ProspectNumber']),
				"AppliedLoanamount"		=> xss_filter($loan_amount),
				"ROI"									=> xss_filter($_SESSION['CIBIL']['revised_ROI']),
				"Tenure"							=> xss_filter($loan_tenure) * 12,
				"Processingfee"				=> xss_filter($processing_fee),
				"Emi"									=> xss_filter($emi),
				"TotalPayableAmount"	=> xss_filter($total_amt_payable),
				"PageNumber"					=> xss_filter($_POST['webpageno'])
			);
			
			$request_data = json_encode($curl_post_data);
			
	
			
			//echo '<pre>'; print_r($request_data); echo '</pre>';
			$handle = curl_init(); 
			curl_setopt($handle, CURLOPT_URL, $service_url);
			curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($handle, CURLOPT_POSTFIELDS, $request_data);
			
			$curl_response = curl_exec($handle);
			curl_close($handle);
			$decoded = json_decode($curl_response);
			$response = json_decode($decoded);
	
			$_SESSION['request'] = $curl_post_data;
			$_SESSION['response'] = $curl_response;
			
			if(strtolower($response[0]->Status) == 'success') {
				redirect_to('congratulations');
			}
		}
		
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]--> 
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
		<title>IIFL : Sapna Aapka, Loan Hamara</title>
		<link rel="shortcut icon" href="images/favicon.ico">
		<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
		<script type="text/javascript" src="js/css3mediaquery.js"></script>
		<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
		<link href="css/fonts.css" rel="stylesheet" type="text/css">
		<link href="css/iifl.css" rel="stylesheet" type="text/css">
		<link href="css/media.css" rel="stylesheet" type="text/css">
		<script src="js/jquery.easing.min.js" type="text/javascript"></script> 
		<script src="js/function.js" type="text/javascript"></script> 
		<script>
			$(function() {
				$("document").on("click", "#applyBtn", function() {
					$("#submitBtn").click();
				});
				
				/*$( "#SliderPoint3").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"loan",<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $revised_max_amount; ?>,'');
					}
				});*/
			
				/*$( "#SliderPoint4").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"years",1,<?php echo $cibil_tenure ; ?>,' Years');
					}
				});
*/
	$("#SliderPoint3" ).slider({
      //value:parseInt(removeComa("<?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?>")),
      value:parseInt(removeComa($('.myval1').text())),
      min: 100000,
      max: parseInt(removeComa($('.myval1').text())),
      step: 1000,
      slide: function( event, ui ) {
  $( ".inventloan" ).val(adcoma(ui.value));
  setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,ui.value,'');
      }
    });
   // $( ".inventloan" ).val($( "#SliderPoint3" ).slider( "value" ) );

	/*$("#SliderPoint14" ).slider({
      value:5,
      min: 1,
      max: 5,
      step: 5,
      slide: function( event, ui ) {
      	console.log('asdf32145321')
  $( ".tenureinventslide" ).val(ui.value);
      }
    });*/
	$("#SliderPoint4" ).slider({
      //value:parseInt("<?php echo to_rupee($_SESSION['personal_details']['tenure'])/12; ?>"),
      value:5,
      min: 1,
      max: 5,
      step: 1,
      slide: function( event, ui ) {
  $( ".tenureinventslide" ).val(ui.value+" Years");
  setPoint('years','SliderPoint4',1,ui.value,' Years');
		/*setTimeout(function(){
			console.log($("#loan").val());
			$("#SliderPoint3").slider( "value",removeComa($("#loan").val()));
			$('#SliderPoint3').slider("option", "max", removeComa($("#loan").val()));
			console.log($("#loan").val(), $('#nLoanAmt').val());
		},100);*/
      }
    });
  //  $( ".tenureinventslide" ).val($( "#SliderPoint4" ).slider( "value" ) );

				setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $revised_max_amount; ?>,'');
				setPoint('years','SliderPoint4',1,<?php echo $cibil_tenure ; ?>,' Years');
				clickbar("SliderPoint3","loan",<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $revised_max_amount; ?>,"");
				clickbar("SliderPoint4","years",0,<?php echo $cibil_tenure ; ?>," Years");
			
				$(".applyNow").click(function() {
					$("#submitBtn").trigger("click");
				});

				if($("#SliderPoint3, #SliderPoint4 ").length>0){	 	
				 	if(vr2 == "SliderPoint4"){
			 			$("#"+vr2).slider( "value",$("#"+vr1).val().split(" ")[0]);
			 		}else if(vr2 == "SliderPoint3"){
			 			$("#"+vr2).slider( "value",$("#"+vr1).val().split(" ")[0]);
			 		}else{
			 			$("#"+vr2).slider( "value",removeComa($("#"+vr1).val()));
			 		}	 	
				}
			
			});
		
			function chkboxFn(e) {
				if(e.target.checked==true) {
					$("#submitBtn").removeAttr("disabled");
					//window.open('IIFLT&C.pdf', '_blank');
					$("#submitBtn").removeClass("disabled");
				} else {	
					$("#submitBtn").prop("disabled","disabled");
					$("#submitBtn").addClass("disabled");
				}
			}
		
			function calbackEmi() {
				var emiVal = emical(str2int($("#loan").val()),str2int($("#years").val()),<?php echo $revised_roi; ?>);
				$("#emidiv").html(emiVal);
				$("#emiVal").val(emiVal);
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
	</head>
<body class="bodyoverflow" onLoad="form1.reset();">
<!-- Your Quote Pixel -->
<img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Your_Quote=<Your_Quote>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
<!-- End Your Quote Pixel -->

	<div class="dnone">
		ERROR MSG: <?php print_r($_SESSION); ?>
		<pre>
			Request data <br>
			<?php print_r($_SESSION['request']); ?>
			Response data <br>
			<?php print_r($_SESSION['response']); ?>
		</pre>
	</div>
<form id="form1" name="form1" method="post" action="your-quote">
  <!--mainwrap-->
  <div id="main-wrap"> 
    <!--header-->
		<div class="overlay"></div>
  <div class="tnc-popup">
    <div class="tnc-popup-txt">
      <p><strong>TERMS AND CONDITIONS</strong></p>
      <p>1.	I hereby declare that every information already provided by me or as may be provided hereinafter are true and updated. I have not withheld or modified any part of such information. </p>
      <p>2.	I agree that the right to grant any credit facility lies with IIFL at its sole discretion and IIFL holds the right to reject my application at any time. I agree that IIFL shall not be responsible for any such rejection or any delay in intimating its decision.</p>
      <p>3.	I agree and accept that IIFL may in its sole discretion, by itself or through authorised persons, advocate, agencies, bureau, etc. verify any information given, check credit references, employment details and obtain credit reports or other KYC related documents. </p>
      <p>4.	I hereby authorize IIFL to exchange, share or part with all the information as provided by me or as may be provided by me with any of the group companies, banks, financial institutions, credit bureaus, statutory bodies or any entity as may required from time to time as deem fit by IIFL. I shall not hold IIFL liable for sharing any such information.</p>
      <p>5.	I hereby undertake to immediately inform IIFL regarding any change in information provided to IIFL by me.</p>
      <p>6.	I would like to know through telephonic calls/SMSs on my mobile number mentioned in this application form or through any other communication mode, various loan schemes, promotional offers of IIFL and I authorise IIFL, its employees or its agents to act accordingly. I confirm that laws in relations to the unsolicited communications referred in ‘National Do Not Call Registry’ as laid down by Telecom Regulatory Authority of India shall not be applicable to such communications/ telephonic calls/SMSs received from IIFL, its employees or its agents</p>
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
      <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
      <div class="card-container1 effect__random card-container" data-id="1">
  <div class="card__front"> <img src="images/48hours.png" class="scale"><p class="pendulamtxt">Express<br>Personal<br>Loan</p> </div>
  <div class="card__back"><img src="images/48hours.png" class="scale"><p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>  </div>
      </div>
    </div>
      </div>
    </header>
    <!--header--> 
    <!--body home-->
    <div id="msform">
      <section class="body-home-outer myclass screen05bg coapp-uquote-container">
  <div class="innerbody-home heightdesign2 ur-quote-height">
    <div class="eligibleDetail"><!-- eligibleDetail part start -->

      <!-- <div class="edNav">Congratulations<b class="orange"> <?php echo $_SESSION['personal_details']['applicantname']; ?>!</b> <strong>
      						You are eligible for a Loan of</strong> &nbsp;<span class="rsapply">`</span> <?php echo to_rupee($revised_max_amount); ?>
      						<a href="javascript:;" class="applyNow" id="applyBtn">APPLY NOW</a></div> -->
      						<h2 class="headss">Your revised quote</h2>
      <div class="clr"></div>
      <div class="edContant">
  <aside> <span class="edcLine1">Loan Amount</span>
    <span class="rsloanamuont">`</span>
								<!-- <input type="text" name="loanAmount" class="edcLine2 inventloan" value="<?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?>" id="loan"  maxlength="8" onkeypress="return isNumberKey(event)" onChange="setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo num_only($revised_max_amount); ?>,'');"> -->


								<input type="text" name="loanAmount" class="edcLine2 inventloan" value="<?php echo to_rupee($revised_max_amount); ?>" id="loan"  maxlength="8" onkeypress="return isNumberKey(event)" onChange="setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo num_only($revised_max_amount); ?>,'');"> 
    <div class="edcRange no-sliderbg"><span class="edcRangeIcons inventslider" id="SliderPoint3"><!-- <img src="images/slider-icon.png" class="scaleX"> --></span></div>
    <span class="edcRangeLeft"><b>`</b> <?php echo $_SESSION['personal_details']['minloanamt']; ?></span><span class="edcRangeRight"><b>`</b> <span class="myval1"><?php echo to_rupee($revised_max_amount); ?></span></span> <span class="edcAdjust">Adjust the loan amount to an<br>
    EMI that suits you.. </span> </aside>
  <aside> <span class="edcLine1 paddsmall">Loan tenure</span>
    <!-- <input type="text" name="loanTenure" class="edcLine2 tenureinventslide" value="<?php echo to_rupee($_SESSION['personal_details']['tenure'])/12; ?> Years" id="years"  maxlength="7" onkeypress="return isNumberKey(event)" onChange="setPoint('years','SliderPoint4',1,<?php echo $tenure; ?>,' Years');"> -->

    <input type="text" name="loanTenure" class="edcLine2 tenureinventslide" value="5 Years" id="years"  maxlength="7" onkeypress="return isNumberKey(event)" onChange="setPoint('years','SliderPoint4',1,<?php echo $tenure; ?>,' Years');">

    <div class="edcRange no-sliderbg"><span class="edcRangeIcons tenureslide" id="SliderPoint4"><!-- <img src="images/slider-icon.png" class="scale"> --></span></div>
    <span class="edcRangeLeft">1 Years</span><span class="edcRangeRight"><!-- <?php echo $tenure/12; ?> -->5 Years</span> <span class="edcAdjust">Adjust the loan tenure to an<br>
    EMI that suits you.. </span> </aside>
  <div class="clr1"></div>
  <aside class="design2emi">
  <span class="edcLine1">EMI</span><br clear="all" />
				<div class="out-cover-emi">
				<span class="rsloanamuont" style="top:3px;">`</span>
				<span class="edcLine2 edcLine2noBorder" id="emidiv"><span class="fl"><?php echo to_rupee($emi); ?></span> </span>
				</div>
							</aside>
  <div class="clr"></div>
      </div>
      <div class="edUperBott"></div>
      <div class="edBottom">
							<div class="edBottomBox">
    <h1>Rate of Interest</h1>

    <h3 id="roi"><?php echo $_SESSION['CIBIL']['revised_ROI']; ?>%</h3>

    <input type="hidden" id="roiAct" value="<?php echo $_SESSION['CIBIL']['revised_ROI']; ?>" name="roiAct">
  </div>
  <div class="edBottomBox">
    <h1>Processing fee</h1>
    <h3><?php echo $_SESSION['CIBIL']['revised_ProcessingFee']; ?>%</h3>
    <input type="hidden" name="proFeeActual" value="<?php echo $_SESSION['CIBIL']['revised_ProcessingFee']; ?>" id="proFeeActual">
  </div>

  <div class="clr"></div>
  <div class="edBottomTerms">
    <div class="edBottomCheckbox">
      <input type="checkbox" value="1" id="checkboxFiveInput" checked="true" onchange="chkboxFn(event);" name="" />
      <label for="checkboxFiveInput"></label>
    </div>
								<p><a href="javascript:;" class="tnc-btn">I agree to all the terms and conditions</a></p>
  </div>
  <div class="clr"></div>
      </div>
						<input type="hidden" name="webpageno" id="webpageno" value="6" />
      <input type="submit" name="submit" id="submitBtn" value="PROCEED" class="homesubmit">
      <div class="co-app-cta">
      	<span>or</span>
      	<div class="add-co-app-btn"><a href="javascript:;">REMOVE CO-APPLICANT</a></div>
      </div>
      
      <!-- eligibleDetail part close --></div>
    <div class="screen05img ipadposabs"> <img src="images/homescreen-05img.png" class="scale">
      <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
      <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
    </div>
  </div>
      </section>
    </div>
    <!--body home--> 
    
  </div>
  <!--mainwrap-->
</form>
<script src="js/cards1.js" type="text/javascript"></script> 
</body>