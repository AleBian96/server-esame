<?php
	$text = $_POST["text"];
	$dir = $_POST["dir"];
	$file = fopen($dir,"w");
	echo fwrite($file, $text);
?>