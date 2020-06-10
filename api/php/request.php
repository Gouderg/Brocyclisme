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
	
	if ($requestMethod == 'OPTIONS')
		{
		header('HTTP/1.1 200 OK');
		exit;
		}

	//var_dump($_SERVER);

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

			case 'POST':
				if (isset($_POST['nomC']) && isset($_POST['prenomC']) && isset($_POST['mail']) && 
					isset($_POST['dossard']) && isset($_POST['id']) && isset($_POST['nomU']) && isset($_POST['prenomU'])) {

					$error = false;

					// On vérifie si le nom existe et si l'adresse mail existe et si le cycliste peut participer. 
					if (dbVerifAuteur($db, strip_tags($_POST['nomC']), strip_tags($_POST['prenomC']), strip_tags($_POST['mail']))) {
						
						// On vérifie si le cycliste appartient au club du user
						if(dbVerifClub($db, strip_tags($_POST['nomU']), strip_tags($_POST['prenomU']), strip_tags($_POST['mail']))) {

							// On vérifie si le dossard n'est pas pris ou si le participant n'est pas déjà inscrit
							if (!dbVerifDossard($db, intval($_POST['dossard'])) && 
								!dbVerifParticipationCycliste($db, strip_tags($_POST['mail']), intval($_POST['id']))) {
								
								//SI tout est bon, on peut inscrire le cycliste à la course
								$data = dbAddCourseParticipants($db, strip_tags($_POST['mail']), intval($_POST['dossard']), 
																intval($_POST['id']));
							} else {$error = 3;}
						} else {$error = 2;}
					} else {$error = 1;}
					if ($error) {$data['error'] = $error;}
				}

			break;
		}
		// On encode en json avec le bon code 
		encodeData($data, $requestMethod);

	} else if ($requestRessource == 'cyclistes') {

		// On récupère des informations sur les cyclistes
		if ($id == NULL) {
			encodeData(dbRequestCyclistes($db), $requestMethod);		// si num_licene null on renvoie tous les cyclistes
		} else {
			encodeData(dbRequestInfos($db, $id), $requestMethod);	//sinon on renvoie le cycliste correspondant au numéro de licence 
		}
		switch ($requestMethod) {									//cas d'une methode PUT
			case 'PUT':
			parse_str(file_gets_contents('php://input'), $_PUT);
			if(isset($_PUT['nom']) && isset($_PUT['prenom']) && isset($_PUT['num_licence']) && isset($_PUT['club']) && isset($_PUT['code_insee'])  && isset($_PUT['valide'])  && $id != NULL) { 									// si l'id n'est pas NULL et que tous les attributs existent
				
				$data =dbModifyinfo($db,  $_PUT['nom'], $_PUT['prenom'], $_PUT['club'], $_PUT['valide'], $_PUT['code_insee'], $id, $_PUT['num_licence']); //on execute la fonction dbModify qui permet de modifier les informations du cycliste 
				
				}

				
				break;
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