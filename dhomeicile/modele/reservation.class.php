<?php //reservation.class.php
// Modèle pour les propriétaires
    require("reservation.client.class.php");

    class RequeteReservation extends RequeteReservationClient{

        public function showReservation(){
            $gab = new Template("./");
            $gab->set_filenames(array("body" => "vue/reservation.tpl.html"));
            // Titre de la table (légende)
            $gab->assign_vars(array("nom" => $this->nom));

            // Chargement des données
            // boucle pour <tr>
            foreach ($this->donnee as $ligne) { 
                $gab->assign_block_vars("ligne", array("idReservation" => $ligne["ID Reservation"]));
                // boucle pour <td>
                foreach($ligne as $val) {
                    $gab->assign_block_vars("ligne.attribut",
                                            array("valeur" => $val));
                }
            }
        
            // Variable cible
            // Pour variable supprimmer
            $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
            // Affichage du gabarit
            $gab->pparse("body");
        }
    }

    class AccessReservation extends AccessReservationClient{

        function __construct($p_pdo) {
            $this->pdo = $p_pdo;
        }
        //liste les hebergement reservé de la BDD en fonction de l'ID du proprietaire connecté
        public function getReservationByIdProp($idG) {
            $this->res = $this->pdo->prepare("SELECT r.idReservation as 'ID Reservation', h.nom as 'Nom de l\'hébergement', i.nom as 'Nom du client ', i.prenom as 'Prénom du client' FROM hebergement h, inscription i, reservationheb r where r.idHebergement = h.idHebergement and r.idClient = i.idInscrit and r.idProprietaire = $idG");
            $this->res->execute();
            $this->donnee = $this->res->fetchAll(PDO::FETCH_ASSOC);
            $heber = new RequeteReservation($this->donnee, "liste de vos hébergements réservés");
            $heber->showReservation();
        } 
        //supprime une reservation selectionné dans la BDD
        public function deleteReservation($idR) {
            $result = $this->pdo->prepare("DELETE FROM reservationheb WHERE idReservation = ?");
            $result->execute([$idR]);
        }
        //change la disponibilite a True d'un hebergement selectionneé dans la BDD
        public function updateDispoTrue($idH) {
            $result = $this->pdo->prepare("UPDATE hebergement SET disponibilite = True WHERE idHebergement = ? ");
            $result->execute([$idH]);
        }

    }
 ?>