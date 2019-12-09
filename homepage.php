<?php
	session_start();
	include 'create_connection.php';
	
	//Homepage del sito nel quale visualizzare i messaggi
	echo "<html><body>";
	
	if(isset($_SESSION['cos']) and $_SESSION['loggedIn']){
		$myCos = $_SESSION['cos'];
		if($myCos=="0"){
			echo "<a href=\"./assegnaPacchetto.php\">Assegna pacchetti</a><br>
			<a href=\"./inviaMessaggio.php\">Invia messaggi</a><br>
			<a href=\"/sito/showUsers.php\">Mostra users</a>
			</body></html>";
		}else{
			//Visualizza messaggi inviati dal server all'utente
			echo "<center><h1>Messaggi personali</h1></center>";
			$sql = "SELECT Text FROM messaggio where CosDestinatario = '$myCos';";
			$result=$conn->query($sql);
			while($row = $result->fetch_assoc()){
				echo $row['Text']."<br><br>";
			}
			//Visualizza messaggi inviati dal server a livello globale
			echo "<center><h1>Messaggi globali</h1></center>";
			$sql = "SELECT Text FROM messaggioGlobale;";
			$result=$conn->query($sql);
			while($row = $result->fetch_assoc()){
				echo $row['Text']."<br><br>";
			}
		}
	}else die("Solo gli utenti registrati possono accedere a questa pagina </html></body>");
	echo "</body></html>";
?>