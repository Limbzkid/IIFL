<?php

	DEFINE('COMMON_API', 'http://ttavatar.iifl.in/PLcommonAPI/CommonAPI.svc/');
	DEFINE('API', 'http://ttavatar.iifl.in/PL_RestAPI/PL_APIService.svc/');
	
	function redirect_to($new_location) {
		header("Location: " . $new_location);
		exit;
	}
	
	function MROUND($number,$multiple){
    if ((is_numeric($number)) && (is_numeric($multiple))) {
			if ($multiple == 0) {
					return 0;
			}
			if ((SIGNTest($number)) == (SIGNTest($multiple))) {
				$multiplier = 1 / $multiple;
				return round($number * $multiplier) / $multiplier;
			}
			return 'NAN';
    }
    return 'NAN';
	}
	
	function SIGNTest($number) {
    if (is_bool($number)) {
      return (int) $number;
    }
    if (is_numeric($number)) {
      if($number == 0.0) {
  return 0;
      }
      return $number / abs($number);
    }
    return 'NAN';
	}
	
	function to_rupee($num) {
		$explrestunits = "" ;
		if(strlen($num) > 3) {
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i == 0) {
					$explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
				}else{
					$explrestunits .= $expunit[$i].",";
				}
			}
			$thecash = $explrestunits.$lastthree;
		} else {
				$thecash = $num;
		}
		return $thecash;
	}
	
	function to_months($startDate) {
		$endDate = date('Y-m-d');
		$datetime1 = new DateTime($startDate);
		$datetime2 = new DateTime($endDate);
		$interval = $datetime2->diff($datetime1);
		return (($interval->format('%y') * 12) + $interval->format('%m'));
	}
	
	function xss_filter( $input, $safe_level = 0 ) {
		$output = $input;
		do {
			// Treat $input as buffer on each loop, faster than new var
			$input = $output;
			// Remove unwanted tags
			$output = _strip_tags($input);
			$output = strip_encoded_entities($output) ;
			// Use 2nd input param if not empty or '0'
			if ($safe_level !== 0) {
				$output = $this->strip_base64( $output );
			}
		} while ($output !== $input);
		return $output;
	}
	
	function strip_encoded_entities($input) {
		$input = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $input);
		$input = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $input);
		$input = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $input);
		$input = html_entity_decode($input, ENT_COMPAT, 'UTF-8');
		// Remove any attribute starting with "on" or xmlns
		$input = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+[>\b]?#iu', '$1>', $input);
		// Remove javascript: and vbscript: protocols
		$input = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $input);
		$input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $input);
		$input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $input);
		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
		$input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
		$input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $input);
		return $input;
	}
	
	function _strip_tags($input) {
		// Remove tags
		$input = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $input);
		// Remove namespaced elements
		$input = preg_replace('#</*\w+:\w[^>]*+>#i', '', $input);
		return $input;
	}
	
	function strip_base64( $input ) {
		$decoded = base64_decode( $input );
		$decoded = $this->strip_tags( $decoded );
		$decoded = $this->strip_encoded_entities( $decoded );
		$output = base64_encode( $decoded );
		return $output;
	}
	
	function valid_name($name) {
		if(preg_match("/^([a-zA-Z.\']+\s?)*$/", $name)) {
			return true;
		}	else {
			return false;
		}
	}
	
	function valid_mail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return true;
		} else {
			return false;
		}
	}
	
	function valid_mobile($mobile) {
		if(!preg_match("/^[789][0-9]{9}$/", $mobile)) {
			return false;
		} else {
			return true;
		}
	}
		
	function numerix($num) {
		if(!preg_match("/^[0-9]$/", $num)) {
			return false;
		} else {
			return true;
		}
	}
	
	function valid_PAN($pan_number) {
		if(!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", trim($pan_number))) {
			return false;
		} else {
			return true;
		}
	}
	
	function alpha($str) {
		if(preg_match("/^[A-Za-z]+$/", $str)) {
			return true;
		} else {
			return false;
		}
	}
		
	function alphanumerix($str) {
		if(preg_match("/^[a-zA-Z0-9]+$/", $str)) {
			return true;
		} else {
			return false;
		}
	}
	
	function valid_aadhar($aadhar_number) {
		if(!preg_match("/^[0-9]{12}$/", $aadhar_number)) {
			return false;
		} else {
			return true;
		}
	}
	
	function valid_pincode($pincode) {
		if(!preg_match("/^[0-9]{6}$/", $pincode)) {
			return false;
		} else {
			return true;
		}
	}
	
	function valid_address($address) {
		if(preg_match("/^[a-zA-Z0-9,.!?#\-:& *'\"\/\\\ ()\[\]]*$/", $address)) {
			return true;
		} else {
			return false;
		}
	}
	
	function valid_date($date) {
		//dd/mm/yyyy
		if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4})$/",$date)) {
			return true;
		} else {
			return false;
		}
	}
	
	function valid_gender($char) {
		if(preg_match("/^[M|F]$/", $char)) {
			return true;
		} else {
			return false;
		}
	}
	
	function valid_location($location) {
		if(!preg_match("/^([a-zA-Z. \']+\s?)*$/", $location)) {
			return false;
		} else {
			return true;
		}
	}
	
	function valid_year($year) {
		if(preg_match("/^[0-9]|[0-9][0-9]$/",$year)) {
			return true;
		} else {
			return false;
		}
	}
	
	function valid_month($month) {
		if(preg_match("/^[0-9]|[0-9][0-9]$/",$month)) {
			return true;
		} else {
			return false;
		}
	}
	
	function num_only($num) { // returns all numbers
		if($num == '') {
			return '';
		} else {
			return preg_replace("/[^0-9]/","",$num);
		}
	}
	
	function valid_company_name($name) {
		if(preg_match("/^([A-Za-z0-9.\&-]+\s?)*$/", $name)) {
			return true;
		} else {
			return false;
		}
	}
	
	function calculate_emi($amount, $rate, $time) {
		if($amount == '' || $rate == '' || $time == '') {
			return '';
		} else {
			$interest 		= $rate/(1200);
			$numerator		= pow((1 + $interest), $time);
			$denominator	= $numerator - 1;
			$emi 					= $amount * $interest * ($numerator/$denominator);		
			return round($emi);
		}
	}
	
	function call_api($type, $method, $data) {
		//echo $type. '- '. $method;
		$time_start = microtime(true); 
		if($type == 'common') {
			$service_url = COMMON_API . $method;
		} else {
			$service_url = API . $method;
		}
		$headers = array ("Content-Type: application/json");
		$curl_post_data = $data;
		$decodeddata = json_encode($curl_post_data);
		$handle = curl_init();
		//echo '<pre>'; print_r($curl_post_data); echo '</pre>';
		curl_setopt($handle, CURLOPT_URL, $service_url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
		$curl_response = curl_exec($handle);
		$_SESSION['exec'][$method] = (microtime(true) - $time_start);
		$_SESSION['exec']['response'][$method] = $curl_response;
		//echo '<pre>'; print_r($curl_response); echo '</pre>'; 
		curl_close($handle);
		return json_decode($curl_response);
	}
	
?>