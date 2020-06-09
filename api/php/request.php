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
	$data = false;

	if ($requestRessource == 'authenticate') {
		encodeData(authenticate($db), $requestMethod);

	} else if ($requestRessource == 'course') {

		// On récupère la liste des courses disponibles avec quelques information
		$data = dbRecupCourse($db);
		encodeData($data, $requestMethod);
	}


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