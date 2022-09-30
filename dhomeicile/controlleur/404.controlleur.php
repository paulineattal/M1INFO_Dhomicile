<?php //404.controlleur.php
	
	// Définition du gabarit
	$gab = new Template("./");
	$gab->set_filenames(array("div" => "vue/404.tpl.html"));
	// Affichage du gabarit
	$gab->pparse("div");
?>