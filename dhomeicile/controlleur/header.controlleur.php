<?php //header.controlleur.php
	
	require("modele/header.class.php");
	// Définition du gabarit
	$gab = new Template("./");

	
	if(isset($_SESSION['logged']) and isset($_SESSION['proprietaire']) or isset($_SESSION['client']) ) {
    	$gabc = new RequeteGab("D'Home'icile", $gab);
    	$gabc->showHeadConnexion();
	}
	if(isset($_SESSION['logged']) and isset($_SESSION['admin'])){
		$gabca = new RequeteGab("D'Home'icile", $gab);
    	$gabca->showHeadConnexionAdmin();
	}
	if (!isset($_SESSION['logged'])){
		$gabd = new RequeteGab("D'Home'icile", $gab);
    	$gabd->showHeadDeconnexion();
	}
?>


