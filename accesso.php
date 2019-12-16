<?php
	//Accesso alla homepage
	
	//Se il bottone non è stato premuto (visualuzzazione grafica)
	if(!isset($_POST['btn'])){
		echo "<html>
		<head>
			<link rel=\"stylesheet\" type=\"text/css\" href=\"css/stili.css\" />
			<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
		</head>
		<body style = \"font-family: Cambria\">
		
		<ul>
			<li><a href=\"./homepage.php\">Home</a></li>
			<li><a href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li class='floatingMobile'><a href=\"./iscrizione.php\">Iscriviti</a></li>
			<li class='active floatingMobile'><a href=\"./accesso.php\">Accedi</a></li>
		</ul>";
		
		//il divMargine evita che nella visualizzazione mobile il menu copre il testo
		echo "<div class='divMargine'>";
		
		echo "<center><b><h1>Pagina di accesso</h1></b><br><br>
		<form name='frm' method='post' action='/sito/accesso.php'>
			<input type='text' name='cos' placeholder='Inserisci il tuo COS'><br><br>
			<input type='password' name='password' placeholder='Inserire password'></textarea><br><br>
			<input type='submit' class='button button1' name='btn' value='Invia'>
		</div></form></center></body></html>";
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
			$conn->close();
			header("Location: /sito/homepage.php");
		}
	}else die("Backend error 2");
	$conn->close();
	}
?>