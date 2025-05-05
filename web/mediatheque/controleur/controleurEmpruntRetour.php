<?php

require_once("modele/empruntRetour.php");

class ControleurEmpruntRetour {

    public function afficherEmpRet(){

        include("vue/debut/debutEmpRet.html");

        include("vue/nav.html");

        include("vue/empruntRetour/empRet.html");

        $resa = EmpruntRetour::getResa($_SESSION["mail"]);

        include("vue/affichage/uneResa.php");

        include("vue/empruntRetour/entreResaEtRet.html");

        $ret = EmpruntRetour::getRetour($_SESSION["mail"]);

        include("vue/affichage/unRetour.php");

        include("vue/empruntRetour/debHist.html");

        $htr = EmpruntRetour::getHistorique($_SESSION["mail"]);

        include("vue/affichage/unHistorique.php");

        include("vue/empruntRetour/fin.html");

        include("vue/fin.html");

    }

    public function afficherEmptRetPasConnecter(){

        include("vue/debut/debutEmpRet.html");

        include("vue/nav.html");

        ?>

        <h2 class="erreur"> Les Emprunts et Retours ne sont pas disponible si vous n'êtes pas connecté </h2>

        <?php

        include("vue/fin.html");
        

    }


}