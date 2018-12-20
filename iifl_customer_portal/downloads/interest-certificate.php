
http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/getInterestcertificate?key=INDIGO";
Parameter = value
prospectno = "5252";
frmDt = "20100101";
toDt = "20160101";
requestCode = "INDIGORS25";
key = "INDIGO";
                                                                     


<?php require_once('../header.php'); ?>
<div class="outer-wrapper middle-wrapper">
<!--inner wrapper start-->
    <div class="inner-wrapper">
    <!--col left start-->
      <div class="col-left">
        <div class="left_menu">
            <ul>
              <li class="active"><a class="activedarkblue" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/my_loan.png"/><img class="img_hover" src="images/left_menu_icon/my_loan_hover.png"/></span>My Loan</a></li>
              <li><a class=" activelightblue" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/overview.png"/><img class="img_hover" src="images/left_menu_icon/overview_hover.png"/></span>Overview</a></li>
              <li><a class=" activelightblue" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/gold_loan.png"/><img class="img_hover" src="images/left_menu_icon/gold_loan_hover.png"/></span>Gold loan</a></li>
              <li><a class=" activelightblue" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/sme_loan.png"/><img class="img_hover" src="images/left_menu_icon/sme_loan_hover.png"/></span>SME loan</a></li>
              <li><a class="" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/loan_against_property.png"/><img class="img_hover" src="images/left_menu_icon/loan_against_property_hover.png"/></span>Loan against property</a></li>
              <li><a class="" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/commercial_vehicle_loan.png"/><img class="img_hover" src="images/left_menu_icon/commercial_vehicle_loan_hover.png"/></span>Commercial vehicle loan</a></li>
              <li><a class="" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/digital_finance.png"/><img class="img_hover" src="images/left_menu_icon/digital_finance_hover.png"/></span>Digital Finance</a></li>
              <li><a class="" href="javascript:;"><span><img class="img_main" src="images/left_menu_icon/home_loan.png"/><img class="img_hover" src="images/left_menu_icon/home_loan_hover.png"/></span>Home loan</a></li>
            </ul>
        </div>

        <div class="pre_apprv_loan orangebg">
          <div class="title">Pre-approved loan <hr></div>
          <div class="pre_loan_icon"></div>
          <p>Get your pre-approved* SME Loan of up to Rs 10 lac </p>
          <p>@ 12.65% disbursed to your account instantly.</p>
          <a class="apply_now" href="javascript:;">Apply Now</a>
        </div>

      </div>
      <!--col left end-->
      <!--col middle start-->
      <div class="col-middle">
        
        <div class="heading intercertificate_icon">Interest Certificate</div>
        
        <div class="interest_certificate">
          <div class="loan-info whitebg">
            <div class="form-control">
               <label>Loan account number :</label>
                 <div class="selectbg">
                  <div class="selectedvalue"></div>
                  <select>
                    <option selected="selected" value="">4545214521</option>
                    <option value=" ">45452148885</option>
                  </select>
                  <div class="clear"> </div>
                </div>
            </div>
          </div>
          
          <div class="view_details ">
            <div class="blackgrey">Select Financial Year</div>
            <div class="whitebg">
              <div class="select_calender">
                <span>From</span>
                <input id="from" type="text" class="datepickerfrom icon" />

                <span class="to">To</span>
                <input id="to" type="text" class="datepickerto icon" />
                <div class="download_btn">
                  <a href="javascript:;" class="view_cer" id="viewCertificate"><span class="icon"></span>View Certificate </a>
                  <a href="javascript:;" class="dowload_cer"><span class="icon"></span>Download Certificate </a>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </div>
      <!--col middle end-->
      <!--col right start-->
      <div class="col-right">

        <div class="offer_box grayishgreen">
          <span>** offer **</span>
          <div class="make_pay_mobile">
            <div class="now_make_pay">
             Now make payments
             </div>
            <div class="from_ur_mob">
              <p>from your</p> 
              Mobile
            </div>
          </div>
          <a href="javascript:;">Download IIFL Loans app</a>
        </div>

        <div class="mobile_app">
          <div class="mobileappbg">
            <div class="title">Mobile App <hr></div>
            <p>Submit number to receive download link</p>
          </div>
          <p>Enter mobile number:</p>  
          <input type="text" name="Mobile Number" value="0000000000" onBlur="clearText(this)" onFocus="clearText(this)"/>
          
          <input class="apply_now" type="button" name="submit" value="Submit"/>
        </div>

        <div class="need_help">
           <div class="title">Need Help?<hr></div>
           <div class="faq"><a href="javascript:;"><span class="faq_icon"></span>FAQ</a></div>
           <div class="contact_us"><a href="javascript:;"><span class="contact_icon"></span>Request Call back</a></div>
        </div>

      </div>
      <!--col right end-->

    </div>
    <!--inner wrapper end-->
</div>
<!--outer wrapper end-->
<?php require_once('../footer.php'); ?>