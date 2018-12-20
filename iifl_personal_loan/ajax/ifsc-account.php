<?php
	session_start();
	if($_POST['appType'] == 'APPLICANT') {
		$_SESSION['personal_details']['code'] 					= $_POST['ifsc'];
		$_SESSION['personal_details']['account_number'] = $_POST['acct_no'];
		$_SESSION['personal_details']['branch'] 				= $_POST['branch'];
		$_SESSION['personal_details']['bank'] 					= $_POST['bank'];
	} else {
		$_SESSION['co-applicant_details']['code'] 				= $_POST['ifsc'];
		$_SESSION['applicant_details']['account_number'] 	= $_POST['acct_no'];
		$_SESSION['applicant_details']['branch'] 					= $_POST['branch'];
		$_SESSION['applicant_details']['bank'] 						= $_POST['bank'];
	}
	
?>
