<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php if(!isset($_SESSION['personal_details'])) { redirect_to(HOME); } ?>
<?php
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
	$loan_amount = $_SESSION['personal_details']['appliedloanamt'];
	if(isset($_SESSION['co_applicant_details'])) {
		$interest = xss_filter($_SESSION['co_applicant_details']['CIBIL']['ROIActual']) / 1200;
		$processing_fee = $_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual'];
		if($processing_fee < 5) {
			$processing_fee = ceil(($processing_fee*$loan_amount)/100);
		}
		
	} else {
		$interest = xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
		$processing_fee = $_SESSION['personal_details']['processing_fee'];
	}
	$tenure 	= $_SESSION['personal_details']['tenure'];
	$emi 			= $_SESSION['personal_details']['actualloanEMI'];
	

	
	
	$netbanking_options 				= '';
	$addr_proof_options 				= '';
	$bank_statement_options 		= '';
	$salary_slip_options				=	'';
	$property_ownership_options = '';
	
	$bank_stmt_upload 	= false;
	$bank_stmt_html 		= '';
	$sal_slip_upload 		= false;
	$sal_slip_html 			= '';
	$bank_stmt_sub_cat	= 0;
	$sal_slip_sub_cat 	= 0;
	
	if(isset($_SESSION['doc_uploads'])) {
		foreach($_SESSION['doc_uploads'] as $rec) {
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
				$('#checkboxInput1').click(function(){
					$(this).next().toggleClass('activeCheckbox');
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
								var _uploadTxt = $(".bnkStmtSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
    $("#bankStmtFrm").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#bankStmtFrm").find(".loader").addClass('dnone');
								$("label[for=file-9]").find("span").html('No file selected');
								_uploadTxt.addClass('docUploadRe');
								_uploadTxt.find('a').text('Document Uploaded');
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
    <section class="body-home-outer myclass screen04bg">
      <div class="innerbody-home ipadheight-auto" style="height:auto">
        <div class="eligibleDetail">
          <div class="edTop">
            <div>Company Name <strong class="strongcom-inner">
              <input type="text" name="textfield" id="textfield" class="companyname-changetop" value="<?php echo xss_filter($_SESSION['personal_details']['companyname']); ?>" disabled />
              </strong> </div>
            <div>Monthly Salary <strong class="strong-inner"> <span class="rsmonthly">`</span>
              <input type="text" name="textfield" id="texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['salary']); ?>" disabled />
              </strong> </div>
            <div>Current EMI <strong class="strong-inner"> <span class="rsmonthly rstotalemi">`</span>
              <input type="text" name="textfield" id="texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['personal_details']['obligation']); ?>" disabled />
              </strong> </div>
          </div>
          <div class="clr"></div>
        </div>
        <div id="updatehide">
          <div class="loan-detailbox">
            <div class="loan-details">Loan Details</div>
            <div class="loan-amount">
							Loan Amount -
							<span class="orange">
								<b class="rupee-symb">`</b>
								<b id="loanAmu"><?php echo to_rupee($loan_amount); ?></b>
							</span>
							<br>
              Loan Tenure -
							<span class="orange" id="tenure"><?php echo $_SESSION['personal_details']['tenure']/12; ?> Years</span>
						</div>
            <div class="loan-amount loanamout-small">
							Rate of Interest -
							<?php if(isset($_SESSION['co_applicant_details'])): ?>
								<span class="orange"><?php echo $_SESSION['co_applicant_details']['CIBIL']['ROIActual']; ?>%</span> <br>
							<?php else: ?>
								<span class="orange"><?php echo $_SESSION['CIBIL']['revised_ROI']; ?>%</span> <br>
							<?php endif; ?>
              Processing Fees -
							<span class="orange">
								<b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?>
							</span>
						</div>
            <div class="total-emi">
							EMI -
							<span class="orange">
								<b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b>
							</span>
						</div>
            <div class="clr none"></div>
          </div>
        </div>
        <div class="approval-wrap" id="Applicant">
          <div class="approval-leftpoints">
            <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
              EMI Quote<!--<br>&nbsp;--></div>
            <div class="lefticons-line"></div>
            <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
              My Details<!--<br>&nbsp;--></div>
            <div class="lefticons-line"></div>
            <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
              Eligibility<!--<br>&nbsp;--></div>
            <div class="lefticons-line"></div>
            <div class="emi-quoteicon"><img src="images/emiicon.png" class="scale"><br>
              Non-Financial Documents</div>
            <div class="lefticons-line"></div>
            <div class="emi-quoteicon"><img src="images/finance-blue.png" class="scale"><br>
              Financial Documents<!--<br>&nbsp;--></div>
            <div class="lefticons-line"></div>
            <div class="emi-quoteicon lasticon"><img src="images/verify-fade.png" class="scale"><br>
              Work Verification<!--<br>&nbsp;--></div>
            <div class="clr"></div>
          </div>
          <div class="approval-right-container bankStat">
            <div class="design18">
              <div class="design18Head">Financial Documents</div>
              <!-- <div class="accordionButton1">
                <div class="docUpload">Bank Statement</div>
              </div>-->
              <div class="accordionContent docUploadBox">
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
                  <div class="docPopupBox" id="dpbBankStatement">
                    <form id="bankStmtFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
                      <label class="input">
                      <div class="select_valall"></div>
                        <select id="bankStmtDoc" class="select_iconall" rel="<?php echo $bank_stmt_sub_cat; ?>"><?php echo $bank_statement_options; ?></select>
                      </label>
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
											<?php if($bank_stmt_upload): ?>
												<ul class="docUBul"><li>Documents Uploaded</li><?php echo $bank_stmt_html; ?></ul>
											<?php else: ?>
												<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
											<?php endif; ?>
                    </form>
                  </div>
                  <div class="clr"></div>
                  <p class="title">Enter Disbursement Account Details</p>
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
                  </div>
                  <div class="clr"></div>
                  <div class="docUpload">Salary Slip</div>
                  <div class="docPopupBox" id="dpbSalarySlip">
                    <form id="salSlipFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
                      <label class="input">
                      <div class="select_valall"></div>
                        <select id="salSlipDoc" class="select_iconall" rel="<?php echo $sal_slip_sub_cat; ?>"><?php echo $salary_slip_options; ?></select>
                      </label>
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
							console.log(ifsCode);
							if(ifsCode == '') {
								$(".bnkBranch").addClass('dnone');
								$(".bnkAcct").addClass('dnone');
							}
							$.ajax({
								url:"ajax/verify-ifsc",
								type:"POST",
								data:{ifsc:ifsCode, 'appType': 'Applicant'},
								success: function(msg){
									console.log('qqq', msg);
									if(msg == 0) {
										return false;
									} else {
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
									
								}
							});
						});

						$(".verifymainsubmit .homesubmit").click(function() {
							$("div[id=error-user]").remove();
								var ifsc = $("#ifsc").val();
								if(ifsc) {
									var ifscBnk 		= $('#branch').val();
									var ifscBranch 	= $("#branch").attr("rel");
									var ifscAcctNo 	= $("#account").val();
									if(ifscAcctNo == '') {
										$("#account").after('<div id="error-user">Please enter your Account number</div>');
										return false;
									} else {
										$.ajax({
											url:"ajax/ifsc-account",
											type:"POST",
											data:{'acct_no':ifscAcctNo, 'bank':ifscBnk, 'branch':ifscBranch, 'ifsc':ifsc, 'appType': 'APPLICANT'},
											success: function(msg) {

												
											}
										});
									}
								} else {
									var ifscBnk = '';
									var ifscAcctNo = '';
									var ifscBranch = '';
									var nach = 'unchecked';
								}

								window.location = "workplace-verification";
			
							});
						});
				</script>
</body>
</html>
