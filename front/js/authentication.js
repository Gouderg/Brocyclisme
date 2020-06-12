'use strict';

// On attend que l'utilisateur soumet sa requête
$('#authentication-send').bind('click', validateLogin);

//------------------------------------------------------------------
//--- validateLogin ------------------------------------------------
//------------------------------------------------------------------
// Envoie une requête au serveur avec les informations rentrées par l'utilisateur
// \param event Évènement de la page actuelle
function validateLogin(event) {
	event.preventDefault();	// Empêche le rafraîchissement de la page
	ajaxRequest('GET', urlCir2 + '/php/request.php/authenticate/?login=' + $('#login').val() + '&password=' + $('#password').val(), setLogin);
}

//------------------------------------------------------------------
//--- setLogin -----------------------------------------------------
//------------------------------------------------------------------
// En fonction du retour, 
// \param auth Savoir si on valide ou pas l'authentication
function setLogin(auth) {
	// Si c'est bon
	if (auth) {
		$('#errors').hide();
		Cookies.set('nom', auth.nom, { sameSite: 'lax' });			// On défini le nom et le prénom du responsable en cookie
		Cookies.set('prenom', auth.prenom, { sameSite: 'lax' });
		window.location = 'accueil.php';							// On redirectionne vers la page d'accueil
	} else { // Sinon on affiche une erreur 403
		$('#errors').show();
		$('#errors').html('403: Accès refusé');
	}
}