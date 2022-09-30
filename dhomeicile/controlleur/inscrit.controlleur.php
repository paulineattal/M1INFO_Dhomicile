<?php //inscrit.controlleur.php
	// Définition du gabarit
	$gab = new Template("./");

	//appeler le bon modele et creer le bon objet en fonction de l'utilisateur connecté
	if(isset($_SESSION['logged']) and isset($_SESSION['admin'])){ 
		require("modele/inscrit.class.php");
		$accins = new AccesInscrit($c);
	}

	try {
		//admin 
		if(htmlspecialchars($_GET['page']=='inscrit')){
			if (isset($_GET['supp'])){ 
	            //suprimer l'inscrit
	            $accins->deleteInscrit($_GET["idInscrit"]);
			}
			//lister reservations 
			$accins->showInscrit();
		} 
	}
	catch(PDOException $erreur) {
    	echo "<p>Erreur : " . $erreur->getMessage() . "</p>\n";
	}
 ?>