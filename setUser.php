<?php
	// Creazione utente
	session_start();
	include 'create_connection.php';

	$psw = md5($_POST['password']);
	$cosPadre = $_POST['CosPadre'];
	
	
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
	
	if($psw=="" or $cosPadre=="") die("Valori obbligatori mancanti! La stringa e il COS sono obbligatori");
	
	//Verifica se il codice segnalazione inserito esiste davvero
	$sql="SELECT myCos,SegnalazioniRimaste,SegnalazioniIllimitate FROM User WHERE myCos = '$cosPadre';";
	$result = $conn->query($sql);
	if($result->num_rows==0) die("Il codice segnalazione da te inserito potrebbe essere errato oppure l'utente che ti ha fornito il codice ha raggiunto il numero massimo di segnalazioni.");
	
	else{
		
		// Gestione delle segnalazioni rimaste. Se le segnalazioni sono 0 allora l'utente è inattivo,
		// altrimenti decrementa di 1 [da inserire in un trigger]
		$row = $result->fetch_assoc();
		$segnalazioni_rimaste=$row['SegnalazioniRimaste'];
		$segnalazioniIllimitateBool = $row['SegnalazioniIllimitate'];
		if($segnalazioni_rimaste==0 and $segnalazioniIllimitateBool!='Y') die("Il codice segnalazione da te inserito potrebbe essere errato oppure l'utente che ti ha fornito il codice ha raggiunto il numero massimo di segnalazioni.");
		if($segnalazioniIllimitateBool!='Y') $segnalazioni_rimaste--;
		//In modo che se è == -1 resta -1 (Riga di sopra)
		
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
			
			$sql = "INSERT INTO user(MyCos,CosPadre,Password) VALUES ('$myCos','$cosPadre','$psw');";
		}while(!($conn->query($sql)));
		
		//Viene aggiornato il numero di segnalazioni rimaste, aggiunto il pacchetto e inviato un messaggio al COS che ha invitato
		$sql = "UPDATE user SET SegnalazioniRimaste=$segnalazioni_rimaste WHERE myCos='$cosPadre';";
		$sql = $sql."INSERT INTO pacchetto VALUES(1,'$myCos',NOW(),'Default');";
		$sql = $sql."INSERT INTO messaggio VALUES('$cosPadre','Complimenti! L\' utente ".$myCos." si &egrave; iscritto col tuo codice segnalazione');";
		$conn->multi_query($sql);
	}
	$conn->close();
	$_SESSION['cos'] = $myCos;
	echo "<html>
		<body style = \"font-family: Cambria\">";
	echo "<h1><b>My CS-code: ".$myCos."</b></h1>";
	echo"<font size=\"5\">
	Alcune indicazioni:
<br>
- trascrivi in un foglio (per sicurezza evita di fare screnshot o fotografie della pagina) e conservale in luogo sicuro le credenziali e utilizzale per accedere alla piattaforma, per invitare i tuoi amici e per godere delle innumerevoli opportunità che il CS-code ti riserverà;
<br>
- invita le persone di cui ti fidi: grazie al tuo CS-code puoi segnalare questa piattaforma ad una persona che stimi o alla quale vorresti fare un interessante regalo utilizzando la procedura di invito a partecipare alla Community (link a sottosezione del menù Attività: “INVITA”). Prendi a tal proposito visione delle (link)regole di  segnalazione di altri utenti e  i vantaggi a te riservati dall’attività di segnalazione… perché le segnalazioni da te effettuate potrebbero rappresentare delle grandi opportunità sia per te che per la persona da te segnalata;
<br>
- controlla periodicamente nel menù in home-page  le COMUNICAZIONI rivolte alla COMMUNITY,  le COMUNICAZIONI a TE RISERVATE,  le OPPORTUNITA’ e i VANTAGGI ECONOMICI riservati ai possessori del CS-code:  quello che vedrai ti stupirà!
<br>
- se lo desideri, compila i seguenti campi: i dati inseriti potrebbero agevolare la procedura di recupero delle tue credenziali di accesso al sito oppure consentirti di ottenere direttamente via mail o via SMS le comunicazioni più importanti che ti riguardano. (Nota: se condividi anche tu la filosofia di questa piattaforma e ritieni un valore importante l’anonimato e la riservatezza che questa piattaforma è in grado di garantirti, prima di inserire il numero di telefono e/o l’indirizzo mail, leggi attentamente le (link)precauzioni da adottare nell'inserimento dell’indirizzo mail e del numero di telefono al fine di granire l’anonimato e la riservatezza).
</font>
<form name='frm' method='post' action='./inserimentoMailPhone.php'>
<input type='text' name='email' placeholder='e-mail'><br>
<input type='number' name='number' placeholder='N. di telefono'>
<input type='submit' name='btn' value='OK'>
</form>
	";
?>