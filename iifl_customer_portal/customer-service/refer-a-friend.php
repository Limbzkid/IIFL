<?php session_start();
require_once('../header.php');
$salt = md5('customerportal_iifl');
$leadtime = time();	
$random_str = md5(uniqid($leadtime));
$token = md5($random_str . $salt);	
$_SESSION["referafriendform"] = $token;
 ?>



    <!--outer wrapper start-->
    <div class="outer-wrapper middle-wrapper">
    <!--inner wrapper start-->
        <div class="inner-wrapper">
        <!--col left start-->
          <div class="col-left">
            <div class="left_menu">
                <ul>
                  <?php include("../api/product-details.php"); ?>
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
            <form name="frm_referfriend" id="frm_referfriend" method="post" >
              <div class="heading quickpay_icon">Refer a friend</div>
              
              <div class="quick-pay">
                <div class="loan-info whitebg">
				<div class="message"></div>
                  <div class="form-control">
                     <label>Select Product Type :</label>
                       <div class="selectbg">
                        <div class="selectedvalue"></div>
                        <select name="producttype" id="producttype">
                          <option value="">---Select Product Type---</option>
                          <option value="personalloan" <?php if(isset($_POST['loantype']) && $_POST['loantype'] == 'personalloan'){ echo 'selected'; }?>>Personal Loan</option>
						  <option value="homeloan" <?php if(isset($_POST['loantype']) && $_POST['loantype'] == 'homeloan'){ echo 'selected'; }?> >Home Loan</option>
						  <option value="carloan" <?php if(isset($_POST['loantype']) && $_POST['loantype'] == 'carloan'){ echo 'selected'; }?> >Car Loan</option>
						  <option value="goldloan" <?php if(isset($_POST['loantype']) && $_POST['loantype'] == 'goldloan'){ echo 'selected'; }?> >Gold Loan</option>
                        </select>
                        <div class="clear"> </div>
                      </div>
					  
                      <div class="error dnone"></div>
                  </div>
				  <div class="form-control">
                     <label>Name :</label>
                       <input type="text" name="Name" id="Name" onBlur="clearText(this)" onFocus="clearText(this)"/>
					   
                      <div class="error dnone"></div>
                  </div>
                  <div class="form-control">
				  
                     <label>city :</label>
                       <div class="selectbg">
                        <div class="selectedvalue"></div>
                        <select name="city" id="city">
                          <option value="">---Select city---</option>
                          <option value="Mumbai" if(isset($_POST['city']) && $_POST['city'] == 'Mumbai') { echo 'selected';}>
						  Mumbai
						  </option>
						  <option value="Pune" if(isset($_POST['city']) && $_POST['city'] == 'Pune') { echo 'selected';}>
						  Pune
						  </option>
						  <option value="Banglore" if(isset($_POST['city']) && $_POST['city'] == 'Banglore') { echo 'selected';}>
						  Banglore
						  </option>
						  <option value="Chennai" if(isset($_POST['city']) && $_POST['city'] == 'Chennai') { echo 'selected';}>
						  Chennai
						  </option>
                        </select>
                        <div class="clear"> </div>
                      </div>
					  
                      <div class="error dnone">account no not valid</div>
                  </div>
                  <div class="form-control">
                     <label>Pincode :</label>
                       <input type="text" name="pincode" id="pincode" onBlur="clearText(this)" onFocus="clearText(this)"/>
					   
                      <div class="error dnone"></div>
                  </div>
                  <div class="form-control">
                     <label>Mobile number :</label>
                       <input type="text" name="mobilenumber" id="mobilenumber" onBlur="clearText(this)" onFocus="clearText(this)"/>
					   
                      <div class="error dnone"></div>
                  </div>
                  
                  <div class="form-control mrg0">
                    <label>&nbsp;</label>
					<input type="hidden" name="userid" id="userid" value="123456" />
				   <input type="hidden" name="formkey" id="formkey" value="<?php echo $random_str; ?>" />
                   <input class="refSubmit submit" type="button" name="submit" value="Confirm"  />
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
              <input type="text" name="Mobile Number" maxlength="10" onBlur="clearText(this)" onFocus="clearText(this)"/>
              
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