<?php

	//------------------------------------------------------------------
	//--- dbRequestCyclistes -------------------------------------------
	//------------------------------------------------------------------
	// Récupère des informations concernants les cyclistes
	// \param db La connexion avec la base de données
	// \param nom Nom du user
	// \param prenom Prénom du user
	// \return Information des cyclistes
	function dbRequestCyclistes($db, $nom, $prenom) {
		try {
			$request = "SELECT cy.nom, cy.prenom, cy.club, cy.num_licence, cy.mail
						FROM cycliste cy 
						JOIN club cl ON cy.club = cl.club
						JOIN user u ON cl.mail = u.mail
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

	//------------------------------------------------------------------
	//--- dbRequestCycliste --------------------------------------------
	//------------------------------------------------------------------
	// Récupère des informations concernant un cycliste
	// \param db La connexion avec la base de données
	// \param mail Mail d'un cycliste
	// \return Information du cycliste
	function dbRequestCycliste($db, $mail) {
		try {
			$request = "SELECT * FROM cycliste WHERE mail=:mail";
			$statement = $db->prepare($request);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR,100);
			$statement->execute();
			$result = $statement->fetch(PDO::FETCH_ASSOC);
	
		} catch (PDOException $exception) {
			error_log('Request error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

	//------------------------------------------------------------------
	//--- dbVerifInsee -------------------------------------------------
	//------------------------------------------------------------------
	// Vérifie si le code insee est présent dans la base de données
	// \param db La connexion avec la base de données
	// \param code_insee Code Insee  vérifier
	// \return True s'il existe, False sinon
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
		if ($result) return true; 
		return false;
	}

	//------------------------------------------------------------------
	//--- dbModifyInfos ------------------------------------------------
	//------------------------------------------------------------------
	// Modifie les informations d'un cycliste dans la base de données
	// \param db La connexion avec la base de données
	// \param nom Nom du cycliste à modifier
	// \param prenom Prénom du cycliste à modifier
	// \param num_licence Numéro de licence à modifier
	// \param code_insee Code Insee à modifier
	// \param date_naissance Date de naissance à modifier
	// \param valide Si le cycliste peut faire une course ou non
	// \param mail Mail du cycliste
	// \return True si c'est bon, False sinon
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
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 100);
			$statement->execute();
		} catch (PDOException $exception) {
			error_log('Request error: '.$exception->getMessage());
			return false;
		}
		return true;
	}
?>