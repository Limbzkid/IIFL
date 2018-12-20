<?php
	require_once("../includes/functions.php");
	$output = '';
	$service_url = COMMON_API. 'FetchDropDownIndigo';
	$headers = array (
		"Content-Type: application/json"
	);
	
	$handle = curl_init(); 
	curl_setopt($handle, CURLOPT_URL, $service_url);
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($handle, CURLOPT_POSTFIELDS, array());

	$curl_response = curl_exec($handle);
	$curl_response = json_decode($curl_response);
	foreach($curl_response->Body->CityMaster as $city) {
		$city_arr[] = $city->dropdownid .'-'. $city->dropdownvalue;
		$output .= '<div class="homecityradio">
        <input type="radio" name="radio" value="'.$city->dropdownvalue.'">
        <label for="'.$city->dropdownvalue.'">'.$city->dropdownvalue.'</label>
    </div>';
	}

	
	
	echo json_encode($output);

?>
