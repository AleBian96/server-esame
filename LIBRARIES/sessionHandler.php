<?php
	function sessionStart(){
		$db = database("SESSION");
		$session_ID = $db->escapeString($_COOKIE["session_ID"]);
		openSession($session_ID);
		$_SESSION = readSession($session_ID);
	}

	function openSession($session_ID){
		$db = database("SESSION");
		$Q = "INSERT OR IGNORE INTO session(id,data) VALUES('$session_ID','');";
		$Q .= "UPDATE session SET lastAccess = CURRENT_TIMESTAMP WHERE id = '$session_ID'";
		$db->query($Q);
	}

	function readSession($session_ID){
		$db = database("SESSION");
		$Q = "SELECT data FROM session WHERE id = '$session_ID'";
		$data = $db->query($Q)->fetchArray();

		return $data;
	}

	function writeSession($session_ID,$data){
		$db = database("SESSION");
		$data = $db->escapeString($data);
		$Q = "INSERT OR IGNORE INTO session(id,data) VALUES('$session_ID','$data');":
		$Q .= "UPDATE session SET data = '$data'";
		$db->query($Q);
	}
?>
