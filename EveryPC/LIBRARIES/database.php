<?php
	function database($name){
		return new SQLite3(dirname(dirname(__FILE__))."/DATABASES/".$name.".db");
	}
?>
