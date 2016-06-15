<?php
	session_start();
	if(isset($_SESSION["user"])){
		$folder = $_SESSION["folder"];
		echo "<script>personalFolder='$folder';</script>";
?>
<HTML>
<link rel="stylesheet" type="text/css" href="remoteStyle/loadfonts.css"/>
<link rel="stylesheet" type="text/css" href="remoteStyle/theme.css"/>
<script src="remoteJS/remoteScript.js"></script>
<script src="remoteJS/uscape.js"></script>
<script src="remoteJS/AJAX.js"></script>
<script src="remoteJS/scriptMAIN.js"></script>
<script src="remoteJS/scriptTOOLBOX.js"></script>
<script src="remoteJS/scriptSTYLE.js"></script>
</HTML>
<?php
}else{
	redirectTo("/");
}
?>
