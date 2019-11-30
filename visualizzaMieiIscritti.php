<?php
		if(!isset($_POST['btn'])){
		echo"
			<html>
				<head>
					<title>Accesso</title>
				</head>
				<body>
					<form name='frm' method='POST' action='/sito/accedi.php'>
						<input type='text' name='value' placeholder='Tuo COS'>
						<input type='submit' name='btn' value='Invia'>
					</form>";
		}else{
			include 'create_connection.php';
			$cos = $_POST['value'];
			$sql="SELECT * FROM user WHERE CosPadre='$cos'";
			$result = $conn->query($sql);
			if($result->num_rows<=0) die("Nessun utente si e' ancora iscritto con il tuo COS");
			else{
				echo "<h2> Gli utenti che si sono iscritti con il tuo codice segnalazione ($cos) sono: </h2><br>";
				while($row=$result->fetch_assoc()){
					echo $row['MyCos']." <br>";
				}
			}
		}
?>