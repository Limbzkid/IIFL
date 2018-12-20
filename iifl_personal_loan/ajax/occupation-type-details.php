<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	if($_POST['empType'] == 'self-emplyed')
	{
		$businessList = '';
		$service_url = COMMON_API. 'SearchFetchDropDown';
		$headers = array (
			"Content-Type: application/json"
		);
		$curl_post_data = array("CategoryName"	=> "Business");
		$decodeddata = json_encode($curl_post_data);
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $service_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $decodeddata);
		$curl_response = (curl_exec($ch));
		curl_close($ch);
		echo $curl_response;
		/*foreach($curl_response->Body->MasterValues as $data) {
			$id = $data->dropdownid;
			$value = $data->dropdownvalue;
			$businessList .= '<option value="'.$id.'">'.$value.'</option>';
		}*/
	}
	if($_POST['empType'] == 'Profession')
	{
		$professionList = '';
		$service_url = COMMON_API. 'SearchFetchDropDown';
		$headers = array (
			"Content-Type: application/json"
		);
		$curl_post_data = array("CategoryName"	=> "Profession");
		$decodeddata = json_encode($curl_post_data);
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $service_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $decodeddata);
		$curl_response = (curl_exec($ch));
		curl_close($ch);
		echo $curl_response;
		/*foreach($curl_response->Body->MasterValues as $data) {
			$id = $data->dropdownid;
			$value = $data->dropdownvalue;
			$professionList .= '<option value="'.$id.'">'.$value.'</option>';
		}
		echo "<pre>"; print_r($professionList); exit;*/
	}
	if($_POST['empType'] == 'Constitutiontype')
	{
		$consTypeList = '';
		$service_url = COMMON_API. 'SearchFetchDropDown';
		$headers = array (
			"Content-Type: application/json"
		);
		$curl_post_data = array("CategoryName"	=> "Constitutiontype");
		$decodeddata = json_encode($curl_post_data);
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $service_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $decodeddata);
		$curl_response = (curl_exec($ch));
		curl_close($ch);
		echo $curl_response;
		/*foreach($curl_response->Body->MasterValues as $data) {
			$id = $data->dropdownid;
			$value = $data->dropdownvalue;
			$consTypeList .= '<option value="'.$id.'">'.$value.'</option>';
		}
		echo "<pre>"; print_r($consTypeList); exit;*/
	}
?>

