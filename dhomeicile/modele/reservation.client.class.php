<?php //reservation.client.class.php
// Modèle pour les clients

    //classe avec la fonction d'affichage du gabarit de la liste des reservations dans la BDD
	class RequeteReservationClient{
		protected $pdo;		// Identifiant de connexion
	    protected $nom;		// Nom du titre
        protected $donnee;	// Résultat de la requête

        function __construct($p_donnee, $nomT) {
            $this->donnee = $p_donnee;
            $this->nom=$nomT;
		}

		// Fonction d'affichage du gabarit
		public function showReservationClient(){
			$gab = new Template("./");
			$gab->set_filenames(array("body" => "vue/reservation.client.tpl.html"));
			// Titre de la table (légende)
			$gab->assign_vars(array("nom" => $this->nom));
			// Chargement des données
			// boucle pour <tr>
            foreach ($this->donnee as $ligne) {
                $gab->assign_block_vars("ligne", array("idReservation" => $ligne["idReservation"]));
                    // boucle pour <td>
                    foreach($ligne as $val) {
                        $gab->assign_block_vars("ligne.attribut", array("valeur" => $val));
                    }
            }
            //variable pour supprimmer
            $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            // Affichage du gabarit
            $gab->pparse("body");
		}
	}

    //classe avec les fonction de manipulation de la BDD
    class AccessReservationClient{
        private $pdo;
        private $res;

        function __construct($p_pdo) {
            $this->pdo = $p_pdo;
        }
        //liste les hebergements reservés de la BDD en fonction de l'ID du client connecté
        public function getReservationByIdCli($idC) {
            $this->res = $this->pdo->prepare("SELECT r.idReservation , h.nom , h.adresse , h.type FROM hebergement h, inscription i, reservationheb r where r.idHebergement = h.idHebergement and r.idClient = i.idInscrit and r.idClient = ?");
            $this->res->execute([$idC]);
            $this->donnee = $this->res->fetchAll(PDO::FETCH_ASSOC);
            $heber = new RequeteReservationClient($this->donnee, "Liste de vos hébergements réservés");
            $heber->showReservationClient();
        } 
        //liste tous les hebergements reservé de la BDD
        public function getReservation() {
            $this->res = $this->pdo->prepare("SELECT r.idReservation , h.nom , h.adresse , h.type FROM hebergement h, reservationheb r where r.idHebergement = h.idHebergement");
            $this->res->execute();
            $this->donnee = $this->res->fetchAll(PDO::FETCH_ASSOC);
            $heber = new RequeteReservationClient($this->donnee, "Liste des hébergements réservés");
            $heber->showReservationClient();
        }
        //supprime une reservation selectionné dans la BDD
        public function deleteReservation($idR) {
            $result = $this->pdo->prepare("DELETE FROM reservationheb WHERE idReservation = ?");
            $result->execute([$idR]);
        }
        //change la disponibilite a True d'un hebergement selectionné dans la BDD
        public function updateDispoTrue($idH) {
            $result = $this->pdo->prepare("UPDATE hebergement SET disponibilite = True WHERE idHebergement = ? ");
            $result->execute([$idH]);
        }
        //change la disponibilite a False d'un hebergement selectionné dans la BDD
        public function updateDispoFalse($idH) {
            $result = $this->pdo->prepare("UPDATE hebergement SET disponibilite = False WHERE idHebergement = ? ");
            $result->execute([$idH]);
        }
    }
 ?>