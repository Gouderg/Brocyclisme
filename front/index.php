<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!--Bootstrap-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<title>BroCyclisme</title>
</head>	
<body>
	<?php require "html/header.html" ?>
	
	
		
			<div class="col-md-12">

				<h1 style="text-align: center; text-decoration: underline; font-family: verdana;">Le gestionnaire numéro 1 du cyclisme </h1>
				
			</div>
			<br> <br> <br>

			<section class="row">

				<div class="col-lg-4 text-center"><a href="html/gestion_coureurs.php"> <img src="img/users.png" width="30%;" class="center-block"> </a> </div>
				<div class = "col-lg-4 text-center">  <a href="html/gestion_courses.php"> <img src="img/Cycliste.GIF" width="30%;"></a></div>
				<div class="col-lg-4 text-center">  <a href="html/classement.php"> <img src="img/cup.png" width="40%;"> </a></div>
		
			</section>

			<br>

			<section class="row">

				<div class="col-lg-4"> <a href="html/gestion_coureurs.php"> <h2 style="text-align: center"> Gestion des coureurs</h2></a></div>
				<div class = "col-lg-4"> <a href="html/gestion_courses.php"><h2 style="text-align: center"> Gestion des courses</h2> </a></div>
				<div class="col-lg-4"> <a href="html/classement.php"><h2 style="text-align: center"> Classement</h2> </a></div>
		
			</section>
	

	<?php require "html/footer.html" ?>
</body>
</html>