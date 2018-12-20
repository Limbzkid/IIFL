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
			var opt = $("#propOwnDoc").val();
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
			}
			else{
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
			/*if(!pinregs.test(pin)) {
				$('#pincodecoapp2').after('<div id="error-user">Invalid Pincode.</div>');
			}*/
			if( pin.length < 6 ){
			//alert(pin)
				$(this).after('<div id="error-user">Invalid Pincode.</div>');
			}
			else{
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
						if(getData.Status == "Success") 
						{
							$(".cocity").css('visibility', 'hidden');
							$(".costate").css('visibility', 'hidden');
							$('#citycoapp2').val(getData.City).attr('readonly', 'readonly');
							$('#statecoapp2').val(getData.State).attr('readonly', 'readonly');
							$('#cityCodecoapp2').val(getData.CityCode);
							$('#stateCodecoapp2').val(getData.StateCode);
						} 
						else 
						{
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
    <div class="approval-wrap align-left">
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
      <div class="co-app-tab-child centerpanel centerall appl" rel="tablink-1">
  <div class="approval-right-container width100">
    <div class="design18">
      <div class="design18Head">Documents and Verifications</div>
      <?php if(isset($_SESSION['co_applicant_details']['aadharNo'])): ?>
      <div class="accordionButton">
        <div class="docUpload docUploadRe">Identity Proof <a href="javascript://">EKYC Verified</a></div>
      </div>
      <?php else: ?>
      <div class="accordionButton">
        <div class="docUpload">Identity Proof <a href="javascript:;">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbIdentity">
    <form id="idProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
        <select id="idProofDoc">
    <?php echo $id_proof_options; ?>
        </select>
      </label>
      <input type="file" name="idProof" id="file-7" class="inputfile inputfile-6 idProofUpload" data-multiple-caption="{count} files selected" multiple />
      <label for="file-7"><span>No file selected</span><strong>Browse</strong></label>
      <input type="submit" name="" value="Upload" class="docPopupBoxSubmit idProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'ID proof');">
      <div class="loaderContainer">
        <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
      </div>
      <div class="clr"></div>
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
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
        <div class="docUpload">Address Proof <a href="javascript:;" id="">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbAddress">
    <form id="addrProofFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
        <select id="addrProofDoc">
    <?php echo $addr_proof_options; ?>
        </select>
      </label>
      <input type="file" name="addrProof" id="file-8" class="addrProofUpload inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
      <label for="file-8"><span>No file selected</span> <strong>Browse</strong></label>
      <input type="submit" name="" value="Upload" class="docPopupBoxSubmit addrProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Address proof');">
      <div class="loaderContainer">
        <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
      </div>
      <div class="clr"></div>
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
      </div>
      <?php endif; ?>
      <div class="accordionButton">
        <div class="docUpload">Bank Statement <a href="javascript:;" class="docUploadButton">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbBankStatement">
    <form id="bankStmtFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
        <select id="bankStmtDoc">
    <?php echo $bank_statement_options; ?>
        </select>
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
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
        <div class="clr"></div>
        <p class="title">Enter Disbursement Account Details</p>
        <div class="detailwrap-line1">
    <div class="detailfields detailfields-veri">
      <label class="input"><span class="pin">IFSC</span>
        <input type="text" id="ifsc" maxlength="11"/>
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
      </div>
      <div class="accordionButton">
        <div class="docUpload">Salary Slip <a href="javascript:;" id="">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbSalarySlip">
    <form id="salSlipFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
        <select id="salSlipDoc">
    <?php echo $salary_slip_options; ?>
        </select>
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
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
      </div>
      <div class="accordionButton">
        <div class="docUpload">Property Ownership Proof <a href="javascript:;" id="">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbPropertyOwnership">
    <form id="propOwnFrm" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
        <select id="propOwnDoc">
    <?php echo $property_ownership_options; ?>
        </select>
      </label>
      <input type="file" name="propOwn" id="file-15" class="inputfile inputfile-6 propOwnUpload" data-multiple-caption="{count} files selected" multiple />
      <label for="file-15"><span>No file selected</span> <strong>Browse</strong></label>
      <input type="submit" name="" value="Upload" class="docPopupBoxSubmit propOwnSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Work');">
      <div class="loaderContainer">
        <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
      </div>
      <div class="clr"></div>
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
      </div>
      <div class="accordionButton">
        <div class="docUpload">Workplace  verification <a href="javascript:;" id="wpv">Verify</a></div>
      </div>
      <div class="accordionContent docUploadBox wpv uploadbgcoapp">
        <div class="datafieldone marrightnone">
    <label class="input"><span class="addr1">Address1*</span>
      <input type="text" id="addr1" maxlength="100"/>
    </label>
        </div>
        <div class="datafieldone marrightnone">
    <label class="input"><span class="addr2">Address2*</span>
      <input type="text" id="addr2" maxlength="100"/>
    </label>
        </div>
        <div class="datafieldone marrightnone">
    <label class="input"><span class="addr3">Address3</span>
      <input type="text" id="addr3" maxlength="100"/>
    </label>
        </div>
        <div class="detailwrap-line1">
    <div class="detailfields detailfields-veri marrightnone">
      <label class="input"><span class="pin">Pincode*</span>
        <input type="text" id="pincode" maxlength="6" class="pin_code_app" onkeypress="return isNumberKey(event)" />
      </label>
    </div>
    <div class="detailfields detailfields-veri marrightnone space_right">
      <label class="input"><span class="city">City*</span>
        <input type="text" id="city" rel=""/>
      </label>
    </div>
    <div class="detailfields detailfields-veri marright-field marrightnone space_right">
      <label class="input"><span class="state">State*</span>
        <input type="text" id="state" rel=""/>
      </label>
    </div>
    <input type="hidden" id="stateCode">
    <input type="hidden" id="cityCode">
    <div class="clr"></div>
    <!--<div class="verifymail-line">Verify official email id to ensure faster disbursal</div>-->
    <div class="veryfymail-box marrightnone">
      <div class="verymailtxt">Work email*</div>
      <div class="verifymail-field">
        <label class="input"><span>Work email id</span>
    <input type="text" id="email" maxlength="50"/>
        </label>
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
    </div>
  </div>
      </div>
      <!-- Co-Applicant Document upload starts -->
      <div class="co-app-tab-child centerpanel centerall co_app" rel="tablink-2">
  <div class="approval-right-container width100">
    <div class="design18">
      <div class="design18Head">Documents and Verifications</div>
      <?php if(isset($_SESSION['co_applicant_details']['aadharNo'])): ?>
      <div class="accordionButton">
        <div class="docUpload docUploadRe">Identity Proof <a href="javascript://">EKYC Verified</a></div>
      </div>
      <?php else: ?>
      <div class="accordionButton">
        <div class="docUpload">Identity Proof <a href="javascript:;">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbIdentity">
    <form id="idProofFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
		<div class="select_valall"></div>
			<select class="select_iconall" id="idProofDoccoapp2">
		<?php echo $id_proof_options; ?>
			</select>
			
      </label>
      <input type="file" name="file-7coapp2" id="file-7coapp2" class="inputfile inputfile-6 idProofUpload" data-multiple-caption="{count} files selected" multiple />
      <label for="file-7coapp2"><span>No file selected</span><strong>Browse</strong></label>
      <input type="submit" name="" value="Upload" class="docPopupBoxSubmit coidProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'ID proof');">
      <div class="loaderContainer">
        <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
      </div>
      <div class="clr"></div>
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
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
        <div class="docUpload">Address Proof <a href="javascript:;" id="">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbAddresscoapp2">
    <form id="addrProofFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
	  <div class="select_valall"></div>
        <select id="addrProofDoccoapp2" class="select_iconall">
    <?php echo $addr_proof_options; ?>
        </select>
      </label>
      <input type="file" name="addrProofcoapp2" id="file-8coapp2" class="addrProofUpload inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple />
      <label for="file-8coapp2"><span>No file selected</span> <strong>Browse</strong></label>
      <input type="submit" name="" value="Upload" class="docPopupBoxSubmit coaddrProofSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Address proof');">
      <div class="loaderContainer">
        <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
      </div>
      <div class="clr"></div>
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
      </div>
      <?php endif; ?>
      <div class="accordionButton">
        <div class="docUpload">Bank Statement <a href="javascript:;" class="docUploadButton">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbBankStatementcoapp2">
    <form id="bankStmtFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
		<div class="select_valall"></div>
        <select id="bankStmtDoccoapp2" class="select_iconall">
    <?php echo $bank_statement_options; ?>
        </select>
      </label>
      <div class="clr"></div>
      <div class="elemCont1">
        <input type="file" name="bnkStmtcoapp2" id="file-9coapp2" class="inputfile inputfile-6 bnkStmtUpload" data-multiple-caption="{count} files selected" multiple />
        <label for="file-9coapp2"><span>No file selected</span> <strong>Browse</strong></label>
        <input type="submit" name="" value="Upload" class="docPopupBoxSubmit cobnkStmtSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Banking');">
        <div class="loaderContainer bankstte_loaderContainer">
    <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
        </div>
      </div>
      <div class="clr"></div>
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
        <div class="clr"></div>
        <!-- <p class="title">Enter Disbursement Account Details</p>
        <div class="detailwrap-line1">
    <div class="detailfields detailfields-veri">
      <label class="input"><span class="pin">IFSC</span>
        <input type="text" id="ifsccoapp2"/>
      </label>
    </div>
    <div class="detailfields detailfields-veri bnkBranch dnone">
      <label class="input"><span class="branch">Bank</span>
        <input type="text" id="branchcoapp2" readonly />
      </label>
    </div>
    <div class="detailfields detailfields-veri marright-field bnkAcct dnone">
      <label class="input"><span class="account">Account Number</span>
        <input type="text" id="accountcoapp2" maxlength="16"/>
      </label>
    </div>
    <div class="clr"></div>
        </div> -->
      </div>
      <div class="accordionButton">
        <div class="docUpload">Salary Slip <a href="javascript:;" id="">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbSalarySlipcoapp2">
    <form id="salSlipFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
		<div class="select_valall"></div>
        <select id="salSlipDoc" class="select_iconall">
    <?php echo $salary_slip_options; ?>
        </select>
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
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
      </div>
      <div class="accordionButton">
        <div class="docUpload">Property Ownership Proof <a href="javascript:;" id="">upload</a></div>
      </div>
      <div class="accordionContent docUploadBox uploadbgcoapp">
        <div class="docPopupBox" id="dpbPropertyOwnershipcoapp2">
    <form id="propOwnFrmcoapp2" action="ajax/do-upload" method="post" enctype="multipart/form-data">
      <label class="input">
		<div class="select_valall"></div>
        <select id="propOwnDoccoapp2" class="select_iconall">
    <?php echo $property_ownership_options; ?>
        </select>
      </label>
      <input type="file" name="propOwncoapp2" id="file-15coapp2" class="inputfile inputfile-6 propOwnUpload" data-multiple-caption="{count} files selected" multiple />
      <label for="file-15coapp2"><span>No file selected</span> <strong>Browse</strong></label>
      <input type="submit" name="" value="Upload" class="docPopupBoxSubmit copropOwnSubmit" onClick="ga('send', 'event', 'Personal Loan', 'Upload', 'Work');">
      <div class="loaderContainer">
        <div class="loader dnone">Please Wait <img src="images/loader.gif"></div>
      </div>
      <div class="clr"></div>
      <ul class="docUBul dnone">
        <li>Documents Uploaded</li>
      </ul>
    </form>
        </div>
      </div>
      <div class="accordionButton">
        <div class="docUpload">Workplace verification <a href="javascript:;" id="wpv">Verify</a></div>
      </div>
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

	$("#ifsc").blur(function() 
	{
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
		if($('.co-app-tab-child:visible').length)
		{
			if($("#addr1coapp2").val() == '') 
			{
				$("#addr1coapp2").after('<div id="error-user">Address1 is required</div>');
				err = true;
			}
			
			if($("#addr2coapp2").val() == '') 
			{
				$("#addr2coapp2").after('<div id="error-user">Address2 is required</div>');
				err = true;
			}
			
			if($("#pincodecoapp2").val() == '') 
			{
				$("#pincodecoapp2").after('<div id="error-user">Pincode is required</div>');
				err = true;
			}
			
		
			if(!err) 
			{
				//alert($('.co-app-tab-child:visible').length);
				//alert("hi");
				$(".co-app-tab-header li a").eq(0).click();
				
			}
		}
		
		
		if($("#addr1").val() == '') 
		{
			$("#addr1").after('<div id="error-user">Address1 is required</div>');
			err = true;
		}	
		else 
		{
			err = false;
		}
		console.log(err)
		
		if($("#addr2").val() == '') 
		{
			$("#addr2").after('<div id="error-user">Address2 is required</div>');
			err = true;
		}
		if($("#pincode").val() == '') 
		{
			$("#pincode").after('<div id="error-user">Pincode is required</div>');
			err = true;
		}
		if($("#citycoapp2").val() == '') 
		{
			$("#citycoapp2").after('<div id="error-user">City is required</div>');
			err = true;
		}
		if($("#statecoapp2").val() == '') 
		{
			$("#statecoapp2").after('<div id="error-user">State is required</div>');
			err = true;
		}
		if($("#city").val() == '') 
		{
			$("#city").after('<div id="error-user">City is required</div>');
			err = true;
		}
		if($("#state").val() == '') 
		{
			$("#state").after('<div id="error-user">State is required</div>');
			err = true;
		}

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
		
		if($("#email").val() == '') 
		{
			$("#email").after('<div id="error-user">Email is required</div>');
			err = true;
			
		}	
		else 
		{
			var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
			if(!pattern.test($("#email").val())) 
			{
				$("#email").after('<div id="error-user">Invalid email id.</div>');
				err = true;
			}
		}
		if($("#emailcoapp2").val() == '') 
		{
			$("#emailcoapp2").after('<div id="error-user">Email is required</div>');
			err = true;
		}	
		else 
		{
			var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
			if(!pattern.test($("#emailcoapp2").val()))
			{
				$('#emailcoapp2').after('<div id="error-user">Invalid email id.</div>');
				err = true;
			}
		}
		
		

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
