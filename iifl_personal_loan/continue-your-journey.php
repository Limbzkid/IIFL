<?php session_start(); ?>
<?php require_once("includes/functions.php"); ?>
<?php
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
      <link href="css/fonts.css" rel="stylesheet" type="text/css">
      <link href="css/iifl.css" rel="stylesheet" type="text/css">
      <link href="css/media.css" rel="stylesheet" type="text/css">
      <script src="js/jquery.easing.min.js" type="text/javascript"></script>
      <script src="js/function.js" type="text/javascript"></script>
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
      <style type="text/css">
        #error-crmid{text-align: center!important;}
        .edBottomTerms2{text-align: center!important;}
        @media only screen and (max-width:560px) {
          .aadhar-wrap{padding: 0 15px;}
          .GO_buttON.aadharbtn{text-align: center;}
          .GO_buttON.aadharbtn .aadharsubmit{margin:15px 0 0 0;}
        }
      </style>
    </head>
    <body class="bodyoverflow">
      <div id="main-wrap">
        <!-- AAdhar page pixel-->
        <img class="seo-btn" src="http://pixel.everesttech.net/px2/784?px_evt=t&ev_Aadhar-Card=<Aadhar-Card>&ev_transid=<?php //echo $_SESSION['personal_details']['CRMLeadID']; ?>" width="1" height="1"/>
        <!--end Aadhar card pixel -->
        <!--popup-->
        <div class="overlay"></div>
          <div class="tnc-popup">
            <div class="tnc-popup-txt">
              <p><strong>Consent for Authentication</strong></p>
              <p>I hereby give my consent to India Infoline Finance Limited to obtain my Aadhaar number, Name and Fingerprint/ Iris for authentication with UIDAI. India Infoline Finance Limited has informed me that my identity information would only be used for Undertaking eKYC for my loan application and also informed that my biometrics will not be stored / shared and will be submitted to CIDR only for the purpose of authentication</p>
              <p class="tc"><a href="javascript://" class="closepop">OK</a></p>
              <div class="closeicon"><a href="javascript://" class="closepop"><img src="images/close-icon.png" class="scale"></a></div>
            </div>
          </div>
          <!--popup-->
          <header>
            <div class="header-inner knowmore">
              <div class="logo"><img src="images/logo.jpg" class="scale"></div>
              <div class="personal-loan"><img src="images/personal.png" class="scale"></div>
              <div class="clr"></div>
              <div class="card-container-outerinner">
                <div class="pendulamline-inner"><img src="images/pendulamline.jpg" class="scale"></div>
                <div class="card-container1 effect__random card-container" data-id="1">
                  <div class="card__front">
                    <img src="images/48hours.png" class="scale">
                    <p class="pendulamtxt">Express<br>Personal<br>Loan</p>
                  </div>
                  <div class="card__back">
                    <img src="images/48hours.png" class="scale">
                    <p class="pendulamtxt">DISBURSAL<br> IN<br> 8 HOURS* <br/><small> T&C Apply</small></p>
                  </div>
                </div>
              </div>
            </div>
          </header>
          <form id="form1" name="form1" method="post" action="" autocomplete="off">
            <div id="msform">
              <section class="body-home-outer myclass aadharbg bgpink">
                <div class="innerbody-home height-ipad-812 full-height">
                  <div class="approval-wrap">
                    <div class="approval-right-container centerpanel width100 centerpanel_journey">
                      <div class="aadhar-wrap">
                        <div class="aadhar-heading aadhar-heading-font">Resume Applications <br></div>
                        <p class="smallheads">Please enter the reference number sent to you through SMS/ Email</p>
                        <div class="companyname sceeen4form journey_frm">
                          <label class="input"><span>Reference Number<sup><span class="red1">*</span></sup></span>
                            <input type="text" id="crmidplace" name="crmidplace" maxlength="7" onkeypress="return isNumberKey(event)"/>
                            <input type="text" style="display: none;" id="theOtp" maxlength="6" value="" onkeypress="return isNumberKey(event)"/>
                            <input type="hidden" class="mobNoFrmOtp" value="">
                          </label>
                        </div>
                        <div class="aadharbtn GO_buttON">
                          <input type="button" id="crmid" value="GO" class="aadharsubmit aadharsubmit_GObtn" name="crmid" >
                        </div>
                        <p class="smallheads">Can't find your reference no.? <a class="fresh_appCation" href="index">Start a fresh application</a></p>
                        <div class="companyname sceeen4form fl centerpanel centerpanel_journey dnone">
                          <label class="input"> <span>Enter OTP</span>
                            <input type="text" maxlength="6" id="OTP" onkeypress="return isNumberKey(event)"/>
                          </label><div class="clr"></div>
                          <p class="smallheads">We have sent the OTP to your registered number ending with ******6789</p>
                        </div>
                        <div class="aadharbtn dnone">
                          <input type="button" id="verifyOTP" maxlength="12" value="CONFIRM" class="aadharsubmit verifyOTP" onClick="ga('send', 'event', 'Personal Loan', 'Confirm-OTP-Click', 'Confirm-Aadhar');"/>
                          <a href="javascript:;" class="text-link resendOtp"> Resend OTP</a>
                        </div>
                        <div class="aadhar-tcbox authentication-line verifyMOBILe" style="display:none">
                          <div class="edBottomTerms2">
                            <input type="button" name="verifyManMobNo" id="verifyManMobNo" onClick="ga('send', 'event', 'Personal Loan', 'Verify-OTP-Click', 'Manual-OTP');" value="Verify OTP" class="ios-btn">
                            <div class="clr"></div>
                          </div>
                        </div>
                        <div class="aadharbtnresend" style="display:none">
                          <!--<input type="submit" name="submit" id="verifyManMobNo" onClick="ga('send', 'event', 'Personal Loan', 'Verify-OTP-Click', 'Manual-OTP');" value="Verify OTP" class="ios-btn">-->
                          <a href="javascript:;" class="text-link resendManOtp"> Resend OTP</a>
                        </div>
                        <div class="clr"></div>
                        <div class="loader_journey"></div>
                        <!--<div class="co-app-cta">
                          <span>or</span>
                          <div class="add-co-app-btn startfreshbtn aadharsubmit"><a href="co-applicant-detail.php">Start fresh application!</a></div>
                        </div>-->
                      </div>
                    </div>
                      <div class="clr"></div>
                  </div>
                  <!--approval wrap-->
                  <div class="screen05img pos-abs">
                    <img src="images/homescreen-05img.png" class="scale">
                    <div class="screen5c move-left1"><img src="images/screen5c.png" class="scale"></div>
                    <div class="screen5c movetop"><img src="images/screen5b.png" class="scale"></div>
                  </div>
                </div>
              </section>
            </div>
          </form>
          <script src="js/cards1.js" type="text/javascript"></script>
          <?php require_once('includes/footer.php'); ?>
          <script type="text/javascript">
            
            $("#crmid").click(function(e) {
              var crmIdValue = document.getElementById('crmidplace').value;
              var errMsg = '';
              $("#error-crmid").remove();
              var reg = new RegExp('^\\d+$');
              if(crmIdValue == '') {
                $("#crmid").after('<div id="error-crmid" >Please enter your Reference ID number.</div>');
                return false;
              }
              if(!reg.test(crmIdValue)) {
                $("#crmid").after('<div id="error-crmid" class="mobtextcenter">Reference ID number can only be numeric.</div>');
                return false;
              }
              $("#crmid").css('opacity','0.3');
              $("#crmid").css('cursor','default');	
              $(".loader_journey").fadeIn(100, function(){
                $.ajax({
                  url:"ajax/reverse-journey",
                  type:"POST",
                  async: false,
                  data:{'crmLeadID' : crmIdValue, 'crmLeadIDType' :'OTP'},
                  success: function(msg) {
                    $(".loader_journey").fadeOut(100);
                    $("#crmid").css('opacity','1');
                    $("#crmid").css('cursor','pointer');	
                    if(msg == 0) {
                      $("#crmid").after('<div id="error-crmid" class="invalidaadhar">Invalid Reference ID.</div>');
                    } else {
                      var getData = JSON.parse(msg);
                      if(getData.Status == 'Y') {
                        $("#theOtp").show();
                        $("#theOtp").val(getData.OTP);
                        $("#crmidplace").after('<div id="error-crmid" class="otperror">OTP has been sent to your registered mobile number ****** '+ getData.MobileNumber.slice(-4) +'</div>');
                        $(".co-app-cta").hide();
                        $(".smallheads").hide();
                        $(".GO_buttON").hide();
                        $(".aadhar-tcbox").show();
                        $(".aadharbtnresend").show();
                        $(".mobNoFrmOtp").val(getData.MobileNumber);
                        document.getElementById('crmidplace').disabled= true;
                      } else {
                        $("#crmid").after('<div id="error-crmid" class="invalidaadhar">Invalid Reference ID.</div>');
                      }
                    }
                  }
                });
              });
            });
          
            $("#verifyManMobNo").click(function(e) {
              $("#error-crmid").remove();
              var crmIdValue = document.getElementById('crmidplace').value;
              var OTP = document.getElementById('theOtp').value;
              var reg = new RegExp('^\\d+$');
              if(crmIdValue == '') {
                $("#crmidplace").before('<div id="error-crmid" >Please enter your Reference ID number.</div>');
                return false;
              }
              if(!reg.test(crmIdValue)) {
                $("#crmidplace").after('<div id="error-crmid" class="mobtextcenter">Reference ID number can only be numeric.</div>');
                return false;
              }
              if(OTP == '') {
                $("#theOtp").after('<div id="error-crmid" >Please enter your OTP.</div>');
                return false;
              }
              if(!reg.test(OTP)) {
                $("#theOtp").after('<div id="error-crmid" class="mobtextcenter">OTP is wrong.</div>');
                return false;
              }
              $(".loader_journey").fadeIn(100, function(){
                $.ajax({
                  url:"ajax/reverse-journey",
                  type:"POST",
                  async: false,
                  data:{'crmLeadID' : crmIdValue, 'crmLeadIDType' :'Verify', 'OTP' : OTP},
                  success: function(msg) {
                    $(".loader_journey").fadeOut(100);
                    if(msg === 0) {
                      $("#crmid").before('<div id="error-crmid" class="invalidaadhar">Invalid Reference ID.</div>');
                    } 
                    if(msg == 'page1') {
                      e.preventDefault();
                      window.location = 'calculate-loan';
                      return false;
                    }
                    if(msg == 'page4') {
                      e.preventDefault();
                      window.location = 'aip-info';
                      return false;
                    }
                    if(msg == 'page5') {
                      e.preventDefault();
                      window.location = 'your-quote';
                      return false;
                    }
                    if(msg == 'page6') {
                      e.preventDefault();
                      window.location = 'congratulations';
                      return false;
                    }
                    if(msg == 'page8') {
                      e.preventDefault();
                      window.location = 'upload-non-financial-document';
                      return false;
                    }
                    if(msg == 'page9') {
                      e.preventDefault();
                      window.location = 'upload-financial-document';
                      return false;
                    }
                    if(msg == 'page10'){
                      e.preventDefault();
                      window.location = 'your-quote';
                      return false;
                    }
                    if(msg == 'page10upload') {
                      e.preventDefault();
                      window.location = 'co-applicant-upload-document';
                      return false;
                    }
                    if(msg == 'page11') {
                      e.preventDefault();
                      window.location = 'congratulations';
                      return false;
                    }
                    if(msg == 'page12') {
                      //$(".otperror").hide();
                      e.preventDefault();
                      window.location = 'co-applicant-upload-non-financial-document';
                      return false;
                     // $("#verifyManMobNo").before('<div id="error-crmid" class="mobtextcenter">Your Applicantion has already been submitted.</div>');
                      //return false;
                    }
                    if(msg == 'page13') {
                      e.preventDefault();
                      window.location = 'upload-financial-document';
                      return false;
                    }
                    if(msg == 'page14') {
                      e.preventDefault();
                      window.location = 'co-applicant-upload-financial-document';
                      return false;
                    }

                    if(msg == 'page16') {
                      e.preventDefault();
                      window.location = 'verification';
                      return false;
                    }
                    
                    if(msg == 'page17') {
                      e.preventDefault();
                      window.location = 'co-applicant-verification';
                      return false;
                    }
                  }
                });
              });
            });
            
            $(".resendManOtp").click(function() {
              $("#error-crmid").remove();
              $.ajax({
                url:"ajax/manual-resend-otp",
                type:"POST",
                success: function(msg) {
                  var getData = JSON.parse(msg);
                  if(getData.Status == "Y") {
                    var mobNo = '******' + $(".mobNoFrmOtp").val().slice(-4);
                    $("#crmidplace").after('<div id="error-crmid" class="otperror">OTP has been sent to your registered mobile number '+ mobNo +'</div>');
                    //$("#theOtp").val(getData.OTP);
                  } else {
                    $('#crmid').after('<div id="error-crmid" class="invalidaadhar">Invalid Reference ID.</div>');
                  }
                }
              });
            });
          
          </script>