<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php
    unset($_SESSION['co_applicant_details']);
// echo "<pre>"; print_r($_SESSION); exit;
	/*-----------------------------Get House Type----------------------------------*/
    /*$residence_list = '';
    $service_url = COMMON_API. 'SearchFetchDropDown';
    $headers = array (
    "Content-Type: application/json"
    );
    $curl_post_data = array("CategoryName"  => "ResidenceType");
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
        $residence_list .= '<option value="'.$id.'">'.$value.'</option>';
    }*/
    /*-----------------------------Get House Type Ends----------------------------------*/
    /*-----------------------------Relation Type----------------------------------*/
    $relation_list = '';
    $service_url = COMMON_API. 'SearchFetchDropDown';
    $headers = array (
    "Content-Type: application/json"
    );
    $curl_post_data = array("CategoryName"  => "RelationwithApplicant");
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
        $relation_list .= '<option value="'.$id.'">'.$value.'</option>';
    }
    /*-----------------------------Relation Type Ends----------------------------------*/
  /* ----------------------------- Get City List   ---------------------------------------*/
    $output = '';
    $service_url = COMMON_API .'SearchFetchDropDown';
    $headers = array (
    "Content-Type: application/json"
    );
    $curl_post_data = array("CategoryName"  => "CityMaster");
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
    if($curl_response) {
        foreach($curl_response->Body->MasterValues as $data) {
            $id = $data->dropdownid;
            $value = $data->dropdownvalue;
            $output .= '<div class="homecityradio"><input type="radio" name="radio" value="'.$id.'" id="'.$id.'"><label for="'.$id.'">'.$value.'</label></div>';
        }
    }
  /* ----------------------------- City List ends ---------------------------------------*/
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,  user-scalable = no" />
<title>IIFL : Sapna Aapka, Loan Hamara</title>
<link rel="shortcut icon" href="images/favicon.ico">
<script type="text/javascript" src="js/jquery.2.1.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="js/css3mediaquery.js"></script>
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="css/fonts.css" rel="stylesheet" type="text/css">
<link href="css/iifl.css" rel="stylesheet" type="text/css">
<link href="css/media.css" rel="stylesheet" type="text/css">
<script src="js/jquery.easing.min.js" type="text/javascript"></script>
<script src="js/function.js" type="text/javascript"></script>
<script>

