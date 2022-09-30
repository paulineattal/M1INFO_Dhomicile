<?php //header.class.php
    class RequeteGab{
    
        protected $nom;
        protected $gab;
        protected $pseudo;
    
    
        function __construct($nom, $gab){
            $this->nom=$nom;
            $this->gab=$gab;
    
        }
    
        public function showHeadConnexion(){
            $this->gab->set_filenames(array("menu" => "vue/header.connexion.html"));
            // Assignation des valeurs des champs
            $this->gab->assign_vars(array("nom"=>$this->nom));
            $this->gab->assign_vars(array("pseudo"=>$_SESSION['nom']));
            $this->gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            $this->gab->pparse("menu");
        }
    
        public function showHeadDeconnexion(){
            $this->gab->set_filenames(array("menu" => "vue/header.deconnexion.html"));
            // Assignation des valeurs des champs
            $this->gab->assign_vars(array("nom"=>$this->nom));
            $this->gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            $this->gab->pparse("menu");
        }
    
        public function showHeadConnexionAdmin(){
            $this->gab->set_filenames(array("menu" => "vue/header.connexion.admin.html"));
            // Assignation des valeurs des champs
            $this->gab->assign_vars(array("nom"=>$this->nom));
            $this->gab->assign_vars(array("pseudo"=>$_SESSION['nom']));
            $this->gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            $this->gab->pparse("menu");
        }
    }
?>