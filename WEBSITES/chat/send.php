<?php
	echo "scrivo nel DB\n";
	$FROM = $_POST["FROM"];
	$TO = $_POST["TO"];
	$MSG = $_POST["MSG"];
	echo "invio '$MSG' a '$TO' da '$FROM'\n";
	$db = database("chat");
	$Q = "INSERT INTO msg VALUES ('$FROM','$TO','$MSG','0')";
	echo "QUERY = $Q\n";
	if($db->query($Q)) echo "SENT"; else echo "message not sent";
?>