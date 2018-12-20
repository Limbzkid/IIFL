<?php session_start();
	$session_value = $_SESSION['referafriendform'];
	$formkeyrec = strip_tags($_POST['formkey']);
	$salt = md5('customerportal_iifl');
	$tokenreceived = md5($formkeyrec.$salt);
  
  $leadtime = time();	
  $random_str = md5(uniqid($leadtime));
  $token = md5($random_str . $salt);	
  $_SESSION["referafriendform"] = $token;
	
	
	
	if($session_value == $tokenreceived) {
    $service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/saveReferal?key=INDIGO';
	
	
    $headers = array (
      "Content-Type: application/json"
    );

    $curl_post_data = array(
      "Userid"=>strip_tags($_POST['userid']),
      "Name"=>strip_tags($_POST['Name']),
      "pinCode"=>strip_tags($_POST['pincode']),
      "City"=>strip_tags($_POST['city']),
      "MobileNo"=>strip_tags($_POST['mobilenumber']),
      "requestCode"=>'INDIGOSF18'
      );

    $decodeddata = json_encode($curl_post_data);
    $handle = curl_init(); 
    curl_setopt($handle, CURLOPT_URL, $service_url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
    
    $curl_response = curl_exec($handle);
    $obj = json_decode($curl_response);
      if($obj->head->status == 0) {
          $msg = 'Feedback has been received';
      } else {
          $msg = 'Failed to submit your feedback';
      }


	} else {
		echo "Invalid token";
	}
    
	echo json_encode(array('msg' => $msg, 'token' => $random_str));
	
?>