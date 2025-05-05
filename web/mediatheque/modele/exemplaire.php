<?php

    require_once("modele/modele.php");

   class Exemplaire extends Modele{

        protected $libelleEditeur;

        public function afficherNb($val){
            if($val->nbEx > 1)
                echo $val->nbEx . " exemplaires disponibles";
            else
                echo $val->nbEx . " exemplaire disponible";
        }

        public function afficherLangue($val){
            echo ucfirst($val->langue) . " ";
        }

        public function afficherEditeur($val){
            echo $val->libelleEditeur ." &nbsp ";
        }

   }

?>