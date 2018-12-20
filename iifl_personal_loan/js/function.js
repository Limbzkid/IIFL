/*! jQuery UI - v1.12.1 - 2016-09-18
* http://jqueryui.com
* Includes: widget.js, position.js, data.js, disable-selection.js, focusable.js, form-reset-mixin.js, jquery-1-7.js, keycode.js, labels.js, scroll-parent.js, tabbable.js, unique-id.js, widgets/draggable.js, widgets/droppable.js, widgets/resizable.js, widgets/selectable.js, widgets/sortable.js, widgets/accordion.js, widgets/autocomplete.js, widgets/button.js, widgets/checkboxradio.js, widgets/controlgroup.js, widgets/datepicker.js, widgets/dialog.js, widgets/menu.js, widgets/mouse.js, widgets/progressbar.js, widgets/selectmenu.js, widgets/slider.js, widgets/spinner.js, widgets/tabs.js, widgets/tooltip.js, effect.js, effects/effect-blind.js, effects/effect-bounce.js, effects/effect-clip.js, effects/effect-drop.js, effects/effect-explode.js, effects/effect-fade.js, effects/effect-fold.js, effects/effect-highlight.js, effects/effect-puff.js, effects/effect-pulsate.js, effects/effect-scale.js, effects/effect-shake.js, effects/effect-size.js, effects/effect-slide.js, effects/effect-transfer.js
* Copyright jQuery Foundation and other contributors; Licensed MIT */

	$(window).load(function(){
		$(document).on('change', '.select_iconall', function(){
			var selectedText = $(this).find('option:selected').text();
			$(this).prev().text(selectedText);
		});
		
		setTimeout(function(){
			$('.select_iconall').each(function(){
				var selectedText = $(this).find('option:selected').text();
				$(this).prev().text(selectedText);
			});
		},10);

	});
	
$(function(){
	
	radioBankState();
	
	$(".tnc-btn").click(function(e) {
		$('.tnc-popup, .overlay').fadeIn();
		 $("html,body").animate({scrollTop:0},100);
	});
	
	$(".closepop, .overlay").click(function(e) {
		$('.tnc-popup, .overlay').fadeOut();
	});

	$("#textfield").autocomplete({
    open: function(event, ui) {
  $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
    }
});

	/*if($(".commedit").prop('disabled', false)){

		$(".editarrow").hide();
	}*/
	$(".subcanclegroup").hide();
	$(".pencilicon").click(function(){
		$(this).parents().find(".commedit").prop('disabled', false).addClass("commoninput-inderline");
		$(".pencilicon").hide();
		$(".subcanclegroup").fadeIn();
	});	

	$('.ededit input').on('focus', function() {
  if (!$(this).data('defaultText')) $(this).data('defaultText', $(this).val());
  if ($(this).val()==$(this).data('defaultText')) $(this).val('');
   this.value = "";
    });
    $('.ededit input').on('blur', function() {

  if ($(this).val()=='') $(this).val($(this).data('defaultText')); 
    });
    $("#cnceldetail").click(function(){
    	$(this).parents().find(".commedit").prop('disabled', true).removeClass("commoninput-inderline");
		$(".pencilicon").fadeIn();
		$(".subcanclegroup").hide();
		var companyName 	= document.getElementById('CompanyNam1').value;
		var monthlySalary 	= document.getElementById('texSal1').value;
		var currentEmi 		= document.getElementById('texEmi1').value;

		$('#textfield').val(companyName);
		$('#texSal').val(monthlySalary);
		$('#texEmi').val(currentEmi);

		$( "#somediv" ).append( $( "#input_text" ).val() );
		$("#error-user").remove();
    });/**/
if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Mac') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
  // console.log('Safari on Mac detected, applying class...');
  $('.card-container-outerinner').addClass('safari-mac'); // provide a class for the safari-mac specific css to filter with
    }
});


function radioBankState() {
	
	$('.chkpersonal-info input:radio').filter('[value="everify"]').attr('checked', true);
	$(".chkpersonal-info input:radio").change(function () { //use change event
		if (this.value == "everify") { //check value if it is domicilio
			$('.everifyOptn').show();
			$('.eStatement').hide();
			$('.scannedDocs').hide();
		} else if(this.value == "eStmtUpload") {
			$('.everifyOptn').hide();
			$('.eStatement').show();
			$('.scannedDocs').hide();
		} else {
			$('.eStatement').hide();
			$('.everifyOptn').hide();
			$('.scannedDocs').show();
		}
	});
}

