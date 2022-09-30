<?php // hebergement.client.class.php
// Modèle pour les clients

    //classe avec la fonction d'affichage du gabarit de la liste des hebergements dans la BDD
	class RequeteHebergementClient{
		protected $pdo;		// Identifiant de connexion
	    protected $nom;		// Nom du titre
        protected $donnee;	// Résultat de la requête

        function __construct($p_donnee, $nomT) {
            $this->donnee = $p_donnee;
            $this->nom=$nomT;
		}

		// Fonction d'affichage du gabarit
		public function showHebergement(){
			$gab = new Template("./");
			$gab->set_filenames(array("body" => "vue/hebergement.client.tpl.html"));
			// Titre de la table (légende)
			$gab->assign_vars(array("nom" => $this->nom));
			// Chargement des données
			// boucle pour <tr>
           foreach ($this->donnee as $ligne) { 
                $gab->assign_block_vars("ligne", array("idHebergement" => $ligne["idHebergement"]));
                // boucle pour <td>
                foreach($ligne as $val) {
                    $gab->assign_block_vars("ligne.attribut", array("valeur" => $val));
                }
            }
            //variable pour faire des reservations
            $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            // Affichage du gabarit
        	$gab->pparse("body");
		}

        // Fonction d'affichage du gabarit
        public function showHebergementAdmin(){
            $gab = new Template("./");
            $gab->set_filenames(array("body" => "vue/hebergement.admin.tpl.html"));
            // Titre de la table (légende)
            $gab->assign_vars(array("nom" => $this->nom));
            // Chargement des données
            // boucle pour <tr>
           foreach ($this->donnee as $ligne) { 
                $gab->assign_block_vars("ligne", array("idHebergement" => $ligne["idHebergement"]));
                // boucle pour <td>
                foreach($ligne as $val) {
                    $gab->assign_block_vars("ligne.attribut", array("valeur" => $val));
                }
            }
            //variable pour faire des reservations
            $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            // Affichage du gabarit
            $gab->pparse("body");
        }
	}

    //classe avec les fonction de manipulation de la BDD
    class AccessHebergementClient{
        private $pdo;
        private $heb;

        function __construct($p_pdo) {
            $this->pdo = $p_pdo;
        }
        //liste les hebergements de la BDD qui sont disponibles 
        public function getHebergementDispo() {
            $this->heb = $this->pdo->prepare("SELECT idHebergement, nom, type, adresse, prix, etoile FROM hebergement where disponibilite = True");
            $this->heb->execute();
            $this->donnee = $this->heb->fetchAll(PDO::FETCH_ASSOC);
            $heber = new RequeteHebergementClient($this->donnee, "Liste des hébergements disponibles");
            $heber->showHebergement();
        }

        //liste tous les hebergements de la BDD
        public function getHebergement() {
            $this->heb = $this->pdo->prepare("SELECT idHebergement, nom, type, adresse, prix, etoile, if(disponibilite, 'Disnponible', 'Indisponible') FROM hebergement");
            $this->heb->execute();
            $this->donnee = $this->heb->fetchAll(PDO::FETCH_ASSOC);
            $heber = new RequeteHebergementClient($this->donnee, "Liste des hébergements");
            $heber->showHebergementAdmin();
        }

        //ajoute une reservation dans la BDD
        public function addReservation($idRes, $idCli, $idProp, $idHeb) {
            $result = $this->pdo->prepare("INSERT INTO reservationheb VALUES(?, ?, ?, ?)");
            $result->execute([$idRes, $idCli, $idProp, $idHeb]);
        }
        //change la disponibilite a False d'un hebergement selectionné dans la BDD
        public function updateDispoFalse($idH) {
            $result = $this->pdo->prepare("UPDATE hebergement SET disponibilite = False WHERE idHebergement = ? ");
            $result->execute([$idH]);
        }

    }
 ?>