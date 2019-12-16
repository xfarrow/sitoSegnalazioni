<?php
	session_start();
	echo "<html>
	<head>
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/stili.css\" />
	</head>
	<body style = \"font-family: Cambria\">";
	
	//Menu superiore
		if(isset($_SESSION['loggedIn'])){
			echo"<ul>
			<li><a href=\"./homepage.php\">Home</a></li>
			<li><a href=\"./comunicazioniAllaCommunity.php\">Comunicazioni alla community</a></li>
			<li><a href=\"./comunicazioniAUtente.php\">Comunicazioni all'utente</a></li>
			<li><a class=\"active\" href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li><a href=\"./attivita.php\">Attività</a></li>
			<li class='floatingMobile'><a href=\"./logout.php\">Logout</a></li>";
			echo"</ul>";
		}else{
			echo "<ul>
			<li><a href=\"./homepage.php\">Home</a></li>
			<li><a class=\"active\" href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li class='floatingMobile'><a href=\"./iscrizione.php\">Iscriviti</a></li>
			<li class='floatingMobile'><a href=\"./accesso.php\">Accedi</a></li>";
			echo"</ul>";
		}
		
	//il divMargine evita che nella visualizzazione mobile il menu copre il testo
	echo "<div class='divMargine'>";
	echo "Working in progress";
	echo"</div>"; 	
		
	echo"</body></html>";
?>