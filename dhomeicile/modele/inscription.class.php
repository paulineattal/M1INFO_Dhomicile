<?php //inscription.class.php

    //classe avec la fonction d'affichage du gabarit du formulaire d'inscription
    class RequeteInscription{
        protected $nom; // Titre de la page

        function __construct($nomT) {
                $this->nom=$nomT;
        }
        //fonction d'affichage du gabarit de l'onglet inscription
        public function showInscription(){
            $gab = new Template("./");
            $gab->set_filenames(array("body" => "vue/inscription.tpl.html"));
            // Titre du formulaire
            $gab->assign_vars(array("nom" => $this->nom));
            // Assignation des valeurs des champs
            $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            // Affichage du gabarit
            $gab->pparse("body");
        }
    }

    //classe avec les fonctions de manipulations de la BDD
    class PersonneInscrit{

        function __construct($p_pdo) {
                $this->pdo = $p_pdo;
        }
        //ajoute un personne dans la BDD
        public function addInscrit($idPersonne,$nom,$prenom,$password,$statut,$pseudo){
            $result = $this->pdo->prepare("INSERT INTO inscription(idInscrit, nom, prenom, mdp, role, pseudo ) VALUES(?, ?, ?, ?, ?, ?)");
            $result->execute([$idPersonne,$nom,$prenom,$password,$statut,$pseudo]);
        }
        //retourne -1 si le pseudo n'existe pas, sinon 1
        public function verifExistence($pseudo){
            $query = $this->pdo->prepare('SELECT pseudo,idInscrit FROM inscription WHERE pseudo = ?');
            //res = false si la requete a echoué (ie si il n'y a pas de pseudo = au pseudo passé en parametre)
            $query->execute([$pseudo]);
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            if(empty($res)){
                $verif = 1;
            }else {
               $verif = -1;
            }
        return $verif;
        }
    }
?>