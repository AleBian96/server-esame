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
	echo "Logout riuscito";
}
else
	if(isset($_SESSION["utenteCollegato"]))
	{
		$collegato=$_SESSION['utenteCollegato'];
		echo "Sei collegato come $collegato.";
		echo '<a href="index.php?comando=logout">Clicca qui per scollegarti </a>';
	}
	else
		if(isset($_POST["user"])) //L'utente ha già effettuato login
	{
		notice("POST");
		$conn= database("chatDB");
		$user=$_POST["user"];
		$pass=$_POST["pass"];
		$passCifrata=crypt($pass);
		$query=" select count (*) as tot from chat where username='$user' and password='$pass'";
		$tabella=$conn->query($query);
		$riga=$tabella->fetchArray();
		$trovati=$riga["tot"];
		if($trovati==0) //non corrispondono username e password
		{
			echo "Errore: Utente non registrato. ";
		}
		else //nome utente e password ok
		{
			$_SESSION["utenteCollegato"]=$user;
			echo "Login effettuato con successo! <br>";
			echo "<a href='index.php'>Clicca qui per proseguire>/a>";
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
		<?php
	}
		?>
		</body>
		</html>
