<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	echo "<pre>"; print_r($_SESSION);  echo '</pre>';
	if(!isset($_SESSION['co_applicant_details'])) {
		$interest = xss_filter($_SESSION['CIBIL']['revised_ROI']) / 1200;
	} else {
		$interest = xss_filter($_SESSION['co_applicant_details']['CIBIL']['ROIActual']) / 1200;
	}

	$tenure = $_SESSION['personal_details']['tenure'];
	$emi = ceil($interest * -$_SESSION['personal_details']['appliedloanamt'] * pow((1 + $interest), $tenure) / (1 - pow((1 + $interest), $tenure)));
	
	if($_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual'] > 10) {
		$processing_fee = $_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual'];
	} else {
		$processing_fee = ceil(($_SESSION['co_applicant_details']['CIBIL']['ProcessingFeeActual'] * $_SESSION['personal_details']['appliedloanamt'])/100);
	}
	
	$id_proof_options 					= '';
	$co_app_id_proof_options 		= '';
	$addr_proof_options 				= '';
	$co_app_addr_options				= '';
	$property_ownership_options = '';
	$co_app_property_options		= '';
	
	
	
	$appl_id_proof_upload 		= false;
	$appl_id_proof_html 			= '';
	$co_appl_id_proof_upload 	= false;
	$co_appl_id_proof_html 		= '';
	
	$appl_addr_proof_upload 	= false;
	$appl_addr_proof_html 		= '';
	$co_appl_addr_proof_upload = false;
	$co_appl_addr_proof_html 		= '';
	
	$appl_prop_proof_upload  = false;
	$appl_prop_proof_html 		= '';
	$co_appl_prop_proof_upload  = false;
	$co_appl_prop_proof_html 		= '';
	
	$appl_id_proof_sub_cat 	  = 0;
	$co_appl_id_proof_sub_cat 	  = 0;
	$appl_addr_proof_sub_cat = 0;
	$co_appl_addr_proof_sub_cat = 0;
	
	$appl_prop_proof_sub_cat = 0;
	$co_appl_prop_proof_sub_cat = 0;
	
	if(isset($_SESSION['doc_uploads'])) {
		foreach($_SESSION['doc_uploads'] as $rec) {
			if($rec->CatID == 1) {
				if($rec->ApplicantType == 'APPLICANT') {
					$appl_id_proof_upload = true;
					$appl_id_proof_html .= '<li>'.$rec->ImageName.'</li>';
					$appl_id_proof_sub_cat = $rec->SubCatID;
				} else {
					$co_appl_id_proof_upload = true;
					$co_appl_id_proof_html .= '<li>'.$rec->ImageName.'</li>';
					$co_appl_id_proof_sub_cat = $rec->SubCatID;
				}
				
			}
			if($rec->CatID == 2) {
				if($rec->ApplicantType == 'APPLICANT') {
					$appl_addr_proof_upload = true;
					$appl_addr_proof_html .= '<li>'.$rec->ImageName.'</li>';
					$appl_addr_proof_sub_cat = $rec->SubCatID;
				} else {
					$co_appl_addr_proof_upload = true;
					$co_appl_addr_proof_html .= '<li>'.$rec->ImageName.'</li>';
					$co_appl_addr_proof_sub_cat = $rec->SubCatID;
				}
			}
			if($rec->CatID == 5) {
				if($rec->ApplicantType == 'APPLICANT') {
					$appl_prop_proof_upload = true;
					$appl_prop_proof_html .= '<li>'.$rec->ImageName.'</li>';
					$appl_prop_proof_sub_cat = $rec->SubCatID;
				} else {
					$co_appl_prop_proof_upload = true;
					$co_appl_prop_proof_html .= '<li>'.$rec->ImageName.'</li>';
					$co_appl_prop_proof_sub_cat = $rec->SubCatID;
				}
			}
		}
	}
	
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
		if($appl_id_proof_sub_cat == $id) {
			$id_proof_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$id_proof_options .= '<option value="'.$id.'">'.$value.'</option>';
		}

		if($co_appl_id_proof_sub_cat == $id) {
			$co_app_id_proof_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$co_app_id_proof_options .= '<option value="'.$id.'">'.$value.'</option>';
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
		if($appl_addr_proof_sub_cat == $id) {
			$addr_proof_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$addr_proof_options .= '<option value="'.$id.'">'.$value.'</option>';
		}

		if($co_appl_addr_proof_sub_cat == $id) {
			$co_app_addr_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$co_app_addr_options .= '<option value="'.$id.'">'.$value.'</option>';
		}

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

		if($appl_prop_proof_sub_cat == $id) {
			$property_ownership_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$property_ownership_options .= '<option value="'.$id.'">'.$value.'</option>';
		}

		if($co_appl_prop_proof_sub_cat == $id) {
			$co_app_property_options .= '<option value="'.$id.'" selected="selected">'.$value.'</option>';
		} else {
			$co_app_property_options .= '<option value="'.$id.'">'.$value.'</option>';
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
						}
					};
					_this.parents("#idProofFrm").ajaxForm(options);
				});

				$(".coidProofSubmit").click(function() {
					$("#idProofFrmcoapp2").find(".loader").removeClass('dnone');
					$("#idProofFrmcoapp2").find("#error-user").remove();
					var opt = $("#idProofDoccoapp2").val();
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
								var _uploadTxt = $(".coidProofSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
								$("#idProofFrmcoapp2").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#idProofFrmcoapp2").find(".loader").addClass('dnone');
								$("label[for=file-7coapp2]").find("span").html('No file selected');
								_uploadTxt.addClass('docUploadRe');
								_uploadTxt.find('a').text('Document Uploaded');
										} else {
								$("#idProofFrmcoapp2").find(".loader").addClass('dnone');
								$(".idProofUpload").val('');
								$("label[for=file-7coapp2]").find("span").html('No file selected');
								$("#idProofFrmcoapp2").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
							}
						},
						error: function() {
						}
					};
					_this.parents("#idProofFrmcoapp2").ajaxForm(options);
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

				$(".coaddrProofSubmit").click(function() {
					$("#addrProofFrmcoapp2").find(".loader").removeClass('dnone');
					$("#addrProofFrmcoapp2").find("#error-user").remove();
					var opt = $("#addrProofDoccoapp2").val();
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
								var _uploadTxt = $(".coaddrProofSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
								$("#addrProofFrmcoapp2").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#addrProofFrmcoapp2").find(".loader").addClass('dnone');
								$("label[for=file-8coapp2]").find("span").html('No file selected');
								_uploadTxt.addClass('docUploadRe');
								_uploadTxt.find('a').text('Document Uploaded');
										} else {
								$("#addrProofFrmcoapp2").find(".loader").addClass('dnone');
								$(".addrProofUpload").val('');
								$("label[for=file-8coapp2]").find("span").html('No file selected');
								$("#addrProofFrmcoapp2").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
							}
						},
						error: function() {
						}
					};
					_this.parents("#addrProofFrmcoapp2").ajaxForm(options);
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

				$(".copropOwnSubmit").click(function() {
					$("#propOwnFrmcoapp2").find(".loader").removeClass('dnone');
					$("#propOwnFrmcoapp2").find("#error-user").remove();
					var opt = $("#propOwnDoccoapp2").val();
					var frmId = 'propOwnFrmcoapp2';
					var _this = $(this);
					var options = {
						dataType: 'json',
						data: {form_id: frmId, opt: opt},
						success: function(data) {
						},
						complete: function(response) {
							var jsonObj = $.parseJSON(response.responseText);
							if(jsonObj.msg == 'success') {
								var _uploadTxt = $(".copropOwnSubmit").parents('.accordionContent').prev('.accordionButton').find(".docUpload");
								$("#propOwnFrmcoapp2").find(".docUBul").append('<li>'+jsonObj.name+'</li>').removeClass('dnone');
								$("#propOwnFrmcoapp2").find(".loader").addClass('dnone');
								$("label[for=file-15coapp2]").find("span").html('No file selected');
							_uploadTxt.addClass('docUploadRe');
								_uploadTxt.find('a').text('Document Uploaded');
										} else {
								$("#propOwnFrmcoapp2").find(".loader").addClass('dnone');
								$("label[for=file-15coapp2]").find("span").html('No file selected');
								$("#propOwnFrmcoapp2").find(".loader").after('<div id="error-user">'+ jsonObj.msg +'</div>');
							}
		
						},
						error: function() {
						}
					};
					_this.parents("#propOwnFrmcoapp2").ajaxForm(options);
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
		<div class="dnone"><pre>Request data <br><?php //print_r($_SESSION['request']); ?>Response data <br><?php //print_r($_SESSION['response']); ?></pre></div>
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
							<li class="tablink-1"><a href="javascript:;"><?php echo $_SESSION['personal_details']['applicantname']. ' ' .$_SESSION['personal_details']['lastname'] ;?></a></li>
							<li class="tablink-2"><a href="javascript:;" class="link-active"><?php echo $_SESSION['co_applicant_details']['applicantname']. ' '. $_SESSION['co_applicant_details']['lastname'] ;?></a></li>
						</ul>
						<div class="innerbody-home ipadheight-auto" style="height:auto">
							<div class="eligibleDetail clr">
								<div class="edTop">
									<div>Company Name
										<strong class="strongcom-inner">
											<input type="text" name="textfield" id="textfield" class="companyname-changetop dnone" value="<?php echo xss_filter($_SESSION['personal_details']['companyname']); ?>" disabled />
											<input type="text" name="textfield" id="co_textfield" class="companyname-changetop" value="<?php echo xss_filter($_SESSION['co_applicant_details']['companyName']); ?>" disabled />
										</strong> 
										<div id="error-user">Company name must be more than 3 characters long</div>
									</div>
									<div>Monthly Salary
										<strong class="strong-inner"> <span class="rsmonthly">`</span>
											<input type="text" name="textfield" id="texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop dnone" value="<?php echo to_rupee($_SESSION['personal_details']['salary']); ?>" disabled />
											<input type="text" name="textfield" id="co_texSal" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['co_applicant_details']['monthlySalary']); ?>" disabled />
										</strong>
									</div>
									<div>Current EMI
										<strong class="strong-inner"> <span class="rsmonthly rstotalemi">`</span>
											<input type="text" name="textfield" id="texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop dnone" value="<?php echo to_rupee($_SESSION['personal_details']['obligation']); ?>" disabled />
											<input type="text" name="textfield" id="co_texEmi" maxlength="8" onChange="changSaEm();" onkeypress="return isNumberKey(event)" class="companysallery-widthtop" value="<?php echo to_rupee($_SESSION['co_applicant_details']['currentEmi']); ?>" disabled />
										</strong>
									</div>
								</div>
								<div class="clr"></div>
							</div>
							<div id="updatehide">
								<div class="loan-detailbox">
									<div class="loan-details">Loan Details</div>
									<div class="loan-amount">
										Loan Amount -
										<span class="orange">
											<b class="rupee-symb">`</b> <b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']); ?></b>
										</span> <br>
										Loan Tenure -
										<span class="orange" id="tenure"><?php echo $tenure/12; ?> Years</span> </div>

										<div class="loan-amount loanamout-small">
											Rate of Interest -
											<span class="orange"><?php echo $_SESSION['co_applicant_details']['CIBIL']['ROIActual']; ?>%</span> <br>
											Processing Fees -
											<span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($processing_fee); ?></span> </div>

									<div class="total-emi">EMI - <span class="orange"><b class="rupee-symb">`</b> <b id="emidiv"><?php echo to_rupee($emi); ?></b></span> </div>
									<div class="clr none"></div>
								</div>
							</div>
							<div class="approval-wrap align-left">
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
								<div class="co-app-tab-child centerpanel centerall appl" rel="tablink-1">
									<div class="approval-right-container width100">
										<div class="design18 CodocVerify-main">
											<div class="design18Head">Non-Financial Documents</div>
											<?php if(isset($_SESSION['personal_details']['aadharNo'])): ?>
												<div class="accordionButton">
													<div class="docUpload docUploadRe">Identity Proof <a href="javascript://">EKYC Verified</a></div>
												</div>
											<?php else: ?>
												<div class="accordionButton">
													<?php if($appl_id_proof_upload): ?>
														<div class="docUpload docUploadRe">Identity Proof <a href="javascript:;">Document uploaded</a></div>
													<?php else: ?>
														<div class="docUpload">Identity Proof <a href="javascript:;">upload</a></div>
													<?php endif; ?>	
												</div>
												<div class="accordionContent docUploadBox uploadbgcoapp">
													<div class="docPopupBox" id="dpbIdentity">
														<form id="idProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input"><select id="idProofDoc" rel="<?php echo $appl_id_proof_sub_cat; ?>"><?php echo $id_proof_options; ?></select></label>
															<input type="file" name="idProof" id="file-7" class="inputfile inputfile-6 idProofUpload" data-multiple-caption="{count} files selected" multiple />
															<label for="file-7"><span>No file selected</span><strong>Browse</strong></label>
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit idProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'ID proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
															</div>
															<div class="clr"></div>
															<?php if($appl_id_proof_upload): ?>
																<ul class="docUBul"><li>Documents Uploaded</li><?php echo $appl_id_proof_html; ?></ul>
															<?php else: ?>
																<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
															<?php endif; ?>
														</form>
													</div>
												</div>
											<?php endif; ?>
											
											<?php if(isset($_SESSION['personal_details']['aadharNo'])): ?>
												<div class="accordionButton">
													<div class="docUpload docUploadRe">Address Proof <a href="javascript://">EKYC Verified</a></div>
												</div>
											<?php else: ?>
												<div class="accordionButton">
													<?php if($appl_addr_proof_upload): ?>
														<div class="docUpload docUploadRe">Address Proof <a href="javascript:;">Document uploaded</a></div>
													<?php else: ?>
														<div class="docUpload">Address Proof <a href="javascript:;">upload</a></div>
													<?php endif; ?>	
												</div>
												<div class="accordionContent docUploadBox uploadbgcoapp">
													<div class="docPopupBox" id="dpbAddress">
														<form id="addrProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input">
																<select id="addrProofDoc" rel="<?php echo $appl_addr_proof_sub_cat; ?>"><?php echo $addr_proof_options; ?></select>
															</label>
															<input type="file" name="addrProof" id="file-8" class="addrProofUpload inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
															<label for="file-8"><span>No file selected</span> <strong>Browse</strong></label>
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit addrProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Address proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
															</div>
															<div class="clr"></div>
															<?php if($appl_addr_proof_upload): ?>
																<ul class="docUBul"><li>Documents Uploaded</li><?php echo $appl_addr_proof_html; ?></ul>
															<?php else: ?>
																<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
															<?php endif; ?>
														</form>
													</div>
												</div>
											<?php endif; ?>
					
											<div class="accordionButton">
												<?php if($appl_prop_proof_upload): ?>
													<div class="docUpload docUploadRe">Property Ownership Proof <a href="javascript:;">Document uploaded</a></div>
												<?php else: ?>
													<div class="docUpload">Property Ownership Proof <a href="javascript:;">upload</a></div>
												<?php endif; ?>	
											</div>
											<div class="accordionContent docUploadBox uploadbgcoapp">
												<div class="docPopupBox" id="dpbPropertyOwnership">
													<form id="propOwnFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
														<label class="input">
															<select id="propOwnDoc" rel="<?php echo $appl_prop_proof_sub_cat; ?>"><?php echo $property_ownership_options; ?></select>
														</label>
														<input type="file" name="propOwn" id="file-15" class="inputfile inputfile-6 propOwnUpload" data-multiple-caption="{count} files selected" multiple />
														<label for="file-15"><span>No file selected</span> <strong>Browse</strong></label>
														<input type="submit" name="" value="Upload" class="docPopupBoxSubmit propOwnSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Work');">
														<div class="loaderContainer">
															<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
														</div>
														<div class="clr"></div>
														<?php if($appl_prop_proof_upload): ?>
															<ul class="docUBul"><li>Documents Uploaded</li><?php echo $appl_prop_proof_html; ?></ul>
														<?php else: ?>
															<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
														<?php endif; ?>
													</form>
												</div>
											</div>
											<div class="clr"></div>
										</div>
									</div>
								</div>
								
								
								
								<!-- Co-Applicant Document upload starts -->
								<div class="co-app-tab-child centerpanel centerall co_app" rel="tablink-2">
									<div class="approval-right-container width100">
										<div class="design18 CodocVerify-other">
											<div class="design18Head">Non-Financial Documents</div>
											<?php if(isset($_SESSION['co_applicant_details']['aadharNo'])): ?>
												<div class="accordionButton">
													<div class="docUpload docUploadRe">Identity Proof <a href="javascript://">EKYC Verified</a></div>
												</div>
											<?php else: ?>
												<div class="accordionButton">
													<?php if($co_appl_id_proof_upload): ?>
														<div class="docUpload docUploadRe">Identity Proof <a href="javascript:;">Document uploaded</a></div>
													<?php else: ?>
														<div class="docUpload">Identity Proof <a href="javascript:;">upload</a></div>
													<?php endif; ?>	
												</div>
												<div class="accordionContent docUploadBox uploadbgcoapp">
													<div class="docPopupBox" id="dpbIdentity">
														<form id="idProofFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input">
																<div class="select_valall"></div>
																<select class="select_iconall" id="idProofDoccoapp2" rel="<?php echo $co_appl_id_proof_sub_cat; ?>"><?php echo $co_app_id_proof_options; ?></select>
															</label>
															<input type="file" name="file-7coapp2" id="file-7coapp2" class="inputfile inputfile-6 idProofUpload" data-multiple-caption="{count} files selected" multiple />
															<label for="file-7coapp2"><span>No file selected</span><strong>Browse</strong></label>
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit coidProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'ID proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
															</div>
															<div class="clr"></div>
															<?php if($co_appl_id_proof_upload): ?>
																<ul class="docUBul"><li>Documents Uploaded</li><?php echo $co_appl_id_proof_html; ?></ul>
															<?php else: ?>
																<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
															<?php endif; ?>
														</form>
													</div>
												</div>
											<?php endif; ?>
											<?php if(isset($_SESSION['co_applicant_details']['aadharNo'])): ?>
												<div class="accordionButton">
													<div class="docUpload docUploadRe">Address Proof <a href="javascript://">EKYC Verified</a></div>
												</div>
											<?php else: ?>
												<div class="accordionButton">
													<?php if($co_appl_addr_proof_upload): ?>
														<div class="docUpload docUploadRe">Address Proof <a href="javascript:;">Document uploaded</a></div>
													<?php else: ?>
														<div class="docUpload">Address Proof <a href="javascript:;">upload</a></div>
													<?php endif; ?>	
												</div>
												<div class="accordionContent docUploadBox uploadbgcoapp">
													<div class="docPopupBox" id="dpbAddresscoapp2">
														<form id="addrProofFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
															<label class="input">
																<div class="select_valall"></div>
																<select id="addrProofDoccoapp2" class="select_iconall" rel="<?php echo $co_appl_addr_proof_sub_cat; ?>"><?php echo $co_app_addr_options; ?></select>
															</label>
															<input type="file" name="addrProofcoapp2" id="file-8coapp2" class="addrProofUpload inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
															<label for="file-8coapp2"><span>No file selected</span> <strong>Browse</strong></label>
															<input type="submit" name="" value="Upload" class="docPopupBoxSubmit coaddrProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Address proof');">
															<div class="loaderContainer">
																<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
															</div>
															<div class="clr"></div>
															<?php if($co_appl_addr_proof_upload): ?>
																<ul class="docUBul"><li>Documents Uploaded</li><?php echo $co_appl_addr_proof_html; ?></ul>
															<?php else: ?>
																<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
															<?php endif; ?>
														</form>
													</div>
												</div>
											<?php endif; ?>
											
											<div class="accordionButton">
												<?php if($co_appl_prop_proof_upload): ?>
													<div class="docUpload docUploadRe">Property Ownership Proof <a href="javascript:;">Document uploaded</a></div>
												<?php else: ?>
													<div class="docUpload">Property Ownership Proof <a href="javascript:;">upload</a></div>
												<?php endif; ?>	
											</div>
											<div class="accordionContent docUploadBox uploadbgcoapp">
												<div class="docPopupBox" id="dpbPropertyOwnershipcoapp2">
													<form id="propOwnFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
														<label class="input">
															<div class="select_valall"></div>
															<select id="propOwnDoccoapp2" class="select_iconall" rel="<?php echo $co_appl_prop_proof_sub_cat; ?>"><?php echo $co_app_property_options; ?></select>
														</label>
														<input type="file" name="propOwncoapp2" id="file-15coapp2" class="inputfile inputfile-6 propOwnUpload" data-multiple-caption="{count} files selected" multiple />
														<label for="file-15coapp2"><span>No file selected</span> <strong>Browse</strong></label>
														<input type="submit" name="" value="Upload" class="docPopupBoxSubmit copropOwnSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Work');">
														<div class="loaderContainer">
															<div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
														</div>
														<div class="clr"></div>
														<?php if($co_appl_prop_proof_upload): ?>
															<ul class="docUBul"><li>Documents Uploaded</li><?php echo $co_appl_prop_proof_html; ?></ul>
														<?php else: ?>
															<ul class="docUBul dnone"><li>Documents Uploaded</li></ul>
														<?php endif; ?>
													</form>
												</div>
											</div>
											<div class="clr"></div>
										</div>
									</div>
								</div>
	  
								<div class="verifymainsubmit uploadsubmit">
									<input type="hidden" id="pageNo" value="16" />
									<input type="submit" name="button" id="button" value="PROCEED" class="homesubmit coapp_btnsubmit" />
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
	</body>
</html>
