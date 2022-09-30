<?php //inscription.controlleur.php
    require("./modele/inscription.class.php");

    try{
        //si tous les champs sont renseignés
        if(!empty($_POST['pseudo']) and !empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['password']) and !empty($_POST['statut'])){    

            //recuperation des champs remplies 
            $pseudo=$_POST['pseudo'];
            $nom =$_POST['nom'];
            $prenom=$_POST['prenom'];
            $password=$_POST['password'];
            $statut=$_POST['statut'];

            // on incrémente l'id du nouveau inscrit  
            $requete = "SELECT MAX(idInscrit),nom FROM inscription"; 
            $query = $c->prepare($requete); 
            $query->execute();
            $maxId = $query->fetch(PDO::FETCH_ASSOC);
            $idPersonne = 1+$maxId['MAX(idInscrit)'];
            //verifier l'unicite du pseudo
            $personne = new PersonneInscrit($c);
            $exist=$personne->verifExistence($pseudo);
            //si le pseudo est deja dans la base de donnee
            if($exist==-1){
                echo "<center><h2>Pseudo existant, veuillez en choisir un autre</h2></center><br>";
            //si le pseudo n'existe pas
            }else{
                //ajout du nouveau inscrit
                $personne->addInscrit($idPersonne,$nom,$prenom,$password,$statut,$pseudo);
                echo "<center><h2>Merci pour votre inscription</h2></center><br>";
            }
        }
        //si un des champs est vide
        elseif(!empty($_POST['pseudo']) or !empty($_POST['nom']) or !empty($_POST['prenom']) or !empty($_POST['password']) or !empty($_POST['statut'])) {
            echo "<center><h2>Erreur de saisie : un des champs est vide</h2></center><br>";
        }
        
        //construction et appel du gabarit
        $ins = new RequeteInscription("Renseignez vos informations pour votre inscription");
        $ins->showInscription();
    }catch(PDOException $e){
        die ('Erreur : '.$e->getMessage());
    }
?>