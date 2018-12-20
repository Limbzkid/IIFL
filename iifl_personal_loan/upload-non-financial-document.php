<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php if(!isset($_SESSION['personal_details'])) { redirect_to(HOME); } ?>
<?php
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
	$interest = xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
	$tenure 	= $_SESSION['personal_details']['tenure'];
	$emi 			= $_SESSION['personal_details']['actualloanEMI'];
	if($_SESSION['personal_details']['processing_fee'] < 10) {
			$processing_fee = ceil(($_SESSION['personal_details']['revised_ProcessingFee'] * $loan_amount) / 100);
		} else {
			$processing_fee = $_SESSION['personal_details']['processing_fee'];
		}
	
	$id_proof_options 			= '';
	$addr_proof_options 		= '';
	$bank_statement_options = '';
	$salary_slip_options		=	'';
	$property_ownership_options = '';
	
	$id_proof_upload 		= false;
	$id_proof_html 			= '';
	$addr_proof_upload 	= false;
	$addr_proof_html 		= '';
	$prop_proof_upload  = false;
	$prop_proof_html 		= '';
	$id_proof_sub_cat 	= 0;
	$addr_proof_sub_cat = 0;
	$prop_proof_sub_cat = 0;
	
	if(isset($_SESSION['doc_uploads'])) {
		foreach($_SESSION['doc_uploads'] as $rec) {
			if(isset($rec->CatID) && $rec->CatID == 1) {
				$id_proof_upload = true;
				$id_proof_html .= '<li>'.$rec->ImageName.'</li>';
				$id_proof_sub_cat = $rec->SubCatID;
			}
			if(isset($rec->CatID) && $rec->CatID == 2) {
				$addr_proof_upload = true;
				$addr_proof_html .= '<li>'.$rec->ImageName.'</li>';
				$addr_proof_sub_cat = $rec->SubCatID;
			}
			if(isset($rec->CatID) && $rec->CatID == 5) {
				$prop_proof_upload = true;
				$prop_proof_html .= '<li>'.$rec->ImageName.'</li>';
				$prop_proof_sub_cat = $rec->SubCatID;
			}
		}
	}
	
	echo $id_proof_sub_cat. '-'. $addr_proof_sub_cat . '-'. $prop_proof_sub_cat;
	
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
		if($id_proof_sub_cat == $id) {
			$id_proof_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$id_proof_options .= '<option value="'.$id.'">'.$value.'</option>';
		}
		
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
		if($addr_proof_sub_cat == $id) {
			$addr_proof_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$addr_proof_options .= '<option value="'.$id.'">'.$value.'</option>';
		}
		
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
		if($prop_proof_sub_cat == $id) {
			$property_ownership_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$property_ownership_options .= '<option value="'.$id.'">'.$value.'</option>';
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
		<script>
			$(function() {
				$('#checkboxInput1').click(function(){
					$(this).next().toggleClass('activeCheckbox');
				});
				
				$(".idProofSubmit").click(function() {
					$("#idProofFrm").find(".loader").removeClass('dnone');
					$("#idProofFrm").find("#error-user").remove();
					var opt = $("#idProofDoc").val();
					var frmId = $(this).closest('form').attr('id');
					var _this = $(this);
					var options = {
						dataType: 'json',
						data: {form_id: frmId, opt: opt},
						success: function(data) {
						},
						complete: function(response) {
							var jsonObj = $.parseJSON(response.responseText);
							if(jsonObj.msg == 'success') {
								var _uploadTxt = $(".idProofSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
								$("#idProofFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#idProofFrm").find(".loader").addClass('dnone');
								$("label[for=file-7]").find("span").html('No file selected');
								_uploadTxt.addClass('docUploadRe');
								_uploadTxt.find('a').text('Document Uploaded');
							} else {
								$("#idProofFrm").find(".loader").addClass('dnone');
								$(".idProofUpload").val('');
								$("label[for=file-7]").find("span").html('No file selected');
								$("#idProofFrm").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
							}
						},
						error: function() {
							//$("#message").html("<font color='red'> ERROR: unable to upload files</font>");
						}
					};
					_this.parents("#idProofFrm").ajaxForm(options);
				});
				
				$(".addrProofSubmit").click(function() {
					$("#addrProofFrm").find(".loader").removeClass('dnone');
					$("#addrProofFrm").find("#error-user").remove();
					var opt = $("#addrProofDoc").val();
					var frmId = $(this).closest('form').attr('id');
					var _this = $(this);
					var options = {
						dataType: 'json',
						data: {form_id: frmId, opt: opt},
						success: function(data) {
							//console.log('xxx', data);
						},
						complete: function(response) {
							var jsonObj = $.parseJSON(response.responseText);
							if(jsonObj.msg == 'success') {
								var _uploadTxt = $(".addrProofSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
								$("#addrProofFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#addrProofFrm").find(".loader").addClass('dnone');
								$("label[for=file-8]").find("span").html('No file selected');
								_uploadTxt.addClass('docUploadRe');
								_uploadTxt.find('a').text('Document Uploaded');
							} else {
								$("#addrProofFrm").find(".loader").addClass('dnone');
								$(".addrProofUpload").val('');
								$("label[for=file-8]").find("span").html('No file selected');
								$("#addrProofFrm").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
							}
						},
						error: function() {
						}
					};
					_this.parents("#addrProofFrm").ajaxForm(options);
				});
				
				
				$(".propOwnSubmit").click(function() {
					$("#propOwnFrm").find(".loader").removeClass('dnone');
					$("#propOwnFrm").find("#error-user").remove();
					var opt = $("#propOwnDoc").val();
					var frmId = 'propOwnFrm';
					var _this = $(this);
					var options = {
						dataType: 'json',
						data: {form_id: frmId, opt: opt},
						success: function(data) {
						},
						complete: function(response) {
							var jsonObj = $.parseJSON(response.responseText);
							if(jsonObj.msg == 'success') {
								var _uploadTxt = $(".propOwnSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
								$("#propOwnFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#propOwnFrm").find(".loader").addClass('dnone');
								$("label[for=file-15]").find("span").html('No file selected');
								_uploadTxt.addClass('docUploadRe');
								_uploadTxt.find('a').text('Document Uploaded');
							} else {
								$("#propOwnFrm").find(".loader").addClass('dnone');
								$("label[for=file-15]").find("span").html('No file selected');
								$("#propOwnFrm").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
							}

						},
						error: function() {
						}
					};
					_this.parents("#propOwnFrm").ajaxForm(options);
				});
				
				$(document).on('click', '.homesubmit', function() {
					window.location = 'upload-financial-document';
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
		<div class="dnone"><pre>Request data <br><?php print_r($_SESSION['request']); ?>Response data <br><?php print_r($_SESSION['response']); ?></pre></div>
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
								<div class="card__front"> <img src="images/48hours.png" class="scale"><p class="pendulamtxt">Express<br>Personal<br>Loan</p> </div>
								<div class="card__back"><img src="images/48hours.png" class="scale"> <p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>  </div>
							</div>
      </div>
					</div>
  </header>
  <div id="msform">
    <section class="body-home-outer myclass screen04bg">
      <div class="innerbody-home ipadheight-auto" style="height:auto">
  <div class="eligibleDetail">
    <div class="edTop">
      <div>Company Name
										<strong class="strongcom-inner">
											<input type="text" name="textfield" id="textfield" class="companyname-changetop" value="<?php echo xss_filter($_SESSION['personal_details']['companyname']); ?>" disabled />
										</strong>
									</div>
									<div>Monthly Salary
										<strong class="strong-inner">
											<span class="rsmonthly">`</span>
											<input type="text" name="textfield" id="texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['salary']); ?>" disabled />
										</strong>
									</div>
									<div>Current EMI
										<strong class="strong-inner">
											<span class="rsmonthly rstotalemi">`</span>
											<input type="text" name="textfield" id="texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['obligation']); ?>" disabled />
										</strong>
									</div>
    </div>
    <div class="clr"></div>
							</div>
							<div id="updatehide">
								<div class="loan-detailbox">
									<div class="loan-details">Loan Details</div>
									<div class="loan-amount">Loan Amount -
										<span class="orange">
											<b class="rupee-symb">`</b>
											<b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b>
										</span>
										<br>Loan Tenure -
										<span class="orange" id="tenure"><?php echo $_SESSION['personal_details']['tenure']/12; ?> Years</span>
									</div>
									<div class="loan-amount loanamout-small">Rate of Interest -
										<span class="orange"><?php echo $_SESSION['CIBIL']['revised_ROI']; ?>%</span>
										<br>Processing Fees -
										<span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span>
									</div>
									<div class="total-emi">EMI -
										<span class="orange"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b></span>
									</div>  
									<div class="clr none"></div>      
								</div>

							</div>
							<div class="approval-wrap">
								<div class="approval-leftpoints">
									<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>EMI Quote</div>
									<div class="lefticons-line"></div>
									<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>My Details</div>
									<div class="lefticons-line"></div>
									<div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>Eligibility</div>
									<div class="lefticons-line"></div>
									<div class="emi-quoteicon"><img src="images/nonFinance-blue.png" class="scale"><br>Non-Financial Documents</div>
									<div class="lefticons-line"></div>
                  <div class="emi-quoteicon"><img src="images/finance-fade.png" class="scale"><br>Financial<br> Documents</div>
                  <div class="lefticons-line"></div>
                  <div class="emi-quoteicon lasticon"><img src="images/verify-fade.png" class="scale"><br>Work<br> Verification</div>
									<div class="clr"></div>
								</div>
								<div class="approval-right-container">
									<div class="design18 docVerify">
										<div class="design18Head">Non-Financial Documents</div>
											<?php if(isset($_SESSION['customer']['aadharNo'])): ?>
												<div class="accordionButton">
													<div class="docUpload docUploadRe">Identity Proof <a href="javascript://">EKYC Verified</a></div>
												</div>
											<?php else: ?>
												<div class="accordionButton">
													<?php if($id_proof_upload): ?>
														<div class="docUpload docUploadRe">Identity Proof <a href="javascript:;">Document uploaded</a></div>
													<?php else: ?>
														<div class="docUpload">Identity Proof <a href="javascript:;">upload</a></div>
													<?php endif; ?>	
												</div>
												<div class="accordionContent docUploadBox">
													<div class="docPopupBox" id="dpbIdentity">
														<form id="idProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input"><select id="idProofDoc" rel="<?php echo $id_proof_sub_cat; ?>"><?php echo $id_proof_options; ?></select></label>      
															<input type="file" name="idProof" id="file-7" class="inputfile inputfile-6 idProofUpload" data-multiple-caption="{count} files selected" multiple />
															<label for="file-7"><span>No file selected</span><strong>Browse</strong></label>
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit idProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'ID proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
															</div>
															<div class="clr"></div>
																<?php if($id_proof_upload): ?>
																	<ul class="docUBul"><li>Documents Uploaded</li><?php echo $id_proof_html; ?></ul>
																<?php else: ?>
																	<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
																<?php endif; ?>
														</form>
													</div>
												</div>
											<?php endif; ?>

											<?php if(isset($_SESSION['customer']['aadharNo'])): ?>
												<div class="accordionButton">
													<div class="docUpload docUploadRe">Address Proof <a href="javascript://">EKYC Verified</a></div>
												</div>
											<?php else: ?>
												<div class="accordionButton">
													<?php if($addr_proof_upload): ?>
														<div class="docUpload docUploadRe">Address Proof <a href="javascript:;">Document uploaded</a></div>
													<?php else: ?>
														<div class="docUpload">Address Proof <a href="javascript:;">upload</a></div>
													<?php endif; ?>	
												</div>
												
												<div class="accordionContent docUploadBox">
													<div class="docPopupBox" id="dpbAddress">
														<form id="addrProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input"><select id="addrProofDoc" rel="<?php echo $addr_proof_sub_cat; ?>"><?php echo $addr_proof_options; ?></select></label>        
															<input type="file" name="addrProof" id="file-8" class="addrProofUpload inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
															<label for="file-8"><span>No file selected</span> <strong>Browse</strong></label> 
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit addrProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Address proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
															</div>
															<div class="clr"></div>
															<?php if($addr_proof_upload): ?>
																<ul class="docUBul"><li>Documents Uploaded</li><?php echo $addr_proof_html; ?></ul>
															<?php else: ?>
																<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
															<?php endif; ?>
														</form>        
													</div>
												</div>
											<?php endif; ?>
															

											<div class="accordionButton">
												<?php if($prop_proof_upload): ?>
													<div class="docUpload docUploadRe">Property Ownership Proof <a href="javascript:;">Document uploaded</a></div>
												<?php else: ?>
													<div class="docUpload">Property Ownership Proof <a href="javascript:;">upload</a></div>
												<?php endif; ?>	
											</div>
											<div class="accordionContent docUploadBox">
												<div class="docPopupBox" id="dpbPropertyOwnership">
													<form id="propOwnFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
														<label class="input"><select id="propOwnDoc" rel="<?php echo $prop_proof_sub_cat; ?>"><?php echo $property_ownership_options; ?></select></label>      
														<input type="file" name="propOwn" id="file-15" class="inputfile inputfile-6 propOwnUpload" data-multiple-caption="{count} files selected" multiple />
														<label for="file-15"><span>No file selected</span> <strong>Browse</strong></label>
														
														<input type="submit" name="" value="Upload" class="docPopupBoxSubmit propOwnSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Work');">
														<div class="loaderContainer">
															<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
														</div>
														<div class="clr"></div>
	
														<?php if($prop_proof_upload): ?>
															<ul class="docUBul"><li>Documents Uploaded</li><?php echo $prop_proof_html; ?></ul>
														<?php else: ?>
															<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
														<?php endif; ?>
													</form>
												</div>
											</div>
        

    <div class="clr"></div>
    <div class="verifymainsubmit">
												<input type="hidden" id="pageNo" value="8" />
												<input type="submit" name="button" id="button" value="PROCEED" class="homesubmit" onClick="ga('send', 'event', 'Personal Loan', 'Submit', 'Document-complete');" />
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
				</div>
				<script src="js/cards1.js" type="text/javascript"></script>
			</body>
		</html>
