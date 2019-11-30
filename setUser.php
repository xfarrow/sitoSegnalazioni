<?php
	// Creazione utente
	session_start();
	include 'create_connection.php';

	$stringa = $_POST['stringa'];
	$cosPadre = $_POST['CosPadre'];
	$email = $_POST['email'];
	$telefono = $_POST['telefono'];
	
	// Check captcha
	if ($_POST['captcha'] != $_SESSION['captcha']) {
		die('Codice captcha non valido');
	}
	
	/*
		Creazione caratteri random:
		random_int() genera numeri random tra 48 e 90, che in ASCII equivalgono a caratteri e numeri, tranne per
		i caratteri da 58 a 64, che sono caratteri speciali.
	*/
	$forbidden = array(58,59,60,61,62,63,64);
	
	if($stringa=="" or $cosPadre=="") die("Valori obbligatori mancanti! La stringa e il COS sono obbligatori");
	
	//Verifica se il codice segnalazione inserito esiste davvero
	$sql="SELECT myCos,SegnalazioniRimaste FROM User WHERE myCos = '$cosPadre';";
	$result = $conn->query($sql);
	if($result->num_rows==0) die("Non esiste nessun utente con questo Codice Segnalazione");
	
	else{
		
		// Gestione delle segnalazioni rimaste. Se le segnalazioni sono 0 allora l'utente è inattivo,
		// altrimenti decrementa di 1 [da inserire in un trigger]
		$row = $result->fetch_assoc();
		$segnalazioni_rimaste=$row['SegnalazioniRimaste'];
		if($segnalazioni_rimaste==0) die("Utente inattivo, impossibile iscriversi");
		$segnalazioni_rimaste--;
		
		// Vengono generati i caratteri casuali che compongono il cos
		do{
			while( in_array($byte1 = random_int(48,90) , $forbidden) ) {}
			while( in_array($byte2 = random_int(48,90) , $forbidden) ) {}
			while( in_array($byte3 = random_int(48,90) , $forbidden) ) {}
			while( in_array($byte4 = random_int(48,90) , $forbidden) ) {}
			while( in_array($byte5 = random_int(48,90) , $forbidden) ) {}
			
			$byte1 = chr($byte1);
			$byte2 = chr($byte2);
			$byte3 = chr($byte3);
			$byte4 = chr($byte4);
			$byte5 = chr($byte5);
			$myCos = $byte1.$byte2.$byte3.$byte4.$byte5;
			
			$sql = "INSERT INTO user(MyCos,CosPadre,Stringa) VALUES ('$myCos','$cosPadre','$stringa');";
		}while(!($conn->query($sql)));
		
		//Viene aggiornato il numero di segnalazioni rimaste e inviato un messaggio al COS che ha invitato
		$sql = "UPDATE user SET SegnalazioniRimaste=$segnalazioni_rimaste WHERE myCos='$cosPadre';";
		$sql = $sql."INSERT INTO messaggio VALUES('$cosPadre','Complimenti! L\' utente ".$myCos." si &egrave; iscritto col tuo codice segnalazione');";
		$conn->multi_query($sql);
	}
	$conn->close();
	echo "Inserito con successo<br>";
	echo "<h1>TUO codice segnalazione: ".$myCos." </h1>";
?>