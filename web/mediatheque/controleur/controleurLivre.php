<?php

    require_once("controleur/controleur.php");

    class ControleurLivre extends Controleur{

        protected static $objet = "livres";
        protected static $cle = "Livre";
        protected static $info = "numLivre";
        protected static $auteur = "Auteur";
        protected static $deb = "Gen.php";

    }
?>