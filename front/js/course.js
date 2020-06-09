'use strict';

ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/php/request.php/course', loadCourse);

function loadCourse(liste) {
	let listeCourse = '<table class="table">' +
						'<thead>' +
						'<tr>' +
						'<th scope="col">Nom</th>' +
						'<th scope="col">Date</th>' +
						'<th scope="col">Club</th>' +
						'<th scope="col">Information</th>' +
						'<th scope="col">Inscription</th>' +
						'<th scope="col">Classement</th>' +
						'</tr>' +
						'</thead>' +
						'<tbody>';
	liste.forEach(function(elt) {
		listeCourse += '<tr id="'+elt.id+'"><th scope="row">'+elt.libelle+'</th>' +
					   '<td>'+elt.date+'</td>' +
					   '<td>'+elt.club+'</td>' +
					   '<td><button type="submit" class="btn-lg btn primary" id="info">Information</button>' +
					   '<td><button type="submit" class="btn-lg btn primary" id="inscrip">Inscription</button>' +
					   '<td><button type="submit" class="btn-lg btn primary" id="classement">Classement</button>' +
					   '</tr>';

	});
	listeCourse += "</tbody></table>";
	$('#listeCourse').html(listeCourse);
}


// Attente du click sur le mot information
$('#listeCourse').on('click','#info', () => {
	console.log('Information :' + $(event.target).closest('tr').attr('id'));
});

// Attente du click sur le mot inscription
$('#listeCourse').on('click','#inscrip', () => {
	console.log('Inscription :' + $(event.target).closest('tr').attr("id"));
});

// Attente du click sur le mot classment
$('#listeCourse').on('click','#classement', () => {
	console.log('Classement :' + $(event.target).closest('tr').attr("id"));
});
