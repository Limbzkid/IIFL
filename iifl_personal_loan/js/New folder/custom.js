$(function(){
  
  if($('body').hasClass('home') || $('body').hasClass('calculate_loan')) {
    /*$.ajax({
      type:'POST',
      url: base_url + "ajax/get-city-list",
      dataType: "json",
      success: function(data) {
  //$("#city").autocomplete({source: data});
  $(".selecthome-radiobox").html(data);
      }
  
    });*/
    
    $.ajax({
      type:'GET',
      url: base_url + "xml/CompanyMaster.xml",
      dataType: "xml",
      success: function( xmlResponse ) {
  var companyArr = [];
				var i = 0;
  $(xmlResponse).find('Company').each(function() {
    companyArr[i] = $(this).find('CompanyName').text();
    i++;
  });
  $(".companylist").autocomplete({source: companyArr});
      }
    });
    
  }
  
  $("#loanAmount, #loanTenure").change(function() {
    var amount = $("#loanAmount").val();
    var years = $("#loanTenure").val();
    var interDef = $("#roiDef").val();
    var interAct = $("#roiAct").val();
    $.ajax({
      type:'POST',
      url: base_url + "ajax/calculate-loan-amount",
      dataType: "json",
      data: {'amt': amount, 'time':years, 'int_def': interDef, 'int_act': interAct},
      success: function(response) {
  $("#emiTxt").val(response.emi);
  $("#loanTenure").val(response.time);
  $(".emiDiff").text(response.diff);
      }
    });
  
  });
  
  /*$("#OTP").blur(function() {
    $("#error-user").remove();
    var _this = $(this);
    var otpVal = _this.val();
    if(otpVal == '') {
      errMsg = '<div id="error-user" >Please enter OTP.</div>';
      _this.closest('.companyname').find('.input').after(errMsg);
    }
  });*/
  
  
  $("#aadharNo").blur(function() {
    var _this = $(this);
    var errMsg = '';
    $("#error-user").remove();
    var aadharvalue = _this.val();
    if(aadharvalue == '') {
      errMsg = '<div id="error-user" >Please enter your Aadhar number.</div>';
    }
    if(errMsg) {
      _this.closest('.companyname').find('.input').after(errMsg);
      return false;
    } 
    
    if(errMsg == ''){
      $.ajax({
  url:base_url + "ajax/aadhar",
  type:"POST",
  data:{'aadharcode' : aadharvalue, 'type' :'aadhar'},
  success: function(msg){
    var getData = JSON.parse(msg);
    if(getData.body.Status == 'Y' && getData.head.status_description == 'Success'){
      //alert("Please Enter Otp sent on your mobile");
      $("#aadharNo").after('<div id="error-user">OTP has been sent to your registered mobile number</div>');
    } else {
      $("#aadharNo").after('<div id="error-user">Invalid Aadhar Number</div>');
    }  
  }
      });
    }
    
    
    if($.trim(aadharvalue) != '') {
      
    }
    
  });
  
  $("#verifyOTP").click(function(e) {
    e.preventDefault();
    $("#error-user").remove();
    var otp = $("#OTP").val();
    $.ajax({
	    url:base_url + "ajax/aadhar",
      type:"POST",
      data:{'aadharcodeotp':otp, 'type':'verifyotp'},
      success: function(msg) {
  if(msg == 'Success') {
    $("#error-user").remove();
    window.location = base_url + 'know-your-customer';
  } else {
    $("#error-user").remove();
    if(otp == '') {
      $("#OTP").after('<div id="error-user">Please enter OTP.</div>');
    } else {
       $("#OTP").after('<div id="error-user">OTP verification failed.</div>');
    }
  }
      }
	  });
  });
  
  
  $("#noAadharSbmit").click(function() {
    var loanAmt = $("#loanAmu").text();
    var loanEmi = $("#emidiv").text();
    var loanTenure = $("#tenure").text();
    $.ajax({
	    url:base_url + "ajax/aadhar-update",
      type:"POST",
      data:{'loanAmt':loanAmt, 'loanEmi':loanEmi, 'loanTenure':loanTenure},
      success: function(msg) {
  window.location = base_url + 'know-your-customer';
      }
	  });
  });
  

  
  


	$("#permanentpincode").blur(function() {
    var _this = $(this);
    var parent = _this.parents(".detailwrap-line1");
    var pinvalue = _this.val();
    $.ajax({
      url:base_url + "ajax/verify-pincode",
      type:"POST",
      data:{pincode:pinvalue,type:'pincode'},
      success: function(msg){
  var getData = JSON.parse(msg);
  if(getData.head.status_description == "Success") {
    parent.find("#permanentstate").closest('.detailfields').find('span').css('visibility', 'hidden');
    parent.find("#permanentcity").closest('.detailfields').find('span').css('visibility', 'hidden');
    parent.find("#permanentstate").val(getData.body.State);
    parent.find("#permanentcity").val(getData.body.City);
  } else {
    alert('Pincode verification failed');
  }

      }
    });
  });     

  
  $("#currentpincode").blur(function() {
    var _this = $(this);
    var parent = _this.parents(".detailwrap-line1");
    var pinvalue = _this.val();
    $.ajax({
      url:base_url + "ajax/verify-pincode",
      type:"POST",
      data:{pincode:pinvalue,type:'pincode'},
      success: function(msg){
  var getData = JSON.parse(msg);
  if(getData.head.status_description == "Success") {
    parent.find("#currentstate").closest('.detailfields').find('span').css('visibility', 'hidden');
    parent.find("#currentcity").closest('.detailfields').find('span').css('visibility', 'hidden');
    parent.find("#currentstate").val(getData.body.State);
    parent.find("#currentcity").val(getData.body.City);
  } else {
    alert('Pincode verification failed');
  }
      }
    });
  });
  
  $("#aipFrm").bind('submit', function() {
    var error = false;
    if($('select[name="residencetype"]').val() == 'Residence Type*') {
      $('select[name="residencetype"]').after('<div id="error-user">Please select a Residence Type.</div>');
      error = true;
    }
    if($('select[name="loanPurpose"]').val() == 'Select*') {
      $('select[name="loanPurpose"]').after('<div id="error-user">Please select a Loan Purpose.</div>');
      error = true;
    }
    
    if(error){
      return false;
    }
  });
  
  $("#kycFrm").bind('submit', function() {
    $(".detailfields").each(function() {
      $(this).find('#error-user').remove();
    });
    $(".datafieldone").each(function() {
      $(this).find('#error-user').remove();
    });
    
    var error = false;
    if($("#applicantname").val() == '') {
      $("#applicantname").after('<div id="error-user">First Name is required.</div>');
      error = true;
    }
    if($("#lastname").val() == '') {
      $("#lastname").after('<div id="error-user">Last Name is required.</div>');
      error = true;
    }
    if($("#panno").val() == '') {
      $("#panno").after('<div id="error-user">Pan Card Number is required.</div>');
      error = true;
    }
    if($("#dob").val() == '') {
      $("#dob").after('<div id="error-user">Date of Birth is required.</div>');
      error = true;
    }
    if($("#mobileno").val() == '') {
      $("#mobileno").after('<div id="error-user">Mobile Number is required.</div>');
      error = true;
    }
    if($("#emailId").val() == '') {
      $("#emailId").after('<div id="error-user">Email Id is required.</div>');
      error = true;
    }
    if($("#datepicker-example1").val() == '') {
      $("#datepicker-example1").after('<div id="error-user">Date is required.</div>');
      error = true;
    }
    if($("#totworkexperiance").val() == '') {
      $("#totworkexperiance").after('<div id="error-user">Total Work Experience is required.</div>');
      error = true;
    }
    
    if($("#currentaddress1").val() == '') {
      $("#currentaddress1").after('<div id="error-user">Current Address is required.</div>');
      error = true;
    }
    if($("#currentpincode").val() == '') {
      $("#currentpincode").after('<div id="error-user">Pincode is required.</div>');
      error = true;
    }
    
    if($("#currentstate").val() == '') {
      $("#currentstate").after('<div id="error-user">State is required.</div>');
      error = true;
    }
    if($("#currentcity").val() == '') {
      $("#currentcity").after('<div id="error-user">City is required.</div>');
      error = true;
    }
    if($("#permanentaddress1").val() == '') {
      $("#permanentaddress1").after('<div id="error-user">Permanent Address is required.</div>');
      error = true;
    }
    if($("#permanentpincode").val() == '') {
      $("#permanentpincode").after('<div id="error-user">Pincode is required.</div>');
      error = true;
    }
    if($("#permanentstate").val() == '') {
      $("#permanentstate").after('<div id="error-user">State is required.</div>');
      error = true;
    }
    if($("#permanentcity").val() == '') {
      $("#permanentcity").after('<div id="error-user">City is required.</div>');
      error = true;
    }
    if(error){
      return false;
    }
    
  });
  

  
  
  
  
  
  
  
  
  



}); // document ready ends here