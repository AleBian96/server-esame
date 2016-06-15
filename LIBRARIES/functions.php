<?php
	function cmdExec($cmd){
		exec($cmd, $O);
		$S="";
		foreach($O as $line)$S.=$line."\n";
		return $S;
	}

	function redirectTo($page){
		echo "<script>
			window.location.replace('$page');
		</script>";
	}

	function reloadPage(){
		echo "<script>
			location.reload();
		</script>";
	}
?>
