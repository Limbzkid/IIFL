<?php
	$output = '';
	$service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/ProductDetails?key=INDIGO';
	$curl = curl_init($service_url);
	$curl_post_data = array(
		'Type' 					=> 'IIFLFINANCE',
		'dob' 					=> '19850710',
		'RequestCode' 	=> 'INDIGO007',
		'key' 					=> 'INDIGO',
		'AppVer' 				=> '1.0',
		'OsName' 				=> 'android',
		'OsVer' 				=> '5.1'
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
	
	$output = '<li class="active"><a class="activedarkblue" href="#"><span><img class="img_main" src="images/left_menu_icon/my_loan.png"/><img class="img_hover" src="images/left_menu_icon/my_loan_hover.png"/></span>My Loan</a></li>';
  $output .= '<li><a class=" activelightblue" href="#"><span><img class="img_main" src="images/left_menu_icon/overview.png"/><img class="img_hover" src="images/left_menu_icon/overview_hover.png"/></span>Overview</a></li>';
	$count = 1;
	if($obj->head->status == 0 && $obj->head->status_description == 'success') {
		//success
		foreach($obj->body as $row) {
			if($count <= 2) {
				$a_class = 'activelightblue';
			} else {
				$a_class = '';
			}
			$url = strtolower(str_replace(' ', '-', $row->LoanProducts));
			$id = $row->Code .'-'. $row->ProductKey;
			$class = $a_class .' '.strtolower(str_replace(' ', '', $row->LoanProducts));
			$output .= '<li id="'.$id.'" rel="'.$row->Default.'"><a class="'.$class.'" href="'.$url.'"><span><img class="img_main" src="images/left_menu_icon/home_loan.png"/><img class="img_hover" src="images/left_menu_icon/home_loan_hover.png"/></span>'.$row->LoanProducts.'</a></li>';
			$count++;
		}
	} else {
		//failure
		$output .= 'Failed to get data';
		
	}
	echo $output;
?>