<?php

    require_once("modele/modele.php");

    class EmpruntRetour extends Modele{

        protected $titreLivre;
        protected $dateEmprunt;
        protected $dateRetour;

        public static function getHistorique($m){
            $requeteL = "SELECT numLivre, titreLivre, dateEmprunt, dateRetour FROM Livre NATURAL JOIN ExemplaireLivre NATURAL JOIN EmpruntLivre WHERE mail = :tag_mail;";
            $requeteF = "SELECT numFilm, titreFilm, dateEmprunt, dateRetour FROM Film NATURAL JOIN ExemplaireFilm NATURAL JOIN EmpruntFilm WHERE mail = :tag_mail;";
            $requeteA = "SELECT numAlbum, titreAlbum, dateEmprunt, dateRetour FROM Album NATURAL JOIN ExemplaireAlbum NATURAL JOIN EmpruntAlbum WHERE mail = :tag_mail;";
            
            $req_prepL = Connexion::pdo()->prepare($requeteL);
            $req_prepF = Connexion::pdo()->prepare($requeteF);
            $req_prepA = Connexion::pdo()->prepare($requeteA);
            
            $val1 = array(
                ":tag_mail" => $m
            );
            try {
                $req_prepL -> execute($val1);
                $req_prepF -> execute($val1);
                $req_prepA -> execute($val1);

            } catch(PDOException $e) {
                echo $e ->getMessage();
            }
            $req_prepL ->setFetchmode(PDO::FETCH_CLASS,"Livre");
            $req_prepF ->setFetchmode(PDO::FETCH_CLASS,"Film");
            $req_prepA ->setFetchmode(PDO::FETCH_CLASS,"Album");

            $tabL = $req_prepL->FetchAll();
            $tabF = $req_prepF->FetchAll();
            $tabA = $req_prepA->FetchAll();

            $tab = array_merge($tabL,$tabF,$tabA);


            return $tab;
        }

        public function getRetour($m){
            $requeteL = "SELECT titreLivre, dateRetour, urlCouverture FROM Livre L NATURAL JOIN ExemplaireLivre EX INNER JOIN EmpruntLivre EM ON EX.numexemplaire = EM.numexemplaire INNER JOIN RetourLivre R ON EX.numexemplaire = R.numexemplaire WHERE EM.mail = :tag_mail AND dateRendu IS NULL;";
            $requeteF = "SELECT titreFilm, dateRetour, urlCouverture FROM Film L NATURAL JOIN ExemplaireFilm EX INNER JOIN EmpruntFilm EM ON EX.numexemplaire = EM.numexemplaire INNER JOIN RetourFilm R ON EX.numexemplaire = R.numexemplaire WHERE EM.mail = :tag_mail AND dateRendu IS NULL;";
            $requeteA = "SELECT titreAlbum, dateRetour, urlCouverture FROM Album L NATURAL JOIN ExemplaireAlbum EX INNER JOIN EmpruntAlbum EM ON EX.numexemplaire = EM.numexemplaire INNER JOIN RetourAlbum R ON EX.numexemplaire = R.numexemplaire WHERE EM.mail = :tag_mail AND dateRendu IS NULL;";
            $req_prepL = Connexion::pdo()->prepare($requeteL);
            $req_prepF = Connexion::pdo()->prepare($requeteF);
            $req_prepA = Connexion::pdo()->prepare($requeteA);
        
            $val = array(
                ":tag_mail" => $m
            );
            try {
                $req_prepL -> execute($val);
                $req_prepF -> execute($val);
                $req_prepA -> execute($val);

            } catch(PDOException $e) {
                echo $e ->getMessage();
            }

            $req_prepL ->setFetchmode(PDO::FETCH_CLASS,"Livre");
            $req_prepF ->setFetchmode(PDO::FETCH_CLASS,"Film");
            $req_prepA ->setFetchmode(PDO::FETCH_CLASS,"Album");
            $tabL = $req_prepL->FetchAll();
            $tabF = $req_prepL->FetchAll();
            $tabA = $req_prepL->FetchAll();

            $tab = array_merge($tabL,$tabF,$tabA);
            return $tab;
        }

        public static function getResa($m){
            $requeteL = "SELECT titreLivre, dateEmprunt, urlCouverture FROM Livre L NATURAL JOIN ExemplaireLivre EX INNER JOIN EmpruntLivre EM ON EX.numexemplaire = EM.numexemplaire INNER JOIN RetourLivre R ON EX.numexemplaire = R.numexemplaire WHERE EM.mail = :tag_mail AND dateEmprunt>NOW();";
            $requeteF = "SELECT titreFilm, dateEmprunt, urlCouverture FROM Film L NATURAL JOIN ExemplaireFilm EX INNER JOIN EmpruntFilm EM ON EX.numexemplaire = EM.numexemplaire INNER JOIN RetourFilm R ON EX.numexemplaire = R.numexemplaire WHERE EM.mail = :tag_mail AND dateEmprunt>NOW();";
            $requeteA = "SELECT titreAlbum, dateEmprunt, urlCouverture FROM Album L NATURAL JOIN ExemplaireAlbum EX INNER JOIN EmpruntAlbum EM ON EX.numexemplaire = EM.numexemplaire INNER JOIN RetourAlbum R ON EX.numexemplaire = R.numexemplaire WHERE EM.mail = :tag_mail AND dateEmprunt>NOW();";
            $req_prepL = Connexion::pdo()->prepare($requeteL);
            $req_prepF = Connexion::pdo()->prepare($requeteF);
            $req_prepA = Connexion::pdo()->prepare($requeteA);
        
            $val = array(
                ":tag_mail" => $m
            );
            try {
                $req_prepL -> execute($val);
                $req_prepF -> execute($val);
                $req_prepA -> execute($val);

            } catch(PDOException $e) {
                echo $e ->getMessage();
            }

            $req_prepL ->setFetchmode(PDO::FETCH_CLASS,"Livre");
            $req_prepF ->setFetchmode(PDO::FETCH_CLASS,"Film");
            $req_prepA ->setFetchmode(PDO::FETCH_CLASS,"Album");
            $tabL = $req_prepL->FetchAll();
            $tabF = $req_prepL->FetchAll();
            $tabA = $req_prepL->FetchAll();

            $tab = array_merge($tabL,$tabF,$tabA);
            return $tab;
        }

        public static function afficherResa($val){

            ?>

                <div class="cover">
                    <img src="<?php echo $val["2"] ?>" alt="" class="couvertureMult">
                </div>

                <div class="textMult">
    
                    <h2><?php echo $val["0"] ?></h2>
                    <p>A récupérer pour le <?php echo $val["1"] ?></p>

                </div>

            <?php
        } 

        public static function afficherRetour($val){

            ?>

            <div class="multiples">

                <div class="cover">
                    <img src="<?php echo $val["2"] ?>" alt="" class="couvertureMult">
                </div>

                <div class="textMult">
                    <h2><?php echo $val["0"] ?></h2>
                    <p>A rendre pour le <?php echo $val["1"] ?></p>
                </div> 

            </div>

            <?php

        }

        public static function afficherHistorique($val){

            if(array_key_first($val)=="numLivre"){
                $ctrl = "Livre";
            }elseif(array_key_first($val)=="numFilm"){
                $ctrl = "Film";
            }elseif(array_key_first($val)=="numAlbum"){
                $ctrl = "Album";
            }

            ?>
            <li>
                <a href="index.php?controleur=controleur<?php echo $ctrl ?>&action=lireUnObjet&num<?php echo $ctrl ?>=<?php echo $val["0"] ?>"><?php echo $val["1"] ?> </a>
                <p><?php echo $val["2"] ?> - <?php echo $val["3"] ?></p>
            </li>
            <?php

        }
    }

?>



