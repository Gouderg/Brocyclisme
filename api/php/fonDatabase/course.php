<?php 
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

	# Renvoie True/False pour savoir si le user a créée la course
	function dbRequestCreateurCourse($db, $nom, $prenom, $id) {
		try {
			$request = "SELECT co.date 
						FROM course co
						JOIN club c ON c.club = co.club
						JOIN user u ON c.mail = u.mail
						WHERE u.nom=:nom AND u.prenom=:prenom AND co.id=:id";
			$statement = $db->prepare($request);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 20);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 20);
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

	# Renvoie la liste de tous les participants à une course
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

	# Fonction qui renvoie la liste des participants d'un club
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
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 20);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 20);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

	# Fonction qui récupère toutes les informations de la course
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

	# Fonction qui vérifie le mail concorde avec le nom et le prénom et si le monsieur peut participer
	function dbVerifAuteur($db, $nom, $prenom, $mail) {
		try {
			$request = 'SELECT valide FROM cycliste WHERE nom=:nom AND prenom=:prenom AND mail=:mail';
			$statement = $db->prepare($request);
			$statement->bindParam(':nom', $nom, PDO::PARAM_STR, 50);
			$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR, 50);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 50);
			$statement->execute();
			$result = $statement->fetch(); 

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

	# Fonction qui vérifie si le dossard n'est pas pris
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
		return $result;
	}

	# Fonction qui vérifie si un coureur fait partie du club du user
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
		return $result;
	}

	# Fonction qui vérifie si le participants n'est pas déjà inscrit
	function dbVerifParticipationCycliste($db, $mail, $id) {
		try {
			$request = 'SELECT * FROM participe WHERE mail = :mail AND id = :id';
			$statement = $db->prepare($request);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 50);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			$result = $statement->fetch();

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}	

	# Fonction qui ajoute un participant à la course
	function dbAddCourseParticipants($db, $mail, $dossard, $id) {
		try {
			$request = "INSERT INTO participe (mail, id, dossart) VALUES (:mail, :id, :dossard);";
			$statement = $db->prepare($request);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR, 50);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->bindParam(':dossard', $dossard, PDO::PARAM_STR, 50);
			$statement->execute();
		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return true;
	}

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