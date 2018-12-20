/*! jQuery UI - v1.12.1 - 2016-09-18
* http://jqueryui.com
* Includes: widget.js, position.js, data.js, disable-selection.js, focusable.js, form-reset-mixin.js, jquery-1-7.js, keycode.js, labels.js, scroll-parent.js, tabbable.js, unique-id.js, widgets/draggable.js, widgets/droppable.js, widgets/resizable.js, widgets/selectable.js, widgets/sortable.js, widgets/accordion.js, widgets/autocomplete.js, widgets/button.js, widgets/checkboxradio.js, widgets/controlgroup.js, widgets/datepicker.js, widgets/dialog.js, widgets/menu.js, widgets/mouse.js, widgets/progressbar.js, widgets/selectmenu.js, widgets/slider.js, widgets/spinner.js, widgets/tabs.js, widgets/tooltip.js, effect.js, effects/effect-blind.js, effects/effect-bounce.js, effects/effect-clip.js, effects/effect-drop.js, effects/effect-explode.js, effects/effect-fade.js, effects/effect-fold.js, effects/effect-highlight.js, effects/effect-puff.js, effects/effect-pulsate.js, effects/effect-scale.js, effects/effect-shake.js, effects/effect-size.js, effects/effect-slide.js, effects/effect-transfer.js
* Copyright jQuery Foundation and other contributors; Licensed MIT */

function PointerFN(P,S,mn,mx,tx) {
	var CW =  str2int($("#"+P).parent().css("width"))-str2int($("#"+P).css("width"));
	var Ppos = str2int($("#"+P).css("left"));
	var pr=((mx-mn)/CW);
	var svl= ((Ppos*pr)+mn).toFixed(0);
	if(svl<=1 && (S=="years" || S=="period")) {
		if(S=="years") {
			tx=" Year";
			$("#"+S).val("1 Year");
		} else {
			$("#"+S).val(1);
		}
	} else {
		$("#"+S).val(adcoma(svl)+tx);
	}
	
	if(svl>mx) {
	  $("#"+S).val(adcoma(mx)+tx);
	}
	
	calbackEmi();
}


function adcoma (vl)

{
		var money =vl;
		var dsml=""
		money = money.toString();
		dsml=money.split('.');
		var comaVL = ""
			
			if(dsml[0].length>3)
			{
				for (i=dsml[0].length; i>=3; i--)
				{
					if (i == 3)
					{
						l = dsml[0].substring(dsml[0].length-3, dsml[0].length);
						comaVL = comaVL+l;
					}
					if (i%2 == 0)
					{
						co = dsml[0].substring(dsml[0].length-i, (-(-(dsml[0].length-i)-1)))+",";
						comaVL = comaVL+co;
					}
					if (i%2>0 && i != 3)
					{
						co = dsml[0].substring(dsml[0].length-i, (-(-(dsml[0].length-i)-1)));
						
						comaVL = comaVL+co;
					}
					
				}
			}
			else
			{
				comaVL=dsml[0];
			}
					
		
return comaVL;

}


function isNumberKey(e)
{
	
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
	 {
		return false;
	 }
		
}


function setPoint(vr1,vr2,mn,mx,tx) {
	console.log("new folder")	
	var sal = str2int($("#"+vr1).val());
	if(sal>mx)	{		
		$("#"+vr1).val(adcoma(mx)+tx);
	} else if(sal<mn) {		
		$("#"+vr1).val(adcoma(mn)+tx);
	} else {
		$("#"+vr1).val(adcoma(sal)+tx);
	}
	if($("#"+vr1).val()=="NaN" ) {
		$("#"+vr1).val(mn);
	}
	
	var CW =  str2int($("#"+vr2).parent().css("width"))-str2int($("#"+vr2).css("width"));
	var pr=((mx-mn)/CW);
	var Ppos=(( str2int($("#"+vr1).val()) - mn)/pr).toFixed(0);
	
	console.log(Ppos);
	$("#"+vr2).animate({left:Ppos});
	
	
	calbackEmi();
	
}


function str2int(sv)
{
	var tm1= sv.replace ( /[^\d.]/g, '' ); ;
	var rvl = parseInt(tm1, 10);
	
	return rvl;
}



function emical(p,n,r) {
	var P = p;
	var R = r/12/100;
	var N = n*12;

	var cal1 = Math.pow((1+R),N);
	var cal2 = cal1 -1;
	var cal3 = cal1 / cal2;
	var emi = Math.ceil((P * R) * cal3);
	
	//console.log((emi*N));
	return adcoma(emi);
}




//alert(emical(400000,4,16.5)); 




function clickbar(poi,fil,mn,mx,tx) {
	$("#"+poi).parent().click(function (event){
	
		var divoffset = $(this).offset();
		var pvl=event.pageX-divoffset.left;
		
		if(pvl>str2int($("#"+poi).css("width")))
		{
			pvl-=str2int($("#"+poi).css("width"));
			
		}
		
		
		$("#"+poi).animate({left:pvl}, {progress: function(animation, progress) {PointerFN(poi,fil,mn,mx,tx);} });
		
		});
  
 console.log(fil);

/*$("#SliderPoint").parent().click(function (event){
	
		var divoffset = $(this).offset();
		var pvl=event.pageX-divoffset.left;
		
		if(pvl>str2int($("#SliderPoint").css("width")))
		{
			pvl-=str2int($("#SliderPoint").css("width"));
			
		}
		console.log($("#SliderPoint").css("width"));
		$("#SliderPoint").animate({left:pvl},{progress: function(animation, progress) {PointerFN("SliderPoint","salary",0,1000000,'');} });
		
	});*/

}


function changSaEm()
{
	
	var sl=str2int($("#texSal").val());
	var em=str2int($("#texEmi").val());
	
	if(em>sl)
	{
		alert("EMI can not be greater than Entered Monthly Salary");
		$("#texEmi, #texSal").val(adcoma(sl));
	}
	else if(sl>1000000)
	{
		$("#texSal").val(adcoma(1000000));
		changSaEm();	
	}
	else
	{
		$("#texSal").val(adcoma(sl));
		$("#texEmi").val(adcoma(em));
	}
	
}

var EditVr="";
function editvalue(e) {
	EditVr=$(e.target).parent().parent().find("input").val();
	$(e.target).parent().parent().find("input").removeAttr("readonly");
	$(e.target).parent().parent().find("input").val("");
	$(e.target).parent().parent().find("input").focus();
	$(e.target).parent().parent().find("input").focusout(function (event) {
		if(event.target.value=="" && event.target.id!="CompanyNam") {
			event.target.value = EditVr;
		} else if(event.target.value.length<5 || event.target.value.length >20) {
			event.target.value = EditVr;
			company_vld(event.target.id);
		} else {
			$(e.target).parent().parent().find("input").trigger( "onchange" );
		}
	}); 
}

