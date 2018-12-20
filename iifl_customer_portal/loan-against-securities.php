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
          <!--col middle start-->
          <div class="col-middle">
            
            <div class="heading notify_icon"><a class="updown minus"><div class="notify">5</div>You have <span>5</span> notifications</a></div>
            
            <div class="notifications whitebg">
              <div class="notify_list">
                <p>Next gold loan (AC: GL10017) Payment is due in 3 days</p><a href="javascript:;">Pay now</a>
              </div>
              <div class="notify_list">
                <p>Glod loan rates dropped. Please pay the differences for 3 accounts</p><a href="javascript:;">View Details</a>
              </div>
              <a class="see_all" href="javascript:;">See All</a>
            </div>
            
            <ul class="loan_account_details">
              <li>
                <a href="javascript:;">
                  <div class="total_loan_acc">16</div>
                  <p>Total Loan Account</p>
                  <span class="total_loan_acc_icon"></span>
                  <hr>
                </a>
              </li>

              <li>
                <a href="javascript:;">
                  <div class="total_active_acc">12</div>
                  <p>Total Active Account</p>
                  <span class="total_active_acc_icon"></span>
                  <hr>
                </a>
              </li>

              <li>
                <a href="javascript:;">
                  <div class="total_closed_acc">04</div>
                  <p>Total Closed Account</p>
                  <span class="total_closed_acc_icon"></span>
                  <hr>
                </a>
              </li>
            </ul>

            <div class="outstanding_highchart whitebg ">
              <ul>
                <li>
                  <div id="container"></div>
                </li>
                <li>
                  <div>
                    <p>Total Outstanding</p>
                    <p class="amount">&#8377; 80,000</p>
                  </div>
                  <ul class="princial_interest_other_details">
                    <li class="Principal">Principal</li>
                    <li class="Interest">Interest</li>
                    <li class="other">Others (penal, BBC, overdue, etc)</li>
                    <li class="grey">Revolving line of credit</li>
                  </ul>
                </li>
              </ul>
            </div>

            <div class="gold_summary whitebg">
              <div class="subheading">Gold loan summary</div>
              <div class="gold_loan_summary_block">
                <div class="summary_block_left">
                  <div class="total_amount_disbursed">
                    <div class="disbursed">
                      <span></span>
                      <div>
                        <p>Total Amount Disbursed</p>
                        <p class="amount">&#8377; 1,00,000</p>
                      </div>
                    </div>
                  </div>

                  <div class="total_amount_disbursed">
                    <ul class="gold_loan_summary_repay">
                      <li><div class="percents">80<span>%</span><div class="repay">Repayed</div></div></li>
                      
                      <li>
                        <div>
                          <p>Total Outstanding</p>
                          <p class="amount">&#8377; 80,000</p>
                        </div>
                        <span class="orange">&#8377; 20,000</span>
                        <span class="lightblue">&#8377; 4,500</span>
                        <span class="normalblue">&#8377; 500</span>
                      </li>
                      
                      <li>
                        <div>
                          <p>Total Repayments</p>
                          <p class="amount">&#8377; 25,000</p>
                        </div>
                        <span class="orange">&#8377; 20,000</span>
                        <span class="lightblue">&#8377; 4,500</span>
                        <span class="normalblue">&#8377; 500</span>
                      </li>
                    </ul>
                  </div>
                  
                  <ul class="princial_interest_other_details">
                    <li class="Principal">Principal</li>
                    <li class="Interest">Interest</li>
                    <li class="other">Others (penal, BBC, overdue, etc)</li>
                  </ul>

                </div>
                <div class="summary_block_right rightbgblue">
                  <ul>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Pay Online</span></a></li>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Repayment Schedule</span></a></li>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Account Summary</span></a></li>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Account Details</span></a></li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="gold_summary whitebg">
              <div class="subheading">Loan against property</div>
              <div class="gold_loan_summary_block">
                <div class="summary_block_left">
                    <ul class="loan_against_property">
                      <li><div class="percents">80<span>%</span><div class="repay">Repayed</div></div></li>
                      
                      <li>
                        <div class="green"><span>Revolving credit limit -  </span><p>&#8377; 10,00,000</p></div>
                        <div class="orange"><span>Utilised amount -</span><p>&#8377; 5,00,000</p></div>
                        <div class="lightblue"><span>Term loan disbursed - </span><p>&#8377; 50,00,000</p></div>
                        <div class="normalblue"><span>Loan outstanding- </span><p>principal, interest, others</p> </div>
                      </li>
                    </ul>
                  
                </div>
                <div class="summary_block_right rightbgblue">
                  <ul>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Pay Online</span></a></li>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Repayment Schedule</span></a></li>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Account Summary</span></a></li>
                    <li><a href="javascript:;"><img src="images/pay_online.png"/><span>Account Details</span></a></li>
                  </ul>
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