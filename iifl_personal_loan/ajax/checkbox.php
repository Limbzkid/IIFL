<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	$checked = strip_tags($_POST['inChk']);
	
	if($checked) {
		$_SESSION['currChk'] = '1';
		$_SESSION['personal_details']['curr_state_code'] 	= $_SESSION['personal_details']['perm_state_code'];
		$_SESSION['personal_details']['curr_city_code'] 	= $_SESSION['personal_details']['perm_city_code'];
	} else {
		$_SESSION['currChk'] = '0';
		$_SESSION['personal_details']['curr_state_code'] 	= '';
		$_SESSION['personal_details']['curr_city_code'] 	= '';
	}

?>

