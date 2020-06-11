'use strict';

// On attend que l'utilisateur soumet sa requête
$('#authentication-send').bind('click', validateLogin);

// Envoie une requête au serveur
function validateLogin(event) {
	event.preventDefault();
	ajaxRequest('GET', urlCir2 + '/php/request.php/authenticate/?login=' + $('#login').val() + '&password=' + $('#password').val(), setLogin);
}

function setLogin(auth) {
	if (auth) {
		$('#errors').hide();
		Cookies.set('nom', auth.nom, { sameSite: 'lax' });
		Cookies.set('prenom', auth.prenom, { sameSite: 'lax' });
		window.location = 'accueil.php';
	} else {
		$('#errors').show();
		$('#errors').html('403: Accès refusé');
	}
}