<?php //presentation.controlleur.php

	// Définition du gabarit
	$gab = new Template("./");
	$gab->set_filenames(array("body" => "vue/presentation.tpl.html"));
	// Affichage du gabarit
	$gab->pparse("body");
?>