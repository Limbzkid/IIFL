<?php
	session_start();
	
	$_SESSION['slider_value'] = $_POST['amt'];
	
	echo $_POST['amt'];

?>

