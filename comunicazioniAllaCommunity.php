<?php
	session_start();
	include 'create_connection.php';
	echo "<html>
	<head>
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
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
			<li><a  class=\"active\" href=\"./comunicazioniAllaCommunity.php\">Comunicazioni alla community</a></li>
			<li><a href=\"./comunicazioniAUtente.php\">Comunicazioni all'utente</a></li>
			<li><a href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li><a href=\"./attivita.php\">Attività</a></li>
			<li class='floatingMobile'><a href=\"./logout.php\">Logout</a></li>";
			echo"</ul>";
	
	//il divMargine evita che nella visualizzazione mobile il menu copre il testo
	echo "<div class='divMargine'>";
	echo "<center><h1>Comunicazioni alla community</h1></center>";
	
	$sql = "SELECT Text FROM messaggioGlobale;";
	$result=$conn->query($sql);
	while($row = $result->fetch_assoc()){
		echo "<div class='divMessaggio'>";
		echo $row['Text']."</div><br><br>";
	}
	$conn->close();
	echo"</div></body></html>";
?>