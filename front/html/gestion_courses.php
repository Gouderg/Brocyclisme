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
	<section class="container" id="Information" style="display: none;"></section>
	<section class="container" id="Inscription" style="display: none;"></section>
	<section class="container" id="Classement" style="display: none;"></section>

	<?php require "footer.html" ?>
</body>
</html>