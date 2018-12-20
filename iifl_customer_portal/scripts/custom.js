$(function(){
  

  
  getProductDetails();
  
  $(document).on('click', '.apply_now', function() {
    $.ajax({
      type:'POST',
      dataType : "json",
      url: "api/new-loan-apply.php",					
      success:function(data) {
        console.log(data);
        //$(".left_menu ul").append(data);
      }
    });
  }); 
  
  
  $(document).on('click', '.refSubmit', function() {
    var error = false;
	  $(".error").each(function() {
      $(this).addClass('dnone');
    });
    var producttypejs = $("#producttype").val();
    var Namejs = $("#Name").val();
    var cityjs = $("#city").val();
    var pincodejs = $("#pincode").val();
    var mobilenumberjs = $("#mobilenumber").val();
  
    if(producttypejs == ''){
      $("#producttype").closest(".form-control").find(".error").text("This field is required").removeClass('dnone');
      error = true;
    }
    if(Namejs == ''){
      $("#Name").closest(".form-control").find(".error").text("This field is required").removeClass('dnone');
      error = true;
    }
    if(cityjs == ''){
      $("#city").closest(".form-control").find(".error").text("This field is required").removeClass('dnone');
      error = true;
    }
    if(pincodejs == ''){
      $("#pincode").closest(".form-control").find(".error").text("This field is required").removeClass('dnone');
      error = true;
    }
    if(mobilenumberjs == ''){
      $("#mobilenumber").closest(".form-control").find(".error").text("This field is required").removeClass('dnone');
      error = true;
    }
  
    if(!error){
      var form = $("#frm_referfriend").serialize();	
      $.ajax({
        type:'POST',
        data:form,
        dataType : "json",
        url: "../api/referfriendres.php",
        success:function(data){
          var msgHtml = '<div class="message">'+ data.msg +'</div>';
          $('#frm_referfriend').after(msgHtml);
          $("#formkey").val(data.token);
        }
      }); 
    }
    
  }); 
  
  
  
  

  
  
  $(document).on('click', '#viewCertificate', function() {
    var valid = true;
    var accountNumber = $(".selectedvalue").text();
    var frmDate = $("#from").val();
    var toDate = $("#to").val();
    if(accountNumber) {
      valid = false;
    }
    if(frmDate == '') {
      valid = false;
    }
    if(toDate == '') {
      valid = false;
    }
    if(frmDate > toDate) {
      valid = false;
    }
    if(valid) {
      $.ajax({
        type:'POST',
        dataType : "json",
        url: "api/get-interest-certificate.php",					
        success:function(data) {
          console.log(data);
          //$(".left_menu ul").append(data);
        }
      });
    }
  
  }); 

  $(document).on('click', '.feedbacksub', function(){
   var valid = true;
   $(".error").each(function() {
      $(this).addClass('dnone');
    });
   var loantypejs = $("#loantype").val();
   var loannojs = $("#loanno").val();
   var categoryjs = $("#category").val();
   var subcategoryjs = $("#subcategory").val();

   if(loantypejs == ''){
    $("#loantype").closest('.form-control').find('.error').text("This field is required").removeClass('dnone');
    valid = false;
   }
   if(loannojs == ''){
    $('#loanno').closest('.form-control').find('.error').text('This field is required').removeClass('dnone');
    valid = false;
   }
   if(categoryjs == ''){
    $('#category').closest('.form-control').find('.error').text('This field is required').removeClass('dnone');
    valid = false;
   }
   if(subcategoryjs == ''){
    $('#subcategory').closest('.form-control').find('.error').text('This field is required').removeClass('dnone');
    valid = false;
   }
   
   if(valid){
	var form = $("#compandfeedbk_frm").serialize();	
    $.ajax({
      type:'POST',
      data:form,
      dataType : "json",
      url: "../api/viewfeedbackres.php",
      success:function(data) {
		//alert("data");
        var msgHtml = '<div class="message">'+ data.msg +'</div>';
        $('#compandfeedbk_frm').after(msgHtml);
        $("#formkey").val(data.token);
		
      }
     });
   }
  });
  
  
});




function getProductDetails() {
  $.ajax({
    type:'POST',
    dataType : "json",
    url: "api/product-details.php",					
    success:function(data) {
      console.log(data);
      $(".left_menu ul").append(data);
    }
  });
}