<?php
//Header che crea la connessione al server

$servername="localhost";
$username="root";
$password="";
$dbname="dbdata";
//creation connection

//Se il database non c'è fa la connessione al database generale, se c'è la fa al database progetto
	$conn=new mysqli($servername,$username,$password); //apre SEMPRE prima la connessione al db generale (per fare la query di dopo)
	$result = $conn->query("SHOW DATABASES LIKE '$dbname' ");
	$row = $result->fetch_array();
	$exists=0; //variabile di appoggio per controllare se il DB esiste negli script che richiamano questa procedure
	if($row[0]==$dbname){
		$conn->select_db($dbname); //sposta la connessione al DB "DBdata" nel caso esista già
		$exists=1;
	}
//check connection
if($conn->connect_error){
    die("Connection failed ".$conn->connect_error);
}
?>