var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true


var flag = true;

function getAge(bDate) {
  // yyyy/mm/dd
  var temp      = bDate.split('/');
  var bDay      = temp[2] +'/'+ temp[1] +'/'+ temp[0]; 
  var today     = new Date();
  var birthDate = new Date(bDay);
  var age       = today.getFullYear() - birthDate.getFullYear();
  var m         = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) { age--; }
  return age;
}

function isNumberKey(e) {
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))	{
		return false;
	}
}

function namevalidator(ths){
	if(ths.attr('data-name') == 'alpha') {        /*validation only for alphabets*/
		var regex = new RegExp("^[a-zA-Z .\']+$");
    if(ths.val() == '') {
      flag = false;
      if(ths.attr('id') == 'nameslot1') {
        ths.parent().find('.error-user').show().text('First name is required');
      } else {
        ths.parent().find('.error-user').show().text('Last name is required');
      }
      
    } else {
      if (regex.test(ths.val())) {
        flag = true;
        ths.parent().find('.error-user').hide();
      } else {
        flag = false;
        ths.parent().find('.error-user').show().text('Invalid characters entered');
      }
    }
	} else if(ths.attr('data-name') == 'mobnumber'){    /*validation only for mobile number*/
    if(parseInt(ths.val()) < 7000000000) {
      ths.closest('.inputbox').find('.error-user').text('Invalid Mobile number').show();
      flag = false;
    } else {
      var phoneregs = /^[7-9][0-9]{9}$/;
      if(phoneregs.test(ths.val())) {
        flag = true;
        ths.closest('.inputbox').find('.error-user').text('Mobile number is required').hide();
      } else {
        flag = false;
        ths.closest('.inputbox').find('.error-user').text('Invalid Mobile number').show();
      }
    }
    
	} else if(ths.attr('data-name') == 'adhar' && ths.val().length == 12){    /*validation only for aadhar number*/
		flag = true;
		ths.parent().find('.error-user').hide();
	} else if(ths.attr('data-name') == 'onlynum' && ths.val().length > 0){        /*validation only for numbers*/
		flag = true;
		ths.parent().find('.error-user').hide();
	} else if(ths.attr('data-name') == 'pinnumber' && ths.val().length == 6){        /*validation only for numbers*/
		flag = true;
		ths.parent().find('.error-user').hide();
	} else if(ths.attr('data-name') == 'pannumber' && ths.val().length == 10){      /*validation only for pancard number*/
    var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
    if (regpan.test(ths.val())) {
      flag = true;
      ths.parent().find('.error-user').hide();
    } else  {
      flag = false;
      ths.parent().find('.error-user').show().text('Invalid PAN');
    }
	} else if(ths.attr('data-name') == 'alphanumeric'){      /*validation only for alphanumeric*/
		var regalphanum = /^([a-zA-Z0-9 _-]+)$/;
		if (regalphanum.test(ths.val())) {
      flag = true;
			ths.parent().find('.error-user').hide();
    } else {
	    flag = false;
			ths.parent().find('.error-user').show();
    }
	} else if(ths.attr('data-name') == 'dates') {      /*validation only for dates dd/mm/yyyy format*/
		//var regdate = /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/;
    var regdate = /^(0?[1-9]|1\d|2\d|3[01])\/(0?[1-9]|1[0-2])\/(19|20)\d{2}$/;
		if (regdate.test(ths.val())) {
      if(getAge(ths.val()) < 25) {
        flag = false;
        ths.parent().find('.error-user').show().text('You should be above 25 years to avail a loan.');
      } else {
        flag = true;
        ths.parent().find('.error-user').hide().text('Birth date is required.');
      }
      
    } else {
	    flag = false;
			ths.parent().find('.error-user').show();
    }
    
  } else if(ths.attr('id') == 'nameslot2') {
    $('#nameslot2').closest('.inputbox').find('.error-user').remove();
    if(ths.val() != '') {
      var regex = new RegExp("^[a-zA-Z .\']+$");
      if (!regex.test(ths.val())) {
        flag = false;
        $('#nameslot2').after('<div class="error-user und">Invalid characters entered</div>');
        $('#nameslot2').closest('.inputbox').find('.error-user').show();
      } else {
        $('#nameslot2').closest('.inputbox').find('.error-user').remove();
      }
    }
    
	} else if(ths.attr('data-name') == 'emailing') {        /*validation only for email id*/
		var regemail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(ths.val() == '') {
      flag = false;
			ths.parent().find('.error-user').show().text('Email is required');
    } else {
      if (regemail.test(ths.val())) {
        flag = true;
        ths.parent().find('.error-user').hide();
      } else {
        flag = false;
        ths.parent().find('.error-user').show().text('Invalid email');
      }
    }
	} else {
		//flag = false;
		//ths.parent().find('.error-user').show();
	}
  


	return flag;
}





