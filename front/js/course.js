'use strict';

// Requête initiale
ajaxRequest('GET', urlCir2+'/php/request.php/course', loadCourse);

//------------------------------------------------------------------
//--- loadCourse ---------------------------------------------------
//------------------------------------------------------------------
// Affiche la liste des courses
// \param liste Contient des informations concernants les courses
function loadCourse(liste) {
	$('#secInf').hide();	// On cache toutes les sections
	$('#secInsc').hide();
	$("#classementCourse").hide();
	

	// On crée une variable qui va contenir une table d'information concernant les courses
	let listeCourse = '<table class="table">' +
							'<thead>' +
								'<tr>' +
									'<th scope="col"></th>' +
									'<th scope="col">Nom</th>' +
									'<th scope="col">Date</th>' +
									'<th scope="col">Club</th>' +
									'<th scope="col"></th>' +
									'<th scope="col"></th>' +
								'</tr>' +
							'</thead>' +
							'<tbody>';

	// On parcours chaque courses
	liste.forEach(function(elt) {

		// On récupère la date de la course et la date du jour
		let temp = new Date(elt.date);
		let now = new Date();

		listeCourse += '<tr id="'+elt.id+'">' +
							'<th scope="row">' + elt.id + '</th>' +
							'<td>'+elt.libelle+'</td>' +
					   		'<td>'+elt.date+'</td>' +
					   		'<td>'+elt.club+'</td>' +
							'<td><button type="submit" class="btn btn-primary" id="btnInf">Information</button></td>';

		// Si la course est passée, on propose le classement (si c'est l'orgaisateur de la course
		// Si la course n'est pas passée, on propose l'inscription
		if (temp - now > 0) {
			listeCourse += '<td><button type="submit" class="btn btn-primary" id="btnInsc">Inscription</button></td>';	
		} else {
			listeCourse += '<td id="isOrga"></td>';
			ajaxRequest('GET', urlCir2+'/php/request.php/courseOrga/'+ elt.id + '?nom=' + Cookies.get('nom') + "&prenom=" + Cookies.get('prenom') , (isOrga) => {
			 	
            	if (isOrga ) {
       				$('#isOrga').html('<button type="submit" class="btn btn-primary" id="btnClas">Classement</button>');
				}	
			});
		}	
		listeCourse += '</tr>';
	});

	listeCourse += "</tbody></table>";

	$('#listeCourse').html(listeCourse); // On injecte dans la balise html

	// Attente du click sur le bouton Information
	// Si on click, on envoie une requête au serveur lui demandant des informations sur la course et les participants en fonction du user
	$('#listeCourse').on('click','#btnInf', () => {
		let path = urlCir2+'/php/request.php/course/' + 
					$(event.target).closest('tr').attr('id') + 
					'?nom='+Cookies.get('nom') + '&prenom=' + Cookies.get('prenom');
		ajaxRequest('GET', path, loadInfo);
	});

	// Attente du click sur le mot inscription
	$('#listeCourse').on('click','#btnInsc', () => {
		// On appelle la fonction inscCourse
		inscCourse($(event.target).closest('tr').attr("id"));
	});

	// Attente du click sur le mot classement
	$('#listeCourse').on('click','#btnClas', () => {
		let id = $(event.target).closest('tr').attr('id');
		ajaxRequest('GET',urlCir2+'/php/request.php/classement/' + id , classCourse);
	});
}

//------------------------------------------------------------------
//--- loadInfo -----------------------------------------------------
//------------------------------------------------------------------
// Affiche des informations précises concernants une course et des cyclistes
// \param info Contient des informations concernants une course et des cyclistes
function loadInfo(info) {
	$('#secInf').show(); 	// On affiche la section avec Information et on cache le reste
	$('#secInsc').hide();
	$("#classementCourse").hide();


	// On déclare 2 variables. L'une contient une description de la course. L'autre la liste des cyclistes de la course
	let listeCoureur = '<br><br><div class="container"><h4>Liste Cyclistes</h4><br>';
	let descriptionCourse = "<div class='container'><h4>" + info.course.libelle + ": </h4><p>" +
							"<br>Organisé par le club " + info.course.club +
							" , le " + info.course.date + ".<br>" +
							"Elle compte " + info.course.nb_tour + " tours de " + info.course.longueur_tour + "km" +
							" pour une distance totale de " + info.course.distance + "km.<br>" +
							info.course.nb_coureur + " coureurs sont inscrits à la course." + "</p></div>";

	// On prend en compte s'il n'y a pas de cycliste.
	if (info.participants.length == 0) {
		listeCoureur += "Aucun de vos cyclistes ne sont inscrits dans cette course";
	} else {
		listeCoureur += "<table class='table'>"+
							"<thead>" +
								'<tr>' +
									'<th scope="col">Email</th>' +
									'<th scope="col">Nom</th>' +
									'<th scope="col">Prénom</th>' +
									'<th scope="col">Licence</th>' +
									'<th scope="col">Club</th>' +
									'<th scope="col">Catégorie</th>' +
									'<th scope="col">Dossard</th>' +
								'</tr>' +
							'</thead>' +
						'<tbody>';
		// On parcours les informations de chaque cycliste
		info.participants.forEach(function(parti) { 
			listeCoureur += "<tr>"+
								"<td>"+ parti.mail +"</td>" +
								"<td>"+ parti.nom +"</td>" +
								"<td>"+ parti.prenom +"</td>" +
								"<td>"+ parti.num_licence +"</td>" +
								"<td>"+ parti.club +"</td>" +
								"<td>"+ parti.categorie +"</td>" +
								"<td>"+ parti.dossart +"</td>" +
							"</tr>"
		});

		listeCoureur += "</body></table>";
	}
	listeCoureur += "</div>";

	// On concatène la description et la liste des cyclistes et on injecte dans le code
	let total = descriptionCourse + listeCoureur;
	$('#secInf').html(total);
}


