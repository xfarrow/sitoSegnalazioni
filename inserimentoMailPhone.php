<?php
	session_start();
	include 'create_connection.php';
	if(!(isset($_SESSION['cos']) or $_SESSION['loggedIn'])) die("Error - session timed out and/or not valid identifier");
	
	$myCos = $_SESSION['cos'];
	if(isset($_POST['number']))
		$phone = $_POST['number'];
	else 
		$phone="NULL";
	
	if(isset($_POST['email']))
		$email = $_POST['email'];
	else 
		$email="NULL";
	
	$sql="UPDATE user
		 SET Telefono='$phone' , Email='$email'
		 WHERE MyCos = '$myCos';";
		 
	if(!($conn->query($sql))) die ("Errore 1: inserimento telefono e/o email fallito");
	$conn->close();
	header("Location: ./accesso.php");
	?>
