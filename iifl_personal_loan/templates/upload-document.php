<?php require_once("includes/functions.php"); ?>
<?php session_start(); ?>
<?php
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
	$interest = xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
	$emi = ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $_SESSION['CIBIL']['revised_Tenure']) / (1 - pow((1 + $interest), $_SESSION['CIBIL']['revised_Tenure'])));
	
	$processing_fee = ceil(($_SESSION['CIBIL']['revised_ProcessingFee']/100) * $_SESSION['personal_details']['appliedloanamt']);
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
	
	//exit;
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
				
				
				/*$("#salSlipDoc, #bankStmtDoc").change(function() {
					var selVal = $(this).val();
					if(selVal == 8 || selVal == 9 || selVal == 12 || selVal == 13) {
      $(".elemCont2, .elemCont3").addClass('dnone');
					} else if (selVal == 10 || selVal == 14) {
						$(".elemCont2").removeClass('dnone');
						$(".elemCont3").addClass('dnone');
    } else if (selVal == 11 || selVal == 15) {
      $(".elemCont2, .elemCont3").removeClass('dnone');
    }
				});*/
				
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
								$("#idProofFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#idProofFrm").find(".loader").addClass('dnone');
								$("label[for=file-7]").find("span").html('No file selected');    
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
							console.log('xxx', data);
						},
						complete: function(response) {
							var jsonObj = $.parseJSON(response.responseText);
							if(jsonObj.msg == 'success') {
								$("#addrProofFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#addrProofFrm").find(".loader").addClass('dnone');
								$("label[for=file-8]").find("span").html('No file selected');
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
								$("#propOwnFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#propOwnFrm").find(".loader").addClass('dnone');
								$("label[for=file-15]").find("span").html('No file selected');
    
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
				
				$(".bnkStmtSubmit").click(function() {
					$("#bankStmtFrm").find(".loader").removeClass('dnone');
					$("#bankStmtFrm").find("#error-user").remove();
					var _this = $(this);
					var opt = $("#bankStmtDoc").val();
					var frmId = 'bankStmtFrm';
					
					var options = {
						dataType: 'json',
						data: {form_id: frmId, opt: opt},
						success: function(data) {
							console.log('xxx', data);
						},
						complete: function(response) {
							var jsonObj = $.parseJSON(response.responseText);
							if(jsonObj.msg == 'success') {
    $("#bankStmtFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#bankStmtFrm").find(".loader").addClass('dnone');
								$("label[for=file-9]").find("span").html('No file selected');
  } else {
								$("#bankStmtFrm").find(".loader").addClass('dnone');
								$(".bnkStmtUpload").val('');
								$("label[for=file-9]").find("span").html('No file selected');
								$("#bankStmtFrm").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
							}
							
						},
						error: function() {
						}
					};
					_this.parents("#bankStmtFrm").ajaxForm(options);
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
    $("#salSlipFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#salSlipFrm").find(".loader").addClass('dnone');
								$("label[for=file-12]").find("span").html('No file selected');
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
				
				$("#pincode").blur(function() {
					$(this).closest('.detailfields').find("#error-user").remove();
					var pin = $(this).val();
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
						$("#pincode").after('<div id="error-user">Please enter a pincode</div>');
						$(".city").css('visibility', 'visible');
						$(".state").css('visibility', 'visible');
						$('#city').val('');
						$('#state').val('');
						
					}
				});
				
				
				
				

			});			
		</script>
		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
	</head>

	<body class="bodyoverflow	">
		<div class="dnone"><pre>Request data <br><?php print_r($_SESSION['request']); ?>Response data <br><?php print_r($_SESSION['response']); ?></pre></div>
			<div id="main-wrap"><!--mainwrap-->
  <header>
    <div class="header-inner knowmore"><!--header-->
      <div class="logo"><img src="images/logo.jpg" class="scale"></div>
      <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
      <div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
      <div class="clr"></div>
      <div class="card-container-outerinner">
  <div class="pendulamline-inner"><img src="images/pendulamline.png" class="scale"></div>
  <div class="card-container1 effect__random card-container" data-id="1">
								<div class="card__front"> <img src="images/48hours.png" class="scale"><p class="pendulamtxt">Express<br>Personal<br>Loan</p> </div>
								<div class="card__back"><img src="images/48hours.png" class="scale"> <p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>  </div>
							</div>
      </div>
					</div>
  </header>
  <div id="msform">
    <section class="body-home-outer myclass screen04bg">
      <div class="innerbody-home" style="height:auto">
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
									<div class="emi-quoteicon lasticon"><img src="images/documenticon-big.png" class="scale"><br>Documents</div>
									<div class="clr"></div>
								</div>
    <div class="approval-right-container">
      <div class="design18">
        <div class="design18Head">Documents and Verifications</div>
											<?php if(isset($_SESSION['customer']['aadharNo'])): ?>
												<div class="accordionButton">
													<div class="docUpload docUploadRe">Identity Proof <a href="javascript://">EKYC Verified</a></div>
												</div>
											<?php else: ?>
												<div class="accordionButton">
													<div class="docUpload">Identity Proof <a href="javascript:;">upload</a></div>
												</div>
												<div class="accordionContent docUploadBox">
													<div class="docPopupBox" id="dpbIdentity">
														<form id="idProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input"><select id="idProofDoc"><?php echo $id_proof_options; ?></select></label>      
															<input type="file" name="idProof" id="file-7" class="inputfile inputfile-6 idProofUpload" data-multiple-caption="{count} files selected" multiple />
															<label for="file-7"><span>No file selected</span><strong>Browse</strong></label>
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit idProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'ID proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
															</div>
															<div class="clr"></div>
															<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
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
													<div class="docUpload">Address Proof <a href="javascript:;" id="">upload</a></div>
												</div>
												<div class="accordionContent docUploadBox">
													<div class="docPopupBox" id="dpbAddress">
														<form id="addrProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input"><select id="addrProofDoc"><?php echo $addr_proof_options; ?></select></label>        
															<input type="file" name="addrProof" id="file-8" class="addrProofUpload inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
															<label for="file-8"><span>No file selected</span> <strong>Browse</strong></label> 
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit addrProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Address proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
															</div>
															<div class="clr"></div>
															<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
														</form>        
													</div>
												</div>
											<?php endif; ?>
															
											<div class="accordionButton">
												<div class="docUpload">Bank Statement <a href="javascript:;" class="docUploadButton">upload</a></div>
											</div>
											<div class="accordionContent docUploadBox">
												<div class="docPopupBox" id="dpbBankStatement">
													<form id="bankStmtFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
														<label class="input"><select id="bankStmtDoc"><?php echo $bank_statement_options; ?></select></label>
														<div class="clr"></div>
														<div class="elemCont1">
															<input type="file" name="bnkStmt" id="file-9" class="inputfile inputfile-6 bnkStmtUpload" data-multiple-caption="{count} files selected" multiple />
															<label for="file-9"><span>No file selected</span> <strong>Browse</strong></label>
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit bnkStmtSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Banking');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
															</div>
															</div>
														<div class="clr"></div>
														<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
													</form>
												</div>
												<div class="clr"></div>
												<p class="title">Enter Disbursement Account Details</p>
												<div class="detailwrap-line1">
													<div class="detailfields detailfields-veri">
														<label class="input"><span class="pin">IFSC</span><input type="text" id="ifsc"/></label>
													</div>
													<div class="detailfields detailfields-veri bnkBranch dnone">
														<label class="input"><span class="branch">Bank</span><input type="text" id="branch" readonly /></label>
													</div>
													<div class="detailfields detailfields-veri marright-field bnkAcct dnone">
														<label class="input"><span class="account">Account Number</span><input type="text" id="account"/></label>
													</div>
													<div class="clr"></div>													
												</div>
											</div>

        
											<div class="accordionButton">
												<div class="docUpload">Salary Slip <a href="javascript:;" id="">upload</a></div>
											</div>
											<div class="accordionContent docUploadBox">
												<div class="docPopupBox" id="dpbSalarySlip">
													<form id="salSlipFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
														<label class="input"><select id="salSlipDoc"><?php echo $salary_slip_options; ?></select></label>      
														<!--<div class="docPopupBoxHead2">Please upload salary slip of last 3 months</div>-->
														<div class="elemCont1">
															<input type="file" name="salSlip" id="file-12" class="inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
															<label for="file-12"><span>No file selected</span> <strong>Browse</strong></label>
															<input type="submit" name="3" value="Upload" class="docPopupBoxSubmit salSlipSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Salary');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
															</div>
														</div>
														<div class="clr"></div>
														<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
													</form>
												</div>
											</div>
											<div class="accordionButton">
												<div class="docUpload">Property Ownership Proof <a href="javascript:;" id="">upload</a></div>
											</div>
											<div class="accordionContent docUploadBox">
												<div class="docPopupBox" id="dpbPropertyOwnership">
													<form id="propOwnFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
														<label class="input"><select id="propOwnDoc"><?php echo $property_ownership_options; ?></select></label>      
														<input type="file" name="propOwn" id="file-15" class="inputfile inputfile-6 propOwnUpload" data-multiple-caption="{count} files selected" multiple />
														<label for="file-15"><span>No file selected</span> <strong>Browse</strong></label>
														
														<input type="submit" name="" value="Upload" class="docPopupBoxSubmit propOwnSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Work');">
														<div class="loaderContainer">
															<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>														
														</div>
														<div class="clr"></div>
														<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
													</form>
												</div>
											</div>
        
											<div class="accordionButton">
												<div class="docUpload">Workplace  verification <a href="javascript:;" id="wpv">Verify</a></div>
											</div>
											<div class="accordionContent docUploadBox wpv">
												<div class="datafieldone marrightnone">
													<label class="input"><span class="addr1">Address1*</span><input type="text" id="addr1"/></label>
												</div>
												<div class="datafieldone marrightnone">
													<label class="input"><span class="addr2">Address2*</span><input type="text" id="addr2"/></label>
												</div>
												<div class="datafieldone marrightnone">
													<label class="input"><span class="addr3">Address3</span><input type="text" id="addr3"/></label>
												</div>
												<div class="detailwrap-line1">
													<div class="detailfields detailfields-veri">
														<label class="input"><span class="pin">Pincode*</span><input type="text" id="pincode"/></label>
													</div>
													<div class="detailfields detailfields-veri">
														<label class="input"><span class="city">City*</span><input type="text" id="city" rel=""/></label>
													</div>
													<div class="detailfields detailfields-veri marright-field">
														<label class="input"><span class="state">State*</span><input type="text" id="state" rel=""/></label>
													</div>
													<input type="hidden" id="stateCode">
													<input type="hidden" id="cityCode">
													<div class="clr"></div>
													<!--<div class="verifymail-line">Verify official email id to ensure faster disbursal</div>-->
													<div class="veryfymail-box">
														<div class="verymailtxt">Work email*</div>
														<div class="verifymail-field">
															<label class="input"><span>Work email id</span><input type="text" id="email"/></label>
														</div>
														<!--<div class="verifybtn">
															<input type="submit" name="" value="Verify" class="uploadverify">
														</div>-->
														<div class="clr"></div>
													</div>
													<div class="docUBprimary naChkBox dnone">
														<aside class="docUBcheckbox">
															<input type="checkbox" name="checkboxInput" id="checkboxInput1" class="naChk"/>
															<label for="checkboxInput1" class="naChkLbl"></label>
														</aside>
														<p><strong>NACH</strong><br>
															<small>Use this address for NACH pick up.</small></p>
													</div>
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
    <div class="verifymainsubmit">
												<input type="hidden" id="pageNo" value="8" />
												<input type="submit" name="button" id="button" value="SUBMIT" class="homesubmit" onClick="ga('send', 'event', 'Personal Loan', 'Submit', 'Document-complete');" />
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
				<script>
					$(function() {
						var err = false;
						var ifscErr = false;
						
						$("#ifsc").blur(function() {
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
							} else {
								$(".bnkBranch").addClass('dnone');
								$(".bnkAcct").addClass('dnone');
							}
						});
								
						
						
						
						
						$("#addr1").blur(function() {
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
						
						$(".verifymainsubmit .homesubmit").click(function() {
							$("div[id=error-user]").remove();
							if($("#addr1").val() == '') {
								$("#addr1").after('<div id="error-user">Address1 is required</div>');
								err = true;
							}	else {
								err = false;
							}
							if($("#addr2").val() == '') {
								$("#addr2").after('<div id="error-user">Address2 is required</div>');
								err = true;
							}	else {
								err = false;
							}
							if($("#pincode").val() == '') {
								$("#pincode").after('<div id="error-user">Pincode is required</div>');
								err = true;
							}	else {
								err = false;
							}
							if($("#email").val() == '') {
								$("#email").after('<div id="error-user">Email is required</div>');
								err = true;
							}	else {
								err = false;
							}
							if(!err) {
    var addr1 		= $("#addr1").val();
								var addr2 		= $("#addr2").val();
								var addr3 		= $("#addr3").val();
								var city  		= $("#city").val();
								var cityCode 	= $("#cityCode").val();
								var state 		= $("#state").val();
								var stateCode = $("#stateCode").val();
								var pincode 	= $("#pincode").val();
								var email			=	$("#email").val();
								var ifsc 			= $("#ifsc").val();
								var pageNo		= $("#pageNo").val();
								if(!ifscErr) {
      if(ifsc != '') {
										var ifscBnk = $('#branch').val();
										var ifscBranch = $("#branch").attr("rel");
										var ifscAcctNo = $("#account").val();
									} else {
										var ifscBnk = '';
										var ifscAcctNo = '';
										var ifscBranch = '';
									}
									
									if($('.naChkLbl').hasClass('activeCheckbox')) {
										var nach = 'checked';
									} else {
										var nach = 'unchecked';
									}
    }	else {
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
									data:{addr1:addr1,addr2:addr2,addr3:addr3,city:city,state:state,pin:pincode,email:email,nach:nach,bank:ifscBnk,acct:ifscAcctNo,ifsc:ifsc,ifscBranch:ifscBranch,cityCode:cityCode,stateCode:stateCode,pageNo:pageNo},
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
											for(var x in data.msg) {
												var temp = data.msg[x].toString();
												temp = temp.split('-');
												console.log(temp[0]);
												var id = temp[0];
												$("#"+id).after('<div id="error-user">'+ temp[1] +'</div>');
												$(".wpv").css('display', 'block');
											}
										}
									}
								});
							} else {
								$(".wpv").css('display', 'block');
							}
						});
					});
				</script>
			</body>
		</html>
