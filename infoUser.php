<?php
	session_start();
	include 'create_connection.php';
	$cos = $_GET['cos'];
	if(!isset($_SESSION['loggedIn']) or ($_SESSION['cos']!="0" and $_SESSION['cos']!=$cos) ) die("Solo gli amministratori o l'utente in questione possono visualizzare questa pagina");
	
	$sql="SELECT SegnalazioniIllimitate, SegnalazioniRimaste FROM user WHERE MyCos='$cos';";
	if(!($result=$conn->query($sql))) die("Backend query 4".$conn->error);
	$row = $result->fetch_assoc();
	$segnalazioniIllimitateBool = $row['SegnalazioniIllimitate'];
	$segnalazioniRimaste = $row['SegnalazioniRimaste'];
	/*
	- Numero segnalazioni totali attribuitegli
	- Numero totale di pacchetti attriguitegli
	- Data del pacchetto più recente
	*/
	
	$sql="SELECT SUM(NumeroSegnalazioni) AS segnalazioni_totali_attribuite, COUNT(Cos) AS pacchetti_attribuiti, MAX(Data) AS pacchetto_piu_recente
		FROM pacchetto
		WHERE Cos='$cos';";
	if(!($result=$conn->query($sql))) die("Backend query 1".$conn->error);
	$row = $result->fetch_assoc();
	$numeroSegnalazioniTotali = $row['segnalazioni_totali_attribuite'];
	$pacchettiAttribuiti = $row['pacchetti_attribuiti'];
	$pacchetto_piu_recente = $row['pacchetto_piu_recente'];
	
	/*
	- Numero di segnalazioni fatte
	*/
	$sql="SELECT COUNT(MyCos) AS segnalazioni_fatte FROM user WHERE CosPadre='$cos';";
	if(!($result=$conn->query($sql))) die("Backend query 2".$conn->error);
	$row = $result->fetch_assoc();
	$numeroSegnalazioniFatte = $row['segnalazioni_fatte'];
	
	/*
	- Numero di segnalazioni contenute nel pacchetto più recente
	*/
	$sql = "SELECT NumeroSegnalazioni FROM pacchetto WHERE Data='$pacchetto_piu_recente';";
	if(!($result=$conn->query($sql))) die("Backend query 3".$conn->error);
	$row = $result->fetch_assoc();
	$numeroSegnalazioniPacchettoPiuRecente = $row['NumeroSegnalazioni'];
	if($numeroSegnalazioniPacchettoPiuRecente==0) $numeroSegnalazioniPacchettoPiuRecente="Illimitate";
	
	$conn->close();
	
	echo"<html>
	<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"></head>
	<body><h2>Per l'utente con codice segnalazione: ".$cos."</h2>
	<b><br>Numero segnalazioni totali attribuite:</b> ";
	
	if($segnalazioniIllimitateBool=='Y') echo"Illimitate"; 
	else echo $numeroSegnalazioniTotali;
	echo "<br><b>Numero totale di pacchetti attribuiti:</b> ".$pacchettiAttribuiti.
	"<br><b>Data del pacchetto più recente:</b> ".$pacchetto_piu_recente.
	"<br><b>Numero di segnalazioni fatte:</b> ".$numeroSegnalazioniFatte.
	"<br><b>Numero di segnalazioni contenute nel pacchetto più recente:</b> ".$numeroSegnalazioniPacchettoPiuRecente.
	"<br><b>Numero di segnalazioni rimaste:</b> ";
	
	if($segnalazioniIllimitateBool=='Y') echo"Illimitate";
	else echo $segnalazioniRimaste;
	
	echo "</body></html>";
	
?>