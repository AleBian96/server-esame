<?php
	sessionStart();
	$utente = $_SESSION["utenteCollegato"];
?>
<HTML>
<form method="post" action="send.php">
<?php
	if(isset($utente))echo "V"; else echo "X";
	echo '<input type="hidden" name="FROM" value="$utente"/>'
?>
<input type="text" placeholder="TO" name="TO"/><br>
<input type="text" placeholder="Message" name="MSG"/><br>
<button>INVIA</button>
</form>

<?php
	echo "utente=".$utente;
	$db = database("chat");
	$Q = "SELECT * FROM msg WHERE receiver='$utente'";
	$R = $db->query($Q);
	while ($r = $R->fetchArray()) {
		$sender = $r["sender"];
		$msg = $r["msg"];
    		echo "$sender - $msg<br>";
	}
?>

</HTML>