<?php
	session_start();
?>
<html>
<head><title>Accesso con login</title></head>
<body>
<?php
if(isset($_GET["comando"])&& $_GET["comando"]=="logout")
{
	unset($_SESSION["utenteCollegato"]);
	redirectTo("/");
}
else
	if(isset($_SESSION["utenteCollegato"]))
	{
		redirectTo("CHAT.php");
	}
	else
		if(isset($_POST["user"])) //L'utente ha gi%uFFFD effettuato login
	{
		$conn= database("chat");
		$user=$_POST["user"];
		$pass=$_POST["pass"];
		$passCifrata=crypt($pass);
		$query=" select count (*) as tot from chat where username='$user' and password='$pass'";
		$tabella=$conn->query($query);
		$riga=$tabella->fetchArray();
		$trovati=$riga["tot"];
		if($trovati==0) //non corrispondono username e password
		{
			$_SESSION["ERROR"] = "utente gia' registrato";
			redirectTo("index.php");
		}
		else //nome utente e password ok
		{
			$_SESSION["utenteCollegato"]=$user;
			redirectTo("CHAT.php");
		}
		$conn->close();
	}
	else //l'utente non ha fatto login, quindi mostra la form di login
	{
		?>
		<form action="#" method="POST">
		Nome utente <input type="text" name="user" /><br>
		Password <input type="password" name="pass" /><br>
		<input type="submit" value="LOGIN" />
		</form>
		<a href="registra.php">Clicca qui per registrarti!</a>
		<br>
		<?php
	if(isset($_SESSION["ERROR"]))echo $_SESSION["ERROR"];
	}
		?>
		</body>
		</html>