function PointerFN(P,S,mn,mx,tx) {

	var CW =  str2int($("#"+P).parent().css("width"))-str2int($("#"+P+' span').css("width"));
	var Ppos = str2int($("#"+P+' span').css("left"));
	var pr=((mx-mn)/CW);
	var svl= ((Ppos*pr)+mn).toFixed(0);


	//console.log(Ppos);
	if(svl<=1 && (S=="years" || S=="period")) {
		if(S=="years"){
			tx=" Year";
			//$("#"+S).val("1 Year");
		} else {
			$("#"+S).val(1);
		}
	}	else	{
		//$("#"+S).val(adcoma(svl)+tx);
	}
	
	if(svl>mx){		
		//$("#"+S).val(adcoma(mx)+tx);
		/*console.log(P)
		if(tx.trim() == "Years"){
			console.log($("#"+P).attr('value'), $("#"+P+' span').attr('value'));
			$("#"+S).val($("#"+P+' span').attr('value'));
		}*/
	}
	
	if(S=="period") {
		$("#periodtxt>div").css("font-weight","400");
		$("#periodtxt>div").eq(str2int($("#"+S).val())-1).css("font-weight","700");
	}
	//calbackEmi();
	
	if($.trim(tx) === 'Years' || $.trim(tx) === 'Year') {
		calcAmt();
	} else {
		calbackEmi();
	}
}


function adcoma (vl) {
	var money =vl;
	var dsml=""
	money = money.toString();
	dsml=money.split('.');
	var comaVL = ""
	if(dsml[0].length>3) {
		for (i=dsml[0].length; i>=3; i--) {
			if (i == 3) {
				l = dsml[0].substring(dsml[0].length-3, dsml[0].length);
				comaVL = comaVL+l;
			}
			if (i%2 == 0) {
				co = dsml[0].substring(dsml[0].length-i, (-(-(dsml[0].length-i)-1)))+",";
				comaVL = comaVL+co;
			}
			if (i%2>0 && i != 3) {
				co = dsml[0].substring(dsml[0].length-i, (-(-(dsml[0].length-i)-1)));
				comaVL = comaVL+co;
			}
		}
	}	else {
		comaVL=dsml[0];
	}
	
	return comaVL;
}
function removeComa(vl){
	var remove_coma = vl.split(',');
	var comaValue='';
	for(var i=0; i<remove_coma.length;i++){
		comaValue +=remove_coma[i];
	}
	//console.log(comaValue);
	return comaValue;
}

function isNumberKey(e) {
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))	{
		return false;
	}
}

function isNumberKeylimit(e)	{
	$('#totworkexperianceM').keyup(function() {
		if (parseInt($('#totworkexperianceM').val()) > 11) {
			var str = $('#totworkexperianceM').val();
			str = str.substring(0, str.length - 1);
			$('#totworkexperianceM').val(str);
      return false;
    }
	});
  
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		return false;
	}
}


function setPoint(vr1,vr2,mn,mx,tx) {
	//alert('setPoint');
//console.log(vr2);
	var sal = str2int($("#"+vr1).val());
	if(sal>mx) {		
		$("#"+vr1).val(adcoma(mx)+tx);
	} else if(sal<mn) {
	   //$(".eerr").show();
	   // return false;/* */
		//$("#"+vr1).val(adcoma(mn)+tx);
	}	else {
		$("#"+vr1).val(adcoma(sal)+tx);
	}
	
	
	if($("#"+vr1).val()=="NaN" ){
		$("#"+vr1).val(mn);
	}
	
	var CW =  str2int($("#"+vr2).parent().css("width"))-str2int($("#"+vr2).css("width"));
	var pr=((mx-mn)/CW);
	var Ppos=(( str2int($("#"+vr1).val()) - mn)/pr).toFixed(0);
	
	$("#"+vr2).animate({left:Ppos});
	
	if(vr1=="period"){
		$("#periodtxt>div").css("font-weight","400");
		$("#periodtxt>div").eq(str2int($("#"+vr1).val())-1).css("font-weight","700");
	}
	
	//calbackEmi();
	if($.trim(tx) === 'Years' || $.trim(tx) === 'Year') {
		calcAmt();
	} else {
		calbackEmi();
	}
	//calbackEmi();
	//calculate_loan home
	if($('body').hasClass('calculate_loan') || $('body').hasClass('home') || $('body').hasClass('your_quote')) {

		if($("#SliderPoint, #SliderPoint3, #SliderPoint4, #SliderPointcoapp3, #SliderPointcoapp4").length>0) {	

			//console.log(vr2);
			if(vr2 == "SliderPoint4"){
				$("#"+vr2).slider( "value",$("#"+vr1).val().split(" ")[0]);
		
			}else{
				$("#"+vr2).slider( "value",removeComa($("#"+vr1).val()));
			}	 	
		}
	}
	
/*
	if($("#SliderPoint").length>0){
	 $("#"+vr2).slider( "value",removeComa($("#"+vr1).val()));
	}
	if($("#SliderPoint3").length>0){
	 $("#"+vr2).slider( "value",removeComa($("#"+vr1).val()));
	}
	if($("#SliderPoint4").length>0){
	 $("#"+vr2).slider( "value",removeComa($("#"+vr1).val()));
	}*/
	
}


