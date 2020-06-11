<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Brocyclisme</title>

	<?php require "head.html" ?>

	<script type="text/javascript" src="../js/constantes.js" defer></script>
	<script type="text/javascript" src="../js/ajax.js" defer></script>
	<script type="text/javascript" src="../js/coureurs.js" defer></script>
</head>	
<body>
	<?php require "header.html" ?>

	<section class="container">
		<h4>Liste des coureurs</h4>
		<br>
		<div id="listeCycliste" class="container"></div>
	</section>
	<br><br>

	<section id="infos" class="container" style="display: none;"></section>
	<section id= "cyclisteInfos" class="container" style="display: none;">
		<form id="update">
				<div class="form-row">
					<div class="form-group col-md-4">
						<label for="nom">Nom</label>
						<input type="text" id="nom" class="form-control" autofocus required>
					</div>
					<div class="form-group col-md-4">
						<label for="prenom">Prenom</label>
						<input type="text" id="prenom" class="form-control" autofocus required>
					</div>
					<div class="form-group col-md-4">
						<label for="date_naissance">Date de naissance</label>
						<input type="date" id="date_naissance" class="form-control" autofocus required>
					</div>
			</div>
			
			<div class="form-row align-items-center">
				<div class="form-group col-md-6">
					<label for="code_insee">Code Insee</label>
					<input type="number" min="0" id="code_insee" class="form-control" autofocus required>
				</div>
				<div class="form-group col-md-4">
					<label for="num_licence">Numero de Licence</label>
					<input type="number" min="0" id="num_licence" class="form-control" autofocus required>
				</div>
				<div class="col-auto">
					<div class="form-check md-2 ">
						<input type="checkbox" class="form-check-input" id="valide">
						<label class="form-check-label" for="valide">Valide</label>
					</div>	
				</div>

			</div>
			<button type="submit" class="btn btn-primary">Update</button>
		</form>
	</section>
	<section class="container" id="secError" style="display: none;"></section>

	<?php require "footer.html" ?>

</body>
</html>