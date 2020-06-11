'use strict';
ajaxRequest('GET',urlCir2+'/php/request.php/cyclistes/?nom=' + Cookies.get('nom') + "&prenom=" + Cookies.get('prenom'), chargementCoureurs);


function chargementCoureurs(cyclistes){
	$("#infos").hide();
	$("#cyclisteInfos").hide();

	let listeCycliste = '<table class="table">' +
							'<thead>' +
								'<tr>' +
									'<th scope="col">Nom</th>' +
									'<th scope="col">Prénom</th>' +
									'<th scope="col">Club</th>' +
									'<th scope="col">Numéro de Licence</th>' +
									'<th scope="col">Email</th>' +
									'<th scope="col">Informations sur le Cycliste</th>' +
								'</tr>' +
							'</thead>' +
							'<tbody>';

	cyclistes.forEach(function(elt) {
		listeCycliste += '<tr id="'+elt.mail+'"><th>'+elt.nom+'</th>' +
					  	 '<td>' + elt.prenom+'</td>' +
					   	 '<td>' + elt.club+'</td>' +
					   	 '<td>' + elt.num_licence + '</td>'+
					   	 '<td>' + elt.mail +'</td>'+
					   	 '<td><button type="submit" class="btn btn-primary" id="info">Fiche</button>' +
					   	 '</tr>';

	});
    
    listeCycliste += "</tbody></table>";
	$('#listeCycliste').html(listeCycliste);

	// Attente du click sur le bouton infomartion
	$('#listeCycliste').on('click','#info', () => {
		let id = $(event.target).closest('tr').attr('id');
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

	Cookies.set('mail', cycliste.mail, { sameSite: 'lax' });

	// On prérempli le formulaire avec les données existantes
	for (let [key1, value1] of Object.entries(cycliste)) {
		for (let [key2, value2] of Object.entries(cycliste)) {
			if (key1 == $('#'+key2).attr('id')) $('#'+key2).val(value2);
		}
	}
	$("#update").submit(updateCoureur);
}

// Fonction qui update la fiche d'un coureur
function updateCoureur(event){

	event.preventDefault();
	let nom = $("#nom").val().toUpperCase();
	let prenom = $("#prenom").val();
	let date_naissance = $("#date_naissance").val();
	let code_insee = $("#code_insee").val();
	let num_licence = $("#num_licence").val();
	let valide = $("#valide").prop("checked") ? 1 : null;

	ajaxRequest('PUT', urlCir2+'/php/request.php/cyclistes/' + Cookies.get('mail'), (error) => {

		
		// Si le serveur nous renvoie une erreur on l'affiche
		if (typeof(error.error) == undefined) {
			$('#secError').show();
			let msgError = "";
			switch (error.error) {
				case 1:
					msgError = "Votre numéro Insee n'est pas valide ou n'est pas contenue dans notre base de donnée";
				break;
			}
			$('#secError').html(msgError);
		} else {
			Cookies.remove('mail');
			$('#secError').hide();
			$('#secError').html('');
			ajaxRequest('GET',urlCir2+'/php/request.php/cyclistes/?nom=' + Cookies.get('nom') + "&prenom=" + Cookies.get('prenom'), 
						chargementCoureurs);
		}
	},	'nom=' + nom +
		'&prenom=' + prenom +
		'&date_naissance=' + date_naissance +
		'&valide=' + valide +
		'&code_insee=' + code_insee + 
		'&num_licence=' + num_licence);
}

