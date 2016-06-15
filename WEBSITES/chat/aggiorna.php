<html>
<head>
<title>
<script type="text/javascript">
function aggiorna(){
var richiesta=new XMLHttpRequest();
richiesta.open("POST", "controllo.php", true);
  richiesta.send("utente='$utente'");