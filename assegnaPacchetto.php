<?php
	session_start();
	echo "<html><body>";
	
	if(isset($_SESSION['cos']) and $_SESSION['loggedIn']){
		$myCos = $_SESSION['cos'];
		if($myCos=="0"){
			if(!isset($_POST['btn'])){
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
					<option value=-1>Illimitate</option>
				</select><br>
				<input type='submit' name='btn' value='invia'>
				</form><br>
				<a href=\"./homepage.php\">Homepage</a></body></html>";
			}else{
					//CONTROLLER QUI
					include 'create_connection.php';
					$numeroSegnalazioni = $_POST['NumeroSegnalazioni'];
					$cos = $_POST['destCos'];
					
					$segnalazioni_rimaste_query = "SELECT SegnalazioniRimaste FROM user WHERE MyCos='$cos';";
					if(!($result = $conn->query($segnalazioni_rimaste_query))) die("Errore retrieveng delle segnalazioni rimaste".$conn->error);
					$row = $result->fetch_assoc();
					$segnalazioni_rimaste = $row['SegnalazioniRimaste'];
					if($numeroSegnalazioni==-1) $segnalazioni_rimaste=-1;
					else $segnalazioni_rimaste+=$numeroSegnalazioni;
					
					$sql="INSERT INTO pacchetto(NumeroSegnalazioni,Cos,Data) VALUES($numeroSegnalazioni,'$cos',NOW());";
					$sql =$sql."UPDATE user SET SegnalazioniRimaste=$segnalazioni_rimaste WHERE myCos='$cos';";
					if(!$conn->multi_query($sql)) die("Error ".$conn->error);
					$conn->close();
					unset($_POST['btn']);
					header("Location: ./AssegnaPacchetto.php");
			}
		}else die("Solo gli amministratori possono accedere a questa pagina</body></html>");
	}else die("Solo gli amministratori possono accedere a questa pagina</body></html>");
?>