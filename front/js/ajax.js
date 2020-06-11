'use strict';

function ajaxRequest(type, url, callback, data = null) {
	let xhr = new XMLHttpRequest();
	if (type == 'GET' && data != null) {
		url += '?' + data;
	}
	xhr.open(type, url);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	
	console.log(url); // Regarde l'url envoyé

	xhr.onload = () => {
		console.log(xhr.responseText); // Regarde la réponse quoi qu'il arrive 
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