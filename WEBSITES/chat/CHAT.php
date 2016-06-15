<?php
	session_start();
	$utente = $_SESSION["utenteCollegato"];
?>
<HTML>
<body>
<a href="index.php?comando=logout">LOGOUT</a>
<form method="post" action="send.php">

<?php
	echo "<input type='hidden' name='FROM' value='$utente' id='from'/>";
?>
<input type="text" placeholder="TO" name="TO" id="to"/><br>
<input type="text" placeholder="Message" name="MSG" id="message"/><br>
<button>INVIA</button>
</form>
<?php
	if(isset($_SESSION["JSENT"]))echo $_SESSION["JSENT"];
	if(isset($_SESSION["ESEND"]))echo $_SESSION["ESEND"];
?>
<div id="risultato"></div>
</body>

<script>

setInterval("aggiorna()",100);

function aggiorna(){
	var richiesta=new XMLHttpRequest();
//	var cercafrom=document.getElementById("from");
//	var cercato=document.getElementById("to");
//	var cercamessage=document.getElementById("message");
	richiesta.open("POST", "controllo.php", true);
	<?php echo "richiesta.send(\"utente=$utente\");\n" ?>
	richiesta.onreadystatechange=function(){
		var el=document.getElementById("risultato");
		if(richiesta.readyState ==4){
			el.innerHTML=richiesta.responseText;
		}
	}
}
</script>

</HTML>