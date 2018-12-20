<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>

	<?php
		//$_SESSION['personal_details']['actual_tenure'];
		//$_SESSION['personal_details']['minloanamt'];
		//$_SESSION['personal_details']['actualloanEMI'];
		//$_SESSION['personal_details']['maxloanamt'];
		$time				= $_POST['time'];
		$emi 				= $_POST['emi'];
		$rate				= $_POST['roi'];
		$amount 		= $_POST['amt'];
		$max_amount = $_POST['maxAmt'];
		$page				= $_POST['page'];
		
		if(isset($_SESSION['co_applicant_details'])) {
			$max_alloted_amount = $_SESSION['co_applicant_details']['CIBIL']['MaxAmount'];
		} else {
			if($page == 'your-quote') {
				$max_alloted_amount = $_SESSION['CIBIL']['revised_MaxAmount'];
			} else {
				$max_alloted_amount = $_SESSION['personal_details']['maxloanamt'];
			}
		}
		
		
		
		if($amount != $max_amount) {
			$calculated_emi = calculate_emi($amount, $rate, $time*12);
			$actual_emi = $_SESSION['personal_details']['actualloanEMI'];
			$tenure 		= $time * 12;
			$interest 	= $rate/(1200);
			$numr 			= $actual_emi * (pow((1 + $interest), $tenure) - 1);
			$denr 			= $interest * (pow((1 + $interest), $tenure));
			$new_amt  	= round($numr/$denr);
			if($new_amt > $max_alloted_amount) {
				$new_amt = $max_alloted_amount;
			}
			if($new_amt > $amount) {
				$emi = $calculated_emi;
			}
			$slider_amt = $new_amt;
			$status 		= 'No'; 
		} else {
			$calculated_emi = calculate_emi($amount, $rate, $time*12);
			$actual_emi = $_SESSION['personal_details']['actualloanEMI'];
			$tenure 		= $time * 12;
			$interest 	= $rate/(1200);
			$numr 			= $actual_emi * (pow((1 + $interest), $tenure) - 1);
			$denr 			= $interest * (pow((1 + $interest), $tenure));
			$new_amt  	= round($numr/$denr);
			if(($amount == $max_amount && $amount == $max_alloted_amount && $tenure == $_SESSION['personal_details']['actual_tenure']) || ($new_amt > $max_alloted_amount)) {
				$new_amt = $max_alloted_amount;
			}
			$slider_amt = $new_amt;
			$status 		= 'Yes'; 
		}
		
		

		$amount = to_rupee(trim($amount));
		$emi = to_rupee($emi);
		echo json_encode(array('amt' => $new_amt, 'emi' => $emi, 'calcEmi' => $calculated_emi, 'sldrAmt' => $slider_amt, 'status' => $status));

	?>
