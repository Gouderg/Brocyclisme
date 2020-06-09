<?php
	require_once("database.php");

	// Connexion à la base de données
	$db = dbConnect();

	// Vérification de la connexion
	if (!$db) {
		header('HTTP/1.1 503 Service Unavailable');
		exit(1);
	}

	// On récupère les informations envoyées par l'url
	$requestMethod = $_SERVER['REQUEST_METHOD'];
	$request = explode('/',substr($_SERVER['PATH_INFO'], 1));
	$requestRessource = array_shift($request);
	$id = array_shift($request);
	if ($id == '') $id = NULL;

	$data = false;
	


	if ($requestRessource == 'authenticate') {
		encodeData(authenticate($db), $requestMethod);

	} else if ($requestRessource == 'course') {
		switch ($requestMethod) {
			case 'GET':
				if ($id != NULL && isset($_GET['nom']) && isset($_GET['prenom'])) {
					$infoCourse = false;
					$infoParticipants = false;

					// On regarde si le user est bien l'admin
					if (dbRequestCreateurCourse($db, $_GET['nom'], $_GET['prenom'], $id)) {
						// Si c'est le monsieur qui a crée la course, il accède à la liste entière des personnes
						$infoParticipants = dbRequestAllPartiCourse($db, $id);

					} else {
						// Sinon il récupère juste les informations de son club
						$infoParticipants = dbRequestClubPartiCourse($db, $_GET['nom'], $_GET['prenom'], $id);

					}

					$infoCourse = dbRecupOneCourse($db, $id);			// On récupère les infos précise d'une course
					$data['participants'] = $infoParticipants;			// On crée un objet participant
					$data['course'] = $infoCourse;						// On crée un objet course
				} else {
					$data = dbRecupCourse($db);
				}
				break;
		}
		// On encode en json avec le bon code 
		encodeData($data, $requestMethod);

	} else if ($requestRessource == 'cyclistes') {

		// On récupère des informations sur les cyclistes
		if ($id == NULL) {
			encodeData(dbRequestCyclistes($db), $requestMethod);
		} else {
			encodeData(dbRequestInfos($db, $id), $requestMethod);
		}

	} 



	header('HTTP/1.1 404 Bad request');
	exit(1);

	// Fonction qui encode la réponse en json et renvoie le bon code
	function encodeData($data, $code) {
		header('Content-Type: application/json');
		header('Cache-control: no-store, no-cache, must-revalidate');
		header('Pragma: no-cache');
		if ($data != NULL) {
			if ($code == 'POST') {
				header('HTTP/1.1 201 Created');
			} else {
				header('HTTP/1.1 200 OK');
			}
			echo json_encode($data);
		} else {
			echo null;
			
		}
		exit();
	}

	// Fonction pour l'authentification
	function authenticate($db) {
		// Récupère le login/password
		$login = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];

		// Check the user
		if (!dbCheckUserInjection($db, $login, $password)) {
			header('HTTP/1.1 401 Unauthorized');
			exit();
		}
	}


?>