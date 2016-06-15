<?php
	session_start();
	if(isset($_SESSION["user"]))if(!isset($_POST["logout"]))redirectTo("remote.php"); else unset($_SESSION["user"]);
?>
<HTML>
<link rel="stylesheet" type="text/css" href="remoteStyle/loadfonts.css">
<link rel="stylesheet" type="text/css" href="remoteStyle/indexTheme.css">
<form method="POST" id="login" action="remote.php" onsubmit="tryLogin()">
	<div id="rett"><div id="circle"><p>login</p></div></div>
	<input type="text" name="name" placeholder="username" autocomplete="off" autocapitalize="off" spellcheck="false">
	<input type="password" name="pass" placeholder="password">
	<input type="submit" value="ok">
<form>
<script src="remoteJS/AJAX.js"></script>
<script>
sexyBoot();
document.getElementsByName("name")[0].focus();

function tryLogin(){
	var name = document.getElementsByName("name")[0].value;
	var pass = document.getElementsByName("pass")[0].value;

	AJAX("login.php","name="+name+"&pass="+pass,function(){
		console.log(response);
		if(response!="error"){}
		else{loginError()};
	});
}

function sexyBoot(){
	var D = document.createElement("div");
	D.style = "background:white;z-index:5000;position:absolute;top:0;left:0;width:100%;height:100%;"
	document.body.appendChild(D);

	setTimeout(function(){D.style.opacity = 0;},500);
	setTimeout(function(){document.body.removeChild(D)},750);
}
function loginError(){
	var F = document.getElementById("login");
	//CSS ANIMATION TO DO
}
function sexyExit(){
	event.preventDefault();
	var F = document.getElementById("login");
	F.style.top = "-30%";
	F.style.opacity = 0;
	location.replace(F.action);
}
</script>
</HTML>