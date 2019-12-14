<?php
	//invia il messaggio agli iscritti
	session_start();
	
	
	echo "<html>
	<head>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/stili.css\" />
	</head>
	<body style = \"font-family: Cambria\">";
	
	if(!isset($_SESSION['loggedIn']) or $_SESSION['cos']!="0"){
		die("Solo gli amministratori possono visualizzare questa pagina");
	}
	
	else{
		//parte grafica
		if(!isset($_POST['btn'])){
			
			//menu superiore
			echo"<ul>
			<li><a href=\"./homepage.php\">Home</a></li>
			<li><a href=\"./comunicazioniAllaCommunity.php\">Comunicazioni alla community</a></li>
			<li><a href=\"./comunicazioniAUtente.php\">Comunicazioni all'utente</a></li>
			<li><a href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li><a class=\"active\" href=\"./attivita.php\">Attività</a></li>
			<li style=\"float:right\"><a href=\"./logout.php\">Logout</a></li>";
			echo"</ul>";
			
			echo"<center><div style=\"margin-top:2%\">";
			
			
			echo "<form name='frm' method='post' action='./inviaMessaggio.php'>
			<input type='text' name='destCos' placeholder='COS destinatario'>
			<br><br>
			<textarea rows=\"4\" cols=\"50\" name=\"text\" placeholder=\"Messaggio\"></textarea>
			
			<label class=\"container\">Globale
				<input type=\"checkbox\" value=\"1\" name=\"global\"> &nbsp;
				<span class=\"checkmark\"></span>
			</label>
			
			<input type='submit' name='btn' class=\"button button1\" value='Invia'>
			</form>
			</div></center>
			</body></html>";
		}else{
			//parte di logica
			include 'create_connection.php';
			$messaggio = $_POST['text'];
			$cos_destinatario = $_POST['destCos'];
			$global = $_POST['global']; //se 1 vuol dire che il messaggio è globale (rivolto a tutti)	
			if($global!="1"){
				$sql="INSERT INTO messaggio VALUES('$cos_destinatario','$messaggio');";
				if(!($result=$conn->query($sql))) die("Errore: controlla se il COS a cui stai inviando il messaggio esiste e se il messaggio non e' vuoto");
			}else{
				$sql="INSERT INTO messaggioGlobale(Text) VALUES('$messaggio');";
				if(!($result=$conn->query($sql))) die("Errore: controlla se il COS a cui stai inviando il messaggio esiste e se il messaggio non e' vuoto");
			}
			unset($_POST['btn']);
			$conn->close();
			header("Location: ./inviaMessaggio.php");
		}
	}
?>