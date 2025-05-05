<?php

    require_once("controleur/controleur.php");

    class ControleurFilm extends Controleur{

        protected static $objet = "films";
        protected static $cle = "Film";
        protected static $info = "numFilm";
        protected static $auteur = "Réalisateur";
        protected static $deb = "Gen.php";

    }
?>