<?php
	session_start();

	if(isset($_SESSION["user"]))
		redirectTo("remote.php");

?>
<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="remoteStyle/loadfonts.css">
<link rel="stylesheet" type="text/css" href="remoteStyle/indexTheme.css">
<form method="POST" id="login" action="remote.php" onsubmit="tryLogin()" autocomplete="off">
	<div id="rett"><div id="circle"><p>login</p></div></div>
	<input type="text" name="name" placeholder="username">
	<input type="password" name="pass" placeholder="password">
	<input type="submit" value="ok">
</form>
<script src="remoteJS/AJAX.js"></script>
<script>
document.getElementsByName("name")[0].focus();
sexyBoot(true);

function tryLogin(){
	event.preventDefault();
	var name = document.getElementsByName("name")[0].value;
	var pass = document.getElementsByName("pass")[0].value;

	AJAX("login.php","name="+name+"&pass="+pass,function(){
		if(response!=""){
			loginError();
		}else{
			sexyExit();
		}
	});
}

function sexyBoot(show){
	if(show){
		var D = document.createElement("div");
		D.style = "background:white;z-index:5000;position:absolute;top:0;left:0;width:100%;height:100%;"
		document.body.appendChild(D);

		window.onload = function(){
			D.style.opacity = 0;
			setTimeout(document.onload = function(){document.body.removeChild(D);},250);
		}
	}else{
		var F = document.getElementById("login");
		F.style.opacity=0;
		setTimeout(function(){F.style.opacity = 1;},0);
	}

}
function loginError(){
	var F = document.getElementById("login");
	F.classList.remove("loginError");
	F.offsetWidth = F.offsetWidth;
	F.classList.add("loginError");
	document.getElementsByName("pass")[0].value = "";
}
function sexyExit(){
	var F = document.getElementById("login");
	F.style.top = "-30%";
	F.style.opacity = 0;
	location.replace(F.action);
}
</script>
</HTML>