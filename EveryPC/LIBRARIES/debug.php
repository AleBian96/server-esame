<?php
	function consoleLog($text){
		echo "<script>console.log('".$text."');</script>";
	}
	function notice($text){
		trigger_error("'".$text."'",E_USER_NOTICE);
	}
?>
