<?php
	//Fa il log out dell'utente
	session_start();
	session_destroy(); //distrugge la sessione
	session_unset(); //rimuove le variabili 	
	header("Location: ./homepage.php");
?>