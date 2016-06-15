<?php
	parse_str($argv[2], $_GET);
	parse_str($argv[3], $_POST);
	parse_str($argv[4], $_COOKIE);
	foreach(glob(dirname(__FILE__)."/LIBRARIES/*.php") as $lib)include($lib);
	include(dirname(__FILE__)."/".$argv[1]);
?>
