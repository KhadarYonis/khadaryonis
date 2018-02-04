<?php 
	
	$host = "db709339533.db.1and1.com";
	$dbname = "dbo709339533";
	$dbuser = "dbo709339533"; 
	$dbpwd = "KH@adar.92";

	try {
		$db = new PDO('mysql:host='.$host.';dbname='.$dbname,$dbuser,$dbpwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}catch(PDOException $e) {
		echo "Une erreur est survenue lors de la connexion à la base de données.";
	}

