<?php session_start(); ?>
<?php require_once("../includes/functions.php"); ?>
<?php

	$form_id = $_POST['form_id'];
	switch($form_id) {
		case 	'idProofFrm':
					id_proof_form();
					exit;
		case 	'addrProofFrm':
					addr_proof_form();
					exit;
		case	'propOwnFrm':
					property_ownership_form();
					exit;
		case	'bankStmtFrm':
					bank_statement_form();
					exit;
		case	'salSlipFrm':
					salary_slip_form();
					exit;

		case 	'idProofFrmcoapp2':
					co_id_proof_form();
					exit;
		case 	'addrProofFrmcoapp2':
					co_addr_proof_form();
					exit;
		case	'propOwnFrmcoapp2':
					co_property_ownership_form();
					exit;
		case	'bankStmtFrmcoapp2':
					co_bank_statement_form();
					exit;
		case	'salSlipFrmcoapp2':
					co_salary_slip_form();
					exit;
		default :
					exit;
	}
	
	
	function addr_proof_form() {
		if(isset($_SESSION['co_applicant_details'])) {
			$page_number = '12';
		} else {
			$page_number = '8';
		}
		$msg = '';
		if(isset($_FILES["addrProof"])) {
			$allowedExts = array("jpeg","jpg", "pdf", "docx", "doc", "png", "JPEG", "JPG", "PDF", "DOCX", "PNG");
			$explode = explode(".", $_FILES["addrProof"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['addrProof']['error'] > 0) {
				$msg = $_FILES['addrProof']['error'];
			} else {
				$name 			= xss_filter($_FILES['addrProof']['name']);
				$type 			= xss_filter($_FILES['addrProof']['type']);
				$temp_name 		= xss_filter($_FILES['addrProof']['tmp_name']);
				$size 			= xss_filter($_FILES['addrProof']['size']);
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Files with extension ". $extension ." are not allowed";
				}	else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) {
						$document_category = $_POST['opt'];
						if($document_category == 5) {
							$document_name = 'Aadhar';
						} elseif($document_category == 6) {
							$document_name = 'Voters ID';
						} elseif($document_category == 7) {
							$document_name = 'Passport';
						}	
						$base64_file = base64_encode(file_get_contents($dir.$name));
						
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "APPLICANT",
							"CatID"				=> "2",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> $page_number
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		}	else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}
	
	function co_addr_proof_form() {
		$msg = '';
		if(isset($_FILES["addrProofcoapp2"])) {
			$allowedExts = array("jpeg","jpg", "pdf", "docx", "doc", "png", "JPEG", "JPG", "PDF", "DOCX", "PNG");
			$explode = explode(".", $_FILES["addrProofcoapp2"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['addrProofcoapp2']['error'] > 0) {
				$msg = $_FILES['addrProofcoapp2']['error'];
			} else {
				$name 			= xss_filter($_FILES['addrProofcoapp2']['name']);
				$type 			= xss_filter($_FILES['addrProofcoapp2']['type']);
				$temp_name 		= xss_filter($_FILES['addrProofcoapp2']['tmp_name']);
				$size 			= xss_filter($_FILES['addrProofcoapp2']['size']);
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Files with extension ". $extension ." are not allowed";
				}	else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) {
						$document_category = $_POST['opt'];
						if($document_category == 5) {
							$document_name = 'Aadhar';
						} elseif($document_category == 6) {
							$document_name = 'Voters ID';
						} elseif($document_category == 7) {
							$document_name = 'Passport';
						}	
						$base64_file = base64_encode(file_get_contents($dir.$name));
						
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "COBORROWER",
							"CatID"				=> "2",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> "12"
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		}	else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}

	function id_proof_form() {
		if(isset($_SESSION['co_applicant_details'])) {
			$page_number = '12';
		} else {
			$page_number = '8';
		}
		$msg = '';
		if(isset($_FILES["idProof"])) {
			$allowedExts = array("jpeg","jpg", "pdf", "docx", "doc", "png", "JPEG", "JPG", "PDF", "DOCX", "PNG");
			$explode = explode(".", $_FILES["idProof"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['idProof']['error'] > 0) {
				$msg = $_FILES['idProof']['error'];
			} else {
				$name 			= $_FILES['idProof']['name'];
				$type 			= $_FILES['idProof']['type'];
				$temp_name 		= $_FILES['idProof']['tmp_name'];
				$size 			= $_FILES['idProof']['size'];
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Files with extension ". $extension ." are not allowed";
				} else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}
					if(move_uploaded_file($temp_name,$dir.$name)) {
						$document_category = $_POST['opt'];
						if($document_category == 0) {
							$document_name = 'PAN';
						} elseif($document_category == 1) {
							$document_name = 'Aadhar';
						} elseif($document_category == 1) {
							$document_name = 'Voters ID';
						}	else {
							$document_name = 'Passport';
						}
						$base64_file = base64_encode(file_get_contents($dir.$name));
						
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "APPLICANT",
							"CatID"				=> "1",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> $page_number
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		} else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}
	
	function co_id_proof_form() {
		$msg = '';
		if(isset($_FILES["file-7coapp2"])) {
			$allowedExts = array("jpeg","jpg", "pdf", "docx", "doc", "png", "JPEG", "JPG", "PDF", "DOCX", "PNG");
			$explode = explode(".", $_FILES["file-7coapp2"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['file-7coapp2']['error'] > 0) {
				$msg = $_FILES['file-7coapp2']['error'];
			} else {
				$name 			= $_FILES['file-7coapp2']['name'];
				$type 			= $_FILES['file-7coapp2']['type'];
				$temp_name 		= $_FILES['file-7coapp2']['tmp_name'];
				$size 			= $_FILES['file-7coapp2']['size'];
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Files with extension ". $extension ." are not allowed";
				} else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}
					if(move_uploaded_file($temp_name,$dir.$name)) {
						$document_category = $_POST['opt'];
						if($document_category == 0) {
							$document_name = 'PAN';
						} elseif($document_category == 1) {
							$document_name = 'Aadhar';
						} elseif($document_category == 1) {
							$document_name = 'Voters ID';
						}	else {
							$document_name = 'Passport';
						}
						$base64_file = base64_encode(file_get_contents($dir.$name));
						
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "COBORROWER",
							"CatID"				=> "1",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> "12"
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		} else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}
	
	function bank_statement_form() {
		if(isset($_SESSION['co_applicant_details'])) {
			$page_number = '13';
		} else {
			$page_number = '9';
		}
		$msg = '';
		$document_category = $_POST['opt'];
		if($document_category == 12) {
			$document_name = 'Consolidated 3 months bank statement ';
		} elseif($document_category == 13) {
			$document_name = 'Month 1 bank statement';	
		} elseif($document_category == 14) {
			$document_name = 'Month 2 bank statement';
		}	elseif($document_category == 15) {
			$document_name = 'Month 3 bank statement';
		}
		if(isset($_FILES['bnkStmt'])) {
			$allowedExts = array("jpeg","jpg", "pdf", "png");
			$explode = explode(".", $_FILES["bnkStmt"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['bnkStmt']['error'] > 0) {
				$msg = $_FILES['bnkStmt']['error'];
			} else {
				$name 			= $_FILES['bnkStmt']['name'];
				$type 			= $_FILES['bnkStmt']['type'];
				$temp_name 		= $_FILES['bnkStmt']['tmp_name'];
				$size 			= $_FILES['bnkStmt']['size'];
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Files with extension ". $extension ." are not allowed";
				} else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) {
						$base64_file = base64_encode(file_get_contents($dir.$name));
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "APPLICANT",
							"CatID"				=> "4",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> $page_number
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		}	else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}	
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}
	
	function co_bank_statement_form() {
		$msg = '';
		$document_category = $_POST['opt'];
		if($document_category == 12) {
			$document_name = 'Consolidated 3 months bank statement ';
		} elseif($document_category == 13) {
			$document_name = 'Month 1 bank statement';	
		} elseif($document_category == 14) {
			$document_name = 'Month 2 bank statement';
		}	elseif($document_category == 15) {
			$document_name = 'Month 3 bank statement';
		}
		if(isset($_FILES['bnkStmtcoapp2'])) {
			$allowedExts = array("jpeg","jpg", "pdf", "png");
			$explode = explode(".", $_FILES["bnkStmtcoapp2"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['bnkStmtcoapp2']['error'] > 0) {
				$msg = $_FILES['bnkStmtcoapp2']['error'];
			} else {
				$name 			= $_FILES['bnkStmtcoapp2']['name'];
				$type 			= $_FILES['bnkStmtcoapp2']['type'];
				$temp_name 		= $_FILES['bnkStmtcoapp2']['tmp_name'];
				$size 			= $_FILES['bnkStmtcoapp2']['size'];
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Files with extension ". $extension ." are not allowed";
				} else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) {
						$base64_file = base64_encode(file_get_contents($dir.$name));
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "COBORROWER",
							"CatID"				=> "4",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> "14"
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		}	else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}	
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}

	function property_ownership_form() {
		if(isset($_SESSION['co_applicant_details'])) {
			$page_number = '12';
		} else {
			$page_number = '8';
		}
		$msg = '';
		if(isset($_FILES["propOwn"])) {
			$allowedExts = array("jpeg","jpg", "pdf", "docx", "doc", "png", "JPEG", "JPG", "PDF", "DOCX", "PNG");
			$explode = explode(".", $_FILES["propOwn"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['propOwn']['error'] > 0) {
				$msg = $_FILES['propOwn']['error'];
			} else {
				$name 			= $_FILES['propOwn']['name'];
				$type 			= $_FILES['propOwn']['type'];
				$temp_name 		= $_FILES['propOwn']['tmp_name'];
				$size 			= $_FILES['propOwn']['size'];
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Error: Files with extension ". $extension ." are not allowed";
				} else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) {
						$document_category = $_POST['opt'];
						if($document_category == 16) {
							$document_name = 'Electricity bill';
						} elseif($document_category == 17) {
							$document_name = 'Water bill';
						} elseif($document_category == 18) {
							$document_name = 'Sales Deed';
						}	elseif($document_category == 19) {
							$document_name = 'Society mantainance billl';
						} elseif($document_category == 20) {
							$document_name = 'Property Tax Bill';
						}
						$base64_file = base64_encode(file_get_contents($dir.$name));
						
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "APPLICANT",
							"CatID"				=> "5",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> $page_number
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'File upload failed';
					}
				}
			}
			unset($_FILES);
		}	else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}
	
	function co_property_ownership_form() {
		$msg = '';
		if(isset($_FILES["propOwncoapp2"])) {
			$allowedExts = array("jpeg","jpg", "pdf", "docx", "doc", "png", "JPEG", "JPG", "PDF", "DOCX", "PNG");
			$explode = explode(".", $_FILES["propOwncoapp2"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['propOwncoapp2']['error'] > 0) {
				$msg = $_FILES['propOwncoapp2']['error'];
			} else {
				$name 			= $_FILES['propOwncoapp2']['name'];
				$type 			= $_FILES['propOwncoapp2']['type'];
				$temp_name 		= $_FILES['propOwncoapp2']['tmp_name'];
				$size 			= $_FILES['propOwncoapp2']['size'];
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Error: Files with extension ". $extension ." are not allowed";
				} else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) {
						$document_category = $_POST['opt'];
						if($document_category == 16) 	{
							$document_name = 'Electricity bill';
						} elseif($document_category == 17) {
							$document_name = 'Water bill';
						} elseif($document_category == 18) {
							$document_name = 'Sales Deed';
						}	elseif($document_category == 19) {
							$document_name = 'Society mantainance billl';
						} elseif($document_category == 20) {
							$document_name = 'Property Tax Bill';
						}
						$base64_file = base64_encode(file_get_contents($dir.$name));
						
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 		=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 	=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 			=> "INDIGO",
							"ApplicantType" 	=> "COBORROWER",
							"CatID"				=> "5",
							"SubCatID"			=> $document_category,
							"Base64string"		=> $base64_file,
							"ImageName"			=> $name,
							"Extension"			=> $extension,
							"PageNumber"		=> "12"
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'File upload failed';
					}
				}
			}
			unset($_FILES);
		}	else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}
		
	function salary_slip_form() {
		if(isset($_SESSION['co_applicant_details'])) {
			$page_number = '13';
		} else {
			$page_number = '9';
		}
		$msg = '';
		$document_category = $_POST['opt'];
		if($document_category == 8) 
		{
			$document_name = 'Consolidated Salary Slip';
		} 
		elseif($document_category == 9) 
		{
			$document_name = 'Month 1 Salary Slip';	
		} 
		elseif($document_category == 10) 
		{
			$document_name = 'Month 2 Salary Slip';
		}	
		elseif($document_category == 11) 
		{
			$document_name = 'Month 3 Salary Slip';
		}
		if(isset($_FILES['salSlip'])) 
		{
			$allowedExts = array("jpeg","jpg", "pdf", "png");
			$explode = explode(".", $_FILES["salSlip"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['salSlip']['error'] > 0) 
			{
				$msg = $_FILES['salSlip']['error'];
			} 
			else 
			{
				$name 			= $_FILES['salSlip']['name'];
				$type 			= $_FILES['salSlip']['type'];
				$temp_name 	= $_FILES['salSlip']['tmp_name'];
				$size 			= $_FILES['salSlip']['size'];
				if(!(in_array($extension, $allowedExts ))) 
				{
					$msg = "Files with extension ". $extension ." are not allowed";
				} 
				else 
				{
					if(file_exists($dir.$name)) 
					{
						$prefix = 1;
						while(file_exists($dir.$name)) 
						{
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) 
					{
						$base64_file = base64_encode(file_get_contents($dir.$name));
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 			=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 		=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 				=> "INDIGO",
							"ApplicantType" 		=> "APPLICANT",
							"CatID"					=> "3",
							"SubCatID"				=> $document_category,
							"Base64string"			=> $base64_file,
							"ImageName"				=> $name,
							"Extension"				=> $extension,
							"PageNumber"			=> $page_number
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') 
						{
							$msg = 'success';
						} 
						else 
						{
							$msg = $json[0]->ErrorMsg;
						}
					} 
					else 
					{
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		}	
		else 
		{
			$msg = 'Please select a file to upload.';
			$name = '';
		}	
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}

	function co_salary_slip_form() {
		$msg = '';
		$document_category = $_POST['opt'];
		if($document_category == 8) {
			$document_name = 'Consolidated Salary Slip';
		} elseif($document_category == 9) {
			$document_name = 'Month 1 Salary Slip';	
		} elseif($document_category == 10) {
			$document_name = 'Month 2 Salary Slip';
		}	elseif($document_category == 11) {
			$document_name = 'Month 3 Salary Slip';
		}
		if(isset($_FILES['salSlipcoapp2'])) {
			$allowedExts = array("jpeg","jpg", "pdf", "png");
			$explode = explode(".", $_FILES["salSlipcoapp2"]["name"]);
			$extension = end($explode);
			$dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'). '/uploads/';
			if($_FILES['salSlipcoapp2']['error'] > 0) {
				$msg = $_FILES['salSlipcoapp2']['error'];
			} else {
				$name 			= $_FILES['salSlipcoapp2']['name'];
				$type 			= $_FILES['salSlipcoapp2']['type'];
				$temp_name 		= $_FILES['salSlipcoapp2']['tmp_name'];
				$size 			= $_FILES['salSlipcoapp2']['size'];
				if(!(in_array($extension, $allowedExts ))) {
					$msg = "Files with extension ". $extension ." are not allowed";
				} else {
					if(file_exists($dir.$name)) {
						$prefix = 1;
						while(file_exists($dir.$name)) {
							$temp = explode('.', $name);
							$end = end($temp);
							$temp = '_'.$prefix.'.'.$extension;
							$prefix++;
							$name = str_replace('.'.$extension, '', $name).$temp;
						}
					}

					if(move_uploaded_file($temp_name,$dir.$name)) {
						$base64_file = base64_encode(file_get_contents($dir.$name));
						$service_url = API. 'InsertKYC';
						$headers = array (
							"Content-Type: application/json"
						);
						$curl_post_data = array(
							"CRMLeadID" 			=> $_SESSION['personal_details']['CRMLeadID'],
							"ProspectNumber" 		=> $_SESSION['personal_details']['ProspectNumber'],
							"Source" 				=> "INDIGO",
							"ApplicantType" 		=> "COBORROWER",
							"CatID"					=> "3",
							"SubCatID"				=> $document_category,
							"Base64string"			=> $base64_file,
							"ImageName"				=> $name,
							"Extension"				=> $extension,
							"PageNumber"			=> "14"
						);
						
						$decodeddata = json_encode($curl_post_data);
						$_SESSION['request'] = $curl_post_data;
						$handle = curl_init(); 
						curl_setopt($handle, CURLOPT_URL, $service_url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'POST');
						curl_setopt($handle, CURLOPT_POSTFIELDS, $decodeddata);
					
						$curl_response = curl_exec($handle);
						curl_close($handle);
						$json = json_decode(json_decode($curl_response));
						if(strtolower($json[0]->Status) == 'success') {
							$msg = 'success';
						} else {
							$msg = $json[0]->ErrorMsg;
						}
					} else {
						$msg = 'unable to move file to upload directory';
					}
				}
			}
			unset($_FILES);
		}	else {
			$msg = 'Please select a file to upload.';
			$name = '';
		}	
		echo json_encode(array('msg' => $msg, 'name'=> $name));
	}
	
	/*
	
	Category ID	Category Name
1	IDProof
2	AddressProof
3	SalarySatement
4	BankStatement
5	OwnershipType
6	RelationshipType

*/
	
	
	
?>