function str2int(sv) {
	//console.log(sv)
	var tm1= sv.replace ( /[^\d.]/g, '' ); ;
	var rvl = parseInt(tm1, 10);
	
	return rvl;
}



function emical(p,n,r) {
	console.log('émical', p +' - '+ n +' - '+ r);
	var P = p;
	var R = r/12/100;
	var N = n*12;
	
	var cal1 = Math.pow((1+R),N);
	var cal2 = cal1 -1;
	var cal3 = cal1 / cal2;
	var emi = ((P * R) * cal3);
	return Math.round(emi);
}




function clickbar(poi,fil,mn,mx,tx) {
	//alert('clickBar');
	$("#"+poi).parent().click(function (event){
	
		var divoffset = $(this).offset();
		var pvl=event.pageX-divoffset.left;
		if(pvl>str2int($("#"+poi).css("width")))
		{
			pvl-=str2int($("#"+poi).css("width"));
			
		}
		
		if(fil=="period")
		{
			pvl=event.pageX-divoffset.left+5;
			var P=poi;	
			var CW =  str2int($("#"+P).parent().css("width"))-str2int($("#"+P).css("width"));
			var Ppos = pvl;
			var pr=((mx-mn)/CW);
			
			var svl= ((Ppos*pr)+mn).toFixed(0);
			
			$("#"+fil).val(svl);
			setPoint('period','SliderPoint5',1,4,'');
			
		}
		else
		{
			//$("#"+poi).animate({left:pvl}, {progress: function(animation, progress) {PointerFN(poi,fil,mn,mx,tx);}});
		}
		
		});
 

/*$("#SliderPoint").parent().click(function (event){
	
		var divoffset = $(this).offset();
		var pvl=event.pageX-divoffset.left;
		
		if(pvl>str2int($("#SliderPoint").css("width")))
		{
			pvl-=str2int($("#SliderPoint").css("width"));
			
		}
		$("#SliderPoint").animate({left:pvl},{progress: function(animation, progress) {PointerFN("SliderPoint","salary",0,1000000,'');} });
		
	});*/

}


function changSaEm() {
	var sl=str2int($("#texSal").val());
	var em=str2int($("#texEmi").val());
	if(em>sl) {
		alert("EMI can not be greater than Entered Monthly Salary");
		$("#texEmi, #texSal").val(adcoma(sl));
	} else if(sl<35000) {
		alert("Minimum Monthly Salary should be 30,000");
		$("#texSal").val(adcoma(35000));
	}	else if(sl>1000000) {
		$("#texSal").val(adcoma(1000000));
		changSaEm();	
	} else {

		$("#texSal").val(adcoma(sl));
		$("#texEmi").val(adcoma(em));
	}
	$("#texSal, #texEmi").prop("readonly","readonly");
}

var EditVr="";

function editvalue(e) {
	EditVr=$(e.target).parent().parent().find("input").val();
	$(e.target).parent().parent().find("input").removeAttr("readonly");
	$(e.target).parent().parent().find("input").val("");
	$(e.target).parent().parent().find("input").focus();
	$(e.target).parent().parent().find("input").focusout(function (event) {
		if(event.target.value=="" && event.target.id!="CompanyNam") {
			event.target.value=EditVr;
		} else if((event.target.value.length<5 || event.target.value.length >20) && event.target.id=="CompanyNam") {
			event.target.value=EditVr;
			company_vld(event.target.id);
		} else {
			$(e.target).parent().parent().find("input").trigger( "onchange" );
		}
	}); 
}

function company_vld(e) {
	//EditVr=$("#"+e).val();
	var compname_length = ($("#"+e).val()).length;	
	if(compname_length <5  || compname_length >20) {
	   //alert('Company name must be more than 3 characters long');
	   //e.target.value="Type your company name";	
	}
	$("#"+e).prop("readonly","readonly");
}




	function chkboxFn(e) {
		if(e.target.checked == true) {
			$("#submitBtn, #applyBtn").removeAttr("disabled");
				$("#submitBtn, #applyBtn").removeClass("disabled");
				$("#checkboxFiveInput").next("label").addClass("activeCheckbox");
		} else {	
			$("#submitBtn, #applyBtn").prop("disabled","disabled");
			$("#submitBtn, #applyBtn").addClass("disabled");
		}
	}



