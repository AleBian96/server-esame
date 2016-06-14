<HTML>
<form method="post" action="send.php">
<input type="hidden" name="FROM" value="NOME_USER"/>
<input type="text" placeholder="TO" name="TO"/>
<input type="text" placeholder="Message" name="MSG"/>
<button>INVIA</button>
</form>

<?php
	$db = database("chat");
	$Q = "SELECT * FROM msg WHERE receiver='NOME_USER'";
	$R = $db->query($Q);
	while ($r = $R->fetchArray()) {
		$sender = $r["sender"];
		$msg = $r["msg"];
    		echo "$sender - $msg<br>";
	}
?>

</HTML>