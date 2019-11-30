<?php
	//invia il messaggio agli iscritti
	session_start();
	include 'create_connection.php';
	
	if(!isset($_SESSION['loggedIn']) or $_SESSION['cos']!="0") die("Solo gli amministratori possono visualizzare questa pagina");
	
	else{
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
	}
	$conn->close();
	header("Location: /sito/homepage.php");
?>