function chkboxFn2(e)
{

	if(e.target.checked==true)
	{
	 if($("#PinCr").val()!="" && $("#AddrCr").val()!="")
	 {
		$("#PinPr").val($("#PinCr").val());
		$("#AddrPr").val($("#AddrCr").val());
		
		$("#spnAP").html("");
		$("#spnPP").html("");
		
		
		$("#DivPA input, #DivPA select, #DivCA input, #DivCA select").each(function()
		{
			
			$(this).not("input[type=checkbox]").prop("disabled","true");
			
		});
		
		
	 }
	 else
	 {

		 e.target.checked=false;
	 }
	 
	}
	else
	{	
		$("#PinPr").val("");
		$("#AddrPr").val("");
		$("#spnAP").html("Permanent Address*");
		$("#spnPP").html("Pin Code*");
		
		$("#DivPA input, #DivPA select").each(function()
		{
			$(this).removeAttr("disabled");
			$(this).prev().css("visibility","visible");
			
		});
		
		$("#DivCA input, #DivCA select").each(function()
		{
			$(this).removeAttr("disabled");
			
		});
		
	}
}



function block_FN(ev,bid,nbid) {
	if("block3" != bid) {
		var chk=0;
		$("#"+bid+" input").not().each(function() {

			if($(this).attr("id")!="datepicker-example2" && $(this).parents('.notValidate').length < 1) {
				if($(this).val() == "" && ($(this).prev().html()).indexOf("*") != -1) {
					chk = 1;
				}
				if((email_vld($(this).val()) == false && ($(this).prev().html()).indexOf("Email") != -1) ) {
					chk = 1;
				}				
				if(( ($(this).prev().html()).indexOf("Mobile") != -1 && ($(this).prev().html()).indexOf("*") != -1 && $(this).val().length < 10)) {
					chk = 1;
					//$(this).css("border-bottom", "solid 1px #f00");
				}
			}
		});

		if(chk == 0) { 
			/*if(nbid=="block2") {
				$(".detailfields").each(function() {
					if($ != '') {
						$(this).find('span').css('visibility', 'hidden');
					}
				});
			}*/
			$("#"+nbid).show(500);
			if(nbid == "block2") {
				if($("#mobileno").val() != '' &&  $("#mobileno").val() != 'Mobile Number1*') {
					$("#mobileno").closest(".detailfields").find("span").css('visibility', 'hidden');
					$("#block3").show();
				}
				if($("#emailId").val() != '' &&  $("#emailId").val() != 'Email ID*') {
					$("#emailId").closest(".detailfields").find("span").css('visibility', 'hidden');
					$("#block3").show();
				}
				
			}
			
		} else {
			$("#"+nbid+" input").each(function() {
				//$(this).val("");
				//$(this).prev().css("visibility","visible");
			});
			//$("#"+nbid).hide(500);
		}
	}
	
}





function block_FN2(ev,bid,nbid){
		var chk=0;

	  if(bid=="block1 select" || bid=="block3 select") {  
			$("#"+bid).each(function() {		
				if($(this).val()=="") {
					chk=1;
				}
			});
		} else {
			$("#"+bid).each(function() {
				var name = $(this).attr("name");
				if($("input:radio[name="+name+"]:checked").length == 0) {
					chk = 1;
				}
			});	
		}
	
		
		if(chk==0) {
			if(nbid=="block2" || nbid=="block3") {
				$("#"+nbid).show(500);
				
			} else {
				$("#"+nbid).removeClass("disabled"); $("#"+nbid).removeAttr("disabled");
			}
		} else {
			if(nbid=="block2") {
				//$("#"+nbid).hide(500);
				$("#block3").hide(500);
				
				$("#block2 input[type=radio]").each(function () 
				{ 
					$(this).removeAttr("checked").next("label").css("background-position", "0 -18px"); ;
					
					
				});
				
				$("#buttonElg").addClass("disabled").prop("disabled","true");
				
			}
			else if(nbid=="block3")
			{
				$("#"+nbid).hide(500);
			}
			else
			{
				$("#"+nbid).addClass("disabled"); $("#"+nbid).prop("disabled","true");
			}
			
			
		}
	
	
}

function monthDiff(d1, d2){
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months += d2.getMonth() - d1.getMonth();
    return months;
}



