<?php 
  session_start();

	$session_value = $_SESSION['feedbackform'];
	$formkeyrec = strip_tags($_POST['formkey']);
	$salt = md5('customerportal_iifl');
	$tokenreceived = md5($formkeyrec.$salt);
  
  $leadtime = time();	
  $random_str = md5(uniqid($leadtime));
  $token = md5($random_str . $salt);	
  $_SESSION["feedbackform"] = $token;
	
	
	
	if($session_value == $tokenreceived) {
    $service_url = 'http://ttavatar.iifl.in/IndigoRestAPI/Service.svc/submitFeedback?key=INDIGO';
	
	
    $headers = array (
      "Content-Type: application/json"
    );
	

    $curl_post_data = array(
      "LoanNo"=>strip_tags($_POST['loanno']),
      "Category"=>strip_tags($_POST['category']),
      "SubCategory"=>strip_tags($_POST['subcategory']),
      "Feedback"=>strip_tags($_POST['feedback']),
      "UserId"=>strip_tags($_POST['userid']),
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