//------------------------------------------------------------------
//--- inscCourse ---------------------------------------------------
//------------------------------------------------------------------
// Propose l'insciption à une course
// \param idCourse Contient l'id de la course
function inscCourse(idCourse) {
	$('#secInf').hide();	// On affiche le formulaire d'inscription et on cache le reste
	$('#secInsc').show();
	$("#classementCourse").hide();

	// On défini un cookie ayant l'identifiant de la course sélectionnée
	Cookies.set('idCourse', idCourse, { sameSite: 'lax' });
	// On rajoute un titre
	$('#titreInsc').html("Inscription à la course " + idCourse);

	// On attends que le user clique sur le bouton envoyé du formulaire
	$('#formInsc').submit(updateInfoCourse);
}

//------------------------------------------------------------------
//--- updateInfoCourse ---------------------------------------------
//------------------------------------------------------------------
// Récupère les informations du formulaire et les envoies dans la bdd
// \param event Évènement de la page
function updateInfoCourse(event) {
	event.preventDefault();

	ajaxRequest('POST', urlCir2+'/php/request.php/course/', (error) => {
		// On traite les erreurs renvoyé par le serveur suite à de précédentes tentatives
		if (typeof(error.error) != "undefined") {
			$('#secError').show();
			let msgError;
			switch (error.error) {
				case 1:
					msgError = "Le nom, le prénom, l'adresse mail ne sont pas bonnes ou bien le cycliste n'est pas valide.";	   
				break;

				case 2:
					msgError = "Ce cycliste ne fait pas partie de votre club";
				break;

				case 3:
					msgError = "Le numéro de dossard n'est pas bon, ou bien le joueur est déjà inscrit";
				break;
			}
			$('#secError').html(msgError);
		} else {
			$('#secError').hide();
			$('#secError').html('');
			$('#formInsc')[0].reset();
			ajaxRequest('GET', urlCir2+'/php/request.php/course', loadCourse);
		}

	}, 'nomC=' + $('#nomInsc').val().toUpperCase() + 
	   '&prenomC=' + $('#prenomInsc').val() +
	   '&nomU=' + Cookies.get('nom') +
	   '&prenomU=' + Cookies.get('prenom') +
	   '&mail=' + $('#emailInsc').val() + 
	   '&dossard=' + $('#dossardInsc').val() + 
	   '&id=' + Cookies.get('idCourse'));
};

//------------------------------------------------------------------
//--- classCourse --------------------------------------------------
//------------------------------------------------------------------
// Affiche le classement d'une course
// \param classement Contient des informations sur le classement
function classCourse(classement){
	$("#classementCourse").show();
	$('#secInf').hide();
	$('#secInsc').hide();

	let Classement = '<br><br><div class="container"><h4>Classement de la course</h4><br>';
    	Classement  += '<table class="table">' +
						'<thead>' +
							'<tr>' +
								'<th scope="col">Place</th>' +
								'<th scope="col">Points</th>' +
								'<th scope="col">Temps</th>' +
								'<th scope="col">Vitesse</th>' +
								'<th scope="col">Nom</th>' +
								'<th scope="col">Prénom</th>' +
								'<th scope="col">Email</th>' +
								'<th scope="col">Club</th>' +
								'<th scope="col">Catégorie</th>' +
							'</tr>' +
							'</thead>' +
							'<tbody>';

		classement.forEach(function(elt) {
			// Récupération de la vitesse
			var temps = elt.temps.split(':');
			var seconds = parseInt(temps[0], 10) * 3600 + parseInt(temps[1], 10) * 60 + parseInt(temps[2], 10);
			var vitesse = (((elt.distance * 1000) / seconds) * 3.6).toFixed(0);
			
			Classement += '<tr id="'+ elt.mail + '">' +
							'<th>' + elt.place + '</th>' +
					  	 	'<td>' + elt.point + '</td>' +
					  	 	'<td>' + elt.temps + '</td>' +
					  	 	'<td>' + vitesse + ' km/h</td>' +
					   	 	'<td>' + elt.nom + '</td>' +
					   	 	'<td>' + elt.prenom + '</td>'+
					   	 	'<td>' + elt.mail + '</td>'+
					   	 	'<td>' + elt.club + '</td>'+
					   	 	'<td>' + elt.categorie + '</td>'+
					   	 
					   	 '</tr>';

	});
		   Classement += '<tr>' +'<td><button type="submit" class="btn btn-primary" id="print">Imprimer</button>' + '</tr>'

    
    $("#classementCourse").html(Classement);

    // Attente du click pour l'impression de la page
    $('#classementCourse').on('click','#print', () => {
    	print(classement);
	});
}