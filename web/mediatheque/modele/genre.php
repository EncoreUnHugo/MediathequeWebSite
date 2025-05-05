<?php

    require_once("modele/modele.php");

   class Genre extends Modele{

        protected $libelle;
        protected $libelleType;

        public function afficherGenre($val){
            echo $val->libelle ." ";
        }

        public function afficherType($val){
            echo $val->libelleType . " ";
        }

   }

?>