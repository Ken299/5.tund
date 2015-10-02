<?php
	/*-----------------------------------------
	function welcomeUser($name, $age){
	echo "Tere ".$name."<br>";
	}
	
	$first_name = "Juku";
	welcomeUser($first_name, 1);
	------------------------------------------*/
	
	//kõik AB'ga seonduv--------------------------
	
	// ühenduse loomiseks kasuta
	require_once("../configglobal.php");
	$database = "if15_kenaon";
	
	//paneme sessiooni käima, saame kasutada $_SESSION muutujat
	session_start();
	
	
	//lisame kasutaja andmebaasi
	function createUser($create_email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		//asendame ? märgid muutujate väärtuste
		// ss - s tähendab string iga muutuja kohta
		$stmt->bind_param("ss", $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();		
	}
	//logime sisse
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
				
		//paneme vastuse muutujatesse
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		
		//küsima kas AB'ist saime kätte
		if($stmt->fetch()){
			//leidis
			echo "kasutaja id=".$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			
			//suunan kasutaja data.php lehele
			header("Location: data.php");
			
			
		}else{
			// tühi, ei leidnud , ju siis midagi valesti
			echo "Wrong password or email!";
			
		}
		
		$stmt->close();
		
		$mysqli->close();
	}
	
	//lisame autod andmebaasi
	function addCar($car_plate, $color) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $car_plate, $color);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();		
	}
	

?>