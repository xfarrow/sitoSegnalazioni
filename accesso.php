<?php
	//Accesso alla homepage
	
	//Se il bottone non è stato premuto (visualuzzazione grafica)
	if(!isset($_POST['btn'])){
		echo "<html>
		<body>
		<form name='frm' method='post' action='/sito/accesso.php'>
			<input type='text' name='cos' placeholder='Inserisci il tuo COS'><br>
			<textarea rows='4' cols='50' name='stringa' placeholder='Inserire stringa qui'></textarea>
			<input type='submit' name='btn' value='Invia'>
		</form></body></html>";
	}
	//se il bottone è stato premuto (parte logica)
	else{
	session_start();
	include 'create_connection.php';
	$cos = $_POST['cos'];
	$stringa = $_POST['stringa'];
	$sql = "SELECT MyCos,Stringa FROM user WHERE MyCos='$cos' AND Stringa = '$stringa';";
	
	if(!($result=$conn->query($sql))) die("Backend error 1");
	
	if($result->num_rows == 0) die("Non sei un utente registrato");
	else if($result->num_rows == 1){ //Teoicamente basterebbe questo controllo per accertarci dell'identità, ma è vulnreabile alle injections
		$row=$result->fetch_assoc();
		if($row['MyCos']==$cos AND $row['Stringa'] == $stringa){
			$_SESSION['cos'] = $cos;
			$_SESSION['loggedIn'] = true;
			header("Location: /sito/homepage.php");
		}
	}else die("Backend error 2");
	$conn->close();
	}
?>