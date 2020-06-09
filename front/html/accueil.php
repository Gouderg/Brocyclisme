<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Brocyclisme</title>
</head>	
<body>
	<?php require "header.html" ?>
	
	<div class="col-md-12">
		<h1 style="text-align: center; text-decoration: underline; font-family: verdana;">Le gestionnaire numéro 1 du cyclisme </h1>
	</div>
	<br> <br> <br>

	<section class="row">
		<div class="col-lg-4 text-center">
			<a href="gestion_coureurs.php"><img src="../img/users.png" width="30%;" class="center-block"></a>
		</div>
		<div class = "col-lg-4 text-center">
			<a href="gestion_courses.php"> <img src="../img/Cycliste.GIF" width="30%;"></a>
		</div>
		<div class="col-lg-4 text-center">
			<a href="classement.php"><img src="../img/cup.png" width="40%;"></a>
		</div>
	</section>
	
	<br>

	<section class="row">
		<div class="col-lg-4">
			<a href="gestion_coureurs.php"><h2 style="text-align: center"> Gestion des coureurs</h2></a>
		</div>
		<div class = "col-lg-4">
			<a href="gestion_courses.php"><h2 style="text-align: center"> Gestion des courses</h2></a>
		</div>
		<div class="col-lg-4">
			<a href="classement.php"><h2 style="text-align: center"> Classement</h2></a>
		</div>
	</section>
	
	<?php require "footer.html" ?>
</body>
</html>