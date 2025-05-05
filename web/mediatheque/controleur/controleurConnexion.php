<?php

require_once("controleur/controleur.php");
require_once("controleur/controleurAcceuil.php");
require_once("controleur/controleurEmprunteur.php");
require_once("modele/utilisateur.php");


    class ControleurConnexion extends Controleur{

        public function afficherConnexion(){

            include("vue/debut/debutCon.html");

            include("vue/connexion.html");

        }

        public function creerEmprunteur(){
            
            $n = $_POST["nom"];
            $p = $_POST["prenom"];
            $m = $_POST["mail"];
            $t = $_POST["tel"];
            $nc = $_POST["numCategorie"];
            $mdp1 = $_POST["mdp1"];

            $C = Carte::creerCarte();

            $I = Individu::creerIndividu($n,$p);

            $E = Emprunteur::addEmprunteur($n,$p,$m,$t,$nc,$mdp1);

            if($E)
                self::afficherConnexion();
            else {
                ControleurAcceuil::afficherAcceuil();
            }
        }

        public static function connecterConnexion(){
            $titre = "connexion Utilisateur";
            $ml = $_POST["mail"];
            $md = $_POST["mdp"];
            if(Utilisateur::checkMDP($ml,$md)){
                $_SESSION["mail"] = $ml;
                //$obj = Livre::getObjetById("1");
                //$_SESSION["isAdmin"] = $obj->isAdmin();
                ControleurEmprunteur::lireUnObjet($_SESSION["mail"]);
            } else {
                self::afficherConnexion();
            }

        }

        public static function deconnecterConnexion(){
            session_unset();
            session_destroy();
            setcookie(session_name(),' ', time()-1);
            self::afficherConnexion();
        }
    }
?>