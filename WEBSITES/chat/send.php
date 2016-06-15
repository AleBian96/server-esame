<?php
	$FROM = $_POST["FROM"];
	$TO = $_POST["TO"];
	$MSG = $_POST["MSG"];
	$db = database("chat");
	$Q = "INSERT INTO msg VALUES ('$FROM','$TO','$MSG','0')";
	if($db->query($Q))$_SESSION["JSENT"] = $MSG; else $_SESSION["ESEND"] = "msg not sent";
	redirectTo("CHAT.php");
?>