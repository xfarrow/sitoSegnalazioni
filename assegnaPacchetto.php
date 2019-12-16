<?php
	session_start();
	echo "<html><head>
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/stili.css\" />
	</head>
	<body style = \"font-family: Cambria\">";
	
	if(isset($_SESSION['cos']) and $_SESSION['loggedIn']){
		$myCos = $_SESSION['cos'];
		if($myCos=="0"){
			if(!isset($_POST['btn'])){
				
				echo"<ul>
			<li><a href=\"./homepage.php\">Home</a></li>
			<li><a href=\"./comunicazioniAllaCommunity.php\">Comunicazioni alla community</a></li>
			<li><a href=\"./comunicazioniAUtente.php\">Comunicazioni all'utente</a></li>
			<li><a href=\"./Vantaggi.php\">Vantaggi & opportunità</a></li>
			<li><a class=\"active\" href=\"./attivita.php\">Attività</a></li>
			<li class='floatingMobile'><a href=\"./logout.php\">Logout</a></li>";
			echo"</ul>";
			
			//il divMargine evita che nella visualizzazione mobile il menu copre il testo
			echo "<div class='divMargine'>";
			
				echo "<div style='margin-left:2%'>";
				echo "<center><h1>Assegna un pacchetto di segnalazioni</h1></center>";
				echo "<form name='frm' method='post' action='AssegnaPacchetto.php'>
				<br><input type='text' name='destCos' placeholder='Inserire COS'>
				<select name='NumeroSegnalazioni'>
					<option value=1>1</option>
					<option value=2>2</option>
					<option value=5>5</option>
					<option value=10>10</option>
					<option value=20>20</option>
					<option value=50>50</option>
					<option value=100>100</option>
					<option value=500>500</option>
					<option value=1000>1000</option>
					<option value=10000>10.000</option>
					<option value=100000>100.000</option>
					<option value=1000000>1.000.000</option>
					<option value=10000000>10.000.000</option>
					<option value=100000000>100.000.000</option>
					<option value=0>Illimitate</option>
				</select><br><br><br>
				<input type='submit' name='btn' class=\"button button1\" value='Invia'>
				</form></div></div><br>";
			}else{
					//CONTROLLER QUI
					include 'create_connection.php';
					$numeroSegnalazioni = $_POST['NumeroSegnalazioni']; //attributo preso dalla tabella user
					$cos = $_POST['destCos'];
					$segnalazioniIllimitateBool = 'N';
					
					$segnalazioni_rimaste_query = "SELECT SegnalazioniRimaste,SegnalazioniIllimitate FROM user WHERE MyCos='$cos';";
					if(!($result = $conn->query($segnalazioni_rimaste_query))) die("Errore retrieveng delle segnalazioni rimaste".$conn->error);
					$row = $result->fetch_assoc();
					
					$segnalazioniIllimitateFromQuery = $row['SegnalazioniIllimitate'];
					if($segnalazioniIllimitateFromQuery=='Y') die("Impossibile aggiornare le segnalazioni di questo utente. Ha già infinite segnalazioni disponibili");
					$segnalazioni_rimaste = $row['SegnalazioniRimaste'];
					
					//setta a illimitato oppure no
					if($numeroSegnalazioni==0){ 
						$segnalazioni_rimaste=-1;
						$segnalazioniIllimitateBool = 'Y';
					}
					else $segnalazioni_rimaste+=$numeroSegnalazioni;
					
					$sql="INSERT INTO pacchetto(NumeroSegnalazioni,Cos,Data) VALUES($numeroSegnalazioni,'$cos',NOW());";
					$sql =$sql."UPDATE user SET SegnalazioniRimaste=$segnalazioni_rimaste, SegnalazioniIllimitate='$segnalazioniIllimitateBool' WHERE myCos='$cos';";
					if(!$conn->multi_query($sql)) die("Error ".$conn->error);
					$conn->close();
					unset($_POST['btn']);
					$conn->close();
					header("Location: ./AssegnaPacchetto.php");
			}
		}else die("Solo gli amministratori possono accedere a questa pagina</body></html>");
	}else die("Solo gli amministratori possono accedere a questa pagina</body></html>");
?>