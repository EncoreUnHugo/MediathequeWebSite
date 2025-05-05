<?php

class ControleurTravail {

    public function afficherTravail(){

        $titre = "Travail";

        include("vue/debut/debutVy.php");

        include("vue/nav.html");

        include("vue/travail.html");

        include("vue/fin.html");

    }


}