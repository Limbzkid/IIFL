<?php
	session_start();
	$loan_amount 	= xss_filter($_POST['loanAmt']);
	$loan_tenure 	= xss_filter($_POST['loanTenure']);
	$loan_emi 		= xss_filter($_POST['loanEmi']);
	
	$_SESSION['personal_details']['appliedloanamt'] 		= preg_replace("/[^0-9]/","",$loan_amount);
	$_SESSION['personal_details']['tenure'] 						= preg_replace("/[^0-9]/","",$loan_tenure) * 12;
	$_SESSION['personal_details']['processing_fee_emi'] = preg_replace("/[^0-9]/","",$loan_emi);

	echo true;
	
?>

