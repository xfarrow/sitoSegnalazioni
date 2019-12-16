<?php
	//Questo file crea il database e le tabelle necessarie.
	include 'create_connection.php';
	echo "<html><body>";
	$sql="CREATE DATABASE $dbname";
    if($conn->query($sql)==TRUE){
        echo "Database creato<br>";
        }else{
        die("Errore creazione database ".$conn->error);
        }
	$conn->select_db($dbname); //Sposta la connessione dal database generale al database "DBdata"
	
	//Tabella utente
    $sql="CREATE TABLE user(
		Stato VARCHAR(3),
		Provincia VARCHAR(2),
		Email VARCHAR(30),
		Telefono VARCHAR(15),
        MyCos VARCHAR(5) PRIMARY KEY,
		CosPadre VARCHAR(5) NOT NULL,
		Password VARCHAR(64) NOT NULL,
		SegnalazioniRimaste INT NOT NULL DEFAULT 1,
		SegnalazioniIllimitate CHAR NOT NULL DEFAULT 'N'
        );";
	//Tabella messaggi privati
	$sql=$sql."CREATE TABLE messaggio(
			CosDestinatario VARCHAR(5) NOT NULL,
			Text VARCHAR(512) NOT NULL,
			CONSTRAINT fkCosMessaggio FOREIGN KEY(CosDestinatario) REFERENCES user(MyCos)
			);";
	//Tabella messaggi pubblici
	$sql=$sql."CREATE TABLE messaggioGlobale(
			id INT PRIMARY KEY AUTO_INCREMENT, 
			Text VARCHAR(512) NOT NULL
			);";
	$sql=$sql."CREATE TABLE pacchetto(
			NumeroSegnalazioni INT NOT NULL,
			Cos VARCHAR(5) NOT NULL,
			Data TIMESTAMP NOT NULL,
			Descrizione VARCHAR(50),
			CONSTRAINT fkCosPacchetto FOREIGN KEY(Cos) REFERENCES user(MyCos)
			);";
	//non si sa mai che l'ID possa servire
	
	if($conn->multi_query($sql)) echo "Tabella creata<br>";
	else die("Errore creazione tabella ".$conn->error);
	
	while(mysqli_next_result($conn)){;} //PULISCE IL BUFFER ALTRIMENTI VA IN OUT OF SYNC
	$conn->close();
	
	//password di admin
	$psw=md5("root");
	//Creazione tabella utente "fantasma"
	include 'create_connection.php';
	$sql = "INSERT INTO user(MyCos,CosPadre,Password)
						VALUES('0','0','$psw');";
	if($conn->query($sql)) echo "Tabella fantasma creata";
	else die("Errore creazione tabella fantasma ".$conn->error);
	
	//Adding constraints
	$sql="ALTER TABLE user ADD CONSTRAINT fkPadre FOREIGN KEY(CosPadre) REFERENCES user(MyCos);";
	if($conn->query($sql)) echo "Constraints aggiunti <br>";
	else die("Constraints non aggiunti ".$conn->error);
	
	//L'utente 0 ha 2 pacchetti attribuiti perchè 1 lo usa per "autoinvitarsi", l'altro per invitare un'altra persona
	$sql="INSERT INTO pacchetto VALUES(2,0,NOW(),'Default');";
	if($conn->query($sql)) echo "Riga pacchetto creata";
	else die("Errore creazione riga pacchetto ".$conn->error);
	$conn->close();
?>