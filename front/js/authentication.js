'use strict';

// On attend que l'utilisateur soumet ça requête
$('#authentication-send').bind('click', validateLogin);

// Met le login et le password en cookie et envoie une requête au serveur
function validateLogin(event) {
	event.preventDefault();
	Cookies.remove('token');	//Évite une erreur
	Cookies.set('login', $('#login').val(), { sameSite: 'lax'});
	Cookies.set('password', $('#password').val(), { sameSite: 'lax'});
	ajaxRequest('GET', 'php/request.php/authenticate', validToken);
}

function validToken(token) {
	console.log(token);
}