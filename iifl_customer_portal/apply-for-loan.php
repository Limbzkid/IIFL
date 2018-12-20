<?php require_once('header.php'); ?>



    <!--outer wrapper start-->
    <div class="outer-wrapper middle-wrapper">
    <!--inner wrapper start-->
        <div class="inner-wrapper">
        <!--col left start-->
          <div class="col-left">
            <div class="left_menu">
                <ul>
                  <?php include("api/product-details.php"); ?>
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
          <div class="col-middle">
            <form name="apply_loan_frm" id="apply_loan_frm" method="post">
              <div class="heading quickpay_icon">Quick Pay</div>
              
              <div class="quick-pay">
                <div class="loan-info whitebg">
                  <div class="form-control">
                     <label>Select Product Type :</label>
                       <div class="selectbg">
                        <div class="selectedvalue"></div>
                        <select name="producttype" id="producttype">
                          <option selected="selected" value="">4545214521</option>
                          <option value=" ">45452148885</option>
                        </select>
                        <div class="clear"> </div>
                      </div>
                      <div class="error dnone">account no not valid</div>
                  </div>
                  <div class="form-control">
                     <label>Loan Type :</label>
                       <div class="selectbg">
                        <div class="selectedvalue"></div>
                        <select name="loantype" id="loantype">
                          <option selected="selected" value="">4545214521</option>
                          <option value=" ">45452148885</option>
                        </select>
                        <div class="clear"> </div>
                      </div>
                      <div class="error dnone">account no not valid</div>
                  </div>
                  <div class="form-control">
                     <label>Loan Amount :</label>
                       <input type="text" name="loanamount" id="loanamount" onBlur="clearText(this)" onFocus="clearText(this)"/>
                      <div class="error dnone"></div>
                  </div>
                  
                  <div class="form-control">
                     <label>Name :</label>
                       <input type="text" name="Name" id="Name" onBlur="clearText(this)" onFocus="clearText(this)"/>
                      <div class="error dnone"></div>
                  </div>
                  
                  <div class="form-control">
                     <label>Mobile number :</label>
                       <input type="text" name="mobilenumber" id="mobilenumber" value="0000000000" onBlur="clearText(this)" onFocus="clearText(this)"/>
                      <div class="error dnone"></div>
                  </div>
                  
                  <div class="form-control">
                     <label>Email Id :</label>
                       <input type="text" name="emailid"  id="emailid" onBlur="clearText(this)" onFocus="clearText(this)"/>
                      <div class="error dnone"></div>
                  </div>
                  
                  <div class="form-control">
                     <label>Account Number :</label>
                       <input type="text" name="accountnumber" id="accountnumber" onBlur="clearText(this)" onFocus="clearText(this)"/>
                      <div class="error dnone"></div>
                  </div>
                  
                  <div class="form-control mrg0">
                    <label>&nbsp;</label>
                    <input class="applysubmit submit" type="button" name="submit" value="Confirm"/>
                  </div>
  
                </div>
                
              </div>
              

            </form>
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
              <input type="text" name="Mobile Number" maxlength="10" value="0000000000" onBlur="clearText(this)" onFocus="clearText(this)"/>
              
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

<?php require_once('footer.php'); ?>