<?php 
	//------------------------------------------------------------------
	//--- dbRecupCourse ------------------------------------------------
	//------------------------------------------------------------------
	// Récupère des informations concernants les courses
	// \param db La connexion avec la base de données
	// \return Information des courses
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

	//------------------------------------------------------------------
	//--- dbRequestCreateurCourse --------------------------------------
	//------------------------------------------------------------------
	// Regarde si le user à crée la course
	// \param db La connexion avec la base de données
	// \param nom Nom du user
	// \param prenom Prenom du user
	// \param id Numéro de la course
	// \return True si c'est vrai, False sinon
	function dbRequestCreateurCourse($db, $nom, $prenom, $id) {
		try {
			$request = "SELECT co.date 
						FROM course co
						JOIN club c ON c.club = co.club
						JOIN user u ON c.mail = u.mail
						WHERE u.nom=:nom AND u.prenom=:prenom AND co.id=:id";
			$statement = $db->prepare($request);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 50);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 50);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetch();

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		if ($result) return true;
		return false;
	}

	//------------------------------------------------------------------
	//--- dbRequestAllPartiCourse --------------------------------------
	//------------------------------------------------------------------
	// Renvoie la liste de tous les participants à une course
	// \param db La connexion avec la base de données
	// \param id Numéro de la course
	// \return Information des cyclistes participants à une course
	function dbRequestAllPartiCourse($db, $id) {
		try {
			$request = "SELECT c.nom, c.prenom, c.mail, c.num_licence, c.categorie, c.club, p.dossart
						FROM cycliste c
						JOIN participe p ON p.mail=c.mail
						JOIN course co ON co.id = p.id
						WHERE co.id = :id";
			$statement = $db->prepare($request);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

	//------------------------------------------------------------------
	//--- dbRequestClubPartiCourse -------------------------------------
	//------------------------------------------------------------------
	// Renvoie la liste des cyclistes d'un club participant à une course
	// \param db La connexion avec la base de données
	// \param nom Nom du user
	// \param prenom Prenom du user
	// \param id Numéro de la course
	// \return Information des cyclistes
	function dbRequestClubPartiCourse($db, $nom, $prenom, $id) {
		try {
			$request = " SELECT cy.nom, cy.prenom, cy.mail, cy.num_licence, cy.categorie, cy.club, p.dossart
						FROM participe p
						JOIN cycliste cy ON p.mail = cy.mail
						JOIN club cl ON cl.club = cy.club
						JOIN user u ON u.mail = cl.mail
						WHERE p.id = :id AND u.nom = :nom AND u.prenom = :prenom";
			$statement = $db->prepare($request);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 50);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 50);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

	//------------------------------------------------------------------
	//--- dbRecupOneCourse ---------------------------------------------
	//------------------------------------------------------------------
	// Renvoie les informations d'une course
	// \param db La connexion avec la base de données
	// \param id Numéro de la course
	// \return Information d'une course
	function dbRecupOneCourse($db, $id) {
		try {
			$request = "SELECT * FROM course WHERE id=:id";
			$statement = $db->prepare($request);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

	//------------------------------------------------------------------
	//--- dbVerifAuteur ------------------------------------------------
	//------------------------------------------------------------------
	// Vérifie si le nom, prénom et mail concorde et si le cycliste est valide
	// \param db La connexion avec la base de données
	// \param nom Nom du cycliste
	// \param prenom Prénom du cycliste
	// \param mail Mail du cycliste
	// \return True si c'est bon, False sinon
	function dbVerifAuteur($db, $nom, $prenom, $mail) {
		try {
			$request = 'SELECT valide FROM cycliste WHERE nom=:nom AND prenom=:prenom AND mail=:mail';
			$statement = $db->prepare($request);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 50);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 50);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 100);
			$statement->execute();
			$result = $statement->fetch(); 

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		if ($result) return true;
		return false;
	}

	//------------------------------------------------------------------
	//--- dbVerifDossard ------------------------------------------------
	//------------------------------------------------------------------
	// Vérifie si le numéro de dossard est valide
	// \param db La connexion avec la base de données
	// \param dossard Numéro de dossard
	// \return True si c'est bon, False sinon
	function dbVerifDossard($db, $dossard) {
		try {
			$request = 'SELECT * FROM participe WHERE dossart = :dossard';
			$statement = $db->prepare($request);
			$statement->bindParam(':dossard', $dossard, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetch();

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		if ($result) return true;
		return false;
	}

	//------------------------------------------------------------------
	//--- dbVerifClub ------------------------------------------------
	//------------------------------------------------------------------
	// Vérifie si le cycliste fait partie du club
	// \param db La connexion avec la base de données
	// \param nom Nom du user
	// \param prenom Prénom du user
	// \param mail Mail du cycliste
	// \return True si c'est bon, False sinon
	function dbVerifClub($db, $nom, $prenom, $mail) {
		try {
			$request = "SELECT cy.num_licence
						FROM cycliste cy
						JOIN club cl ON cl.club = cy.club
						JOIN user u ON u.mail = cl.mail
						WHERE u.nom = :nom AND u.prenom = :prenom AND cy.mail = :mail";
			$statement = $db->prepare($request);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 150);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 150);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 100);
			$statement->execute();
			$result = $statement->fetch();

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		if ($result) return true;
		return false;
	}

	//------------------------------------------------------------------
	//--- dbVerifParticipationCycliste ---------------------------------
	//------------------------------------------------------------------
	// Vérifie si le cycliste n'est pas déjà inscrit à la course
	// \param db La connexion avec la base de données
	// \param mail Mail du cycliste
	// \param id Numéro de la course
	// \return True si c'est bon, False sinon
	function dbVerifParticipationCycliste($db, $mail, $id) {
		try {
			$request = 'SELECT * FROM participe WHERE mail = :mail AND id = :id';
			$statement = $db->prepare($request);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 100);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetch();

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		if ($result) return true;
		return false;
	}	

	//------------------------------------------------------------------
	//--- dbAddCourseParticipants --------------------------------------
	//------------------------------------------------------------------
	// Ajoute un cycliste à une course
	// \param db La connexion avec la base de données
	// \param mail Mail du cycliste
	// \param dossard Numéro de dossard du cycliste
	// \param id Numéro de la course
	// \return True si c'est bon, False sinon
	function dbAddCourseParticipants($db, $mail, $dossard, $id) {
		try {
			$request = "INSERT INTO participe (mail, id, dossart) VALUES (:mail, :id, :dossard);";
			$statement = $db->prepare($request);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 100);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->bindParam(':dossard', $dossard, PDO::PARAM_STR, 15);
			$statement->execute();
		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return true;
	}

	//------------------------------------------------------------------
	//--- dbClassement -------------------------------------------------
	//------------------------------------------------------------------
	// Récupère les informations concernant la victoire
	// \param db La connexion avec la base de données
	// \param id Numéro de la course
	// \return Information concernant la victoire
	function dbClassement($db, $id){
		try{
			$request = 'SELECT * 
						FROM participe p
						JOIN cycliste cy ON p.mail = cy.mail
						WHERE p.id = :id';
			$statement =$db->prepare($request);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetchALL(PDO::FETCH_ASSOC);
		} catch(PDOException $exception){
			error_log('Request error :'.$exception->getMessage());
			return false;
		}
		return $result;
	}
?>