<?php
	$W = isset($_POST["cmd"]) && $_POST["cmd"] == "wrong";
?>
<HTML>
<link rel="stylesheet" type="text/css" href="remoteStyle/loadfonts.css">
<link rel="stylesheet" type="text/css" href="remoteStyle/indexTheme.css">
<form method="POST" id="login" action="remote.php" onsubmit="sexyExit()">
	<div id="rett"><div id="circle"><p>login</p></div></div>
	<input type="text" name="name" placeholder="username" autocomplete="off" autocapitalize="off" spellcheck="false">
	<input type="password" name="pass" placeholder="password">
	<input type="submit" value="ok">
<form>
<script>
<?php if($W){ echo "loginError();"; }else{ echo "sexyBoot();";} ?>
document.getElementsByName("name")[0].focus();
function sexyBoot(){
	var D = document.createElement("div");
	D.style = "background:white;z-index:5000;position:absolute;top:0;left:0;width:100%;height:100%;"
	document.body.appendChild(D);

	setTimeout(function(){D.style.opacity = 0;},500);
	setTimeout(function(){document.body.removeChild(D)},750);
}
function loginError(){
	var F = document.getElementById("login");
	F.style.opacity = 0;
	setTimeout(function(){F.style.opacity = 1;},0);
	setTimeout(function(){F.style.transitionDuration = "100ms";F.style.left = "37%";},350);
	setTimeout(function(){F.style.left = "38%";},450);
	setTimeout(function(){F.style.left = "37.5%";},550);
	setTimeout(function(){F.style.transitionDuration = "250ms";},650);
}
function sexyExit(){
	event.preventDefault();
	var F = document.getElementById("login");
	F.style.top = "-30%";
	F.style.opacity = 0;
	setTimeout(function(){F.submit();},250);
}
</script>
</HTML>