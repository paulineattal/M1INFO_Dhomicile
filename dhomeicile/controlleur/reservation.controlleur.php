<?php // reservation.controlleur.php
	// Définition du gabarit
	$gab = new Template("./");

	//appeler le bon modele et creer le bon objet en fonction de l'utilisateur connecté
	if(isset($_SESSION['logged']) and isset($_SESSION['proprietaire'])){ 
		require("modele/reservation.class.php");
		$accheb = new AccessReservation($c);
	}
	if(isset($_SESSION['logged']) and isset($_SESSION['client']) or isset($_SESSION['admin'])){ 
		require("modele/reservation.client.class.php");
		$accheb = new AccessReservationClient($c);
	}

	try {
		$id = $_SESSION['idInscrit'];

		//admin 
		if(htmlspecialchars($_GET['page']=='reservation') and isset($_SESSION['admin']) ){
			//s'il clique sur annuler
			if (isset($_GET['supp'])){  
           		//changer dispo a True
                $requeteHeb = "SELECT idHebergement FROM reservationheb WHERE idReservation = ?"; 
				$queryHeb = $c->prepare($requeteHeb); 
				$idRes = $_GET["idReservation"];
				$queryHeb->execute([$idRes]);
				$idH = $queryHeb->fetch(PDO::FETCH_ASSOC);
                $accheb->updateDispoTrue($idH['idHebergement']);
				//supprimer l'hébergement
				$accheb->deleteReservation($_GET["idReservation"]);
			}
			//lister reservations
			$accheb->getReservation();
		}

		//proprietaire
		if(htmlspecialchars($_GET['page']=='reservation') and isset($_SESSION['proprietaire']) ){
			//s'il clique sur annuler
			if (isset($_GET['supp'])){ 
                //changer dispo a True
                $requeteHeb = "SELECT idHebergement FROM reservationheb WHERE idReservation = ?"; 
				$queryHeb = $c->prepare($requeteHeb); 
				$idRes=$_GET["idReservation"];
				$queryHeb->execute([$idRes]);
				$idH = $queryHeb->fetch(PDO::FETCH_ASSOC);
                $accheb->updateDispoTrue($idH['idHebergement']);
                //suprimer la reservation
                $accheb->deleteReservation($_GET["idReservation"]);
			}
			//lister reservations 
			$accheb->getReservationByIdProp($id);
		}

		//client
		if(htmlspecialchars($_GET['page']=='reservation') and isset($_SESSION['client']) ){
				//s'il clique sur annuler
				if (isset($_GET['supp'])){  
               		//changer dispo a True
                    $requeteHeb = "SELECT idHebergement FROM reservationheb WHERE idReservation = ?"; 
					$queryHeb = $c->prepare($requeteHeb); 
					$idRes = $_GET["idReservation"];
					$queryHeb->execute([$idRes]);
					$idH = $queryHeb->fetch(PDO::FETCH_ASSOC);
                    $accheb->updateDispoTrue($idH['idHebergement']);
					//supprimer l'hébergement
					$accheb->deleteReservation($_GET["idReservation"]);
				}
				//lister reservations
				$accheb->getReservationByIdCli($id);
		}
	} 
	catch(PDOException $erreur) {
    	echo "<p>Erreur : " . $erreur->getMessage() . "</p>\n";
	}
 ?>