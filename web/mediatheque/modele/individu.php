<?php

    require_once("modele/modele.php");

   class Individu extends Modele{

        protected $numIndividu;
        protected $nom;
        protected $prenom;

        public function afficherIndividu($val){
            if($val->prenom=="NULL")
                echo $val->nom;
            else
                echo $val->prenom . " " . $val->nom . " &nbsp"; 
        }

        public function afficherNom($val){
            echo $val->nom;
        }

        public function afficherPrenom($val){
            echo $val->prenom;
        }

        public function creerIndividu($n,$p){

            $requete2 = "SELECT MAX(numIndividu) FROM Emprunteur;";
            $resultat2=connexion::pdo()->query($requete2);
            $maxNumIndividu = $resultat2->fetchColumn();
            $numIndividu=$maxNumIndividu+1;

            $requete4 = "INSERT INTO Individu (numIndividu,nom,prenom) VALUES (:tag_ni,:tag_n,:tag_p)";

            $req_prep4 = Connexion::pdo()->prepare($requete4);
    
            $valI = array(
                ":tag_ni" => $numIndividu,
                ":tag_n" => $n,
                ":tag_p" => $p
            );  

        try {
            $req_prep4 -> execute($valI);
            return true;
        } catch(PDOException $e) {
            return false;
        }
        }

   }