$(function(){
    $(".co-app-tab-header li a").click(function(){
        $(this).addClass("link-active").parent().siblings('li').find('a').removeClass("link-active");
        var getclassname = $(this).parent().attr('class');
        $('.co-app-tab-child[rel="'+getclassname+'"]').fadeIn();
        $('.co-app-tab-child[rel="'+getclassname+'"]').siblings().hide();
    }).eq(1).click();

    $("#corelselect").change(function(){
        $(this).find("option:selected").each(function(){
            $(".blocknew2").fadeIn();
            $(".blocknew3").css('opacity','1');
        });
    });

    $("#SliderPoint").on("slidechange", function( event, ui ) {
        $("#mxemi").html(adcoma(str2int($("#salary").val())));
    });

    $('.chkpersonal-info input[type="radio"]').click(function(){
		if($(this).attr("value")=="salaried"){
            $(".sameclasscoapp").not(".salaried").hide();
            $(".salaried").fadeIn();
        }
        if($(this).attr("value")=="semp"){
            $(".sameclasscoapp").not(".semp").hide();
            $(".semp").fadeIn();
        }
    }).eq(0).click();
	
	$("#corelselect").change(function(){
		var corelselect = $("#corelselect option:selected").val();
		if(corelselect == "")
		{
			$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
		}
		else if(corelselect == "Relation with applicant*"){
			$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
		}
		else{
			$("#error-user").css('display','none');
		}
	});
	
	$("#coappselect").change(function(){
		$(this).next("#error-user").remove();
		var coappselect = $("#coappselect option:selected").val();
		if(coappselect == "")
		{
			$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
		}
		else if(coappselect == "Residence Type*"){
			$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
		}
		else{

			$(this).next("#error-user").css('display','none');
		}
	});

	$("#cnamecoappnatureprofession").change(function(){
		var cnamecoappnatureprofession = $("#cnamecoappnatureprofession option:selected").val();
		if(cnamecoappnatureprofession == "")
		{
			$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
		}
		else if(cnamecoappnatureprofession == "Residence Type*"){
			$(this).after('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
		}
		else{
			$("#error-user").css('display','none');
		}
	});
	/*
	$(document).on("change", "#cnamecoapp", function(e){

		if($(this).val().length < 3) {

				$(this).next('<div id="error-user" class="mobtextcenter" style="display: block;">Please select at least One option</div>');
				$(this).addClass('sad');
				//return false;
			}
	});	*/
	
				
	
});	


</script>
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
<body class="bodyoverflow calculate_loan">

<!-- PL Apply Now --> 
<img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Apply-Now=<Apply-Now>&ev_transid=<?php echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1" class="transbg"/> 
<!-- End PL Apply -->

<div id="main-wrap">
<header>
    <div class="header-inner knowmore">
        <div class="logo"><img src="images/logo.jpg" class="scale"></div>
        <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
        <div class="headerRefID">Application Reference No: <strong><?php echo $_SESSION['personal_details']['CRMLeadID']; ?></strong></div>
        <div class="clr"></div>
        <div class="card-container-outerinner">
            <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
            <div class="card-container1 effect__random card-container" data-id="1">
                <div class="card__front"> <img src="images/48hours.png" class="scale">
                    <p class="pendulamtxt">Express<br>Personal<br>Loan</p>
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
<form id="form1" name="form1" method="post" action="co-applicant-aadhar">
    <div id="msform">
        <section class="body-home-outer myclass screen05bg bgpink">
            <div class="heightdesign2 screen5 height-ipad-812 heght_autoclass" >
                <ul class="co-app-tab-header">
                    <li class="tablink-1"><a href="#">1st applicant</a></li>
                    <li class="tablink-2"><a href="#" class="link-active">co-applicant</a></li>
                </ul>
            <div class="innerbody-home co-app-tab-parent clr" style="height:auto">
                <div class="approval-leftpoints visibleall margintop5per centerall">
                    <div class="emi-quoteicon width57"><img src="images/emiicon.png" class="scale"><br />
                        <span class="pagin-detail">EMI Quote</span>
                    </div>
                    <div class="lefticons-line"></div>
                    <div class="emi-quoteicon width57"><img src="images/emiicon.png" class="scale"><br />
                        <span class="pagin-detail">My Details</span>
                    </div>
                    <div class="lefticons-line"></div>
                    <div class="emi-quoteicon width57"><img src="images/detailicon-big.png" class="scale"><br />
                        <span class="pagin-detail">Co-applicant's Details</span>
                    </div>
                    <div class="lefticons-line"></div>
                    <div class="emi-quoteicon width57"><img src="images/eligible-icon-fade.png" class="scale"><br />
                        <span class="pagin-detail">Eligibility</span>
                    </div>
                    <div class="lefticons-line"></div>
                    <div class="emi-quoteicon width57 lasticon"><img src="images/document-icon-fade.png" class="scale"><br />
                        <span class="pagin-detail">Documents</span>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="co-app-tab-child" rel="tablink-1">
                    <div class="loan-detailbox">
                        <div class="loan-details">Loan Details</div>
                        <div class="loan-amount">Loan Amount -
                        	<span class="orange"><span class="disp-in-block"><b class="rupee-symb">`</b> <b id="loanAmu"><?php echo to_rupee($_SESSION['personal_details']['appliedloanamt']);?></b></span></span>
                        	<br>
                            Loan Tenure -
                        	<span class="orange" id="tenure"><?php echo ($_SESSION['personal_details']['actual_tenure']/12);?> Year<?php if($_SESSION['personal_details']['actual_tenure']/12 == 1) echo ''; else echo 's'?></span>
                    	</div>
                        <div class="loan-amount loanamout-small">Rate of Interest -
                            <span class="orange"><?php echo $_SESSION['personal_details']['roi_actual']?> %</span>
                            <br>
                            Processing Fees -&nbsp;
                            <span class="orange"><b class="rupee-symb">`</b> <?php echo to_rupee($_SESSION['personal_details']['processing_fee']);?></span>
                    	</div>
                        <div class="total-emi">EMI -
                    		<span class="orange">
                    			<span class="disp-in-block"><b class="rupee-symb">`</b> 
                    			<b id="emidiv"><?php echo to_rupee($_SESSION['personal_details']['actualloanEMI']);?></b></span>
                    		</span>
                    	</div>
                        <div class="clr none"></div>
                    </div>
                    <div class="appdetails-coapp">
                        <div class="aadhar-heading paddtop40 margin-bott20">Applicant's details</div>
                        <div class="detailwrap-line1">
                            <div class="detailfields mmargin-bott20">
                                <div class="placholderval">Applicant's company name</div>
                                <label class="input"> <span></span>
                                    <input type="text" name="coapp1coname" id="coapp1coname" value="<?php echo $_SESSION['personal_details']['companyname']?>" disabled />
                                </label>
                            </div> 
                            <div class="detailfields mmargin-bott20">
                                <div class="placholderval">Applicant's net monthly salary</div>
                                <label class="input"> <span></span>
                                    <input type="text" name="coapp1sal" id="coapp1sal" value="<?php echo to_rupee($_SESSION['personal_details']['salary']);?>" disabled />
                                </label>
                            </div>
                            <div class="detailfields mmargin-bott20">
                                <div class="placholderval">Applicant's EMI, if any</div>
                                <label class="input"> <span></span>
                                    <input type="text" name="coapp1emi" id="coapp1emi" value="<?php echo to_rupee($_SESSION['personal_details']['obligation']);?>" disabled />
                                </label>
                            </div>  
                            <div class="clr"></div>
                        </div>
                    </div>
                </div>
                <div class="co-app-tab-child" rel="tablink-2">
                    <div class="blocknew1">
                        <div class="hometop-container paddtop0">
                        <h1 class="textleft">Relation with applicant</h1>
                        </div>
                        <div class="detailfields textleft">
                        <label class="input">
							<div class="select_valall"></div>
                            <select id="corelselect" name="relationtype" class="mfl select_iconall">
                                <option value="">Relation with applicant*</option>
                                <?php echo $relation_list; ?>
                            </select>
                        </label>
                        </div>
                        <div class="clr"></div>
                        <!--<div class="hometop-container paddtop0">
                            <h1 class="textleft">Residence information</h1>
                        </div>
                        <div class="detailfields textleft">
                            <label class="input">
                                <select id="coappselect" name="residencetype" class="mfl residence_type">
                                    <option value="">Residence Type*</option>
                                    <?php //echo $residence_list; ?>
                                </select>
                            </label>
                        </div>-->
                    </div>
                    <div class="blocknew2 clr">
                        <div class="hometop-container paddtop0">
                            <h1 class="textleft margin-bott20">Occupation</h1>
                        </div>
                        <div class="personalinfo-radiobox marginspace0">
                            <div class="inputcheckbx">
                                <div class="chkpersonal-info coappradio1">
                                    <input type="radio" name="occupation" id="d" value="salaried">
                                    <label for="d">Salaried</label>
                                </div>
                                <div class="chkpersonal-info coappradio2">
                                    <input type="radio" name="occupation" id="e" value="semp">
                                    <label for="e">Self employed</label>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="blocknew3 clr sameclasscoapp salaried">
                        <div class="detailwrap-line1">
                            <div class="detailfields width100 marginspace0 paddtop40 mpaddtop12 hometop-container">
                                <h1 class="textleft margin-bott20">Where does your co-applicant work?</h1>
                                <label class="input width100 max-width285"> <span class="pholder">Type your company name*</span>
                                    <input name="cnamecoapp" id="cnamecoapp" class="companylist" value="" type="text">
                                </label>
                            </div><div class="clr"></div>
                            <div class="hometop-container fl">
                    			<h1 class="textleft">What is co-applicant's net monthly salary?</h1>
                    			<div class="salary-slider fl slimargin">
                    				<div class="slidericon" id="SliderPointcoapp3"></div>
                    				<div class="leftvalue">35,000</div><div class="rightvalue">10,00,000</div>
                    			</div>
                    			<div class="companyname fl compmargin">
                    				<b class="rupeeicon">`</b>
                    				<input type="text" name="SliderPointcoapp3" class="salaryinput" id="salarycoapp3" value="35,000" maxlength="8"  onkeypress="return isNumberKey(event)" onChange="setPoint('salarycoapp3','SliderPointcoapp3',35000,1000000,'');"/>      
                    			</div><div class="clr"></div>
                    			<div class="eerr">salary cannot be less than 35,000</div>
                        	</div>
                    		<div class="hometop-container fl">
                    			<h1 class="textleft">What are your co-applicant's current EMIs, if any? </h1>
                    			<div class="salary-slider fl slimargin">
                    				<div class="slidericon" id="SliderPointcoapp4"></div>
                    				<div class="leftvalue">0</div><div class="rightvalue" id="salariedval">10,000,00</div>
                    			</div>
                    			<div class="companyname fl compmargin">
                    				<span class="rupeeicon">`</span>
                    				<input type="text" name="salarycoapp4" class="salaryinput" id="salarycoapp4" value="0" maxlength="8"  onkeypress="return isNumberKey(event)" onChange="setPoint('salarycoapp4','SliderPointcoapp4',0,str2int($('#salarycoapp3').val()),'');" />  
                    			</div><div class="clr"></div>
                    		</div>
                        </div>
                    </div>
                    <div class="blocknew4 clr sameclasscoapp semp">
                        <div class="detailwrap-line1">
                            <div class="detailfields width100 marginspace0 paddtop40">
                                <div class="aadhar-heading textleft margin-bott20">What is co-applicant's nature of business</div>
                                <label class="input width100 max-width285 coapp_nature_profession"> <span></span>
									<div class="select_valall left_align_clss"></div>
                                    <select name="cnamecoappnature" id="cnamecoappnature" value="" type="text" class="select_iconall">
										<option value="">Select nature of business*</option>
                                    </select>
                                </label>
                                <label class="input width100 max-width285"> <span></span>
									<div class="select_valall left_align_clss"></div>
                                    <select name="cnamecoappnatureprofession" id="cnamecoappnatureprofession" value="" type="text" class="select_iconall">
										<option value="">Select profession*</option>
                                    </select>
                                </label>
                            </div>
                            <div class="clr"></div>
                            <div class="detailfields width100 marginspace0 paddtop40">
                                <div class="aadhar-heading textleft margin-bott20">How do you operate as</div>
                                <label class="input width100 max-width285"> <span></span>
                                    <div class="select_valall left_align_clss"></div>
									<select name="cnamecoappnatureconstitution" id="cnamecoappnatureconstitution" value="" type="text" class="select_iconall">
										<option value="">Select profession*</option>
                                    </select>
                                </label>
                            </div>
                            <div class="clr"></div>
                            <div class="detailfields width100 marginspace0 paddtop40">
                                <div class="aadhar-heading textleft margin-bott20">What is the name of organization</div>
                                    <label class="input width100 max-width285"> <span>Type name of organization*</span>
                                        <input name="cnamecoapporg" id="cnamecoapporg" class="companylist" value="" type="text">
                                    </label>
                            </div>
                            <div class="clr"></div>
                            <div class="hometop-container fl">
                				<h1>What is co-applicant's net monthly salary?</h1>
                				<div class="salary-slider fl slimargin">
                					<div class="slidericon" id="SliderPointcoapp1">
                                    </div>
                					<div class="leftvalue">35,000</div><div class="rightvalue">10,00,000</div>
                				</div>
                				<div class="companyname fl compmargin">
                					<b class="rupeeicon">`</b>
                					<input type="text" name="salarycoapp1" class="salaryinput" id="salarycoapp1" value="35,000" maxlength="8" onkeypress="return isNumberKey(event)" onChange="setPoint('salarycoapp1','SliderPointcoapp1',35000,1000000,'');"/>      
                				</div><div class="clr"></div>
                				<div class="eerr">salary cannot be less than 35,000</div>
                			</div>
                			<div class="hometop-container fl">
                				<h1 class="textleft">What are your current EMIs, if any? </h1>
                				<div class="salary-slider fl slimargin">
                					<div class="slidericon" id="SliderPointcoapp2">
                                    </div>
                					<div class="leftvalue">0</div><div class="rightvalue" id="salariedval_1">10,000,00</div>
                				</div>
                				<div class="companyname fl compmargin">
                					<span class="rupeeicon">`</span>
                					<input type="text" name="obligation" class="salaryinput" id="salarycoapp2" value="0" maxlength="8"  onkeypress="return isNumberKey(event)" onChange="setPoint('salarycoapp2','SliderPointcoapp2',0,str2int($('#salarycoapp1').val()),'');" />	
                				</div><div class="clr"></div>
                			</div>
                        </div>
                    </div>
                    <div class="clr"></div>
                    <div class="next-home">
                        <input type="submit" name="next" id="submitBtn" value="NEXT" class="edBottomSubmit">
                	</div>
                </div>
                <div class="clr"></div>
            </div>
            </div>
            <div class="screen05img relatepos"> <img src="images/homescreen-05img.png" class="scale">
                <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
                <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
            </div>
            </div>
        </section>
    </div>
</form>
<?php require_once('includes/footer.php'); ?>
<script>
$(document).ready(function(){
    if(document.getElementById("d").checked)
    {

    }
    $('.chkpersonal-info input[id="e"]').click(function(){
        $.ajax({
            url:"ajax/occupation-type-details",
            type:"POST",
            data:{empType : 'self-emplyed'},
            success: function(msg){
                msg = JSON.parse(msg)
                msg = msg.Body.MasterValues;
                var businessList = '';
                $("#cnamecoappnature").html('');
                select = document.getElementById('cnamecoappnature');
                $('#cnamecoappnature').append($("<option></option>").attr("value",'').text('Select nature of business*')); 
                for (var i = 0; i < msg.length; i++) 
                {
                    $('#cnamecoappnature').append($("<option></option>").attr("value",msg[i].dropdownid).text(msg[i].dropdownvalue)); 
                };
            }
        });

        $.ajax({
            url:"ajax/occupation-type-details",
            type:"POST",
            data:{empType : 'Profession'},
            success: function(msg){
                msg = JSON.parse(msg)
                msg = msg.Body.MasterValues;
                var businessList = '';
                $("#cnamecoappnatureprofession").html('');
                select = document.getElementById('cnamecoappnatureprofession');
                $('#cnamecoappnatureprofession').append($("<option></option>").attr("value",'').text('Select profession*')); 
                for (var i = 0; i < msg.length; i++) 
                {
                    $('#cnamecoappnatureprofession').append($("<option></option>").attr("value",msg[i].dropdownid).text(msg[i].dropdownvalue)); 
                };
            }
        });

        $.ajax({
            url:"ajax/occupation-type-details",
            type:"POST",
            data:{empType : 'Constitutiontype'},
            success: function(msg){
                msg = JSON.parse(msg)
                msg = msg.Body.MasterValues;
                var businessList = '';
                $("#cnamecoappnatureconstitution").html('');
                select = document.getElementById('cnamecoappnatureconstitution');
                $('#cnamecoappnatureconstitution').append($("<option></option>").attr("value",'').text('Select Constitution type')); 
                for (var i = 0; i < msg.length; i++) 
                {
                    $('#cnamecoappnatureconstitution').append($("<option></option>").attr("value",msg[i].dropdownid).text(msg[i].dropdownvalue)); 
                };
            }
        });
    });
	/*
	$('#cnamecoapp').blur(function() {
		$(this).parent().find('span').hide();
		console.log($(this).parent().find('span').hide());
	});*//*
	$('#cnamecoapp').keypress(function(event){
		$(this).parent().find('span').hide();
		console.log($(this).parent().find('span').hide());
	});*/
	
	$('#cnamecoapp').bind('focus', function(){
		$('.pholder').hide();
	});
	$("#salarycoapp3").blur(function() {
		var stor_val = $(this).val();
		$("#salariedval").html(stor_val);
	});
	
});
/*$("#form1").submit(function(){
   
});*//*
function clear_self_employed()
	{
		$("#cnamecoappnature").val() = "";
		$("#cnamecoappnatureprofession").val() = "";
		$("#cnamecoappnatureconstitution").val() = "";
		$("#cnamecoapporg").val() = "";
		$("#salarycoapp1").val() = "35000";
		$("#salarycoapp2").val() = "0";
	}
	
function clear_Salaried()
	{
		$("#cnamecoapp").val() = "";
		$("#salarycoapp3").val() = "35000";
		$("#salarycoapp4").val() = "0";
	}	
*/
$("#form1").bind('submit', function() {

        $(".error-user").remove();

        var error = false;
        if($("#corelselect").val() == '') {
            $("#corelselect").after('<div id="error-user" class="error-user">Please select any one option.</div>');
            error = true;
        } 

        if($("#coappselect").val() == '') {
            $("#coappselect").after('<div id="error-user" class="error-user">Please select any one option.</div>');
            error = true;
        } 
        if($('#d').is(':checked'))
        {
			//clear_self_employed();
            if($("#cnamecoapp").val() == '') {
                $("#cnamecoapp").after('<div id="error-user" class="error-user">Company Name is required.</div>');
                error = true;
            } 
        }
        if($('#e').is(':checked'))
        {    
			//clear_Salaried();
            if($("#cnamecoappnature").val() == '') {
                $("#cnamecoappnature").after('<div id="error-user" class="error-user">Please select atleast one business.</div>');
                error = true;
            } 
            if($("#cnamecoappnatureprofession").val() == '') {
                $("#cnamecoappnatureprofession").after('<div id="error-user" class="error-user">Please select atleast one profession.</div>');
                error = true;
            }
            if($("#cnamecoapporg").val() == '') {
                $("#cnamecoapporg").after('<div id="error-user" class="error-user">Your organization name is required.</div>');
                error = true;
            } 

        }
        if(error){  
            return false;
        }
		
		
    
  });

  function calbackEmi() {
				var emiVal = emical(str2int($("#salarycoapp3").val()));
				$("#emidiv").html(emiVal);
				$("#emiVal").val(emiVal);
			}

</script>
