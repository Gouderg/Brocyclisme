'use strict';

ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/php/request.php/course', loadCourse);

function loadCourse(liste) {
	let listeCourse = '<table class="table">' +
						'<thead>' +
						'<tr>' +
						'<th scope="col">Nom</th>' +
						'<th scope="col">Date</th>' +
						'<th scope="col">Club</th>' +
						'<th scope="col"></th>' +
						'<th scope="col"></th>' +
						'<th scope="col"></th>' +
						'</tr>' +
						'</thead>' +
						'<tbody>';

	liste.forEach(function(elt) {
		listeCourse += '<tr id="'+elt.id+'"><th scope="row">'+elt.libelle+'</th>' +
					   '<td>'+elt.date+'</td>' +
					   '<td>'+elt.club+'</td>' +
					   '<td><button type="submit" class="btn btn-primary" id="info">Information</button>' +
					   '<td><button type="submit" class="btn btn-primary" id="inscrip">Inscription</button>' +
					   '<td><button type="submit" class="btn btn-primary" id="classement">Classement</button>' +
					   '</tr>';

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
		console.log('Inscription :' + $(event.target).closest('tr').attr("id"));
	});

	// Attente du click sur le mot classment
	$('#listeCourse').on('click','#classement', () => {
		console.log('Classement :' + $(event.target).closest('tr').attr("id"));
	});
}

// Fonction qui affiche la course détaillé et les participants en fonction de qui on est
function loadInfo(info) {
	// On switch active la bonne section et on désactive les mauvaises
	$('#Information').show();
	$('#Inscription').hide();
	$('#Classement').hide();

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
						'<th scope="col">Dossart</th>' +
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
	$('#Information').html(total);
}