<html>
<head><title>Registrazione</title>
<script type="text/javascript">
function controlla(){
	var richiesta=new XMLHttpRequest();
	var username=document.getElementById("username").value;
	richiesta.onreadystatechange=function(){
		var el=document.getElementByID("risposta");
	el.innerHTML=richiesta.responseText;}
	richiesta.open("GET","controlla.php?test="+username,"true");
	richiesta.send();
	}
}
</script></head>
<body>
<form action="registra.php"method="GET">
Inserisci l'username:
<input type="text" id="username" name="username" onsubmit="controlla();">
<div id="risposta"></div>
<input type="submit" value="invia">
</form>
</body>
</html>