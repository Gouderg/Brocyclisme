<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="../js/ajax.js" defer></script>
	<script type="text/javascript" src="../js/coureurs.js" defer></script>
	<title>Brocyclisme</title>
</head>	
<body>
	<?php require "header.html" ?>
	<section class="container">
		<h4 style="text-decoration: underline; font-family: bold;">Liste des coureurs</h4>
		<br>
		<div id="listeCycliste" class="container"></div>
	</section>
	<br>
	<br>                   
	<div id="infos" class="container" style="display: none;">
	</div>
	<section id= "cyclisteInfos" class="container" style="display: none;">
		<form id="update">
  			<div class="form-row">
					<div class="form-group col-md-6">
						<label for="mail">Email</label>
						<input type="email" id="mail" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="nomI">Nom</label>
						<input type="text" id="nomI" class="form-control">
					</div>
					<div class="form-group col-md-3">
						<label for="prenomI">Prenom</label>
						<input type="text" id="prenomI" class="form-control">
					</div>
			</div>
			<div class="form-group">
				<label for="club">Club</label>
				<input type="text" id="club" class="form-control">
			</div>
			<div class="form-row">
				<div class="form-group col-md-2 ">
					<label for="valide"> Valide</label>
					<input type="int" id="valide" class="form-control">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="code">Code Insee</label>
					<input type="int" id="code" class="form-control">
				</div>
			<div class="form-group col-md-4">
				<label for="num_li">Numero de Licence</label>
				<input type="int" id="num_li" class="form-control">
			</div>																		 
			<button type="submit" id="update" class="btn btn-primary">Update</button>
		</form>
	</section>
																		

	<?php require "footer.html" ?>

</body>
</html>