'use strict';

ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/php/request.php/course', loadCourse);

function loadCourse(liste) {
	$('#information').hide();
	$('#inscription').hide();
	$('#classement').hide();

	let listeCourse = '<table class="table">' +
						'<thead>' +
						'<tr>' +
						'<th scope="col">Nom</th>' +
						'<th scope="col">Date</th>' +
						'<th scope="col">Club</th>' +
						'<th scope="col"></th>' +
						'<th scope="col"></th>' +
						'</tr>' +
						'</thead>' +
						'<tbody>';

	liste.forEach(function(elt) {
		var temp = new Date(elt.date);
		var now = new Date();
		listeCourse += '<tr id="'+elt.id+'"><th id="'+elt.libelle+'" scope="row">'+elt.libelle+'</th>' +
					   '<td>'+elt.date+'</td>' +
					   '<td>'+elt.club+'</td>' +
					   '<td><button type="submit" class="btn btn-primary" id="info">Information</button>';
		if (temp - now > 0) {
			listeCourse += '<td><button type="submit" class="btn btn-primary" id="inscrip">Inscription</button>';	
		} else {
			listeCourse += '<td><button type="submit" class="btn btn-primary" id="classement">Classement</button>';
		}		   
		listeCourse += '</tr>';
	});
	listeCourse += "</tbody></table>";
	$('#listeCourse').html(listeCourse);

	// Attente du click sur le mot information
	$('#listeCourse').on('click','#info', () => {
		let path = 'http://prj-cir2-web-api.monposte/php/request.php/course/' + 
					$(event.target).closest('tr').attr('id') +
					'?nom='+Cookies.get('nom') + 
					'&prenom=' +Cookies.get('prenom');
		ajaxRequest('GET', path, loadInfo);
	});

	// Attente du click sur le mot inscription
	$('#listeCourse').on('click','#inscrip', () => {
		inscriptionCourse($(event.target).closest('tr').attr("id"));
	});

	// Attente du click sur le mot classment
	$('#listeCourse').on('click','#classement', () => {
	});
}

// Fonction qui affiche la course détaillé et les participants en fonction de qui on est
function loadInfo(info) {
	// On switch active la bonne section et on désactive les mauvaises
	$('#information').show();
	$('#inscription').hide();
	$('#classement').hide();

	let listeCoureur = '<br><br><div class="container"><h4>Liste Cyclistes</h4><br>';
	let descriptionCourse = "<div class='container'><h4>" + info.course.libelle + ": </h4><p>" +
							"<br>Organisé par le club " + info.course.club +
							" , le " + info.course.date + ".<br>" +
							"Elle compte " + info.course.nb_tour + " tours de " + info.course.longueur_tour + "km" +
							" pour une distance totale de " + info.course.distance + "km.<br>" +
							info.course.nb_coureur + " coureurs sont inscrits à la course." + "</p></div>";

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

		info.participants.forEach(function(parti) { 
			listeCoureur += "<tr><td>"+ parti.mail +"</td>" +
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

	let total = descriptionCourse + listeCoureur;
	$('#information').html(total);
}


// Fonction qui propose une inscription d'une personne à une course
function inscriptionCourse(idCourse) {
	$('#information').hide();
	$('#inscription').show();
	$('#classement').hide();

	Cookies.set('idCourse', idCourse, { sameSite: 'lax' });
	
	$('#titreInsc').html("Inscription à la course: " + idCourse);

	$('#btnFormInscrip').submit(updateInfoCourse);
}

// Fonction qui récupère les informations et qui les update dans la base de donnée
function updateInfoCourse(event) {
	event.preventDefault();
	 
	
	ajaxRequest('POST', 'http://prj-cir2-web-api.monposte/php/request.php/course/', () => {
		ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/php/request.php/course', loadCourse);
	}, 'nom=' + $('#nomI').val() + '&prenom=' + $('#prenomI').val() + '&mail=' + $('#email').val() + '&dossard=' + $('#dossard').val() + '&id=' + Cookies.get('idCourse'));
};
