<?php //ajout_hebergement.controlleur.php
	//modele pour les proprietaires 
	require("modele/hebergement.class.php");
	$accheb = new AccessHebergement($c);

	try{
		if(!empty($_POST['nom']) and !empty($_POST['type']) and !empty($_POST['adresse']) and !empty($_POST['prix']) and !empty($_POST['etoile'])){
		    //recuperation des champs remplies 
			$nom = ($_POST['nom']);
			$type = ($_POST['type']);
			if($type=="Auberge de jeunesse"){
			    $type = "Auberge_jeunesse";
			}
			$adresse = ($_POST['adresse']);
			$prix = ($_POST['prix']);
			$etoile = ($_POST['etoile']);
			$idProp = $_SESSION["idInscrit"];
			$dispo = true;

			// on incrÃ©mente l'id du nouvel hebergement   
			$requete = "SELECT MAX(idHebergement) FROM hebergement"; 
			$query = $c->prepare($requete); 
			$query->execute();
			$maxId = $query->fetch(PDO::FETCH_ASSOC);
			$idHebergement = 1+$maxId['MAX(idHebergement)'];
			//ajouter l'hebergement
			$nouvHeb=$accheb->addHebergement($idHebergement, $nom, $type, $adresse, $prix, $etoile, $idProp, $dispo);
            //message de bon envoie du formulaire
            echo "<center><h2>Merci pour votre ajout d'hebergement</h2></center><br>";
            
		}elseif(!empty($_POST['nom']) or !empty($_POST['type']) or !empty($_POST['adresse']) or !empty($_POST['prix']) or !empty($_POST['etoile'])) {
	            echo "<center><h2>Erreur de saisie : un des champs est vide</h2></center><br>";
	    }
    	//construction et appel du gabarit
        $heber = new RequeteAjoutHebergement("Ajouter votre nouveau logement");
	    $heber->showAjoutHebergement();
	}catch(PDOException $erreur){
    	echo "<p>Erreur : " . $erreur->getMessage() . "</p>\n";
	}
 ?>