<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Brocyclisme</title>

	<script type="text/javascript" src="../js/ajax.js" defer></script>
	<script type="text/javascript" src="../js/course.js" defer></script>
</head>	
<body>
	<?php require "header.html" ?>

	<section class="container">
		<h4>Liste des courses</h4>
		<br>
		<div id="listeCourse" class="container"></div>
	</section>
	
	<br><br><br>
	<section class="container" id="information" style="display: none;"></section>
	<section class="container" id="inscription" style="display: none;">
		<h4 id="titreInsc"></h4>
		<hr>
		<form id="btnFormInscrip">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="nomI">Nom</label>
					<input type="text" class="form-control" id="nomI" placeholder="Nom" autofocus required>
				</div>
				<div class="form-group col-md-6">
					<label for="prenomI">Prenom</label>
					<input type="text" class="form-control" id="prenomI" placeholder="Prenom" autofocus required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" placeholder="gh@fg.com" autofocus required>
				</div>
				<div class="form-group col-md-6">
					<label for="dossard">Dossard</label>
					<input type="number" class="form-control" id="dossard" min="0" max="100" placeholder="78" autofocus required>
				</div>
			</div>
			<button type="submit" class="btn btn-primary pull-right">
				<i class="fa fa-paper-plane"></i> Envoyer 
			</button>
		</form>
	</section>
	<section class="container" id="classement" style="display: none;"></section>

	<?php require "footer.html" ?>
</body>
</html>