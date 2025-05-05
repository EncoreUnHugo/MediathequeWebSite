<?php

require_once("modele/livre.php");
require_once("modele/modele.php");
require_once("modele/album.php");
require_once("modele/film.php");

    class ControleurAcceuil {

        public function afficherAcceuil(){

            include("vue/debut/debutAcc.html");

            include("vue/nav.html");

            include("vue/acceuil.html");

            include("vue/fin.html");

        }

        public function afficherRechercheGeneral(){

            $key = "Livre";
            $author = "Auteur";

            $titre = "Recherche";

            $Livre = "Livre";
            $Film = "Film";
            $Album = "Album";

            include("vue/debut/debutGen.php");

            include("vue/nav.html");

            include("vue/recherche.html");

            ?>

            <h2 class ="title">Résultat pour :  <?php echo $_GET["recherche"] ?></h2>
            
            <?php 

            $recherche = "";
            if(isset($_GET["recherche"]))$recherche = $_GET["recherche"];

            $tableau = Modele::researchAll($recherche);
            if($tableau == null){
                ?>
                <h2 class="erreur"> La recherche souhaitée n'est pas disponible </h2>
                <?php
            }else
                include("vue/affichage/lesRecherches.php");
            
            include("vue/fin.html");

        }

        public function lireNouveaute(){

            $key = "Livre";
            $author = "Auteur";

            $titre = "Nouveauté";

            $Livre = "Livre";
            $Film = "Film";
            $Album = "Album";

            include("vue/debut/debutGen.php");

            include("vue/nav.html");

            include("vue/recherche.html");

            ?>

            <h2 class ="title">Nouveautés</h2>

            <?php

            $tableau = Modele::getNouveaute();

            include("vue/affichage/lesObjets.php");

            include("vue/fin.html");

        }
    
    }
?>