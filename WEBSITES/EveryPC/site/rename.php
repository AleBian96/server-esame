<?php
	$oldname = $_POST["oldname"];
	$newname = $_POST["newname"];
	$dir = $_POST["dir"];
	rename($dir."/".$oldname,$dir."/".$newname);
?>
