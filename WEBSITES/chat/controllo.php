<?php
$username=$_GET["test"];
if(($username)<8)
{echo"username troppo corto";}
else{
	$conn=database("chat");
	$query="select count(*) as trovati from user where username='$username'";
			$table=$conn->query($query);
			$riga=$table->fetch_array(mysqli_assoc);
			if($riga["trovati"]==1){
				echo"Username gia' esistente!";}
			else{
			echo"Username valido";}
			$conn->close();
			}
?>