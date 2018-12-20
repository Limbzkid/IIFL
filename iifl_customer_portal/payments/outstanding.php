<?php
  $output = '';
	$service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/getLoanType?key=INDIGO';
	$curl = curl_init($service_url);
	$curl_post_data = array(
		'Parameter' 		=> 'value',
		'ProductType' 	=> 'CV',
		'RequestCode' 	=> 'INDIGOLT22',
		'key' 					=> 'INDIGO',
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
  print_r($obj);
  echo '</pre>';
	exit;
  $output .= '<option value=" ">Gold Loan</option>';








?>





<?php require_once('../header.php'); ?>



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
          <!--col middle start-->
          <div class="col-half-middle">
            
            <div class="heading outstandingpay_icon">Outstanding Dues</div>
            
            <div class="outstanding ">
             <div class="form-control whitebg">
                 <label>Loan type :</label>
                   <div class="selectbg">
                    <div class="selectedvalue"></div>
                    <select>
                      <option selected="selected" value="">Select</option>
                      <option value=" ">Gold Loan</option>
                    </select>
                    <div class="clear"> </div>
                  </div>
                  <!--<div class="error">select type</div>-->
             </div>

             <div class="statement">
              <div class="heading gold_loan_icon">Gold</div>
              <table id="outstanding" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th>Loan Account No</th>
                      <th>Loan Amount</th>
                      <th>EMI</th>
                      <th>Penal</th>
                      <th>Overdue</th>
                      <th>Bounce <br> Cheque Charge</th>
                      <th>Excess Available</th>
                      <th>Total<br> Amount due</th>
                      <th>Due Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>RCITY714684</td>
                      <td>&#8377; 2,50,000</td>
                      <td>&#8377; 10,000</td>
                      <td>&#8377; 1000</td>
                      <td>&#8377; 20,000</td>
                      <td>&#8377; 00.00</td>
                      <td>&#8377; 2,00,000</td>
                      <td>&#8377; 2,00,000</td>
                      <td>04-01-2016 <a href="javacsript:;">Pay Now</td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <div class="download_btn">
              <a href="#" class="download">Download <span class="icon"></span></a>
              <a href="#" class="print">Print <span class="icon"></span></a>
            </div>

            </div>

            

          </div>
          <!--col middle end-->


        </div>
        <!--inner wrapper end-->
    </div>
    <!--outer wrapper end-->

<?php require_once('../footer.php'); ?>