<?php
	function cmdExec($cmd){
		exec($cmd, $O);
		$S="";
		foreach($O as $line)$S.=$line."\n";
		return $S;
	}

	function save($dir, $text){
		$file = fopen($dir);
		fwrite($file,$text);
	}
?>
