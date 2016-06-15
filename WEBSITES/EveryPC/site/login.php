<?php
	session_start();
	$name = $_POST["name"];
	$pass = $_POST["pass"];

	if(!(isset($name, $pass)))echo "error";

	$DB = database("siteDB");
	$R = $DB->query("SELECT COUNT(*) as C, dir as F FROM users WHERE user='$name' AND pass='$pass'")->fetchArray();

	$folder = $R["F"];
	$count = $R["C"];

	if($count != 0){
		$_SESSION["user"] = $name;
		$_SESSION["folder"] = $folder;
	}
	else{
		echo "error";
	}
?>
