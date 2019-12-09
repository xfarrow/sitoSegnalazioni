<?php
	//invia il messaggio agli iscritti
	session_start();
	
	if(!isset($_SESSION['loggedIn']) or $_SESSION['cos']!="0"){
		$conn->close();
		die("Solo gli amministratori possono visualizzare questa pagina");
	}
	
	else{
		//parte grafica
		if(!isset($_POST['btn'])){
			echo "<form name='frm' method='post' action='./inviaMessaggio.php'>
			<input type='text' name='destCos' placeholder='COS destinatario'>
			<input type='text' name='text' placeholder='messaggio'><br>
			<input type='checkbox' value='1' name='global'>Globale<br>
			<input type='submit' name='btn' value='invia'>
			</form>
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