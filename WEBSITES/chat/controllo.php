<?php
	$db = database("chat");
	$utente = $_POST["utente"];
	$Q = "SELECT * FROM msg WHERE receiver='$utente'";
	$R = $db->query($Q);
	while ($r = $R->fetchArray()) {
		$sender = $r["sender"];
		$msg = $r["msg"];
    		echo "$sender - $msg<br>";
	}
?>