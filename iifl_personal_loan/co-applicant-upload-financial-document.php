<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php

	//echo "<pre>"; print_r($_SESSION); echo '</pre>';
	if(!isset($_SESSION['co_applicant_details'])) 	{
		$interest = xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
	} else {
		$interest = xss_filter($_SESSION['co_applicant_details']['CIBIL']['ROIActual']) / 1200;
	}
	$tenure = $_SESSION['personal_details']['tenure'];
	$emi = ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $tenure) / (1 - pow((1 + $interest), $tenure)));
	if(!isset($_SESSION['co_applicant_details']))	{
		$processing_fee = ceil(($_SESSION['CIBIL']['revised_ProcessingFee']/100) * $_SESSION['personal_details']['appliedloanamt']);
	} else {
		$processing_fee = $_SESSION['co_applicant_details']['CIBIL']['processing_fee'];
	}
	
	$netbanking_options 		= '';
	$bank_statement_options = '';
	$salary_slip_options		=	'';
	
	$bank_stmt_upload 	= false;
	$bank_stmt_html 		= '';
	$sal_slip_upload 		= false;
	$sal_slip_html 			= '';
	$bank_stmt_sub_cat	= 0;
	$sal_slip_sub_cat 	= 0;
	
	if(isset($_SESSION['doc_uploads'])) {
		foreach($_SESSION['doc_uploads'] as $rec) {
			if(isset($rec->CatID)) {
				if($rec->PageNumber == 14 ) {
				if($rec->CatID == 3) {
					$sal_slip_upload 	= true;
					$sal_slip_html 		.= '<li>'.$rec->ImageName.'</li>';
					$sal_slip_sub_cat = $rec->SubCatID;
				}
				if($rec->CatID == 4) {
					$bank_stmt_upload  = true;
					$bank_stmt_html 	.= '<li>'.$rec->ImageName.'</li>';
					$bank_stmt_sub_cat = $rec->SubCatID;
				}
			}
			}
			
		}
	}

	
	$service_url = COMMON_API. 'SearchFetchDropDown';
	$headers = array (
		"Content-Type: application/json"
	);
	$curl_post_data = array("CategoryName"	=> "netbankingFetch");
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
	//echo '<pre>'; print_r($curl_response); echo '</pre>';
	foreach($curl_response->Body->MasterValues as $data) {
		$value = $data->dropdownid;
		$id = $data->dropdownvalue;
		$netbanking_options .= '<option value="'.$id.'">'.$value.'</option>';
	}
	
	$service_url = COMMON_API. 'SearchFetchDropDown';
	$headers = array (
		"Content-Type: application/json"
	);


	
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
		if($bank_stmt_sub_cat == $id) {
			$bank_statement_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$bank_statement_options .= '<option value="'.$id.'">'.$value.'</option>';
		}
		
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
		if($sal_slip_sub_cat == $id) {
			$salary_slip_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$salary_slip_options .= '<option value="'.$id.'">'.$value.'</option>';
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
<script type="text/javascript" src="js/css3mediaquery.js"></script>
<link href="css/fonts.css" rel="stylesheet" type="text/css">
<link href="css/iifl.css" rel="stylesheet" type="text/css">
<link href="css/media.css" rel="stylesheet" type="text/css">
<script src="js/jquery.easing.min.js" type="text/javascript"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/function.js" type="text/javascript"></script>
<script src="js/design18.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>
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

		
		$(".cobnkStmtSubmit").click(function() {
			$("#bankStmtFrmcoapp2").find(".loader").removeClass('dnone');
			$("#bankStmtFrmcoapp2").find("#error-user").remove();
			var _this = $(this);
			var opt = $("#bankStmtDoc").val();
			var frmId = 'bankStmtFrmcoapp2';
			
			var options = {
				dataType: 'json',
				data: {form_id: frmId, opt: opt},
				success: function(data) {
					console.log('xxx', data);
				},
				complete: function(response) {
					var jsonObj = $.parseJSON(response.responseText);
					if(jsonObj.msg == 'success') {
						var _uploadTxt = $(".cobnkStmtSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
  				$("#bankStmtFrmcoapp2").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
						$("#bankStmtFrmcoapp2").find(".loader").addClass('dnone');
						$("label[for=file-9coapp2]").find("span").html('No file selected');
						_uploadTxt.addClass('docUploadRe');
						_uploadTxt.find('a').text('Document Uploaded');
      					} else {
						$("#bankStmtFrmcoapp2").find(".loader").addClass('dnone');
						$(".bnkStmtUpload").val('');
						$("label[for=file-9coapp2]").find("span").html('No file selected');
						$("#bankStmtFrmcoapp2").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
					}
					
				},
				error: function() {
				}
			};
			_this.parents("#bankStmtFrmcoapp2").ajaxForm(options);
		});

		$(".salSlipSubmit").click(function() {
			$("#salSlipFrm").find(".loader").removeClass('dnone');
			$("#salSlipFrm").find("#error-user").remove();
			var _this = $(this);
			var opt = $("#salSlipDoc").val();
			var frmId = 'salSlipFrm';
			var options = {
				dataType: 'json',
				data: {form_id: frmId, opt: opt},
				success: function(data) {
					console.log('xxx', data);
				},
				complete: function(response) {
					var jsonObj = $.parseJSON(response.responseText);
					if(jsonObj.msg == 'success') {
						var _uploadTxt = $(".salSlipSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
  				$("#salSlipFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
						$("#salSlipFrm").find(".loader").addClass('dnone');
						$("label[for=file-12]").find("span").html('No file selected');
						_uploadTxt.addClass('docUploadRe');
						_uploadTxt.find('a').text('Document Uploaded');
      					} else {
						$("#salSlipFrm").find(".loader").addClass('dnone');
						$(".idProofUpload").val('');
						$("label[for=file-12]").find("span").html('No file selected');
						$("#salSlipFrm").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
					}
				},
				error: function() {
					
				}
			};
			_this.parents("#salSlipFrm").ajaxForm(options);
		});

		$(".cosalSlipSubmit").click(function() {
			$("#salSlipFrmcoapp2").find(".loader").removeClass('dnone');
			$("#salSlipFrmcoapp2").find("#error-user").remove();
			var _this = $(this);
			var opt = $("#salSlipDoc").val();
			var frmId = 'salSlipFrmcoapp2';
			var options = {
				dataType: 'json',
				data: {form_id: frmId, opt: opt},
				success: function(data) {
					console.log('xxx', data);
				},
				complete: function(response) {
					var jsonObj = $.parseJSON(response.responseText);
					if(jsonObj.msg == 'success') {
						var _uploadTxt = $(".cosalSlipSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
  				$("#salSlipFrmcoapp2").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
						$("#salSlipFrmcoapp2").find(".loader").addClass('dnone');
						$("label[for=file-12coapp2]").find("span").html('No file selected');
						_uploadTxt.addClass('docUploadRe');
						_uploadTxt.find('a').text('Document Uploaded');
      					} else {
						$("#salSlipFrmcoapp2").find(".loader").addClass('dnone');
						$(".idProofUpload").val('');
						$("label[for=file-12coapp2]").find("span").html('No file selected');
						$("#salSlipFrmcoapp2").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
					}
				},
				error: function() {
					
				}
			};
			_this.parents("#salSlipFrmcoapp2").ajaxForm(options);
			
			
			
		});
				



		
		$(document).on('click', '.homesubmit', function() {
			window.location = 'co-applicant-workplace-verification';
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

	<body class="bodyoverflow">
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
							<div class="card__front"> <img src="images/48hours.png" class="scale"><p class="pendulamtxt">Express<br>Personal<br>Loan</p></div>
							<div class="card__back"><img src="images/48hours.png" class="scale">
								<p class="pendulamtxt">DISBURSAL<br>IN<br>8 HOURS* <br/><small> T&C Apply</small></p>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div id="msform">
				<section class="body-home-outer myclass screen04bg bgpink coappcontainer">
					<div class="heightdesign2 screen5 height-ipad-812" >
						<ul class="co-app-tab-header">
							<!--<li class="tablink-1"><a href="javascript:;"><?php echo $_SESSION['personal_details']['applicantname']. ' ' .$_SESSION['personal_details']['lastname'] ;?></a></li>-->
							<li class="tablink-2"><a href="javascript:;" class="link-active"><?php echo $_SESSION['co_applicant_details']['applicantname']. ' '. $_SESSION['co_applicant_details']['lastname'] ;?></a></li>
						</ul>
						<div class="innerbody-home ipadheight-auto" style="height:auto">
							<div class="eligibleDetail clr">
								<div class="edTop">
									<div>Company Name
										<strong class="strongcom-inner">
											<input type="text" name="textfield" id="co_textfield" class="companyname-changetop" value="<?php echo xss_filter($_SESSION['co_applicant_details']['companyName']); ?>" disabled />
										</strong> 
										<div id="error-user">Company name must be more than 3 characters long</div>
									</div>
									<div>Monthly Salary
										<strong class="strong-inner"> <span class="rsmonthly">`</span>
											<input type="text" name="textfield" id="co_texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['co_applicant_details']['monthlySalary']); ?>" disabled />
										</strong>
									</div>
									<div>Current EMI
										<strong class="strong-inner"> <span class="rsmonthly rstotalemi">`</span>
											<input type="text" name="textfield" id="co_texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['co_applicant_details']['currentEmi']); ?>" disabled />
										</strong>
									</div>
								</div>
								<div class="clr"></div>
							</div>
							<div id="updatehide">
								<div class="loan-detailbox">
									<div class="loan-details">Loan Details</div>
									<div class="loan-amount">Loan Amount -
										<span class="orange"> <b class="rupee-symb">`</b> <b id="loanAmu">
											<?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b>
										</span>
										<br>Loan Tenure -
										<span class="orange" id="tenure">
											<?php echo $_SESSION['personal_details']['tenure']/12; ?> Years
										</span>
									</div>
									<?php if(!isset($_SESSION['co_applicant_details'])) { ?>
										<div class="loan-amount loanamout-small">Rate of Interest -
											<span class="orange"><?php echo $_SESSION['CIBIL']['revised_ROI']; ?>%</span>
											<br>Processing Fees -
											<span class="orange"><b class="rupee-symb">`</b><?php echo to_rupee($processing_fee); ?></span>
										</div>
									<?php } else { ?>
										<div class="loan-amount loanamout-small">Rate of Interest -
											<span class="orange"><?php echo $_SESSION['co_applicant_details']['CIBIL']['ROIActual']; ?>%</span>
											<br>Processing Fees -
											<span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span>
										</div>
									<?php } ?>
										<div class="total-emi">EMI -
											<span class="orange"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b></span>
										</div>
										<div class="clr none"></div>
								</div>
							</div>
							
							<div class="approval-wrap align-left CobankStat" id="COBORROWER">
								<div class="approval-leftpoints">
									<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>EMI Quote</div>
									<div class="lefticons-line"></div>
									<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>My Details</div>
									<div class="lefticons-line"></div>
									<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>Eligibility</div>
									<div class="lefticons-line"></div>
									<div class="emi-quoteicon lasticon"><img src="images/documenticon-big.png" class="scale"><br>Documents</div>
									<div class="clr"></div>
								</div>
								
      <!-- Co-Applicant Document upload starts -->
      <div class="co-app-tab-child centerpanel centerall co_app" rel="tablink-2">
  <div class="design18">
              <div class="design18Head">Financial Documents</div>
              <!-- <div class="accordionButton1">
                <div class="docUpload">Bank Statement</div>
              </div>-->
              <div class="accordionContent docUploadBox uploadbgcoapp">
                <div class="personalinfo-radiobox">
             
									
									<div class="inputcheckbx">
                    <div class="chkpersonal-info">
                      <input name="radioEdu" id="everify" value="everify" type="radio">
                      <label for="everify">e-Verify</label>
                    </div>
										<div class="chkpersonal-info">
                      <input name="radioEdu" id="eStmtUpload" value="eStmtUpload" type="radio">
                      <label for="eStmtUpload">Upload e-Statement</label>
                    </div>
                    <div class="chkpersonal-info">
                      <input name="radioEdu" id="estat" value="estat" type="radio">
                      <label for="estat">Upload scanned documents</label>
                    </div>
                    <div class="clr"></div>
                  </div>
                </div>
                <div class="everifyOptn bankSel">
                  <div class="detailfields">
                    <label class="input">
                    <div class="select_valall"></div>
                    <select id="bankName" name="bankName" class="select_iconall">
                      <option value="">Bank Name</option>
											<?php echo $netbanking_options; ?>
                    </select>
                    </label>
                  </div>
                  <div class="detailfields">
                    <label class="input">
                    <div class="select_valall"></div>
                    <select id="accType" name="accType" class="select_iconall">
                      <option value="">Account Type</option>
											<option value="Current">Current</option>
											<option value="Savings">Savings</option>
                    </select>
                    </label>
                  </div>
                  <div class="clr"></div>
                  <div class="verifymainsubmit" id="NBF"> 
                    <!-- <input type="hidden" id="pageNo" value="8" />-->
                    <!--<input type="submit" name="button" id="button" value="Verify" class="homesubmit" />-->
										<input type="submit" name="eVerSbmt" id="button" value="Verify" class="perfioStart" />
                  </div>
                </div>
								
								<div class="eStatement bankSel">

										<div class="detailfields">
											<label class="input">
											<div class="select_valall"></div>
											<select id="bankName" name="bankName" class="select_iconall">
												<option value="">Bank Name</option>
												<?php echo $netbanking_options; ?>
											</select>
											</label>
										</div>
										<div class="detailfields">
											<label class="input">
											<div class="select_valall"></div>
											<select id="accType" name="accType" class="select_iconall">
												<option value="">Account Type</option>
												<option value="Current">Current</option>
												<option value="Savings">Savings</option>
											</select>
											</label>
										</div>
										<div class="clr"></div>
										<div class="verifymainsubmit" id="ES"> 
											<!-- <input type="hidden" id="pageNo" value="8" />-->
											<input type="submit" name="eVerSbmt" id="button" value="Verify" class="perfioStart" />
										</div>

                </div>
								
								
								
                <div class="scannedDocs">
                  <div class="docUpload">Bank Statement</div>
                  <div class="docPopupBox" id="dpbBankStatementcoapp2">
                    <form id="bankStmtFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
                      <label class="input">
												<div class="select_valall"></div>
                        <select id="bankStmtDoc" class="select_iconall" rel="<?php echo $bank_stmt_sub_cat; ?>"><?php echo $bank_statement_options; ?></select>
                      </label>
                      <div class="clr"></div>
                      <div class="elemCont1">
                        <input type="file" name="bnkStmtcoapp2" id="file-9coapp2" class="inputfile inputfile-6 bnkStmtUpload" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-9coapp2"><span>No file selected</span> <strong>Browse</strong></label>
                        <input type="submit" name="" value="Upload" class="docPopupBoxSubmit cobnkStmtSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Banking');">
                        <div class="loaderContainer">
                          <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
                        </div>
                      </div>
                      <div class="clr"></div>
                      <?php if($bank_stmt_upload): ?>
												<ul class="docUBul"><li>Documents Uploaded</li><?php echo $bank_stmt_html; ?></ul>
											<?php else: ?>
												<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
											<?php endif; ?>
                    </form>
                  </div>
                  <div class="clr"></div>
                  <!--<p class="title">Enter Disbursement Account Details</p>
                  <div class="detailwrap-line1">
                    <div class="detailfields detailfields-veri">
                      <label class="input"><span class="pin">IFSC</span>
                        <input type="text" id="ifsc"/>
                      </label>
                    </div>
                    <div class="detailfields detailfields-veri bnkBranch dnone">
                      <label class="input"><span class="branch">Bank</span>
                        <input type="text" id="branch" readonly />
                      </label>
                    </div>
                    <div class="detailfields detailfields-veri marright-field bnkAcct dnone">
                      <label class="input"><span class="account">Account Number</span>
                        <input type="text" id="account" maxlength="16"/>
                      </label>
                    </div>
                    <div class="clr"></div>
                  </div>-->
                  <div class="clr"></div>
                  <div class="docUpload">Salary Slip</div>
                  <div class="docPopupBox" id="dpbSalarySlipcoapp2">
                    <form id="salSlipFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
                      <label class="input">
												<div class="select_valall"></div>
                        <select id="salSlipDoc" class="select_iconall" rel="<?php echo $sal_slip_sub_cat; ?>"><?php echo $salary_slip_options; ?></select>
                      </label>
                      <!--<div class="docPopupBoxHead2">Please upload salary slip of last 3 months</div>-->
                      <div class="elemCont1">
                        <input type="file" name="salSlipcoapp2" id="file-12coapp2" class="inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-12coapp2"><span>No file selected</span> <strong>Browse</strong></label>
                        <input type="submit" name="3" value="Upload" class="docPopupBoxSubmit cosalSlipSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Salary');">
                        <div class="loaderContainer">
                          <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
                        </div>
                      </div>
                      <div class="clr"></div>
                      <?php if($sal_slip_upload): ?>
												<ul class="docUBul"><li>Documents Uploaded</li><?php echo $sal_slip_html; ?></ul>
											<?php else: ?>
												<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
											<?php endif; ?>
                    </form>
                  </div>
                  <div class="clr"></div>
                  <div class="verifymainsubmit">
                    <input type="hidden" id="pageNo" value="8" />
                    <input type="submit" name="button" id="button" value="SUBMIT" class="homesubmit" onClick="ga('send', 'event', 'Personal Loan', 'Submit', 'Document-complete');" />
                  </div>
                </div>
              </div>
            </div>
  <!-- <div class="verifymainsubmit uploadsubmit">
    <input type="hidden" id="pageNo" value="8" />
    <input type="submit" name="button" id="button" value="SUBMIT" class="homesubmit coapp_btnsubmit" onClick="ga('send', 'event', 'Personal Loan', 'Submit', 'Document-complete');" />
  </div> -->
      </div>
	  
		<!--<div class="verifymainsubmit uploadsubmit">
			<input type="hidden" id="pageNo" value="16" />
			<input type="submit" name="button" id="button" value="SUBMIT" class="homesubmit coapp_btnsubmit" />
		</div>-->
		
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

	$("#ifsc").blur(function() {
		$(this).closest('.detailfields ').find("#error-user").remove();
		var ifsCode = $(this).val();
		if($(this).val() == ''){
			$(this).after('<div id="error-user">ifsc code is required.</div>');
			err = true;
		} 
		else 
		{
			var pattern = new RegExp(/^[^\s]{4}\d{7}$/);
			if(!pattern.test(ifsCode)) 
			{
				$(this).after('<div id="error-user">Invalid ifsc code.</div>');
				err = true;
			}	
			else 
			{
				err = false;
			}
		}

		
		
		if(ifsCode != '') {
			$.ajax({
				url:"ajax/verify-ifsc",
				type:"POST",
				data:{ifsc:ifsCode, 'appType':'Coborrower'},
				success: function(msg){
					var getData = JSON.parse(msg);
					console.log(getData);
					if(getData.Status == "Y") {
						$(".bnkBranch").removeClass('dnone');
						$(".bnkAcct").removeClass('dnone');
						$("#branch").val(getData.BankName);
						$(".branch").css('visibility', 'hidden');
						$("#branch").attr('rel', getData.BankBranch);
						$(".naChkBox").removeClass("dnone");
					} else {
						$("#ifsc").after('<div id="error-user">'+ getData.ErrorMsg +'</div>');
						$(".naChkBox").addClass("dnone");
						$(".naChkLbl").removeClass("activeCheckbox");
						ifscErr = true;
					}
				}
			});
		} 
		else 
		{
			$(".bnkBranch").addClass('dnone');
			$(".bnkAcct").addClass('dnone');
		}
	});
	$("#ifsccoapp2").blur(function() 
	{
		$(this).closest('.detailfields ').find("#error-user").remove();
		var ifsCode = $(this).val();
		if(ifsCode != '') {
			$.ajax({
				url:"ajax/verify-ifsc",
				type:"POST",
				data:{ifsc:ifsCode},
				success: function(msg){
					var getData = JSON.parse(msg);
					console.log(getData);
					if(getData.Status == "Y") 
					{
						$(".bnkBranch").removeClass('dnone');
						$(".bnkAcct").removeClass('dnone');
						$("#branch").val(getData.BankName);
						$(".branch").css('visibility', 'hidden');
						$("#branch").attr('rel', getData.BankBranch);
						$(".naChkBox").removeClass("dnone");
					} 
					else 
					{
						$("#ifsc").after('<div id="error-user">'+ getData.ErrorMsg +'</div>');
						$(".naChkBox").addClass("dnone");
						$(".naChkLbl").removeClass("activeCheckbox");
						ifscErr = true;
					}
				}
			});
		} 
		else 
		{
			$(".bnkBranch").addClass('dnone');
			$(".bnkAcct").addClass('dnone');
		}
	});

	$("#addr1").blur(function() {
		$(this).closest(".marrightnone").find("#error-user").remove();
		if($(this).val() == '') 
		{
			$(this).after('<div id="error-user">Address1 is required</div>');
			err = true;
		} 
		else 
		{
			err = false;
		}
	});

	$("#addr1coapp2").blur(function() {
		$(this).closest(".marrightnone").find("#error-user").remove();
		if($(this).val() == '') 
		{
			$(this).after('<div id="error-user">Address1 is required</div>');
			err = true;
		} 
		else 
		{
			err = false;
		}
	});

	$("#addr2").blur(function() 
	{
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

	$("#addr2coapp2").blur(function() 
	{
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
		if(eMail == '') 
		{
			$(this).after('<div id="error-user">Email field is required.</div>');
			err = true;
		} 
		else 
		{
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
		if(ifsccode == '') 
		{
			$(this).after('<div id="error-user">ifsc code field is required.</div>');
			err = true;
		} 
		else 
		{
			var pattern = new RegExp("^[^\s]{4}\d{7}$");
			if(!pattern.test(ifsccode)) 
			{
				$(this).after('<div id="error-user">Invalid ifsc code.</div>');
				err = true;
			}	
			else 
			{
				err = false;
			}
		}
	});
	
	var flag_app = false;

	$("#button").click(function() {
		$("div[id=error-user]").remove();
		var err = false;

		


		/*
		else
		{
			var pattern = new RegExp("/^([0-9](6,6)+$/");
			if(!pattern.test($("#pincode").val()) 
			{
				$(this).after('<div id="error-user">Invalid Pincode.</div>');
				err = true;
			}	
			else 
			{
				err = false;
			}
		}	*/	


		
		

		if(!err) 
		{
			var addr1 		= $("#addr1").val();
			var addr2 		= $("#addr2").val();
			var addr3 		= $("#addr3").val();
			var city  		= $("#city").val();
			var cityCode 	= $("#cityCode").val();
			var state 		= $("#state").val();
			var stateCode 	= $("#stateCode").val();
			var pincode 	= $("#pincode").val();
			var email		= $("#email").val();
			var ifsc 		= $("#ifsc").val();
			var pageNo		= $("#pageNo").val();

			var coappaddr1 		= $("#addr1coapp2").val();
			var coappaddr2 		= $("#addr2coapp2").val();
			var coappaddr3 		= $("#addr3coapp2").val();
			var coappcity  		= $("#citycoapp2").val();
			var coappcityCode 	= $("#cityCodecoapp2").val();
			var coappstate 		= $("#statecoapp2").val();
			var coappstateCode 	= $("#stateCodecoapp2").val();
			var coapppincode 	= $("#pincodecoapp2").val();
			var coappemail		= $("#emailcoapp2").val();

			if(!ifscErr) 
			{
				if(ifsc != '') 
				{
					var ifscBnk = $('#branch').val();
					var ifscBranch = $("#branch").attr("rel");
					var ifscAcctNo = $("#account").val();
				} 
				else 
				{
					var ifscBnk = '';
					var ifscAcctNo = '';
					var ifscBranch = '';
				}

				if($('.naChkLbl').hasClass('activeCheckbox')) 
				{
					var nach = 'checked';
				} 
				else 
				{
					var nach = 'unchecked';
				}
			}	
			else 
			{
				ifsc	= '';
				var ifscBnk = '';
				var ifscAcctNo = '';
				var ifscBranch = '';
				var nach = 'unchecked';
			}
			$.ajax({
				dataType: 'json',
				url:"ajax/disburse-loan",
				type:"POST",
				data:{addr1:addr1,addr2:addr2,addr3:addr3,city:city,state:state,pin:pincode,email:email,nach:nach,bank:ifscBnk,acct:ifscAcctNo,ifsc:ifsc,ifscBranch:ifscBranch,cityCode:cityCode,stateCode:stateCode,pageNo:pageNo, coappaddr1:coappaddr1, coappaddr2:coappaddr2, coappaddr3:coappaddr3, coappcity:coappcity,coappstate:coappstate,coapppincode:coapppincode,coappcityCode:coappcityCode,coappstateCode,coappemail:coappemail},
				success: function(data) {
					console.log(data);
					if(data.status == '1') 
					{
						var temp = $.trim(data.msg);
						if (temp == "success") 
						{
							window.location = 'thank-you';
						} 
						else 
						{
							window.location = 'resetpage';
						}
					} 
					else 
					{
						for(var x in data.msg) 
						{
							console.log(data.msg[x]);
							var temp = data.msg[x].toString();
							console.log(temp.length);
							temp = temp.split('-');
							console.log(temp[0]);
							var id = temp[0];
							$("#"+id).after('<div id="error-user">'+ temp[1] +'</div>');
							$(".wpv").css('display', 'block');
						}
					}
				}
			});
		} 
		else 
		{
			$(".wpv").css('display', 'block');
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
