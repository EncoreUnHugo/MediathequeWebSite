<?php

class ControleurUtilisateur{

  public static function afficherFormulaireConnexion() {

    include("vue/formulaireConnexion.html");
  }

  public static function connecterUtilisateur() {
    $m = $_GET["mail"];
    $mdp = $_GET["mdp"];
    if (Utilisateur::checkMDP($m,$mdp) && Utilisateur::isAdmin()) {
        $_SESSION["mail"] = $m;
        include("vue/inscription.html");
    } else {
        self::afficherFormulaireConnexion();
    }
}

}