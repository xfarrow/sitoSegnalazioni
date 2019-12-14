<?php
	session_start();
	
	echo "<html>
	<head>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/stili.css\" />
	</head>
	<body style = \"font-family: Cambria\">";
	
	if(!(isset($_SESSION['cos']) and $_SESSION['loggedIn'])){
		die("Solo gli utenti registrati possono accedere a questa pagina");
	}
	$myCos = $_SESSION['cos'];
	//Menu superiore
	if(isset($_SESSION['loggedIn'])){
			echo"<ul>
			<li><a href=\"./homepage.php\">Home</a></li>
			<li><a href=\"./comunicazioniAllaCommunity.php\">Comunicazioni alla community</a></li>
			<li><a href=\"./comunicazioniAUtente.php\">Comunicazioni all'utente</a></li>
			<li><a href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li><a class=\"active\" href=\"./attivita.php\">Attività</a></li>
			<li style=\"float:right\"><a href=\"./logout.php\">Logout</a></li>";
			echo"</ul>";
		}
		
	if($myCos=="0"){
			echo "<center><h1>Attività amministrazione</h1></center>";
			echo "<span style='font-size:10px;'>&#9679;</span>";
			echo "<a href=\"./assegnaPacchetto.php\"> Assegna pacchetti</a><br>
			<br><span style='font-size:10px;'>&#9679;</span>
			<a href=\"./inviaMessaggio.php\"> Invia messaggi</a><br>
			<br><span style='font-size:10px;'>&#9679;</span>
			<a href=\"/sito/showUsers.php\"> Mostra users</a><br>
			<br><span style='font-size:10px;'>&#9679;</span>
			<a href='./infoUser.php?cos=$myCos'> Mie statistiche</a>
			</body></html>";
	}else{
			echo "<center><h1>Attività</h1></center>";
			echo "<a href='#invita' onclick='invita()'>Invita</a><br>
			<a href='./segnala.php'>Segnala</a><br>
			<a href='./infoUser.php?cos=$myCos'>Mie statistiche</a>";
	}
	
	echo "<script>
		function invita() {
		var myWindow = window.open(\"\", \"MsgWindow\", \"width=512,height=150\");
		myWindow.document.write(\"<h3>Copia il seguente link. Il ricevente potrà iscriversi con il tuo codice.</h3><br><h1><b>.iscrizione.php?cos=$myCos</b></h1>\");
		}
		</script>";
	echo"</body></html>";
?>