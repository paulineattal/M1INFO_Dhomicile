<?php // hebergement.class.php
// Modèle pour les propriétaires
	////heritage de la classe RequeteHebergementClient
	require("hebergement.client.class.php");

	//classe avec la fonction d'affichage du gabarit de la liste des hebergements dans la BDD
	class RequeteHebergement extends RequeteHebergementClient{

		//fonction d'affichage du gabarit de l'onglet hebergement
		public function showHebergement(){
			$gab = new Template("./");
			$gab->set_filenames(array("body" => "vue/hebergement.tpl.html"));
			// Titre de la table
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
			// Pour variable supprimmer
	        $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
	        // Affichage du gabarit
	        $gab->pparse("body");
    	}
	}

	//classe avec la fonction d'affichage du gabarit du formulaire de l'ajout d'un hebergement
	class RequeteAjoutHebergement{
		protected $nom;	// Titre de la page

        function __construct($nomT) {
            $this->nom=$nomT;
		}
    	//fonction d'affichage du gabarit de l'onglet ajout hebergement 
    	public function showAjoutHebergement(){
		    $gab = new Template("./");
		    $gab->set_filenames(array("body" => "vue/hebergementform.tpl.html"));
			// Titre du formulaire 
			$gab->assign_vars(array("nom" => $this->nom));
		    // Assignation des valeurs des champs
		    $gab->assign_vars(array("cible" => $_SERVER["PHP_SELF"]));
		    // Affichage du gabarit
		    $gab->pparse("body");
    	}
    }
	
	//classe avec les fonction de manipulation de la BDD
	class AccessHebergement extends AccessHebergementClient{

        function __construct($p_pdo) {
            $this->pdo = $p_pdo;
        }
        //ajoute un hebergement dans la BDD
		public function addHebergement($idHeb, $nom, $type, $adresse, $prix, $etoile, $idProp, $dispo) {
            $result = $this->pdo->prepare("INSERT INTO hebergement(idHebergement, nom, type, adresse, prix, etoile, idGerant, disponibilite ) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $result->execute([$idHeb, $nom, $type, $adresse, $prix, $etoile, $idProp, $dispo]);
		}
		//supprime un hebergement selectionné dans la BDD
		public function deleteHebergement($idH) {
			$result = $this->pdo->prepare("DELETE FROM hebergement WHERE idHebergement = ?");
            $result->execute([$idH]);
		}
		//liste les hebergement de la BDD en fonction de l'ID du proprietaire connecté
		public function getHebergementById($idG) {
			$this->heb = $this->pdo->prepare("SELECT idHebergement, nom, type, adresse, prix, etoile, if(disponibilite, 'Disnponible', 'Indisponible') FROM hebergement where idGerant = ?");
            $this->heb->execute([$idG]);
            $this->donnee = $this->heb->fetchAll(PDO::FETCH_ASSOC);
            $heber = new RequeteHebergement($this->donnee, "liste de vos hébergements disponibles/indisponibles ");
        	$heber->showHebergement();
		}
	}
 ?>