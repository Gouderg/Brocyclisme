<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Brocyclisme</title>

	<?php require "head.html" ?>
	<script type="text/javascript" src="../js/constantes.js" defer></script>
	<script type="text/javascript" src="../js/authentication.js" defer></script>
	<script type="text/javascript" src="../js/ajax.js" defer></script>

	<script>
		Cookies.remove('nom');
		Cookies.remove('prenom');
	</script>

</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FD9927;">
			<div class="collapse navbar-collapse row" id="navbarSupportedContent">
				<div class="col-12" style="text-align: center;">
					<h1 style="font-weight: bold;">Brocyclisme</h1>
				</div>
			</div>
		</nav>
	</header>
	
	<section class="container">
		<br>
		<h4>Authentification</h4>
		<hr>
		<br>
		<section id="errors" class="container alert alert-danger" style="display: none;"></section>
		<form>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Email</span>
				</div>
				<input type="email" class="form-control" id="login" placeholder="Entrez votre email" autofocus required>
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Mot de passe</span>
				</div>
				<input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" autofocus required>
			</div>
			<button type="submit" class="btn btn-success float-right" id="authentication-send">Envoyer</button>
		</form>
	</section>


	<?php require "footer.html" ?>
</body>
</html>