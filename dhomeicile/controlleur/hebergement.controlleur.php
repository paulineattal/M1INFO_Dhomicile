<?php  //hebergement.controlleur.php
	// Définition du gabarit
	$gab = new Template("./");
	
	//appeler le bon modele et creer le bon objet en fonction de l'utilisateur connecté
	if(isset($_SESSION['logged']) and isset($_SESSION['proprietaire'])){ 
		require("modele/hebergement.class.php");
		$accheb = new AccessHebergement($c);
	}
	if(isset($_SESSION['logged']) and isset($_SESSION['client']) or isset($_SESSION['admin'])){ 
		require("modele/hebergement.client.class.php");
		$accheb = new AccessHebergementClient($c);
	}

	try{
		$id = $_SESSION['idInscrit'];
		
		//admin
		if(htmlspecialchars($_GET['page']=='hebergement') and isset($_SESSION['admin']) ){
			//lister
			$accheb->getHebergement();
		}

		//proprietaire
		if(htmlspecialchars($_GET['page']=='hebergement') and isset($_SESSION['proprietaire']) ){
			//s'il clique sur supprimer
			if (isset($_GET['supp'])){ 
				//supprimer l'hébergement
				$accheb->deleteHebergement($_GET["idHebergement"]);
			}
			//lister hebergements
			$accheb->getHebergementById($id);
		}

		//client
		if(htmlspecialchars($_GET['page']=='hebergement') and isset($_SESSION['client']) ){
			//s'il clique sur reserver 
			if (isset($_GET['res'])){
				//on incrémente l'id de la nouvelle reservation  
				$requete = "SELECT MAX(idReservation) FROM reservationheb"; 
				$query = $c->prepare($requete); 
				$query->execute();
				$maxId = $query->fetch(PDO::FETCH_ASSOC);
				$idReservation = 1+$maxId['MAX(idReservation)'];
				// Rechercher l'identifiant du propriétaire dans $idProprietaire
				$requeteProp = "SELECT idGerant FROM hebergement WHERE idHebergement = ?"; 
				$queryProp = $c->prepare($requeteProp); 
				$idHeb = $_GET["idHebergement"];
				$queryProp->execute([$idHeb]);
				$idP = $queryProp->fetch(PDO::FETCH_ASSOC);
				$idProprietaire = $idP['idGerant'];
				//ajouter l'hebergement a la liste de reservation
				$accheb->addReservation($idReservation, $id, $idProprietaire, $_GET["idHebergement"]);
				//passer la dispo a False
                $accheb->updateDispoFalse($_GET['idHebergement']);
			}
			//lister
			$accheb->getHebergementDispo();
		}
	} 
	catch(PDOException $erreur){
    	echo "<p>Erreur : " . $erreur->getMessage() . "</p>\n";
	}
 ?>