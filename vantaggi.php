<?php
	session_start();
	echo "<html>
	<head>
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
			<li style=\"float:right\"><a href=\"./logout.php\">Logout</a></li>";
			echo"</ul>";
		}else{
			
			echo "<ul>
			<li><a href=\"./homepage.php\">Home</a></li>
			<li><a class=\"active\" href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li style=\"float:right\"><a href=\"./iscrizione.php\">Iscriviti</a></li>
			<li style=\"float:right\"><a href=\"./accesso.php\">Accedi</a></li>";
			echo"</ul>";
		}
		
	echo "Working in progress"; 	
		
	echo"</body></html>";
?>