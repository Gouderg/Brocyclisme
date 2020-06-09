<?php
	require_once('constante.php');

	# Fonction de connexion à la base de données
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

	# 
	#	gestion_course
	#

	# Récupère la liste des courses disponibles avec des informations suplémentaires
	function dbRecupCourse($db) {
		try {
			$request = "SELECT * FROM course";
			$statement = $db->prepare($request);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result; 
	}

	#
	#	gestion_coureur
	#

	# Fonction qui récupères des informations sur les cyclistes
	function dbRequestCyclistes($db) {
		try {
			$request = 'SELECT nom, prenom, num_licence, club AS src FROM cycliste';
			$statement = $db->prepare($request);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	
		} catch (PDOException $exception) {
		error_log('Request error: '.$exception->getMessage());
		return false;
		}
		return $result;
	}


	function dbRequestInfos($db, $num_licence) {
		try {
			$request = 'SELECT nom, prenom, date_de_naissance FROM cycliste WHERE num_licence=:num_licence';
			$statement = $db->prepare($request);
			$statement->bindParam(':num_licence', $num_licence, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			error_log('Request error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}
?>