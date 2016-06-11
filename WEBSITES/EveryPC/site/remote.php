<?php
	function index(){
		echo "<script>
			var F = document.createElement('form');
			var i = document.createElement('input');
			F.method = 'post';
			i.name = 'cmd';
			i.value = 'wrong';
			F.appendChild(i);
			F.action = '/';
			F.submit();
		</script>";
	}

	$name = $_POST["name"];
	$pass = $_POST["pass"];
	if(!(isset($name)) || !(isset($pass)))index();
	$DB = database("siteDB");
	$R = $DB->query("SELECT COUNT(*) as TOT, dir FROM users WHERE user='$name' AND pass='$pass'")->fetchArray();
	$folder = $R["dir"];
	$count = $R["TOT"];
	if($count != 0){
		echo "<script>personalFolder='".$folder."';</script>";
	}
	else{
		index();
	}
?>
<HTML>
<link rel="stylesheet" type="text/css" href="remoteStyle/loadfonts.css"/>
<link rel="stylesheet" type="text/css" href="remoteStyle/theme.css"/>
<script src="remoteJS/remoteScript.js"></script>
<script src="remoteJS/uscape.js"></script>
<script src="remoteJS/scriptMAIN.js"></script>
<script src="remoteJS/scriptTOOLBOX.js"></script>
<script src="remoteJS/scriptSTYLE.js"></script>
</HTML>