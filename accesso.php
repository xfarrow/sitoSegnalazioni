<?php
	//Accesso alla homepage
	
	//Se il bottone non è stato premuto (visualuzzazione grafica)
	if(!isset($_POST['btn'])){
		echo "<html>
		<body>
		<form name='frm' method='post' action='/sito/accesso.php'>
			<input type='text' name='cos' placeholder='Inserisci il tuo COS'><br>
			<input type='password' name='password' placeholder='Inserire password'></textarea>
			<input type='submit' name='btn' value='Invia'>
		</form></body></html>";
	}
	//se il bottone è stato premuto (parte logica)
	else{
	session_start();
	include 'create_connection.php';
	$cos = $_POST['cos'];
	$psw = md5($_POST['password']);
	
	$sql = "SELECT MyCos,Password FROM user WHERE MyCos='$cos' AND Password = '$psw';";
	
	if(!($result=$conn->query($sql))) die("Backend error 1");
	
	if($result->num_rows == 0) die("Non sei un utente registrato");
	else if($result->num_rows == 1){ //Teoicamente basterebbe questo controllo per accertarci dell'identità, ma è vulnreabile alle injections
		$row=$result->fetch_assoc();
		if($row['MyCos']==$cos AND $row['Password'] == $psw){
			$_SESSION['cos'] = $cos;
			$_SESSION['loggedIn'] = true;
			header("Location: /sito/homepage.php");
		}
	}else die("Backend error 2");
	$conn->close();
	}
?>