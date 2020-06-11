<?php
	# Fonction qui récupères des informations sur les cyclistes
	function dbRequestCyclistes($db, $nom, $prenom) {
		try {
			$request = "SELECT y.nom, y.prenom, y.club, y.num_licence, y.mail
						FROM cycliste y 
						JOIN club c ON y.club = c.club
						JOIN user u ON c.mail = u.mail
						WHERE u.nom = :nom AND u.prenom = :prenom";
			$statement = $db->prepare($request);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 150);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 150);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	
		} catch (PDOException $exception) {
			error_log('Request error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}


	function dbRequestInfos($db,$mail) {
		try {

			$request = "SELECT * FROM cycliste where mail=:mail";
			$statement = $db->prepare($request);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR,50);
			$statement->execute();
			$result = $statement->fetch(PDO::FETCH_ASSOC);
	
		} catch (PDOException $exception) {
			error_log('Request error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

	# Vérifie si le code Insee est présent dans la base de données
	function dbVerifInsee($db, $code_insee) {
		try {
			$request = "SELECT code_postal FROM ville WHERE code_insee = :code_insee";
			$statement = $db->prepare($request);
			$statement->bindParam(':code_insee', $code_insee, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetch();

		} catch (PDOException $exception) {
			error_log('Request error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}


	function dbModifyInfos($db, $nom, $prenom, $num_licence, $code_insee, $date_naissance, $valide, $mail) {
		try {
			$request = 'UPDATE cycliste 
						SET nom=:nom, prenom=:prenom, date_naissance=:date_naissance,
							valide=:valide, code_insee=:code_insee, num_licence=:num_licence 
						WHERE mail=:mail';
			$statement = $db->prepare($request);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 50);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 50);
			$statement->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
			$statement->bindParam(':valide', $valide, PDO::PARAM_INT);
			$statement->bindParam(':code_insee', $code_insee, PDO::PARAM_INT);
			$statement->bindParam(':num_licence', $num_licence, PDO::PARAM_INT);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 50);
			$statement->execute();
		} catch (PDOException $exception) {
			error_log('Request error: '.$exception->getMessage());
			return false;
		}
		return true;
	}
?>