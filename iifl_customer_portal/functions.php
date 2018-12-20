<?php

	function redirect_to($path=NULL) {
		if($path != NULL) {
			header("Location: ".$path);
			exit;
		}
	}
	
	
	
	

?>