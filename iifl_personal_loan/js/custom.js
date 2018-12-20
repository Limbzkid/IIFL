$(function(){

  var kycErr = false;
  var bdErr = false;
  var cpErr = false;
  var ppErr = false;
  var caErr = false;
  var paErr = false;
  var panErr = false;
  var mnErr = false;
  var lnErr = false;
  var mnErr = false;
  var fnErr = false;
  var weErr = false;
  
  if($('body').hasClass('home') || $('body').hasClass('calculate_loan')) {
    $.ajax({
      type:'GET',
      url: "xml/CompanyMaster.xml",
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
      url: "ajax/calculate-loan-amount",
      dataType: "json",
      data: {'amt': amount, 'time':years, 'int_def': interDef, 'int_act': interAct},
      success: function(response) {
  $("#emiTxt").val(response.emi);
  $("#loanTenure").val(response.time);
  $(".emiDiff").text(response.diff);
      }
    });
  });
  
  $("#OTP").blur(function() {
    $("#error-user").remove();
    var _this = $(this);
    var otpVal = _this.val();
    if(otpVal == '') {
      errMsg = '<div id="error-user" >Please enter OTP.</div>';
      _this.closest('.companyname').find('.input').after(errMsg);
    } else {
      $("#verifyOTP").removeClass("disabled");
    }
  });
  
  $(".resendOtp").click(function() {
    var _this = $(this);
    var errMsg = '';
    $("#error-user").remove();
    var aadharvalue = $("#theOtp").val();
    if(errMsg == ''){
      $.ajax({
  url:"ajax/aadhar",
  type:"POST",
  data:{'aadharcode' : aadharvalue, 'type' :'aadhar'},
  success: function(msg){
    
    if(msg == '0') {
      $("#aadharNo").after('<div id="error-user">Invalid Aadhar Number</div>');
    } else {
      var getData = JSON.parse(msg);
      console.log(getData);
      if(getData.Status == 'Y'){
  $("#theOtp").val(aadharvalue);
  $("#aadharNo").after('<div id="error-user">OTP sent again</div>');
  $(".sceeen4form").eq(1).removeClass('dnone');
  $(".aadharbtn").removeClass('dnone');
  $(".aadhar-tcbox").removeClass('dnone');
      } else {
  $("#aadharNo").after('<div id="error-user">Invalid Aadhar Number</div>');
      } 
    }
  }
      });
    }
  });
  $(".authentication-linerev").hide();
  $("#aadharNo").click(function() {
    var _this = $(this).parent().prev().find('input');
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
        url:"ajax/aadhar",
        type:"POST",
        async: false,
        data:{'aadharcode' : aadharvalue, 'type' :'aadhar'},
        success: function(msg){
            if(msg == 0) 
            {
                $("#aadharNo").before('<div id="error-user" class="invalidaadhar">Invalid Aadhar Number</div>');
            } 
            else 
            {
                var getData = JSON.parse(msg);
                if(getData.Status == 'Y')
                {
                    $("#theOtp").val(aadharvalue);
                    $("#aadharNo").after('<div id="error-user" class="otperror">OTP has been sent to your registered mobile number</div>');
                    $(".sceeen4form").eq(1).removeClass('dnone');
                    $(".aadharbtn").removeClass('dnone');
                    $(".aadhar-tcbox").removeClass('dnone');
                    $(".authentication-linerev").show();
                } 
                else 
                {
                    $("#aadharNo").before('<div id="error-user" class="invalidaadhar">Invalid Aadhar Number</div>');
                }
            }
        }
    });
    }
    if($.trim(aadharvalue) != '') {
      
    }
    
  });
  
  
  var otpClick = false;
  $("#verifyOTP").click(function(e) {
    e.preventDefault();
    if(!$(this).hasClass('disabled')) {
      if(!otpClick) {
        otpClick = true;
        $("#error-user").remove();
        var otp = $("#OTP").val();
        var aadharNo = $("#theOtp").val();
        $.ajax({
          url:"ajax/aadhar",
          type:"POST",
          async: false,
          data:{'aadharcodeotp':otp, 'type':'verifyotp', 'aadharno': aadharNo},
          success: function(msg) {
            if(msg == '0') {
              $("#OTP").after('<div id="error-user">Invalid inputs supplied.</div>');
            } else {
              if($.trim(msg) == 'Y') {
                $("#error-user").remove();
                window.location = 'know-your-customer';
              } else {
                $("#error-user").remove();
                if(otp == '') {
                  $("#OTP").after('<div id="error-user">Please enter OTP.</div>');
                } else {
                  $("#OTP").after('<div id="error-user">OTP verification failed.</div>');
                }
              }
            }
          }
        });
        otpClick = false;
      }
    } else {
      return false;
    }
  });
  
  
  $("#noAadharSbmit").click(function() {
    window.location = 'know-your-customer';
    return false;
    /*var loanAmt = $("#loanAmu").text();
    var loanEmi = $("#emidiv").text();
    var loanTenure = $("#tenure").text();
    $.ajax({
	    url:"ajax/aadhar-update",
      type:"POST",
      data:{'loanAmt':loanAmt, 'loanEmi':loanEmi, 'loanTenure':loanTenure},
      success: function(msg) {
  window.location = 'know-your-customer';
      }
	  });*/
  });
  var otpCoAppClick = false;
  $("#verifyOTPCoApp").click(function(e) {
    e.preventDefault();
    if(!$(this).hasClass('disabled')) {
      if(!otpCoAppClick) {
  otpCoAppClick = true;
  $("#error-user").remove();
  var otp = $("#OTP").val();
  var aadharNo = $("#theOtp").val();
  $.ajax({
    url:"ajax/aadhar",
    type:"POST",
    async: false,
    data:{'aadharcodeotp':otp, 'type':'verifyotp', 'aadharno': aadharNo},
    success: function(msg) {
      if(msg == '0') {
  $("#OTP").after('<div id="error-user">Invalid inputs supplied.</div>');
      } else {
  if($.trim(msg) == 'Y') {
    $("#error-user").remove();
    window.location = 'know-your-co-applicant';
  } else {
    $("#error-user").remove();
    if(otp == '') {
      $("#OTP").after('<div id="error-user">Please enter OTP.</div>');
    } else {
      $("#OTP").after('<div id="error-user">OTP verification failed.</div>');
    }
  }
      }
    }
  });
  otpCoAppClick = false;
      }
    } else {
      return false;
    }
  });

  $("#noAadharSbmitCoApp").click(function() {
    window.location = 'know-your-co-applicant';
    return false;
  });
  
  $("#permanentstate").blur(function() {
    var _this = $(this);
    _this.closest('.detailfields').find("#error-user").remove();
    if($("#permanentstate").val() == '') {
      errMsg = '<div id="error-user" >State is required.</div>';
    }

  });
  
  
  
  
  /*var date1=new Date(2013,5,21);//Remember, months are 0 based in JS
var date2=new Date(2013,9,18);
var year1=date1.getFullYear();
var year2=date2.getFullYear();
var month1=date1.getMonth();
var month2=date2.getMonth();
if(month1===0){ //Have to take into account
  month1++;
  month2++;
}
var numberOfMonths; */


  
  $("#aipFrm").bind('submit', function() {
   /* if($('select[name="residencetype"]').val() == 'Residence Type*') {
      $('select[name="residencetype"]').after('<div id="error-user">Please select a Residence Type.</div>');
      error = true;
    }
    if($('select[name="loanPurpose"]').val() == 'Select*') {
      $('select[name="loanPurpose"]').after('<div id="error-user">Please select a Loan Purpose.</div>');
      error = true;
    }
    
    if(error){
      return false;
    }*/
  });
  
    $("#kycFrm").bind('submit', function() {

        $("#error-user").remove();
        $(".detailfields").each(function() {
            $(this).find('#error-user').remove();
        });
        $(".datafieldone").each(function() {
            $(this).find('#error-user').remove();
        });
        var error = false;
        if($("#totworkexperianceY").is(":visible")) 
        {
            if($("#totworkexperianceY").val() != '' ||  $("#totworkexperianceM").val() != '') 
            {
                var joinDate = $("#datepicker-example1").val();
                var tempDate = joinDate.split('-');
                var curJoinDate = tempDate[0]+','+tempDate[1]+','+tempDate[2];  
                var currentDate = now();
                var temp = currentDate.split('-')
                currentDate = temp[0]+','+temp[1]+','+temp[2];
                var currWorkMonths = monthDiff(curJoinDate,currentDate);
  
                if($("#totworkexperianceY").val() == '') 
                {
                    var totalWorkY = 0;
                } 
                else 
                {
                    var totalWorkY = $("#totworkexperianceY").val() *12;
                }
  
                if ($("#totworkexperianceM").val() == '') 
                {
                    var totalWorkM = 0;
                } 
                else 
                {
                    var totalWorkM = $("#totworkexperianceM").val();
                }
  
                var totalWorkExp = parseInt(totalWorkY) + parseInt(totalWorkM);
                if(currWorkMonths > totalWorkExp) 
                {
                    $("#totworkexperianceM").after('<div id="error-user">Current Work experience cannot be greater than Total experience</div>');
                    error = true;
                }
            }
        }

        if($("#cnamecoapporg").val() == '') {
            $("#cnamecoapporg").after('<div id="error-user">Name of organization is required.</div>');
            error = true;
        } 

        if($("#cnamecoappnature").val() == '') {
            $("#cnamecoappnature").after('<div id="error-user">Nature of business is required.</div>');
            error = true;
        } 

        if($("#cnamecoapp").val() == '') {
    	    $("#cnamecoapp").after('<div id="error-user">Company Name is required.</div>');
            error = true;
        } 
          
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
        if($("#dob").val() == 'Date of Birth*') {
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
    		
    	if($("#datepicker-example2").val() == 'Date of Birth*') {
            $("#datepicker-example2").after('<div id="error-user">Birth Date is required.</div>');
            error = true;
        }

        if($("#datepicker-example1").val() == '') {
		$("#datepicker-example1").next("#error-user").remove();
		//$(this).next("#error-user").css('display','none');
		//alert("hi");
            $("#datepicker-example1").after('<div id="error-user">Joining Date is required.</div>');
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
        if($("#cocurrentpincode").val() == '') {
            $("#cocurrentpincode").after('<div id="error-user">Pincode is required.</div>');
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
        if($("#copermanentpincode").val() == '') {
            $("#copermanentpincode").after('<div id="error-user">Pincode is required.</div>');
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
        
        if(($("#totworkexperianceY:visible").length>0 && $('#totworkexperianceY').val() == '') && ($("#totworkexperianceM:visible").length>0 && $('#totworkexperianceM').val() == '')) {
            $("#totworkexperianceY").after('<span id="error-user">Either Year or Month is required</span>');
            error = true;
        } else {
            $("#totworkexperianceY").parent().find('#error-user').remove();
        }
        
        //console.log(panErr, error, bdErr, cpErr, cpErr, caErr, paErr, lnErr, mnErr, fnErr, weErr);
        //if(error || bdErr || cpErr || ppErr || caErr || paErr || panErr || mnErr || lnErr || mnErr || fnErr){
        if(error || bdErr || cpErr || cpErr || caErr || paErr  || lnErr || mnErr || fnErr || weErr){
          //alert($("#error-user:visible").text());
         // $("#error-user:visible").focus();
          $(window).scrollTop($("#error-user:visible").offset().top-100);
            return false;
        }
    
  });


  
  $("#panno").on('input', function(evt) {
    var input = $(this);
    var start = input[0].selectionStart;
    $(this).val(function (_, val) {
      return val.toUpperCase();
    });
    //input[0].selectionStart = input[0].selectionEnd = start;
  }); 

 $("#cnamecoapporg").blur(function() {
    var fnErr = false;
    $(this).closest('.detailfields').find("#error-user").remove();
    var inputVal = $(this).val();
    var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
    if(inputVal == '' ) {
      $("#cnamecoapporg").after('<div id="error-user">Name of organization is required.</div>');
      fnErr = true;
    } else {
      if($(this).val().length < 3) {
  $("#cnamecoapporg").after('<div id="error-user">Company name must be more than 3 characters long.</div>');
  fnErr = true;
      } 
    }
  });

  $("#cnamecoappnature").blur(function() {
    var fnErr = false;
    $(this).closest('.detailfields').find("#error-user").remove();
    var inputVal = $(this).val();
    var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
    if(inputVal == '' ) {
      $("#cnamecoappnature").after('<div id="error-user">Nature of business is required.</div>');
      fnErr = true;
    } else {
      if(!characterReg.test(inputVal)){
  $("#cnamecoappnature").after('<div id="error-user">Invalid characters in Nature of business.</div>');
  fnErr = true;
      } 
    }
  });

  $("#cnamecoapp").blur(function() {
  //alert();
    var fnErr = false;
    $(this).closest('.detailfields').find("#error-user").remove();
	//$(this).parent().find('span').remove();
	//alert("hi454");
    var inputVal = $(this).val();
    var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
    if(inputVal == '' ) {
      $("#cnamecoapp").after('<div id="error-user">Company Name is required.</div>');
      fnErr = true;
    } else {
      if($(this).val().length < 3) {
	  //alert();
  $("#cnamecoapp").parents('label').after('<div id="error-user">Company name must be more than 3 characters long.</div>');
  fnErr = true;
      } 
    }
  });
  
  
    $("#applicantname").blur(function() {
        var fnErr = false;
        $(this).closest('.detailfields').find("#error-user").remove();
        var inputVal = $(this).val();
        var characterReg = /^\s*[a-zA-Z,.\'\s]+\s*$/;
        if(inputVal == '' ) {
            $("#applicantname").after('<div id="error-user">First Name is required.</div>');
            fnErr = true;
        } else {
            if(!characterReg.test(inputVal)){
                $("#applicantname").after('<div id="error-user">Invalid characters or numbers in First name.</div>');
                fnErr = true;
            }	
        }
        $('#block2, #block3').fadeIn();
    });
    $("#applicantnamecoapp").blur(function() {
        var fnErr = false;
        $(this).closest('.detailfields').find("#error-user").remove();
        var inputVal = $(this).val();
        var characterReg = /^\s*[a-zA-Z,.\'\s]+\s*$/;
        if(inputVal == '' ) {
            $("#applicantnamecoapp").after('<div id="error-user">First Name is required.</div>');
            fnErr = true;
        } else {
            if(!characterReg.test(inputVal)){
                $("#applicantnamecoapp").after('<div id="error-user">Invalid characters or numbers in First name.</div>');
                fnErr = true;
            } 
        }
        $('#block2, #block3').fadeIn();
    });
  
  $("#middlename").blur(function() {
    var mnErr = false;
    $(this).closest('.detailfields').find("#error-user").remove();
    var inputVal = $(this).val();
		var characterReg = /^\s*[a-zA-Z,.\'\s]+\s*$/;
    if(!characterReg.test(inputVal) && inputVal != ''){
      $("#middlename").after('<div id="error-user">Invalid characters or numbers in Middle name.</div>');
      mnErr = true;
    }	
	});
  $("#middlenamecoapp").blur(function() {
    var mnErr = false;
    $(this).closest('.detailfields').find("#error-user").remove();
    var inputVal = $(this).val();
    var characterReg = /^\s*[a-zA-Z,.\'\s]+\s*$/;
    if(!characterReg.test(inputVal) && inputVal != ''){
      $("#middlenamecoapp").after('<div id="error-user">Invalid characters or numbers in Middle name.</div>');
      mnErr = true;
    } 
  });
  
  
  $("#lastname").blur(function() {
    var lnErr = false;
    var inputVal = $(this).val();
    $(this).closest('.detailfields').find("#error-user").remove();
    var inputVal = $(this).val();
		var characterReg = /^\s*[a-zA-Z,.\'\s]+\s*$/;
    if(inputVal == '' ) {
      $("#lastname").after('<div id="error-user">Last Name is required.</div>');
      lnErr = true;
    } else {
      if(!characterReg.test(inputVal)){
  $("#lastname").after('<div id="error-user">Invalid characters or numbers in Last name.</div>');
  lnErr = true;
      }	
    }
	});

  $("#lastnamecoapp").blur(function() {
    var lnErr = false;
    var inputVal = $(this).val();
    $(this).closest('.detailfields').find("#error-user").remove();
    var inputVal = $(this).val();
    var characterReg = /^\s*[a-zA-Z,.\'\s]+\s*$/;
    if(inputVal == '' ) {
      $("#lastnamecoapp").after('<div id="error-user">Last Name is required.</div>');
      lnErr = true;
    } else {
      if(!characterReg.test(inputVal)){
  $("#lastnamecoapp").after('<div id="error-user">Invalid characters or numbers in Last name.</div>');
  lnErr = true;
      } 
    }
  });
  
  
  $("#mobileno").blur(function() {
    var mnErr = false;
    var phoneVal = $(this).val();
    $(this).closest('.detailfields').find("#error-user").remove();
		var phoneregs = /^[7-9][0-9]{9}$/;
    if(phoneVal == '') {
      $('#mobileno').after('<div id="error-user">Mobile Number is required.</div>');
      mnErr = true;
    } else {
      if(!phoneregs.test(phoneVal)) {
  $('#mobileno').after('<div id="error-user">Invalid Mobile Number.</div>');
  mnErr = true;
      } 
    }
  });
  
  $("#alternatemobileno").blur(function() {
    var anErr = false;
    var phoneVal = $(this).val();
    $(this).closest('.detailfields').find("#error-user").remove();
		var phoneregs = /^[7-9][0-9]{9}$/;
    if(!phoneregs.test(phoneVal) && $(this).val() != '') {
      $('#alternatemobileno').after('<div id="error-user">Invalid Mobile Number.</div>');
      anErr = true;
    }
  });
  
  
  var panClick = false;
  $("#panno").blur(function() {
    if(!panClick) {
      panClick = true;
      var panNo = $(this).val();
      $(this).closest('.detailfields').find("#error-user").remove();
      var panregs = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
      if(panNo == '') {
        $('#panno').after('<div id="error-user">PAN Card number is required.</div>');
        panErr = true;
      } else {
        if(!panregs.test(panNo) && $(this).val() != '') {
          $('#panno').after('<div id="error-user">Invalid PAN Card number.</div>');
          panErr = true;
        } else {
          $.ajax({
            url:"ajax/verify-pancard",
            type:"POST",
            //async:false,
            data:{panNo:panNo},
            success: function(msg) {
              var getData = JSON.parse(msg);
              //console.log(msg);
              if(getData.Status == "N") {
                $('#panno').after('<div id="error-user">'+getData.ErrorMsg+'</div>');
                panErr = true;
              } else {
                panErr = false;
              }
              panClick = false;
            }
          });
        }
      }
    }
  });
  
  $("#permanentaddress1").blur(function() {
    var paErr = false;
    $(this).closest('.datafieldone').find("#error-user").remove();
    if ($(this).val() == '') {
      $('#permanentaddress1').after('<div id="error-user">Address is required.</div>');
      paErr = true;
    } else ;
  });
  
  
  
  $("#currentaddress1").blur(function() {
    var caErr = false;
    $(this).closest('.datafieldone').find("#error-user").remove();
    if ($(this).val() == '') {
      $('#currentaddress1').after('<div id="error-user">Address is required.</div>');
      caErr = true;
    } 
  });
  
  $("#permanentpincode").blur(function() {
    var _this = $(this);
    _this.closest('.detailfields').find("#error-user").remove();
    var parent = _this.parents(".detailwrap-line1");
    var pinvalue = _this.val();
    var addGrp = parent.attr('id');
    var pin = $(this).val();
   // var pinregs = /^[0-9]{1,6}$/;
   var pinregs = /^[1-9][0-9]{5}$/;
    if(pin == '') {
      $('#permanentpincode').after('<div id="error-user">Pincode is required.</div>');
      ppErr = true;
    } else {
      if(!pinregs.test(pin)) {
  $('#permanentpincode').after('<div id="error-user">Invalid Pincode.</div>');
  ppErr = true;
      } else {
  $.ajax({
    url:"ajax/verify-pincode",
    type:"POST",
    data:{pincode:pinvalue,type:'pincode', grp: addGrp},
    success: function(msg){
      var getData = JSON.parse(msg);
      if(getData.Status == "Success") {
  parent.find("#permanentstate").closest('.detailfields').find('span').css('visibility', 'hidden');
  parent.find("#permanentcity").closest('.detailfields').find('span').css('visibility', 'hidden');
  parent.find("#permanentstate").val(getData.State);
  parent.find("#permanentcity").val(getData.City);
  parent.find("#permanentcity").closest('.detailfields').find('#error-user').remove();
  parent.find("#permanentstate").closest('.detailfields').find('#error-user').remove();
  ppErr = false;
      } else {
  parent.find("#permanentstate").closest('.detailfields').find('span').css('visibility', 'visible');
  parent.find("#permanentcity").closest('.detailfields').find('span').css('visibility', 'visible');
  $("#permanentcity").val('');
  $("#permanentstate").val('');
  ppErr = true;
      }
    }
  });
      }
    }
  });
$("#copermanentpincode").blur(function() {
    var _this = $(this);
    _this.closest('.detailfields').find("#error-user").remove();
    var parent = _this.parents(".detailwrap-line1");
    var pinvalue = _this.val();
    var addGrp = parent.attr('id');
    var pin = $(this).val();
    var pinregs = /^[1-9][0-9]{5}$/;
    if(pin == '') {
        $('#copermanentpincode').after('<div id="error-user">Pincode is required.</div>');
        ppErr = true;
    } 
    else 
    {
        if(!pinregs.test(pin)) 
        {
            console.log(1)
            $('#copermanentpincode').after('<div id="error-user">Invalid Pincode.</div>');
            ppErr = true;
        } 
        else 
        {
            $.ajax({
            url:"ajax/verify-pincode",
            type:"POST",
            data:{pincode:pinvalue,type:'pincode', grp: addGrp},
            success: function(msg){
                var getData = JSON.parse(msg);
                if(getData.Status == "Success") 
                {
                    parent.find("#permanentstate").closest('.detailfields').find('span').css('visibility', 'hidden');
                    parent.find("#permanentcity").closest('.detailfields').find('span').css('visibility', 'hidden');
                    parent.find("#permanentstate").val(getData.State);
                    parent.find("#permanentcity").val(getData.City);
                    parent.find("#permanentcity").closest('.detailfields').find('#error-user').remove();
                    parent.find("#permanentstate").closest('.detailfields').find('#error-user').remove();
                    ppErr = false;
                } 
                else 
                {
                    parent.find("#permanentstate").closest('.detailfields').find('span').css('visibility', 'visible');
                    parent.find("#permanentcity").closest('.detailfields').find('span').css('visibility', 'visible');
                    $("#permanentcity").val('');
                    $("#permanentstate").val('');
                    ppErr = true;
                }
            }
            });
        }
    }
});
  
   
  $("#currentpincode").blur(function() {
    var _this = $(this);
    _this.closest('.detailfields').find("#error-user").remove();
    var parent = _this.parents(".detailwrap-line1");
    var pinvalue = _this.val();
    var addGrp = parent.attr('id');
    var pin = $(this).val();
    var pinregs = /^[1-9][0-9]{5}$/;
    if(pin == '') {
        $('#currentpincode').after('<div id="error-user">Pincode is required.</div>');
        cpErr = true;
    } 
    else 
    {
        if(!pinregs.test(pin)) 
        {
            $('#currentpincode').after('<div id="error-user">Invalid Pincode.</div>');
            cpErr = true;
        } 
        else 
        {
            $.ajax({
            url:"ajax/verify-pincode",
            type:"POST",
            data:{pincode:pinvalue,type:'pincode',grp: addGrp},
            success: function(msg){
            var getData = JSON.parse(msg);
                if(getData.Status == "Success") 
                {
                    parent.find("#currentstate").closest('.detailfields').find('span').css('visibility', 'hidden');
                    parent.find("#currentcity").closest('.detailfields').find('span').css('visibility', 'hidden');
                    parent.find("#currentstate").val(getData.State);
                    parent.find("#currentcity").val(getData.City);
                    cpErr = false;
                } 
                else 
                {
                    $('#currentpincode').after('<div id="error-user">Pincode verification failed.</div>');
                    cpcErr = true;
                }
            }
          });
        }
    }
});

$("#cocurrentpincode").blur(function() {
    var _this = $(this);
    _this.closest('.detailfields').find("#error-user").remove();
    var parent = _this.parents(".detailwrap-line1");
    var pinvalue = _this.val();
    var addGrp = parent.attr('id');
    var pin = $(this).val();
    var pinregs = /^[1-9][0-9]{5}$/;
    if(pin == '') {
      $('#cocurrentpincode').after('<div id="error-user">Pincode is required.</div>');
      cpErr = true;
    } else {
      if(!pinregs.test(pin)) {
  $('#cocurrentpincode').after('<div id="error-user">Invalid Pincode.</div>');
  cpErr = true;
      } else {
  $.ajax({
    url:"ajax/verify-pincode",
    type:"POST",
    data:{pincode:pinvalue,type:'pincode',grp: addGrp},
    success: function(msg){
      var getData = JSON.parse(msg);
      if(getData.Status == "Success") {
  parent.find("#currentstate").closest('.detailfields').find('span').css('visibility', 'hidden');
  parent.find("#currentcity").closest('.detailfields').find('span').css('visibility', 'hidden');
  parent.find("#currentstate").val(getData.State);
  parent.find("#currentcity").val(getData.City);
  cpErr = false;
      } else {
  $('#currentpincode').after('<div id="error-user">Pincode verification failed.</div>');
  cpcErr = true;
      }
    }
  });
      }
    }
  });
  
  $("#datepicker-example2").focusout(function() {
    $(this).closest('.detailfields').find("#error-user").remove();
    var dob = $(this).val();
    var dateReg = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
    if(!dateReg.test(dob) && dob != ''){
      $("#datepicker-example2").after('<div id="error-user">Invalid characters.</div>');
      bdErr = true;
      return false;
    } else {
      bdErr = false;
    }
    var birthdate = new Date(dob);
    var cur = new Date();
    var diff = cur - birthdate; // This is the difference in milliseconds
    var age = Math.floor(diff/31536000000); // Divide by 1000*60*60*24*365
    //alert(age);
    if(age < 25) {
      $('#datepicker-example2').after('<div id="error-user">You should be above 25 to avail a Loan.</div>');
      bdErr = true;
    }  else {
      $("#kycDob").val(dob);
    }
  });

  
  $(".aadhar-tcbox #termschk").click(function() {
    if($(this).prop('checked')) {
      $(".verifyOTP").removeClass('disabled');
    } else {
      $(".verifyOTP").addClass('disabled');
    }
  });
  
  
  
  
  $(".aadhar-tcbox #termschk").click(function() {
    if($(this).prop('checked')) {
      $(".verifyOTP").removeClass('disabled');
    } else {
      $(".verifyOTP").addClass('disabled');
    }
  });
  
  /*
  $('#datepicker-example1').datepicker({
	onSelect: function(dateText, inst) { 
		 var date = $(this).datepicker('getDate'),
		 month = date.getMonth() + 1;     
		 console.log(month);
	}
  });
  */
  /*
    $('#datepicker-example1').datepicker({
	alert("");
    dateFormat: 'yy-m-d',
    inline: true,
    onSelect: function(dateText, inst) { 
        var date = $(this).datepicker('getDate'),
            day  = date.getDate(),  
            month = date.getMonth() + 1,   
            year =  date.getFullYear();
        alert(day + '-' + month + '-' + year);
        alert(month);
    }
});*/
  

  $("#datepicker-example1").change(function() {
  //alert("hi");
   //dateFormat: 'yy-m-d';
   var date = $(this).datepicker('getDate');
  var month = date.getMonth() + 1;
  //console.log(month);
    $(this).closest('.empdetail-box').find('#error-user').remove();
    var myDate = $(this).val();
	console.log(myDate);
    var dateReg = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
    if(!dateReg.test(myDate) && myDate != ''){
      $("#datepicker-example1").after('<div id="error-user">Invalid characters.</div>');
      weErr = true;
      return false;
    } else {
      weErr = false;
    }
    var tempDate = myDate.split('-');
    var selDate = tempDate[0]+','+tempDate[1]+','+tempDate[2];
    //console.log(selDate);
   /* var today = new Date();
    var dd = today.getDate();
    var mm = date.getMonth()+1; 
	console.log(mm);
    var yyyy = today.getFullYear();*/
	var dd = date.getDate();
    var mm = date.getMonth()+1; 
    var yyyy = date.getFullYear();
	//console.log(dd,mm,yyyy);
    var curDate = yyyy + '-' + mm + '-' + dd;
    //var date1=new Date(2013,5,21);//Remember, months are 0 based in JS
	var tmpData,tmpData1;
    var date1=new Date(selDate);
	//var dateie=new Date(selDate).parseISO8601(tempDate[0]+ "-" +tempDate[1]+ "-" +tempDate[2]);
	var dateie=new Date(tempDate[0]+ "-" +tempDate[1]+ "-" +tempDate[2]);
	if(date1.getFullYear()){
		tmpData = date1;
	}else{
		tmpData = dateie;
	}
	//var date2=new Date(curDate);	
	var tmpData1=new Date();
	//console.log(date2,dateie1);
	//console.log(date2.getFullYear());
/*	if(date2.getFullYear()){
		tmpData1 = date2;
	}else{
		tmpData1 = dateie1;
	}   */
	//console.log(tmpData1);
	//console.log(tmpData1.getFullYear()); 
    var year1=tmpData.getFullYear();
	//console.log(year1);
    var year2=tmpData1.getFullYear();
	//var year2=tmpData.getFullYear();
	//console.log(year2);
	var month1=tmpData.getMonth() + 1;
	//console.log(month1);
    var month2=tmpData1.getMonth() + 1;
	//console.log(month1); 
	//console.log(month2);  
	//console.log(tmpData);
	console.log(year1,year2,month1,month2);
    if(month1 === 0){ //Have to take into account
      month1++;
      month2++;
    }
    var numberOfMonths;
    //numberOfMonths = (year2 - year1) * 12 + (month2 - month1) - 1;
    //console.log(numberOfMonths);
    numberOfMonths = (year2 - year1) * 12 + (month2 - month1);
    //numberOfMonths = (year2 - year1) * 12 + (month2 - month1) + 1;
    //console.log(numberOfMonths);
    if(numberOfMonths < 60){
      $("#empjoin").removeClass('dnone');
    } else {
      $("#empjoin").addClass('dnone');
    }
  });
  
  
  Date.prototype.parseISO8601 = function(date){
        var matches = date.match(/^\s*(\d{4})-(\d{2})-(\d{2})\s*$/);
		//console.log(matches);	
        if(matches){
            this.setFullYear(parseInt(matches[1]));    
            this.setMonth(parseInt(matches[2]) - 1);    
            this.setDate(parseInt(matches[3]));    
        }

        return this;
    };
  
  
	$("#sendOTP").click(function() {
    $("#error-user").remove()
    var mob = $("#verifyMobNo").val();
    $.ajax({
      url:"ajax/generate-otp",
      type:"POST",
      data:{mobileNo:mob},
      success: function(msg){
  var getData = JSON.parse(msg);
  //console.log(getData.Status);
  if(getData.Status == "Y") {
    $('#verifyMobNo').after('<div id="error-user">OTP has ben sent to your Mobile Number</div>');
    $('.manual').show();
  } else {
    //$('#currentpincode').after('<div id="error-user">+getData.ErrorMsg+</div>');
  }
      }
    });
  });
  
  $(".resendManOtp").click(function() {
    if($('body').hasClass('manual_verify')) {
      $("#error-user").remove()
      var otp = $("#manualOTP").val();
      $.ajax({
        url:"ajax/manual-resend-otp",
        type:"POST",
        success: function(msg){
          var getData = JSON.parse(msg);
          if(getData.Status == "Y") {
            $('#manualOTP').after('<div id="error-user">OTP has been sent to your Mobile Number</div>');
            $('#theOtp').val('');
          } else {
            //$('#currentpincode').after('<div id="error-user">+getData.ErrorMsg+</div>');
          }
        }
      });
    }
    
  });
  
  /*$("#verifyManMobNo").click(function() {
    $otp = $("#manualOTP").val();
    $.ajax({
      url:"ajax/verify-manual-otp",
      type:"POST",
      data:{otp:$otp},
      success: function(msg){
  var getData = JSON.parse(msg);
  console.log(getData.Status);
  if(getData.Status == "Y") {
    //window.location = 'aip-info';
  } else {
   // window.location = 'declined';
  }
      }
    });
  });*/
  

  
  
  
  /*$(".idProofSubmit").submit(function(e) {
    e.preventDefault();
    var opt = $("#idProofDoc").val();
    alert(opt);
    var frmId = $(this).closest('form').attr('id');
		$.ajax({
			type: "POST",
			dataType : "json",
			url: 'ajax/do-upload',
			data: {item: 'PAN',form_id: frmId, opt: opt},
			success: function(result) {
				//alert(result.status);

  console.log(result);

			}
		});
	});*/
  
  $(document).on('click', '.perfioStart', function() {
    $('#error-user').remove();
    var error = false;
    var bankcd = $(this).closest('.bankSel').find('#bankName').val();
    var banknm = $(this).closest('.bankSel').find('#bankName option:selected').text();
    var acct    = $(this).closest('.bankSel').find('#accType').val();
    if(bankcd == '') {
      error = true;
      $(this).closest('.bankSel').find('#bankName').after('<div id="error-user">Please select a Bank</div>');
    } 
    //alert(bankcd +' - '+ banknm);
    if(acct == '') {
      error = true;
      $(this).closest('.bankSel').find('#accType').after('<div id="error-user">Please select an Account Type</div>');
    } 
    
    var ownerType = $(".approval-wrap").attr('id');
    var pType = $(this).closest(".verifymainsubmit").attr("id");
    
    if(!error) {
      $.ajax({
        type:'POST',
        url: "ajax/start-perfios",
        dataType: "json",
        data: {'bankcd': bankcd, 'banknm': banknm, 'acct':acct, 'type':ownerType, 'ptype': pType},
        success: function(response) {
          //var amt = $.trim(response);
          //var sliderAmt = amt.replace(/[^0-9.]/g, '');
          console.log(response[0].HTMLPayLoad);
          window.location = 'perfios';

        }
      });
    }
  });

 
  



}); // document ready ends here

function setAmt(amt) {
  $.ajax({
    type:'POST',
    url: "ajax/set-amount",
    data: {'amt': amt},
    success: function(response) {

    }
  });
}

function calcAmt() {
  if($('body').hasClass('calculate_loan') || $('body').hasClass('home') || $('body').hasClass('your_quote')) {
    var emi     = $("#emidiv").text().replace(/[^0-9.]/g, '');
    var tenure  = $("#years").val().replace(/[^0-9.]/g, '');
    var roi     = $("#roiAct").val().replace(/[^0-9.]/g, '');
    var maxAmt  = $("#nLoanAmt").val().replace(/[^0-9.]/g, '');
    var maxTen  = $("#nTenure").val().replace(/[^0-9.]/g, '');
    var amt     = $("#loan").val().replace(/[^0-9.]/g, '');
    if($('body').hasClass('your_quote')) {
      var page = 'your-quote';
    } else {
      var page = 'calculate-loan';
    }
    
    $.ajax({
      type:'POST',
      url: "ajax/calculate-amount",
      dataType: "json",
      data: {'emi': emi, 'time':tenure, 'roi': roi, 'maxAmt' : maxAmt, 'maxTen': maxTen, 'amt': amt, 'page':page},
      success: function(response) {
        var amt = $.trim(response.amt);
        var sliderAmt = amt.replace(/[^0-9.]/g, '');
        if(response.status == 'Yes') {
          $("#loan").val(amt);
        }
        $('.edcRangeRight .rightamt').html(amt);
       // $("#nLoanAmt").val(amt);
        $("#emidiv").html('');
        $("#emidiv").html('<b>`</b>' + response.emi);
        $("#emidiv").attr('rel', response.calcEmi);
        
        //$("#SliderPoint3").slider("value", 1000000, 2500000);
        /*$("#SliderPoint3").prop({
          min: 100000,
          max: sliderAmt
        }).slider("refresh");*/
      }
    });
  }
}


function now() {    // current date in yyyy-mm-dd format
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();
  if(dd<10) { dd='0'+dd; } 
  if(mm<10) { mm='0'+mm; } 
  var today = yyyy+'-'+mm+'-'+dd;
  return today;
}

function monthDiff(date_1,date_2) {
  var date1   = new Date(date_1);
  var date2   = new Date(date_2);
  var year1   = date1.getFullYear();
  var year2   =date2.getFullYear();
  var month1  =date1.getMonth();
  var month2  =date2.getMonth();
  if(month1 === 0){ //Have to take into account
    month1++;
    month2++;
  }
  var numberOfMonths;
  numberOfMonths = (year2 - year1) * 12 + (month2 - month1);
  return numberOfMonths;
}

$(document).ready(function(){
 // $('.remain-detail').hide();
  $('#textfield').bind('focus', function(){
    $('.pholder').hide();
  });
$('#datepicker-example1').bind('focus', function(){
    $("#block4").fadeIn();
  });

if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB10/i.test(navigator.userAgent)) {
  $("body").addClass("ifl-touchDevices");
   
    }else{
  $("body").addClass("ifl-no-touch");
 
    }

//$( "#SliderPoint" ).slider({
  //step: 1000
//});
//
//
//
//
//
/*$( "#SliderPoint" ).slider({
    min: 35000,
    max: 1000000,
    start: function( event, ui ) {
  $(this).slider("option", "step", 5000);
    },
    slide: function( event, ui ) {
    }
});*/




});