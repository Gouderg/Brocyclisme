<?php
	//------------------------------------------------------------------
	//--- dbCheckUser --------------------------------------------------
	//------------------------------------------------------------------
	// Check si le login/mot de passe
	// \param db La connexion avec la base de données
	// \param login	Adresse mail du user
	// \param password Mot de passe du user
	// \return Renvoie le nom et le prénom du user
	function dbCheckUser($db, $login, $password) {
		try {
			$request = "SELECT nom, prenom FROM user WHERE mail = :mail AND password = :password";
			$statement = $db->prepare($request);
			$statement->bindParam(':mail', $login, PDO::PARAM_STR, 150);
			$statement->bindParam(':password', $password, PDO::PARAM_STR, 150);
			$statement->execute();
			$result = $statement->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException $exception) {
			error_log('Connection error: '.$exception->getMessage());
			return false;
		}
		return $result;
	}

?>