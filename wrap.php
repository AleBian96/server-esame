<?php
	foreach(glob(dirname(__FILE__)."/LIBRARIES/*.php") as $lib)include($lib);
	parse_str($argv[2], $_GET);
	parse_str($argv[3], $_POST);
	parse_str($argv[4], $_COOKIE);
	include(dirname(__FILE__)."/".$argv[1]);
?>
