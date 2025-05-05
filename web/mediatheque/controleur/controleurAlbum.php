<?php

    require_once("controleur/controleur.php");

    class ControleurAlbum extends Controleur{

        protected static $objet = "albums";
        protected static $cle = "Album";
        protected static $info = "numAlbum";
        protected static $auteur = "Artiste";
        protected static $deb = "Gen.php";

    }
?>