<?php //connexion.controlleur.php
	
	require_once("./modele/connexion.class.php");
	try{
		//si les 2 champs ont ete renseignés 
		if(!empty($_POST['identifiant']) and !empty($_POST['password'])){
			//recuperer les champs remplies
			$identifiant = htmlspecialchars($_POST['identifiant']);
			$password = htmlspecialchars($_POST['password']);

			$query = $c->prepare("SELECT * FROM inscription where pseudo = ?"); 
			$query->execute([$identifiant]);

			// Vérification de la connexion
			$resultats = $query->fetch(PDO::FETCH_ASSOC);
			if($resultats == False){
				echo "<center><h2>Erreur de saisie : pseudo ou mot de passe incorrect </h2></center><br>";
			}
			else{
				// Vérification du password
				if(($password == $resultats['mdp']) and ($identifiant == $resultats['pseudo'])){
					//initialiser les variables de session
					$_SESSION['logged'] = true;
					$_SESSION['nom']=$resultats['pseudo'];
					$_SESSION['idInscrit'] = $resultats['idInscrit'];	
					//differencier les differents types de connexions 
					if($resultats['role'] == "Proprietaire"){
						$_SESSION['proprietaire'] = true;
					}
					if($resultats['role'] == "Client"){
						$_SESSION['client'] = true;
					}	
					if($resultats['role'] == "admin"){
						$_SESSION['admin'] = true;
					}
					header("location:https://dhomeicile.000webhostapp.com/index.php");
				}
				else{
				    echo "<center><h2>Erreur de saisie : pseudo ou mot de passe incorrect </h2></center><br>";
				}
			}
		}
		//un des champs est vide
		elseif(!empty($_POST['identifiant']) or !empty($_POST['password'])) {
			echo "<center><h2>Erreur de saisie : un des champs est vide</h2></center><br>";
		}
		
    	//construction et appel du gabarit
        $ins = new RequeteConnexion("Connectez-vous");
        $ins->showConnexion();

	}catch(PDOException $e){
		die ('Erreur : '.$e->getMessage());
	}
?>