<?php 
	$service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/getLoanSummary?key=INDIGO';
	$curl = curl_init($service_url);
	$curl_post_data = array(
	'Parameter' 	=> 'value',
	'Userid' 			=> 'John@12',
	'business' 		=> 'GL',
	'requestCode' => 'INDIGOSF28',
	'key' 				=> 'INDIGO'
	);
	
	$headers = array (
		"Content-Type: application/json"
	);

	$decodeddata = json_encode($curl_post_data);
	$handle = curl_init(); 
	curl_setopt($handle, CURLOPT_URL, $service_url);
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_POST, true);
	curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
	$curl_response = curl_exec($handle);
	$obj = json_decode($curl_response);
	echo '<pre>';
	print_r ($obj);
	echo '</pre>';
?>





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
            
            <div class="heading gold_loan_icon">Gold Loans Summary</div>
            
            <ul class="total_loan_account_details">
              <li>
                <a href="#">
                  <div class="total_loan_acc">1560</div>
                  <p>Total Gold Loan Account</p>
                  <span class="total_loan_acc_icon"></span>
                  <hr>
                </a>
              </li>

              <li>
                <a href="#">
                  <div class="total_active_acc">1625</div>
                  <p>Total Loan Active Account</p>
                  <span class="total_active_acc_icon"></span>
                  <hr>
                </a>
              </li>

              <li>
                <a href="#">
                  <div class="total_closed_acc">1504</div>
                  <p>Total Loan Closed Account</p>
                  <span class="total_closed_acc_icon"></span>
                  <hr>
                </a>
              </li>
            </ul>

            <div class="total_principle_dis whitebg ">
               <div class="total_amount_disbursed">
                <div class="disbursed">
                  <span></span>
                  <div>
                    <p>Total Amount Disbursed</p>
                    <p class="amount">&#8377; 1,00,000</p>
                  </div>
                </div>
               </div>

               <div class="outstanding_highchart whitebg ">
                <ul>
                  <li>
                    <div class="total_outstanding"></div>
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
                    </ul>
                  </li>
                </ul>
                <ul>
                  <li>
                    <div class="total_repayments"></div>
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
                    </ul>
                  </li>
                </ul>
              </div>
              
              <div class="total_summary_block rightbgblue">
                <ul>
                  <li><a href="#"><img src="images/pay_online.png"/><span>Pay Online</span></a></li>
                  <li><a href="#"><img src="images/pay_online.png"/><span>Account Summary</span></a></li>
                  <li><a href="#"><img src="images/pay_online.png"/><span>Account Details</span></a></li>
                </ul>
              </div>

            </div>
            
            <div class="view_details ">
              <div class="blackgrey">View Details</div>
              <div class="clickon">Click on '+' to view details</div>
              <table id="gold_loan_view_details" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th>Loan Account Number</th>
                      <th>Disbursal Date</th>
                      <th>Disbursal Amount </th>
                      <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>GL - 1003451</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control">
                        <div class="acc_content_details">
                          <table cellspacing="0">
                            <tr>
                              <td>
                                <strong>
                                  Loan Amount
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Tenure (Months)
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Annual ROI
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Amount repaid
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Outstanding amount
                                </strong>
                              </td>
                            </tr>

                            <tr>
                              <td>
                               &#8377; 25,000
                              </td>
                              <td>
                                11 Months
                              </td>
                              <td>
                                24.96%
                              </td>
                              <td>
                               &#8377; 3,000
                              </td>
                              <td>
                               &#8377; 23,000
                              </td>
                            </tr>

                            <tr>
                              <td>
                               
                              </td>
                              <td>
                                
                              </td>
                              <td>
                               
                              </td>
                              <td class="principle_interest">
                               Principal : &#8377; 2700 <br>
                               Interest : &#8377; 300
                              </td>
                              <td class="principle_interest">
                               Principal : &#8377; 2700<br>
                               Interest : &#8377; 300
                              </td>
                            </tr>
                          </table>
                          <div class="account_user_info">
                            <div><span>Name of Customer :</span><p>Mr. CHIRAG BRAHMBHATT</p></div>
                            <div><span>Name of Co-Borrower : </span><p>XYZ</p></div>
                            <div><span>Branch Name : </span><p>Mehsana City road</p></div>
                            <div><span>Branch Address :</span><p>F1,F2, Second floor, Sakabhai
                                                              Seth Complex, Toranwali mata
                                                              Chowk Bazar, City Road, Mehsana</p></div>
                          </div>
                          <div class="summary_block_right rightbgblue">
                            <ul>
                              <li><a href="#"><img src="images/pay_online.png"/><span>Pay Online</span></a></li>
                              <li><a href="#"><img src="images/pay_online.png"/><span>Account Summary</span></a></li>
                            </ul>
                          </div>
                        </div>
                        <a class="plus" href="javascript:;"></a>
                      </td>
                  </tr>
                  <tr>
                      <td>GL - 1003452</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control">
                        <div class="acc_content_details">
                          <table cellspacing="0">
                            <tr>
                              <td>
                                <strong>
                                  Loan Amount
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Tenure (Months)
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Annual ROI
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Amount repaid
                                </strong>
                              </td>
                              <td>
                                <strong>
                                  Outstanding amount
                                </strong>
                              </td>
                            </tr>

                            <tr>
                              <td>
                               &#8377; 25,000
                              </td>
                              <td>
                                11 Months
                              </td>
                              <td>
                                24.96%
                              </td>
                              <td>
                               &#8377; 3,000
                              </td>
                              <td>
                               &#8377; 23,000
                              </td>
                            </tr>

                            <tr>
                              <td>
                               
                              </td>
                              <td>
                                
                              </td>
                              <td>
                               
                              </td>
                              <td class="principle_interest">
                               Principal : &#8377; 2700 <br>
                               Interest : &#8377; 300
                              </td>
                              <td class="principle_interest">
                               Principal : &#8377; 2700<br>
                               Interest : &#8377; 300
                              </td>
                            </tr>
                          </table>
                          <div class="account_user_info">
                            <div><span>Name of Customer :</span><p>Mr. CHIRAG BRAHMBHATT</p></div>
                            <div><span>Name of Co-Borrower : </span><p>XYZ</p></div>
                            <div><span>Branch Name : </span><p>Mehsana City road</p></div>
                            <div><span>Branch Address :</span><p>F1,F2, Second floor, Sakabhai
                                                              Seth Complex, Toranwali mata
                                                              Chowk Bazar, City Road, Mehsana</p></div>
                          </div>
                          <div class="summary_block_right rightbgblue">
                            <ul>
                              <li><a href="#"><img src="images/pay_online.png"/><span>Pay Online</span></a></li>
                              <li><a href="#"><img src="images/pay_online.png"/><span>Account Summary</span></a></li>
                            </ul>
                          </div>
                        </div>
                        <a class="plus" href="javascript:;"></a>
                      </td>
                  </tr>
                  <tr>
                      <td>GL - 1003453</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003454</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003455</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003456</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003457</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003458</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                  <tr>
                      <td>GL - 1003459</td>
                      <td>11/12/2015</td>
                      <td>&#8377; 4,00,000 </td>
                      <td class="details-control"><a class="plus" href="javascript:;"></a></td>
                  </tr>
                </tbody>
              </table>
              
              
              
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
              <a href="#">Download IIFL Loans app</a>
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

<?php require_once('footer.php'); ?>