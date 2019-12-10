<?php
	session_start();
	include 'create_connection.php';
	$cos = $_GET['cos'];
	if(!isset($_SESSION['loggedIn']) or $_SESSION['cos']!="0") die("Solo gli amministratori possono visualizzare questa pagina");
	
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
	
	$conn->close();
	
	echo"<html><body><h2>Per l'utente con codice segnalazione: ".$cos."</h2>
	<b><br>Numero segnalazioni totali attribuite:</b> ".$numeroSegnalazioniTotali.
	"<br><b>Numero totale di pacchetti attribuiti:</b> ".$pacchettiAttribuiti.
	"<br><b>Data del pacchetto più recente:</b> ".$pacchetto_piu_recente.
	"<br><b>Numero di segnalazioni fatte:</b> ".$numeroSegnalazioniFatte.
	"<br><b>Numero di segnalazioni contenute nel pacchetto più recente:</b> ".$numeroSegnalazioniPacchettoPiuRecente.
	"</body></html>";
	
?>