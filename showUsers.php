<?php
	// Mostra tutti gli utenti a cosa sono collegati
	session_start();
	include 'create_connection.php';
	$myCos = $_SESSION['cos'];
	if(!isset($_SESSION['loggedIn']) or $_SESSION['cos']!="0") die("Solo gli amministratori possono visualizzare questa pagina");
	$sql="SELECT myCos FROM user";
	$result=$conn->query($sql);
	//non mostra il primo utente (0)
	$result->fetch_assoc();
	while($row=$result->fetch_assoc()){
		echo "<br><b>Il codice segnalazione dell' utente <a href='infoUser.php?cos=".$row['myCos']."'>".$row['myCos']."</a></b> e' stato collegato a<br>";
		
		$cosPadre = $row['myCos'];
		
		$sql2 = "SELECT MyCos FROM user WHERE CosPadre = '$cosPadre';";
		$result2 = $conn->query($sql2);
		
		while($row=$result2->fetch_assoc()){
			echo $row['MyCos']."<br>";
		}
		
	}
	$conn->close();
?>