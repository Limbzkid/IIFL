<?php
	session_start();
	$page = basename($_SERVER['PHP_SELF'], ".php");
	if($page == 'index') {
		$current_page = 'home';
	} else {
		$current_page = str_replace('-', '_', $page);
	}
?>


<!doctype html>
<!--[if lt IE 7 ]><html class="no-js ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]--> 
<head>
	<title>IIFL : Sapna Aapka, Loan Hamara</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
	<link rel="shortcut icon" href="images/favicon.ico">
	<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
	<script type="text/javascript" src="js/css3mediaquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<link href="css/fonts.css" rel="stylesheet" type="text/css">
	<link href="css/iifl.css" rel="stylesheet" type="text/css">
	<link href="css/media.css" rel="stylesheet" type="text/css">
	<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
	<script src="js/jquery.easing.min.js" type="text/javascript"></script> 
	<script src="js/function.js" type="text/javascript"></script>
	<?php if($current_page == "home"): ?>
		<script>
			$(function() {
				$( "#sliderintervals").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"amounttoslide",30000,1000000,'');
					}
				});
				clickbar("sliderintervals","amounttoslide",30000,1000000,"");
			});
			
			function calbackEmi() {
				// use only emi page..but dont delete..
			}
		
			function emislid() {
				$("#mxemi").html(adcoma(str2int($("#amounttoslide").val())));
				$( "#SliderPoint2").draggable({
					containment: "parent", axis: "x", drag: function(event, ui) {
						PointerFN(event.target.id,"emis",0,str2int($("#amounttoslide").val()),'');
					}
				});
				clickbar("SliderPoint2","emis",0,str2int($("#amounttoslide").val()),"");
			}
		</script>
		<script>
			$(function(){
				$('.mobie-errormsg').hide;
				$('.email-errormsg').hide;
				var error_mobile = false;
				var error_email = false;
				$('#mobilefield').focusout(function(){chkmobile();});
				$('#emailfield').focusout(function(){chkemail();});
				
				function chkmobile(){
					var pattern = new RegExp(/^[1-9]{1}[0-9]{9}$/);
					if(pattern.test($('#mobilefield').val())){
						$('.mobie-errormsg').hide();
					} else {
						$('.mobie-errormsg').html('Mobile number must be in 10 digit');
						$('.mobie-errormsg').show();
						error_mobile = true;
					}
				};
				
				function chkemail(){
					var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
					if(pattern.test($('#emailfield').val())){
						$('.email-errormsg').hide();
					} else {
						$('.email-errormsg').html('Invalid email address');
						$('.email-errormsg').show();
						error_email = true;
					}
				};
				
				$('#form1').submit(function(){
					error_mobile = false;
					error_email = false;
					chkmobile();
					chkemail();
					if(error_mobile == false && error_email == false){
						return true;
					} else {
						return false;	
					}
				});
			});
		</script>
	<?php endif; ?>
	<?php if($current_page == "calculate_loan"): ?>
	<script>
	$(function() {
		$( "#SliderPoint3").draggable({
			containment: "parent", axis: "x", drag: function(event, ui){
				PointerFN(event.target.id,"loan",<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');
			}
		});
		$( "#SliderPoint4").draggable({
			containment: "parent", axis: "x", drag: function(event, ui){
				PointerFN(event.target.id,"years",1,<?php echo $_SESSION['personal_details']['tenure']/12 ; ?>,' Years');
			}
		});
		setPoint('loan','SliderPoint3',<?php echo $_SESSION['personal_details']['minloanamt']; ?>,<?php echo $_SESSION['personal_details']['maxloanamt']; ?>,'');
		setPoint('years','SliderPoint4',1,<?php echo $_SESSION['personal_details']['tenure']/12 ; ?>,' Years');
		clickbar("SliderPoint3","loan",0,1000000,"");
		clickbar("SliderPoint4","years",0,<?php echo $_SESSION['personal_details']['tenure']/12 ; ?>," Years");
	});

	function chkboxFn(e) {
		if(e.target.checked==true) {
			$("#submitBtn").removeAttr("disabled");
			window.open('IIFLT&C.pdf', '_blank');
			$("#submitBtn").removeClass("disabled");
		} else {	
			$("#submitBtn").prop("disabled","disabled");
			$("#submitBtn").addClass("disabled");
		}
	}

	function calbackEmi() {
		var emiVal = emical(str2int($("#loan").val()),str2int($("#years").val()),<?php echo $_SESSION['personal_details']['tenure']/12 ; ?>);
		$("#emidiv").html(emiVal);
		$("#emiVal").val(emiVal);
	}
</script>
		
	<?php endif; ?>
	<?php if($current_page == "know_your_customer"): ?>
		<link rel="stylesheet" href="css/default.css" type="text/css">
		<script type="text/javascript" src="js/zebra_datepicker.js"></script>
		<script type="text/javascript" src="js/core.js"></script>
	<?php endif; ?>
</head>
<body class="bodyoverflow <?php echo $current_page; ?>" onLoad="form1.reset();" style="font-family:'MyriadPro-Semibold';">
	<div id="main-wrap">
		<header>
    	<div class="header-inner">
  <div class="logo"><img src="images/logo.jpg" class="scale"></div>
				<div class="personal-loan"><img src="images/personal.png" class="scale"></div>
				<div class="clr"></div>
				<?php if($current_page == 'home') { ?>
					<div class="card-container1">
						<div><img src="images/pendulamline.png" class="scale"></div>
						<div class="card1 flip">
							<div class="side1"><img src="images/48hours.png" class="scale"><div class="express-home">Express<br>Personal<br>Loan</div></div>
							<div class="side1 back1"><img src="images/48hours.png" class="scale"><p class="instant-home">INSTANT<br>APPROVAL</p></div>
						</div>
					</div>
				<?php } else { ?>
					<div class="card-container">
						<div><img src="images/pendulamline.png" class="scale"></div>
						<div class="card flip">
							<div class="side"><img src="images/48hours.png" class="scale"><p class="pendulamtxt">Express<br>Personal<br>Loan</p></div>
							<div class="side back"><img src="images/48hours.png" class="scale"><p class="pendulamtxt">INSTANT<br>APPROVAL</p></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</header>