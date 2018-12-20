<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php if(!isset($_SESSION['personal_details'])) { redirect_to(HOME); } ?>
<?php
// echo "<pre>"; print_r($_SESSION); exit;
  $error = false;
  unset($_SESSION['customer']);
    if($_POST['occupation'] == 'salaried') {
        if($_POST['SliderPointcoapp3'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(!is_numeric(num_only($_POST['SliderPointcoapp3']))) 
            {
                $error = true;
            } 
            else 
            {
                $monthlySalary = $_SESSION['co_applicant_details']['monthlySalary'] = xss_filter(num_only($_POST['SliderPointcoapp3']));
            }
        }

        /*if($_POST['residencetype'] == '')  {
          $error = true;
        } else {
          if(!is_numeric(num_only($_POST['residencetype']))) {
            $error = true;
          } else {
            $residencetype = $_SESSION['co_applicant_details']['residencetype'] = xss_filter(num_only($_POST['residencetype']));
          }
        }*/
          
        if($_POST['salarycoapp4'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(!is_numeric(num_only($_POST['salarycoapp4']))) 
            {
                $error = true;
            } 
            else 
            {
                $currentEmi = $_SESSION['co_applicant_details']['currentEmi'] = xss_filter(num_only($_POST['salarycoapp4']));
            }
        } 
          
        if($_POST['cnamecoapp'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(valid_company_name($_POST['cnamecoapp'])) 
            {
                $companyName = $_SESSION['co_applicant_details']['companyName'] = xss_filter($_POST['cnamecoapp']);
            } 
            else 
            {
                $error = true;
            }
        }

        if($_POST['relationtype'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(valid_company_name($_POST['relationtype'])) 
            {
                $relationType = $_SESSION['co_applicant_details']['relationType'] = xss_filter($_POST['relationtype']);
            } 
            else 
            {
                $error = true;
            }
        }

        if($_POST['occupation'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(valid_company_name($_POST['occupation'])) 
            {
                $occupation = $_SESSION['co_applicant_details']['occupation'] = xss_filter($_POST['occupation']);
                $companynature = $_SESSION['co_applicant_details']['cnamecoappnature'] = '';
                $companyProfession = $_SESSION['co_applicant_details']['cnamecoappnatureprofession'] = '';
                $companyconstitution = $_SESSION['co_applicant_details']['cnamecoappnatureconstitution'] = '';
            } 
            else 
            {
                $error = true;
            }
        } 
    }
    else
    {
        if($_POST['salarycoapp1'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(!is_numeric(num_only($_POST['salarycoapp1']))) 
            {
                $error = true;
            } 
            else 
            {
                $monthlySalary = $_SESSION['co_applicant_details']['monthlySalary'] = xss_filter(num_only($_POST['salarycoapp1']));
            }
        }

        /*if($_POST['residencetype'] == '') {
          $error = true;
        } else {
          if(!is_numeric(num_only($_POST['residencetype']))) {
            $error = true;
          } else {
            $residencetype = $_SESSION['co_applicant_details']['residencetype'] = xss_filter(num_only($_POST['residencetype']));
          }
        }*/

        if($_POST['obligation'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(!is_numeric(num_only($_POST['obligation']))) 
            {
                $error = true;
            } 
            else 
            {
                $currentEmi = $_SESSION['co_applicant_details']['currentEmi'] = xss_filter(num_only($_POST['obligation']));
            }
        }
        if($_POST['cnamecoapporg'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(valid_company_name($_POST['cnamecoapporg'])) 
            {
                $companyName = $_SESSION['co_applicant_details']['companyName'] = xss_filter($_POST['cnamecoapporg']);
            } 
            else 
            {
                $error = true;
            }
        }

        if($_POST['relationtype'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(valid_company_name($_POST['relationtype'])) 
            {
                $relationType = $_SESSION['co_applicant_details']['relationType'] = xss_filter($_POST['relationtype']);
            } 
            else 
            {
                $error = true;
            }
        }

        if($_POST['occupation'] == '') 
        {
            $error = true;
        } 
        else 
        {
            if(valid_company_name($_POST['occupation'])) 
            {
                $occupation = $_SESSION['co_applicant_details']['occupation'] = xss_filter($_POST['occupation']);
                $occupation = "Self employed";
                $companynature = $_SESSION['co_applicant_details']['cnamecoappnature'] = xss_filter($_POST['cnamecoappnature']);
                $companyProfession = $_SESSION['co_applicant_details']['cnamecoappnatureprofession'] = xss_filter($_POST['cnamecoappnatureprofession']);
                $companyconstitution = $_SESSION['co_applicant_details']['cnamecoappnatureconstitution'] = xss_filter($_POST['cnamecoappnatureconstitution']);
            } 
            else 
            {
                $error = true;
            }
        }
    }
  
  if($error) { redirect_to('resetpage'); }
  /*$loan_tenure      = $tenure/12;
  $company    = xss_filter($_SESSION['co_applicant_details']['companyname']);
  $salary     = xss_filter($_SESSION['co_applicant_details']['salary']);
  $obligation = xss_filter($_SESSION['co_applicant_details']['obligation']);  
  $crm_lead_id      = xss_filter($_SESSION['co_applicant_details']['CRMLeadID']);
  $email      = xss_filter($_SESSION['co_applicant_details']['emailid']);
  $mobile_no  = xss_filter($_SESSION['co_applicant_details']['mobileno']);
  $city       = xss_filter($_SESSION['co_applicant_details']['city']);
  $max_loan_amt     = xss_filter($_SESSION['co_applicant_details']['maxloanamt']);
  $min_loan_amt     = xss_filter($_SESSION['co_applicant_details']['minloanamt']);
  $emi_difference   = xss_filter($_SESSION['co_applicant_details']['emi_diff']);
  
  $processing_fee = ceil((xss_filter($_SESSION['co_applicant_details']['processing_fee_actual']) * $loan_amount) / 100);
  
  $total_amount_payable = ceil((xss_filter($_SESSION['co_applicant_details']['roi_actual']) / 100) * $loan_amount + ($loan_amount));
  $_SESSION['co_applicant_details']['processing_fee']     = $processing_fee;
  $_SESSION['co_applicant_details']['totalamountpayable'] = $total_amount_payable;*/
    
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
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="js/css3mediaquery.js"></script>
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="css/fonts.css" rel="stylesheet" type="text/css">
<link href="css/iifl.css" rel="stylesheet" type="text/css">
<link href="css/media.css" rel="stylesheet" type="text/css">
<script src="js/jquery.easing.min.js" type="text/javascript"></script>
<script src="js/function.js" type="text/javascript"></script>
<script>
      $(function() {  
  
      $(".co-app-tab-header li a").click(function(){
      $(this).addClass("link-active").parent().siblings('li').find('a').removeClass("link-active");
       var getclassname = $(this).parent().attr('class');
       $('.co-app-tab-child[rel="'+getclassname+'"]').fadeIn();
       $('.co-app-tab-child[rel="'+getclassname+'"]').siblings().hide();
       //$('html, body').animate({ scrollTop: $(".popup-video-tabs").offset().top }, 500); 
  }).eq(1).click();

      $("#coappselect").change(function(){
      $(this).find("option:selected").each(function(){
        $(".blocknew2").fadeIn();
        $(".blocknew3").css('opacity','1');
  });
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
<form id="form1" name="form1" method="post" action="">
  <div id="msform">
    <section class="body-home-outer myclass screen05bg bgpink">
    <div class="heightdesign2 screen5 height-ipad-812" >
      <ul class="co-app-tab-header">
  <li class="tablink-1"><a href="#">1st applicant</a></li>
  <li class="tablink-2"><a href="#" class="link-active">co-applicant</a></li>
      </ul>
      <div class="innerbody-home co-app-tab-parent innerbody-home" style="height:auto">
  <div class="approval-leftpoints visibleall margintop5per centerall">
    <div class="emi-quoteicon width57"><img src="images/emiicon.png" class="scale"><br />
      <span class="pagin-detail">EMI Quote</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57"><img src="images/emiicon.png" class="scale"><br />
      <span class="pagin-detail">My Details</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57"><img src="images/detailicon-big.png" class="scale"><br />
      <span class="pagin-detail">Co-applicant's Details</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57"><img src="images/eligible-icon-fade.png" class="scale"><br />
      <span class="pagin-detail">Eligibility</span></div>
    <div class="lefticons-line"></div>
    <div class="emi-quoteicon width57 lasticon"><img src="images/document-icon-fade.png" class="scale"><br />
      <span class="pagin-detail">Documents</span></div>
    <div class="clr"></div>
  </div>
  <div class="co-app-tab-child" rel="tablink-1">
  <div class="approval-right-container coapp-approvalcont">
      <?php if(isset($_SESSION['personal_details']['AddharNo'])) { ?>
  <div class="aadhar-wrap">
    <div class="aadhar-heading aadhar-heading-font">Applicant's Aadhaar number<sup><span class="red1">*</span></sup>. <br>
      </div>
    <div class="companyname sceeen4form1">
    <!-- <span style="color:#D44242">eKYC services will not be available till 11th Nov 2016</span> <br></br> -->
      <label class="input"><span>Aadhaar Number</span>
        <input type="text" class="textcaps" value="<?php echo $_SESSION['personal_details']['AddharNo']; ?>" disabled onkeypress="return isNumberKey(event)" maxlength="12"/>
        <input type="hidden" id="theOtp" value=""/>
      </label>
    </div> 

      
  </div>
  <?php } else { ?>
    <div class="aadhar-wrap">
    <div class="aadhar-heading aadhar-heading-font">Applicant's Aadhaar number not entered.<sup><span class="red1">*</span></sup>. <br>
      </div>
  </div>
  <?php } ?>
      </div>
  </div>
  <div class="co-app-tab-child" rel="tablink-2">
    <div class="eligibleDetail eligibleDetailcoapp">
      <div class="edTop edtopcoapp coaadhar">
  <div>Relation with applicant<strong class="strongcom-inner paddleft7"><?php echo $relationType;?></strong></div>
  <div>Occupation<strong class="strong-inner paddleft7"> <?php echo ucfirst($occupation);?></strong>
  </div>
  <div>Monthly salary
    <strong class="strong-inner paddleft7"><span class="rsmonthly rstotalemi">`</span><?php echo $monthlySalary;?></strong>
  </div>
  <div>Total EMI
    <strong class="strong-inner paddleft7"><span class="rsmonthly rstotalemi">`</span><?php echo $currentEmi; ?></strong>
  </div>
      </div>
      <div class="clr"></div>
    </div>
    <div class="approval-right-container coapp-approvalcont">
  <div class="aadhar-wrap">
    <div class="aadhar-heading aadhar-heading-font">Auto-fill your application using your Aadhaar number<sup><span class="red1">*</span></sup>. <br>
      </div>
    <div class="companyname sceeen4form">
    <!-- <span style="color:#D44242">eKYC services will not be available till 11th Nov 2016</span> <br></br> -->
      <label class="input"><span>Aadhaar Number</span>
        <input type="text" onkeypress="return isNumberKey(event)" maxlength="12"/>
        <input type="hidden" id="theOtp" value=""/>
      </label>
    </div>
    <div class="aadharbtn">
      <input type="button" id="aadharNo" value="Get OTP" class="aadharsubmit" name="noAadharSbmit" onClick="ga('send', 'event', 'Personal Loan', 'Get-OTP-Click', 'Yes-Aadhar');">
    </div>
    <div class="companyname sceeen4form dnone">
      <label class="input"> <span>Enter OTP</span>
        <input type="text" maxlength="6" id="OTP" onkeypress="return isNumberKey(event)"/>
      </label>
    </div>
    <div class="aadharbtn dnone">
      <input type="button" id="verifyOTPCoApp" maxlength="12" value="CONFIRM" class="aadharsubmit verifyOTP" onClick="ga('send', 'event', 'Personal Loan', 'Confirm-OTP-Click', 'Confirm-Aadhar');"/>
      <a href="javascript:;" class="text-link resendOtp"> Resend OTP</a>
    </div>
    <div class="aadhar-tcbox dnone dnonenew authentication-line authentication-linerev">
      <div class="edBottomTerms2">
        <div class="edBottomCheckbox2">
    <input type="checkbox" checked id="termschk" name=""/>
    <label for="termschk"></label>
        </div>
        <p><a href="javascript:;" class="tnc-btn"> I hereby give my consent to IIFL to do EKYC through Aadhaar authentication</a></p>
        <div class="clr"></div>
      </div>
    </div>
    <div class="dontremember">Proceed without Aadhaar number.</div>
    <div class="aadharbtn">
      <input type="button" id="noAadharSbmitCoApp" value="CLICK HERE" class="aadharsubmit" onClick="ga('send', 'event', 'Personal Loan', 'Click-Here', 'No-Aadhar');" name="noAadharSbmit"/>
    </div>
  </div>
      </div> 

  </div>
  <div class="clr"></div>
      </div>
    </div>
    <div class="screen05img"> <img src="images/homescreen-05img.png" class="scale">
      <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
      <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
    </div>
  </div>
  </section>
  </div>
</form>
<?php require_once('includes/footer.php'); ?>
