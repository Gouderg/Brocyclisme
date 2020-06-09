'use strict';

function ajaxRequest(type, url, callback, data = null) {
	let xhr = new XMLHttpRequest();
	if (type == 'GET' && data != null) {
		url += '?' + data;
	}
	xhr.open(type, url);

	/*if (Cookies.get('token') == undefined) {
		xhr.setRequestHeader('Authorization', 'Basic ' + btoa(Cookies.get('login') + ':' + Cookies.get('password')));
	} else {
		xhr.setRequestHeader('Authorization', 'Bearer ' + Cookies.get('token'));
	}*/
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	console.log(url);

	xhr.onload = () => {
		console.log(xhr.responseText);
		switch(xhr.status) {
			case 200:
			case 201:
				if (xhr.responseText.length != 0) {callback(JSON.parse(xhr.responseText));}
				else {callback(null);}
				break;

			case 401:
			case 403:
				// Cookies.remove('token');
				// $('#auth').show();
				httpErrors(xhr.status);
				break;

			default: 
				httpErrors(xhr.status);
		}
	};
	xhr.send(data);
}

function httpErrors(errorCode) {
	let message = {
		400: '400: Requête incorrecte',
		401: '401: Authentifiez-vous',
		403: '403: Accès refusé',
		500: '500: Erreur interne au Serveur',
		503: '503: Service indisponible'
	}
	console.log(message[errorCode]);
}