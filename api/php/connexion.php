<?php
	require_once('constante.php');

	//------------------------------------------------------------------
	//--- dbConnect ----------------------------------------------------
	//------------------------------------------------------------------
	// Permet d'établir une connexion à la base de données
	// \return Connexion à la base de données
	function dbConnect() {
		try {
			$db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',DB_USER, DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $db;
	}
?>