

<?php
	$dir = '/var/www/html/loans/personal_loan/uploads/';
	echo realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'); 
	//echo getcwd();
	//echo dirname(__FILE__);
	

	
	/*$url = "http://ttavatar.iifl.in/SMELoan/XML/CompanyMater.xml";
	$xml = simplexml_load_file($url);
	echo "<pre>";
	foreach($xml->Company as $company) {
		$company_arr[] = $company[0]->CompanyName;
		
	
	}
	
	print_r($company_arr);*/

?>