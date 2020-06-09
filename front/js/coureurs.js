'use strict';

ajaxRequest('GET','http://prj-cir2-web-api.monposte/php/request.php/cycliste', chargementCoureurs);


function chargementCoureurs(cyclistes){
	console.log(cyclistes);
	if (cyclistes) {
		var add = '<div class="panel panel-default"><br>';
		cyclistes.forEach( function(cyclistes) {
			add += cycliste['nom'], cycliste['prenom'], cycliste['num_license'], cycliste['club'];
		})
		add += "</div>"
		$('#liste_cyclistes').html(add);
	}

}