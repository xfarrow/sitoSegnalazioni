<?php
	session_start();
	include 'create_connection.php';
	echo "<html>
	<head>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/stili.css\" />
	</head>
	<body style = \"font-family: Cambria\">";
	
	if(!(isset($_SESSION['cos']) and $_SESSION['loggedIn'])){
		$conn->close();
		die("Solo gli utenti registrati possono accedere a questa pagina");
	}
	$myCos = $_SESSION['cos'];
	//Menu superiore
	echo"<ul>
		<li><a href=\"./homepage.php\">Home</a></li>
		<li><a href=\"./comunicazioniAllaCommunity.php\">Comunicazioni alla community</a></li>
		<li><a class=\"active\" href=\"./comunicazioniAUtente.php\">Comunicazioni all'utente</a></li>
		<li><a href=\"./vantaggi.php\">Vantaggi & opportunità</a></li>
		<li><a href=\"./attivita.php\">Attività</a></li>
		<li style=\"float:right\"><a href=\"./logout.php\">Logout</a></li>
		</ul>";
		
		
	echo "<center><h1>Comunicazioni per te</h1></center>";
	$sql = "SELECT Text FROM messaggio WHERE CosDestinatario = '$myCos';";
	$result=$conn->query($sql);
	while($row = $result->fetch_assoc()){
		echo $row['Text']."<br><br>";
	}
	$conn->close();
	echo"</body></html>";
?>