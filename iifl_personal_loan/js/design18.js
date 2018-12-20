

$(document).ready(function(e)
{
	$("#dub_cancel2").click(function()
	{	
		$("#docUploadBox2").slideUp(500);
		$(".dub_AddAccount").fadeIn(500);
	});	
	$("#dub_cancel3").click(function()
	{	
		$("#docUploadBox3").slideUp(500);
		$(".dub_AddAccount").fadeIn(500);
	});	
	
	
	$(".dub_AddAccount").click(function()
	{	
	var docUploadBox2 = $("#docUploadBox2").css("display");
	var docUploadBox3 = $("#docUploadBox3").css("display");	
	
		if(docUploadBox2 == 'none' && docUploadBox3 == 'none')	
		{
		$("#docUploadBox2").slideDown(500);
		}
		else if(docUploadBox2 == 'none' && docUploadBox3 == 'block')	
		{
		$("#docUploadBox2").slideDown(500);
		}
		else if(docUploadBox2 == 'block' && docUploadBox3 == 'none')	
		{
		$("#docUploadBox3").slideDown(500);
		$(".dub_AddAccount").fadeOut(500);
		}
		else if(docUploadBox2 == 'block' && docUploadBox3 == 'block')	
		{
		$(".dub_AddAccount").fadeOut(500);
		}
	});
	


	
	
	
	
	
    $(".docPopupClose").click(function()
	{
		$(".docPopupBG").fadeOut(500);
		$(".docPopupBox").fadeOut(500);
	});		
	
	$("#docOpenIdentity").click(function()
	{
		$(".docPopupBG").fadeIn(500);
		$("#dpbIdentity").fadeIn(500);
	});	
	
	

	$("#docOpenAddress").click(function()
	{
		$(".docPopupBG").fadeIn(500);
		$("#dpbAddress").fadeIn(500);
	});
	
	$("#docOpenBankStatement").click(function()
	{		
		$(".docPopupBG").fadeIn(500);
		$("#dpbBankStatement").fadeIn(500);
	});
					$("#docOpen-eStatement1, #docOpen-eStatement2").click(function()
					{		
					$(".docPopupBG").fadeIn(500);
					$("#dpbeStatement").fadeIn(500);
					});
					
					$("#docOpen-sStatement1, #docOpen-sStatement2").click(function()
					{		
					$(".docPopupBG").fadeIn(500);
					$("#dpbsStatement").fadeIn(500);
					});

	$("#docOpenSalarySlip").click(function()
	{
		$(".docPopupBG").fadeIn(500);
		$("#dpbSalarySlip").fadeIn(500);
	});
	
	$("#docOpenPropertyOwnership").click(function()
	{
		$(".docPopupBG").fadeIn(500);
		$("#dpbPropertyOwnership").fadeIn(500);
	});
	
	
	

});

$(document).ready(function() {
	$('.accordionButton').click(function() {
		$('.accordionButton').removeClass('on');
	 	$('.accordionContent').slideUp('fast');
		if($(this).next().is(':hidden') == true) {
			$(this).addClass('on');
			$(this).next().slideDown('fast');
			// $("body,html").animate({scrollTop : $(this).next('.accordionContent').offset().top}, 800);

			var getpos=  $(this);	
			setTimeout(function(){
					$("body,html").animate({scrollTop : getpos.offset().top -0}, 500)
					},500)
		 } 
	 });
	$('.accordionButton').mouseover(function() {
		$(this).addClass('over');
	}).mouseout(function() {
		$(this).removeClass('over');										
	});
	$('.accordionContent').hide();
});