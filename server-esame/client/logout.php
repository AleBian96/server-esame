<?php
	session_start();
	unset($_SESSION["user"]);
	redirectTo("remote.php");
?>