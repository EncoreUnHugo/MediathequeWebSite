<?php

    require_once("modele/modele.php");

   class Carte extends Modele{

        protected $numCarte;
        protected $points;

        public function afficherPoints($val){
            echo "Carte : " . $val->points . " pts";
        }

        public function creerCarte(){
            $requete1 = "SELECT MAX(numCarte) FROM Emprunteur;";
            $resultat1=connexion::pdo()->query($requete1);
            $maxNumCarte = $resultat1->fetchColumn();
            $numCarte=$maxNumCarte+1;

            $requete = "INSERT INTO Carte(numCarte,points) VALUES ($numCarte,20)";

            try{
                Connexion::pdo()->query($requete);
            }catch(PDOException $e) {
				echo $e->getMessage();
			}
        }

   }

?>