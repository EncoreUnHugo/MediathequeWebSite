<?php

    require_once("modele/livre.php");
    require_once("modele/modele.php");
    require_once("modele/album.php");
    require_once("modele/film.php");
    require_once("modele/session.php");
    require_once("modele/emprunteur.php");
    
    Class Controleur{
        public static function lireObjets(){

            $obj = static::$objet;
            $key = static::$cle;
            $author = static::$auteur;

            $titre = "Nos " . ucfirst($obj);

            $tableau = $key::getAll("$key");

            include("vue/debut/debutGen.php");

            include("vue/nav.html");

            include("vue/recherche.html");

            ?>

            <h2 class ="title"> <?php echo $titre ?></h2>
            
            <?php 

            include("vue/affichage/lesObjets.php");

            include("vue/fin.html");
        }

        public static function lireUnObjet(){

            $key = static::$cle;
            $inf = static::$info;
            $ut = static::$deb;

            if($key != "Emprunteur"){
                $titre = "Un " . $key;
                $l = $_GET["$inf"];
            } else{
                $l = $_SESSION["mail"];
            }

            $tab = $key::getObjetById($l);

            include("vue/debut/debut$ut");

            include("vue/nav.html");

            if(!$tab){
                include("vue/erreur.php");
                echo $key , $l , " n'existe pas dans la base";
            }
            else
                include("vue/affichage/unObjet.php");

            include("vue/fin.html");
        }

        public static function afficherRecherche(){

            $key = static::$cle;
            $obj = static::$objet;
            $author = static::$auteur;

            $titre = ucfirst($obj);

            include("vue/debut/debutGen.php");

            include("vue/nav.html");

            include("vue/recherche.html");

            ?>

            <h2 class ="title">Résultat pour :  <?php echo $_GET["recherche"] ?></h2>
            
            <?php 
            $recherche = "";
            if(isset($_GET["recherche"]))$recherche = $_GET["recherche"];

            if ($key=="Film"){$tableau = $key::getResearchFilm($recherche);}       
            else{$tableau = $key::getResearch($recherche);}
               
            if($tableau == null){
                ?>
                <h2 class="erreur"> La recherche souhaitée n'est pas disponible </h2>
                <?php
            }
            else
                include("vue/affichage/lesObjets.php");

            include("vue/fin.html");
        }

        
    }

?>