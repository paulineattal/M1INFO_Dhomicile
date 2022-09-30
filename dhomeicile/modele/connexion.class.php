<?php //connexion.class.php
	class RequeteConnexion{
        protected $nom; // Titre de la page

        function __construct($nomT) {
                $this->nom=$nomT;
        }
        //fonction d'affichage du gabarit de l'onglet inscription
        public function showConnexion(){
            $gab = new Template("./");
            $gab->set_filenames(array("body" => "vue/connexion.tpl.html"));
            // Titre du formulaire
            $gab->assign_vars(array("nom" => $this->nom));
            // Assignation des valeurs des champs
            $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            // Affichage du gabarit
            $gab->pparse("body");
        }
    }
?>


