<?php

require_once("controleur/controleur.php");
require_once("controleur/controleurConnexion.php");

class controleurEmprunteur extends controleur{

    protected static $objet = "profils";
    protected static $cle = "Emprunteur";
    protected static $info = "mail";
    protected static $deb = "Prf.html";

    public function supprimerEmprunteur(){

        $suppr = Emprunteur::deleteEmprunteur($_SESSION["mail"]);

        $deco = ControleurConnexion::deconnecterConnexion();
        
    }

}