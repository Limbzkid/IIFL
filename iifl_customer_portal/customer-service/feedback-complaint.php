<?php 
session_start();

require_once '../header.php';

$salt = md5('customerportal_iifl');
$leadtime = time();	
$random_str = md5(uniqid($leadtime));
$token = md5($random_str . $salt);	
$_SESSION["feedbackform"] = $token;



?>


<!--outer wrapper start-->
<div class="outer-wrapper middle-wrapper">
	<!--inner wrapper start-->
	<div class="inner-wrapper">
	<!--col left start-->
		<div class="col-left">
			<div class="left_menu">
				<ul><?php include("../api/product-details.php"); ?></ul>
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
			<form id="compandfeedbk_frm" method="post">
				<div class="quick-pay">
					<div class="loan-info whitebg">
						<div class="message"></div>
						<div class="form-control">
								<label>Loan Type</label>
									<div class="selectbg">
										<div class="selectedvalue"></div>
										<select name="loantype" id="loantype">
											<option value="">---Select Loan Type---</option>
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
							<label>Loan No  </label> 
							<input type="text" name="loanno" id="loanno" value="<?php if(isset($_POST['loanno'])){ echo $_POST['loanno']; } ?>"/>
							<div class="error dnone"></div>
						</div>
						<div class="form-control">
							<label>Category </label>
							<div class="selectbg">
								<div class="selectedvalue"></div>
								<select name="category" id="category">
									<option value="">---Select Loan Category---</option>
									<option value="documentrelated" <?php if(isset($_POST['category']) && $_POST['category'] == 'documentrelated'){ echo 'selected'; } ?>>Document Related</option>
								</select>
								<div class="clear"> </div>
							</div>
							<div class="error dnone"></div>
						</div>
						<div class="form-control">
							<label>Subcategory </label>
							<div class="selectbg">
								<div class="selectedvalue"></div>
								<select name="subcategory" id="subcategory">
									<option value="">---Select Loan Sub-Category---</option>
									<option value="others" <?php if(isset($_POST['subcategory']) && $_POST['subcategory'] == 'others'){ echo 'selected'; } ?>>Others</option>
								</select>
								<div class="clear"> </div>
							</div>
							<div class="error dnone"></div>
						</div>

						<div class="form-control">
							<label>Feedback  </label> 
							<input type="textarea" name="feedback" id="feedback" cols="25" rows="8" />
						</div>
						<input type="hidden" name="userid" id="userid" value="123456" />
						<input type="hidden" name="formkey" id="formkey" value="<?php echo $random_str; ?>" />
						<!--<input type="submit" name="Submit" id="Submit" value="Submit" /> -->
						<input type="button" name="Submit"  class="feedbacksub submit" value="Submit" />
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



