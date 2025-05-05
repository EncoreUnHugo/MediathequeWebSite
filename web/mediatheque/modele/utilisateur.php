<?php

    require_once("modele/modele.php");

    class Utilisateur extends Modele{


        protected $id;
        protected $mail;
        protected $tel;
        protected $mdp;
        protected $numCategorie;

        public function isAdmin(){return $this->numCategorie == 5;}

        public static function checkMDP($ml,$md){
            $requete_prep = "SELECT * FROM Emprunteur WHERE mail = :tag_ml AND mdp = :tag_md";
            $req_prep = Connexion::pdo()->prepare($requete_prep);
            $val = array(
                ":tag_ml" => $ml,
                ":tag_md" => $md
            ); 
            try {
                $req_prep-> execute($val);
            } catch(PDOException $e) {
                echo $e ->getMessage();
            }
            $req_prep->setFetchmode(PDO::FETCH_CLASS,"Emprunteur");
            $tabEmprunteur = $req_prep->fetchall();
            if(sizeof($tabEmprunteur) == 1)
                return true;
            else   
                return false;
        }

}