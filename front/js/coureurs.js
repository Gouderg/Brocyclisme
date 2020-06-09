'use strict';
$('#nom').val();

ajaxRequest('GET','http://prj-cir2-web-api.monposte/php/request.php/cyclistes', chargementCoureurs);





function chargementCoureurs(cyclistes){
	console.log(cyclistes);
	let listeCycliste = '<table class="table">' +
						'<thead>' +
						'<tr>' +
						'<th scope="col">Nom</th>' +
						'<th scope="col">Prénom</th>' +
						'<th scope="col">Club</th>' +
						'<th scope="col">Numéro de License</th>' +
						'<th scope="col">mails</th>' +
						'<th scope="col"> Informations sur le Cycliste</th>' +
						'</tr>' +
						'</thead>' +
						'<tbody>';
	cyclistes.forEach(function(elt) {
		listeCycliste += '<tr id="'+elt.num_licence+'"><th>'+elt.nom+'</th>' +
					  	 '<td>'+elt.prenom+'</td>' +
					   	 '<td>'+elt.club+'</td>' +
					   	 '<td>' + elt.num_licence + '</td>'+
					   	 '<td>' + elt.mail +'</td>'+
					   	 '<td><button type="submit" class="btn-lg btn primary" id="info">Fiches</button>' +
					   	 '</tr>';

	});
    
    listeCycliste += "</tbody></table>";
	$('#listeCycliste').html(listeCycliste);
	$('#listeCycliste').on('click','#info', () => {
		let id = $(event.target).closest('tr').attr('id');
		console.log('Information :' + id);
		ajaxRequest('GET','http://prj-cir2-web-api.monposte/php/request.php/cycliste ' + id , infosCoureurs);

	});
}





function infosCoureurs(cycliste){

	console.log(cycliste);
    ajaxRequest('GET', 'php/request.php/comments/?id='+ cycliste['id'], chargementCoureurs);

    let Cycliste  = '<table class="table">' +
						'<thead>' +
						'<tr>' +
						'<th scope="col">Nom</th>' +
						'<th scope="col">Prénom</th>' +
						'<th scope="col">Club</th>' +
						'<th scope="col">Valide</th>' +
						'<th scope="col">code_insee</th>' +
						'<th scope="col">categorie</th>' +
						'<th scope="col">categorie_valeur</th>' +
						'<th scope="col">Numéro de License</th>' +
						'<th scope="col">mails</th>' +
						'<th scope="col"> Informations sur le Cycliste</th>' +
						'</tr>' +
						'</thead>' +
						'<tbody>';

		Cycliste += '<tr id="'+cycliste['num_licence']+'"><th>'+cycliste['nom']+'</th>' +
					  	 '<td>'+cycliste['prenom']+'</td>' +
					   	 '<td>'+cycliste['club']+'</td>' +
					   	 '<td>'+cycliste['valide'] +'</td>' +
					   	 '<td>'+cycliste['code_insee']+'</td>' +
					   	 '<td>'+cycliste['categorie']+'</td>' +
					   	 '<td>'+cycliste['categorie_categorie_valeur']+'</td>' +
					   	 '<td>' + cycliste['num_licence'] + '</td>'+
					   	 '<td>' + cycliste['mail'] +'</td>'+
					   	 '<td><button type="submit" class="btn-lg btn primary" id="info">Fiches</button>' +
					   	 '</tr>';
    
    $('#Cycliste').attr('cyclisteid', cycliste['id']);
    $('#Cycliste').html(texte);
	
}
	/*
	console.log('test');
		let Cycliste  = '<table class="table">' +
						'<thead>' +
						'<tr>' +
						'<th scope="col">Nom</th>' +
						'<th scope="col">Prénom</th>' +
						'<th scope="col">Club</th>' +
						'<th scope="col">Valide</th>' +
						'<th scope="col">code_insee</th>' +
						'<th scope="col">categorie</th>' +
						'<th scope="col">categorie_valeur</th>' +
						'<th scope="col">Numéro de License</th>' +
						'<th scope="col">mails</th>' +
						'<th scope="col"> Informations sur le Cycliste</th>' +
						'</tr>' +
						'</thead>' +
						'<tbody>';

	cycliste.(function(elt) {

		Cycliste += '<tr id="'+elt.num_licence+'"><th>'+elt.nom+'</th>' +
					  	 '<td>'+elt.prenom+'</td>' +
					   	 '<td>'+elt.club+'</td>' +
					   	 '<td>'+elt.valide +'</td>' +
					   	 '<td>'+elt.code_insee+'</td>' +
					   	 '<td>'+elt.categorie+'</td>' +
					   	 '<td>'+elt.categorie_categorie_valeur+'</td>' +
					   	 '<td>' + elt.num_licence + '</td>'+
					   	 '<td>' + elt.mail +'</td>'+
					   	 '<td><button type="submit" class="btn-lg btn primary" id="info">Fiches</button>' +
					   	 '</tr>';

	});
	
	console.log('Information :' + $(event.target).closest('tr').attr('id'));
	$('#infos').show();
	Cycliste += "</tbody></table>";
	$('#infos').html(Cycliste);
	
	});
    
}











/*$('#listeCycliste').on('click','#info', () => {
	console.log('Information :' + $(event.target).closest('tr').attr('id'));

		let Cycliste  = '<table class="table">' +
						'<thead>' +
						'<tr>' +
						'<th scope="col">Nom</th>' +
						'<th scope="col">Prénom</th>' +
						'<th scope="col">Club</th>' +
						'<th scope="col">Valide</th>' +
						'<th scope="col">code_insee</th>' +
						'<th scope="col">categorie</th>' +
						'<th scope="col">categorie_valeur</th>' +
						'<th scope="col">Numéro de License</th>' +
						'<th scope="col">mails</th>' +
						'<th scope="col"> Informations sur le Cycliste</th>' +
						'</tr>' +
						'</thead>' +
						'<tbody>';




	$('#infos').show();
	Cycliste += "</tbody></table>";
	$('#infos').html(Cycliste);
	
	});

	*/
    
