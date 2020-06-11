'use strict';

// On attend que l'utilisateur soumet ça requête
$('#authentication-send').bind('click', validateLogin);

// Met le login et le password en cookie et envoie une requête au serveur
function validateLogin(event) {
	event.preventDefault();
	ajaxRequest('GET', urlCir2 + '/php/request.php/authenticate/?login=' + $('#login').val() + '&password=' + $('#password').val(), setLogin);
}

function setLogin(auth) {
	console.log(auth);
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