function email_vld(vr){
		var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
		if(pattern.test(vr))
		{
		  return true;
		}
		else
		{
			return false;
		}
	};


/*
$('input').on("keypress", function(e) {
     
      if (e.keyCode == 13) {
   
    var inputs = $(this).parents("form").eq(0).find(":input");
    var idx = inputs.index(this);

    if (idx == inputs.length - 1) 
				{
        inputs[0].select()
    } else {
        inputs[idx + 1].focus(); 
        inputs[idx + 1].select();
    }
    return false;
      }
  });*/


  $('#datepicker-example1').click(function(){
  	$("#block4").fadeIn();
  });


$( function() {

	$(".ededit input[disabled]").addClass("color_INPT");
	$("#SliderPoint" ).slider({
      value:35000,
      min: 35000,
      max: 1000000,
      step: 1000,
      slide: function( event, ui ) {
  $( "#salary" ).val(adcoma(ui.value));

      }
    });
    $( "#salary" ).val($( "#SliderPoint" ).slider( "value" ) );

    $( "#SliderPoint2" ).slider({
      value:0,
      min: 0,
      max: /*parseInt(removeComa($('#salary').val()))*/1000000,
      step: 100,
      slide: function( event, ui ) {
  $( "#emis" ).val(adcoma(ui.value));
      }
    });
    $( "#emis" ).val($( "#SliderPoint2" ).slider( "value" ) );

    $("#SliderPointcoapp1" ).slider({
      value:35000,
      min: 35000,
      max: 1000000,
      step: 1000,
      slide: function( event, ui ) {
  $( "#salarycoapp1" ).val(adcoma(ui.value));
		$("#SliderPointcoapp2" ).slider("option", "max", ui.value);
      }
    });

	$( "#salarycoapp1" ).val($( "#SliderPointcoapp1" ).slider( "value" ) );
     $( "#SliderPointcoapp1" ).on( "slidestop", function( event, ui ) {
		$("#salariedval_1").html(adcoma(str2int($("#salarycoapp1").val())));
      });
	    

    $("#SliderPointcoapp2" ).slider({
      value:0,
      min:0,
      max: 1000000,
      step: 1000,
      slide: function( event, ui ) {
	$( "#salarycoapp2" ).val(adcoma(ui.value));
      }
    });
    $( "#salarycoapp2" ).val($( "#SliderPointcoapp2" ).slider( "value" ) );


    $("#SliderPointcoapp3").slider({
      value:35000,
      min: 35000,
      max: 1000000,
      step: 1000,
      slide: function( event, ui ) {
		$( "#salarycoapp3" ).val(adcoma(ui.value));
		$("#SliderPointcoapp4" ).slider("option", "max", ui.value);
		
      }
    });
    $( "#salarycoapp3" ).val($( "#SliderPointcoapp3" ).slider( "value" ) );
     $( "#SliderPointcoapp3" ).on( "slidestop", function( event, ui ) {
		$("#salariedval").html(adcoma(str2int($("#salarycoapp3").val())));
      });

    $("#SliderPointcoapp4" ).slider({
      value:0,
      min: 0,
      max: 1000000,
      step: 1000,
      slide: function( event, ui ) {
  $( "#salarycoapp4" ).val(adcoma(ui.value));
      }
    });
    $( "#salarycoapp4" ).val($( "#SliderPointcoapp4" ).slider( "value" ) );

   











	
   //$('#SliderPoint2').slider( "option", "max", parseInt(removeComa($('#mxemi').text()) ));
   //
   //
   //
   //
   //
   //
   //
  /*$(".inventslider" ).slider({
      value:parseInt(removeComa($('.myval1').text())),
      min: 100000,
      max: parseInt(removeComa($('.myval1').text())),
      step: 1000,
      slide: function( event, ui ) {
  $( ".inventloan" ).val(adcoma(ui.value));
      }
    });
    $( ".inventloan" ).val($( ".inventslider" ).slider( "value" ) );*/




 $(".salnext").click(function(){
 	$('#SliderPoint2').slider( "option", "max", parseInt(removeComa($('#salary').val())));	
 });

 /*$(".edBottomSubmit").click(function(){
 	$('.inventslider').slider( "option", "max", parseInt(removeComa($('.myval1').text())));
 });*/

   /* $( "#SliderPoint3" ).slider({
      value:2500000,
      min: 100000,
      max: 2500000,
      step: 1000,
      slide: function( event, ui ) {
  $( "#loan" ).val(adcoma(ui.value));
      }
    });
    $( "#loan" ).val($( "#SliderPoint3" ).slider( "value" ) );*/



});/**/

