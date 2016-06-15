<?php
	session_set_save_handler("open","close","read","write","destroy","garbage");

	function open($path,$name){
		$db = database("SESSION");
		$sessionId = session_id();
		$sql = "INSERT OR IGNORE INTO session(id,data) VALUES('$sessionId','');";
		$sql .= "UPDATE session SET lastAccess = CURRENT_TIMESTAMP WHERE id = '$sessionId'";
		$db->exec($sql);
	}

	function read($sessionId){
		$db = database("SESSION");
		$sql = "SELECT data FROM session WHERE id = '$sessionId'";
		$data = unserialize($db->query($sql)->fetchArray()["data"]);

		return $data;
	}

	function write($sessionId,$data){
		$db = database("SESSION");
		$data = $db->escapeString(serialize($data));
		$sql = "INSERT OR IGNORE INTO session(id,data) VALUES('$sessionId','$data');";
		$sql .= "UPDATE session SET data = '$data' WHERE id = '$sessionId'";
		$db->exec($sql);
	}

	function close(){

	}

	function destroy($sessionId){
		$db = database("SESSION");
		$sessionId = $db->escapeString($sessionId);
		$sql = "DELETE FROM session WHERE id=$sessionId";
		$db->exec($sql);
		setcookie(session_name(), "", time() - 3600);
	}

	function garbage($lifetime){
		$db = database("SESSION");
		$sql = "DELETE FROM session WHERE lastAccess < datetime('now','-$lifetime second')";
		$db->exec($sql);
 	}
?>
