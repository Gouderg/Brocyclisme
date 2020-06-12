'use strict';

//------------------------------------------------------------------
//--- ajaxRequest --------------------------------------------------
//------------------------------------------------------------------
// Fonction qui communique avec le serveur grâce au protocole HTTP
// \param type Type de méthode de la requête
// \param url Contient l'url vers la ressource
// \param callback Fonction appelé si la requête renvoie un bon code
// \param data Contient les paramètres supplémentaires
// \return Renvoie la réponse du serveur décodé à la fonction de callback
function ajaxRequest(type, url, callback, data = null) {
	let xhr = new XMLHttpRequest();			// Création d'un nouveau protocole Http
	if (type == 'GET' && data != null) {
		url += '?' + data;
	}
	xhr.open(type, url);
	// Header prenant en compte le formalisme REST
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	
	console.log(url); // Regarde l'url envoyé

	xhr.onload = () => {
		console.log(xhr.responseText); // Regarde la réponse quoi qu'il arrive 
		// En fonction du code de retour, on effectue quelque chose
		switch(xhr.status) {
			case 200:
			case 201:
				if (xhr.responseText.length != 0) {callback(JSON.parse(xhr.responseText));}
				else {callback(null);}
				break;
			default: 
				httpErrors(xhr.status);
		}
	};
	console.log(data); // Regarde les paramètres passés
	xhr.send(data);
}

//------------------------------------------------------------------
//--- httpErrors ---------------------------------------------------
//------------------------------------------------------------------
// Affiche dans la console une courte description de l'erreur
// \param errorCode Contient le code erreur HTTP
function httpErrors(errorCode) {
	let message = {
		400: '400: Requête incorrecte',
		401: '401: Authentifiez-vous',
		403: '403: Accès refusé',
		404: '404: Bad request',
		500: '500: Erreur interne au Serveur',
		503: '503: Service indisponible'
	}
	console.log(message[errorCode]); // Affiche l'erreur
}