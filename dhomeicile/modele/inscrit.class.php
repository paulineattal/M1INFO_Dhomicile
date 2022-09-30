<?php //inscrit.class.php
    //classe avec la fonction d'affichage du gabarit du formulaire d'inscription
    class RequeteInscrit{
        protected $pdo;     // Identifiant de connexion
        protected $nom;     // Nom du titre
        protected $donnee;  // Résultat de la requête

        function __construct($p_donnee, $nomT) {
            $this->donnee = $p_donnee;
            $this->nom=$nomT;
        }
        //fonction d'affichage du gabarit de l'onglet inscription
        public function showInscription(){
            $gab = new Template("./");
            $gab->set_filenames(array("body" => "vue/inscrit.tpl.html"));
            // Titre du formulaire
            $gab->assign_vars(array("nom" => $this->nom));
            // Chargement des données
            // boucle pour <tr>
           foreach ($this->donnee as $ligne) { 
                $gab->assign_block_vars("ligne", array("idInscrit" => $ligne["idInscrit"]));
                // boucle pour <td>
                foreach($ligne as $val) {
                    $gab->assign_block_vars("ligne.attribut", array("valeur" => $val));
                }
            }
            // Assignation des valeurs des champs
            $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            // Affichage du gabarit
            $gab->pparse("body");
        }
    }

    //classe avec les fonctions de manipulations de la BDD
    class AccesInscrit{
        private $result;

        function __construct($p_pdo) {
                $this->pdo = $p_pdo;
            }
        //liste les inscrits de la BDD, sauf l'admin
        public function showInscrit(){
            $this->result = $this->pdo->prepare("SELECT * from inscription where role<>'admin'");
            $this->result->execute();
            $this->donnee = $this->result->fetchAll(PDO::FETCH_ASSOC);
            $inscr = new RequeteInscrit($this->donnee, "Liste des inscrits sur le site");
            $inscr->showInscription();
        }
        //supprime un inscrit
        public function deleteInscrit($idIns){
            $this->result = $this->pdo->prepare('DELETE FROM inscription WHERE idInscrit = ?');
            $this->result->execute([$idIns]);
        }
    }
?>