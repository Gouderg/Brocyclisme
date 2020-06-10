'use strict';
ajaxRequest('GET',urlCir2+'/php/request.php/cyclistes', chargementCoureurs);


function chargementCoureurs(cyclistes){
	$("#infos").hide();
	$("#cyclisteInfos").hide();

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
		listeCycliste += '<tr id="'+elt.mail+'"><th>'+elt.nom+'</th>' +
					  	 '<td>'+elt.prenom+'</td>' +
					   	 '<td>'+elt.club+'</td>' +
					   	 '<td>' + elt.num_licence + '</td>'+
					   	 '<td>' + elt.mail +'</td>'+
					   	 '<td><button type="submit" class="btn btn-primary" id="info">Fiches</button>' +
					   	 '</tr>';

	});
    
    listeCycliste += "</tbody></table>";
	$('#listeCycliste').html(listeCycliste);
	$('#listeCycliste').on('click','#info', () => {
		let id = $(event.target).closest('tr').attr('id');
		console.log('Information :' + id);
		ajaxRequest('GET',urlCir2+'/php/request.php/cyclistes/' + id , infosCoureur);

	});
}



function infosCoureur(cycliste){
	$("#infos").show();
	$("#cyclisteInfos").hide();

	let Cycliste = '<br><br><div class="container"><h4>Le Cycliste</h4><br>';
    	Cycliste  += '<table class="table">' +
						'<thead>' +
							'<tr>' +
								'<th scope="col">Nom</th>' +
								'<th scope="col">Prénom</th>' +
								'<th scope="col">Club</th>' +
								'<th scope="col">Valide</th>' +
								'<th scope="col">code_insee</th>' +
								'<th scope="col">categorie</th>' +
								'<th scope="col">categorie_valeur</th>' +
								'<th scope="col">Numéro de Licence</th>' +
								'<th scope="col">Email</th>' +
							'</tr>' +
							'</thead>' +
							'<tbody>';

		Cycliste += '<tr id="' + cycliste['mail'] + '">' + 
						'<th>' + cycliste['nom'] + '</th>' +
					  	'<td>' + cycliste['prenom'] + '</td>' +
					   	'<td>' + cycliste['club'] + '</td>' +
					   	'<td>' + cycliste['valide'] + '</td>' +
					   	'<td>' + cycliste['code_insee'] + '</td>' +
					   	'<td>' + cycliste['categorie'] + '</td>' +
					   	'<td>' + cycliste['categorie_categorie_valeur'] + '</td>' +
					   	'<td>' + cycliste['num_licence'] + '</td>' +
					   	'<td>' + cycliste['mail'] +'</td>' +
					   	'<td><button type="button" class="btn btn-primary" id="info">Modifier</button></td>' +
					'</tr>'+
				'</tbody>' +
		   	'</table>';
    
    $("#infos").html(Cycliste);
	$("#infos").on('click','#info', ()=>{
		modifCoureur(cycliste);
	});
}


function modifCoureur(cycliste){
	$("#infos").hide();
	$("#cyclisteInfos").show();

	// On prérempli le formulaire avec les données existantes
	$("#mail").val(cycliste['mail']);
	$("#nomI").val(cycliste['nom']);
	$("#prenomI").val(cycliste['prenom']);
	$("#club").val(cycliste['club']);
	$("#code").val(cycliste['code_insee']);
	$("#num_li").val(cycliste['num_licence']);
	$("#valide").val(cycliste['valide']);
	
	$("#update").submit(updateCoureur);
}

// Fonction qui update la fiche d'un coureur
function updateCoureur(event){

	event.preventDefault();		
	let mail = $("#mail").val();
	let nom = $("#nomI").val();
	let prenom = $("#prenomI").val();
	let club = $("#club").val();
	let code = $("#code").val();
	let num_li = $("#num_li").val();
	let valide = $("#valide").val();

	ajaxRequest('PUT', urlCir2+'/php/request.php/cyclistes/' + mail, (error) => {

		// Faire un gestionnaire d'erreur en cas de mauvaise sasie de l'user
		//si error n'est pas defini on fais ceci sinon on appele ajaxRequest
	  	ajaxRequest('GET',urlCir2+'/php/request.php/cyclistes', chargementCoureurs);
	},	'nom=' + nom +
		'&prenom=' + prenom +
		'&club=' + club +
		'&valide=' + valide +
		'&code=' + code + 
		'&num_licence=' + num_li);
}

