<?php
		
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	
	date_default_timezone_set("Asia/Kolkata");
	DEFINE('HOME', 'http://10.132.150.2:9001/iifl_personal_loan');
	DEFINE('COMMON_API', 'http://ttavatar.iifl.in/PLcommonAPI/CommonAPI.svc/');
	DEFINE('API', 'http://ttavatar.iifl.in/PL_RestAPI/PL_APIService.svc/');
	DEFINE('PERFIOS_API', 'http://ttavatar.iifl.in/DigitalFinance/perfios/Service1.svc/');
	//DEFINE('COMMON_API', 'https://digitalfinance.indiainfoline.com/CommonAPI/CommonAPI.svc/');
	//DEFINE('API', 'https://digitalfinance.indiainfoline.com/PLApiService/PL_APIService.svc/');
	
	DEFINE('APPL_RETURN_URL', 'http://10.132.150.2:9001/iifl_personal_loan/verification?q=%s_%s');
	DEFINE('COAPP_RETURN_URL', 'http://10.132.150.2:9001/iifl_personal_loan/co-applicant-verification?q=%s_%s');
	$errors = array();

?>