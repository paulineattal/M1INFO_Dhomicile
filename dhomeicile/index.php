<?php // main.php
    
    // Session
    session_start();
    ob_start();
    
    require("./template.class.php");
    //header
    require('./controlleur/header.controlleur.php');

    const DEBUG = true;
    //connexion a la BDD 
    $host = 'localhost';
    $login = 'id16781148_pauline_audrey';
    $password = 'ug{&m%}^]U+Gc7Ue';
    $dbname = 'id16781148_dhomeicile';

    $c = new PDO("mysql:host=$host;dbname=$dbname", $login, $password);
    $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    try{
        //recuperer variable page
        if(isset($_GET['page'])) {
            $page = htmlspecialchars($_GET['page']); 
            //si la page n'existe pas, ouvrir une page vide 404 plutot qu'une erreur php
            if(!is_file("./controlleur/".$_GET['page'].".controlleur.php")){ 
                $page = '404'; 
            }
        }
        else {
            $page = "accueil";
        }
    } 
    catch(PDOException $erreur) {
        echo "<p>Erreur : " . $erreur->getMessage() . "</p>\n";
    }
    //appel controleur de la page active
    require("./controlleur/".$page.".controlleur.php"); 
    
    //footer
    require ("./vue/footer.tpl.html");

?>