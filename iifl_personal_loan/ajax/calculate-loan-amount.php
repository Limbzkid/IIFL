<?php

	$loan_amount 	= strip_tags($_POST['amt']);
	$time 				= strip_tags($_POST['time']);
	$ROI_default 	= strip_tags($_POST['int_def']);
	$ROI_actual 	= strip_tags($_POST['int_act']);
	
	$max_tenure = $time * 12;
	
	$interest = $ROI_default / 1200;
	$maximumloanamtemi = ceil($interest * -$loan_amount * pow((1 + $interest), $max_tenure) / (1 - pow((1 + $interest), $max_tenure)));
	
	$interest_actual = $ROI_actual / 1200;
	$emi_actual = ceil($interest_actual * -$loan_amount * pow((1 + $interest_actual), $max_tenure) / (1 - pow((1 + $interest_actual), $max_tenure)));

	$emi_difference = $emi_actual -  $maximumloanamtemi;
	
	echo json_encode(array('time' => $time, 'emi' => $maximumloanamtemi, 'diff' => $emi_difference));
	

?>
