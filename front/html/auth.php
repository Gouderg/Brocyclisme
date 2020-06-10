<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Brocyclisme</title>
	
	<script type="text/javascript" src="../js/authentication.js" defer></script>
	<script type="text/javascript" src="../js/ajax.js" defer></script>

</head>
<body>
	<?php require "header.html" ?>

	<section class="container">
		<br>
		<h4>Authentication</h4>
		<hr>
		<form>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Email</span>
				</div>
				<input type="text" class="form-control" id="login" placeholder="Entrez votre email" autofocus required>
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Mot de passe</span>
				</div>
				<input type="text" class="form-control" id="password" placeholder="Entrez votre mot de passe" autofocus required>
			</div>
			<button type="submit" class="btn btn-success float-right" id="authentication-send">Envoyer</button>
		</form>
	</section>


	<?php require "footer.html" ?>
</body>
</html>