$(document).ready(function(){
  if(isMobile) {
    $('.dtVersion').remove();
  } else {
    $('.mobVersion').remove();
  }
  
  $('.otpVerify').hide();
  
  $(".resendManOtp").click(function() {
    $(".error-user").remove();
    $(".otpMsg").remove();
    $("#manualOTP").val('');
    $.ajax({
      url:"verify-otp.php",
      type:"POST",
      dataType: "json",
      data:{'param':'res'},
      success: function(data){
        if(data.status == '') {
          $('#manualOTP').after('<p class="error-user">'+ data.msg+'</p>');
          //$('#theOtp').val('');
        } else {
          $('.aadhar-heading').after('<p class="otpMsg">'+ data.msg+'</p>');
        }
      }
    });
  });

  $.ajax({
    type:'GET',
    url: "CompanyMaster.xml",
    dataType: "xml",
    success: function( xmlResponse ) {
      var companyArr = [];
			var i = 0;
      $(xmlResponse).find('Company').each(function() {
        companyArr[i] = $(this).find('CompanyName').text();
        i++;
      });
      //console.log(companyArr);
      $(".companylist").autocomplete({source: companyArr});
    }
  });
  
  $(document).on('click', '#addrCh', function() {
    if($(this).is(':checked')) {
      $("#slotcadd1").val($("#slotpadd1").val());
      $("#slotcadd2").val($("#slotpadd2").val());
      $("#slotcadd3").val($("#slotpadd3").val());
      $("#slotpin2").val($("#slotpin").val());
      $('.currAddr').hide();
    } else {
      $("#slotcadd1").val('');
      $("#slotcadd2").val('');
      $("#slotcadd3").val('');
      $("#slotpin2").val('');
      $('.currAddr').show();
    }
  });
  var isClicked = false;
  $(document).on('click', '#verifyManMobNo', function() {
    $("#manualOTP").closest('.inputbox').find('.error-user').remove();
    $('.resendManOtp').hide();
    if(!isClicked) {
      isClicked = true;
      
      var otp = $('#manualOTP').val();
      if(otp == '') {
        $("#manualOTP").after("<div class='error-user'>Please enter OTP</div>");
        $("#manualOTP").closest('.inputbox').find('.error-user').show();
        $("#manualOTP").focus();
        $('.resendManOtp').show();
        isClicked = false;
        return false;
      }
      $.ajax({
        type:'POST',
        url: "verify-otp.php",
        dataType: "json",
        data: {'otp':otp, 'param':'ver'},
        success: function(response) {
          if(response.status == '1') {
            $.ajax({
              type:'POST',
              url: "apply-loan.php",
              dataType: "json",
              data: {},
              success: function(response) {
                if(response.status === "1") {
                  window.location = 'http://10.132.150.2:9001/iifl_personal_loan/loans/personal_loan/aip-info'; 
                  //window.location = 'http://indigoconsulting.in/iifl-finance/loans/personal_loan/aip-info';
                } else {
                  $('.resendManOtp').show();
                }
              }
            });
          } else {
            $('#manualOTP').after('<div class="error-user">'+ response.msg +'</div>');
            $("#manualOTP").closest('.inputbox').find('.error-user').show();
            $('.resendManOtp').show();
          }
          isClicked = false;
        }
      });
    }
  });

  var minSalOblige = 35000;
  $(document).on('click', '#subaffildetail', function() {
    $('.error-user').not('.und').remove();
    
    var error = false;    
    if($("#nameslot1").val() == '') {
      $("#nameslot1").after('<div class="error-user">First Name is required</div>');
      error = true;
    } else {
      var fName     = $("#nameslot1").val();
    }
    
    var mName     = $("#nameslot2").val();
    
    if($("#nameslot3").val() == '') {
      $("#nameslot3").after('<div class="error-user">Last Name is required</div>');
      error = true;
    } else {
      var lName     = $("#nameslot1").val();
    }
    if($("#panslot1").val() == '') {
      $("#panslot1").after('<div class="error-user">Pan card is required</div>');
      error = true;
    } else {
      var panNo     = $("#panslot1").val();
    }
    
    if($("#datepicker").val() == '' || $("#datepicker").val() == 'Date of Birth*') {
      $("#datepicker").after('<div class="error-user">Date of birth is required</div>');
      error = true;
    } else {
      var dob     = $("#datepicker").val();
    }
    if($("#slotmob1").val() == '') {
      $("#slotmob1").after('<div class="error-user">Mobile number is required</div>');
      error = true;
    } else {
      var mobNo     = $("#slotmob1").val();
    }
    
    var altNo     = $("#slotmob2").val();
    
    if($("#slotemail").val() == '') {
      $("#slotemail").after('<div class="error-user">Email is required</div>');
      error = true;
    } else {
      var email     = $("#slotemail").val();
    }
    if($("#slotpadd1").val() == '') {
      $("#slotpadd1").after('<div class="error-user">Address is required</div>');
      error = true;
    } else {
      var pAddr1    = $("#slotpadd1").val();
    }

    var pAddr2    = $("#slotpadd2").val();
    var pAddr3    = $("#slotpadd3").val();
    if($("#slotpin").val() == '') {
      $("#slotpin").after('<div class="error-user">Pincode is required</div>');
      error = true;
    } else {
      if($("#slotpin").val() <= 99999) {
        $("#slotpin").after('<div class="error-user">Invalid pincode</div>');
        error = true;
      } else {
        var pPin      = $("#slotpin").val();
      }
      
    }
    
    if($("#slotcompname").val() == '') {
      $("#slotcompname").after('<div class="error-user">Company name is required</div>');
      error = true;
    } else {
      var compName  = $("#slotcompname").val();
    }
    
    if($("#slotmonthsal").val() == '') {
      $("#slotmonthsal").after('<div class="error-user">Monthly salary is required</div>');
      error = true;
    } else {
      if($("#slotmonthsal").val() < 35000 || $("#slotmonthsal").val() > 1000000) {
        $("#slotmonthsal").after('<div class="error-user">Salary must be in the range of Rs.35000 - Rs.1000000</div>');
        minSalOblige  = 35000;
        error = true;
      } else {
        var monthSal  = $("#slotmonthsal").val();
        minSalOblige  = monthSal;
      }  
    }
    
    if($("#cworkexpslot").val() == '') {
      $("#cworkexpslot").after('<div class="error-user">Current work experience is required</div>');
      error = true;
    } else {
      if($("#cworkexpslot").val() <= 0){
        $("#cworkexpslot").after('<div class="error-user">Current work experience should be greater than 0.</div>');
        error = true;
      } else {
        var curExp    = $("#cworkexpslot").val();
      }
      
    }
    if($("#slotExp").val() == '') {
      $("#slotExp").after('<div class="error-user">Total work experience is required</div>');
      error = true;
    } else {
      if($("#slotExp").val() <= 0) {
        $("#slotExp").after('<div class="error-user">Total work experience should be greater than 0.</div>');
        error = true;
      } else if(parseInt($("#slotExp").val()) < parseInt(curExp)) {
        $("#slotExp").after('<div class="error-user">Total experience should be greater than Current experience.</div>');
        error = true;
      } else {
        var totalExp  = $("#slotExp").val();
      }
    }
  
    if($("#slotOblig").val() != '') {
      if(parseInt($("#slotOblig").val()) <= 0 || parseInt($("#slotOblig").val()) > minSalOblige) {
        $("#slotOblig").after('<div class="error-user und">Obligation should be between 0 and Rs.'+ minSalOblige+'.</div>');
        error = true;
      } else {
        var oblige    = $("#slotOblig").val();
      }
    }
    
    if($("#loanCity").val() == '' || $("#loanCity").val() == 'Select City') {
      $("#loanCity").after('<div class="error-user">City is required</div>');
      error = true;
    } else {
      var city      = $("#loanCity").val();
    }
    
    var addrChk   = $("#addrCh").val();
    if($("#gender").val() == '' || $("#gender").val() == 'Select Gender') {
      $("#gender").after('<div class="error-user">Gender is required</div>');
      error = true;
    } else {
      var gender    = $("#gender").val();
    }
    
    
    if($("#addrCh").is(":checked")) {
      var cAddr1    = pAddr1;
      var cAddr2    = pAddr2;
      var cAddr3    = pAddr3;
      var cPin      = pPin;
    } else {
      if($("#slotcadd1").val() == '') {
        $("#slotcadd1").after('<div class="error-user">Address is required</div>');
        error = true;
      } else {
        var cAddr1    = $("#slotcadd1").val();
      }
      var cAddr2    = $("#slotcadd2").val();
      var cAddr3    = $("#slotcadd3").val();
      if($("#slotpin2").val() == '') {
        $("#slotpin2").after('<div class="error-user">Pincode is required</div>');
        error = true;
      } else {
        var cPin      = $("#slotpin2").val();
      }
    }

    $('.error-user').css('display', 'block');
    if(!error && flag == true) {
      $('html, body').animate({scrollTop: '0px'}, 300);
      $(".overlays").show();
      $(".loader").show();
      $.ajax({
        type:'POST',
        url: "process.php",
        dataType: "json",
        data: {
          'fName'   :fName,
          'mName'   :mName,
          'lName'   :lName,
          'panNo'   :panNo,
          'dob'     :dob,
          'mobNo'   :mobNo,
          'altNo'   :altNo,
          'email'   :email,
          'pAddr1'  :pAddr1,
          'pAddr2'  :pAddr2,
          'pAddr3'  :pAddr3,
          'pPin'    :pPin,
          'cAddr1'  :cAddr1,
          'cAddr2'  :cAddr2,
          'cAddr3'  :cAddr2,
          'cPin'    :cPin,
          'compName':compName,
          'monthSal':monthSal,
          'curExp'  :curExp,
          'totalExp':totalExp,
          'oblige'  :oblige,
          'city'    :city,
          'addrChk' :addrChk,
          'gender'  :gender
        },
        success: function(response) {
          console.log(response);
          if(response.status == '1') {
            var mobileNo = '******' + mobNo.slice(-4);
            $('.data_block1').remove();
            $('.data_block2').remove();
            $('.data_block3').remove();
            $('.submitBtn').remove();
            $('.aadhar-heading').after('<p class="otpMsg">Please use the OTP received on your Mobile Number '+ mobileNo +'</p>');
            $(".overlays").remove();
            $(".loader").remove();
            $('.otpVerify').show();
          } else {
            for(x in response.msg) {
              var temp = response.msg[x].split('-');
              $('#'+temp[0]).after('<div class="error-user">'+ temp[1] +'</div>');
              $('.error-user').show();
            }
            $(".loader").hide();
            $(".overlays").hide();
            $(window).scrollTop($(".error-user:visible").offset().top-100);
          }
        }
      });
    } else {
      $(window).scrollTop($(".error-user:visible").offset().top-100);
    }
  });
  
  //$("#datepicker").readonlyDatepicker(true);
  
  $("#panslot1").on('input', function(evt) {
    var input = $(this);
    var start = input[0].selectionStart;
    $(this).val(function (_, val) {
      return val.toUpperCase();
    });
    //input[0].selectionStart = input[0].selectionEnd = start;
  }); 
	
	$('.inputbox input').focus(function(){
		$(this).parent(".input").find('span').addClass("blurtext");
	});
  
	$('.inputbox input').blur(function(){
		if($(this).val().length > 0){
			$(this).parent().find('span').addClass("blurtext");
			$(this).parent().find('.error-user').hide();
			flag = true;
		} else {
			$(this).parent().find('span').removeClass("blurtext");
			$(this).parent().find('.error-user').show();
			flag = false;
		}
		flag = namevalidator($(this));
	});

	$('.inputbox input').keyup(function() {
		if($(this).val().length > 0){
			$(this).parent().find('span').addClass("notext");
			flag = namevalidator($(this));
		} else  {
			flag = false;
			$(this).parent().find('span').removeClass("notext");
		}
		/*if(flag) {
			$('#aadharNoslot').prop('disabled', false);
		} else {
			$('#aadharNoslot').prop('disabled', true);
		}*/

		/*if(flag) {
			$('#subaffildetail').prop('disabled', false);
		} else {
			$('#subaffildetail').prop('disabled', true);
      $(window).scrollTop($(".error-user:visible").offset().top-100);
		}*/
	});

	$("#noAadharSbmit1").click(function(){
		$('.aadharblock').hide();
		$('.data_block1').fadeIn();
	});

	$('.data_block1 .inputbox input:first').blur(function(){
		$('.data_block2').fadeIn();
		//$(window).scrollTop($(this).offset().top);
	});

	$('.data_block2 .inputbox input:first').blur(function(){
		$('.data_block3').fadeIn();
    $('.next-home').fadeIn();
		//$(window).scrollTop($(this).offset().top);
	});

	$('.data_block3 .inputbox input:first').blur(function(){
		
		//$(window).scrollTop($(this).offset().top);
	});

  /**/
//  $("#aadharNoslot").click(function(){
//		$('.enterotpsection').fadeIn();
//	});
  

  $( "#datepicker" ).datepicker({
    changeMonth : true,
    changeYear  : true,
    yearRange   : "1900:+nn",
    dateFormat  : "dd/mm/yy",
    maxDate     : new Date()
  });

  $( "#datepicker" ).change(function() {
    flag = namevalidator($(this));
  });
  
  $('#slotmob2').blur(function() {
    $(this).closest('.inputbox').find('.error-user').remove();
    var phoneregs = /^[7-9][0-9]{9}$/;
    if(phoneregs.test($(this).val())) {
      $(this).parent().find('.error-user').hide();
    } else {
      if($(this).val() == '') {
        flag = true;
        $(this).closest('.inputbox').find('.error-user').remove();
      } else {
        flag = false;
        $(this).after('<div class="error-user und">Invalid Mobile number</div>');
        $(this).closest('.inputbox').find('.error-user').show();
      }
    }
  });
  
  $('#gender').change(function() {
    $(this).closest('.inputbox').find('.error-user').remove();
    if($(this).val() == '' || $(this).val() == 'Select Gender') {
      flag = false;
      $(this).after('<div class="error-user">Gender is required.</div>');
      $(this).closest('.inputbox').find('.error-user').show();
    } else {
      flag = true;
    }
  });
  
  $('#loanCity').change(function() {
    $(this).closest('.inputbox').find('.error-user').remove();
    if($(this).val() == '' || $(this).val() == 'Select City') {
      flag = false;
      $(this).after('<div class="error-user">City is required.</div>');
      $(this).closest('.inputbox').find('.error-user').show();
    } else {
      flag = true;
    }
  });
  
  $("#slotpin2, #slotpin").blur(function() {
    $(this).closest('.inputbox').find('.error-user').text('Pincode is required.').hide();
    if(parseInt($(this).val()) <= 99999) {
      flag = false;
      $(this).closest('.inputbox').find('.error-user').remove();
      $(this).after('<div class="error-user">Invalid pincode.</div>');
      $(this).closest('.inputbox').find('.error-user').show();
    }
  });
  
  $(document).on('change', '.selectContainer select', function(){
    $(this).parents('.selectContainer').find('.selectText').text($(this).val());
  });
  
});