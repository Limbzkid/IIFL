<pre>

<?php
	$output = '';
	$service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/viewImageDetails?key=INDIGO';
	$curl = curl_init($service_url);
	$curl_post_data = array(
		'Parameter' 				=> 'value',
		'UserId' 			=> 'John@12',
		'business' 			=> 'GL',
		'requestCode' => 'INDIGOSF29',
		'key' 				=> 'INDIGO'		
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
	print_r($obj);
	exit;
	
	
	
	$output = '';
	$count = 1;
	if($obj->head->status == 0 && $obj->head->status_description == 'success') {
		//success
		foreach($obj->body as $row) {
			if($count == 1) {
				$a_class = 'activedarkblue';
			} elseif($count <= 4) {
				$a_class = 'activelightblue';
			} else {
				$a_class = '';
			}
			$id = $row->Code .'-'. $row->ProductKey;
			$class = $a_class .' '.strtolower(str_replace(' ', '', $row->LoanProducts));
			$output .= '<li id="'.$id.'" rel="'.$row->Default.'"><a class="'.$class.'" href="javascript:;">'.$row->LoanProducts.'</a></li>';
			$count++;
		}
	} else {
		//failure
		$output .= 'Failed to get data';
		
	}
	echo $output;
?>
</pre>