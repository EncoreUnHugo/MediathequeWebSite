<?php

class Modele{

    protected $attribut,$valeur;
    protected $donnees;
    protected static $objet;
    
    public function get($attribut){
        return $this->$attribut;
    }
        
    public function set($attribut,$valeur){
        $this->$attribut = $valeur;
        $this->$valeur = $attribut;
    }

    public function __construct($donnees = NULL){
        if(!is_null($donnees)){
            foreach($donnees as $attribut-> $valeur){
                $this -> set($attribut,$valeur);    
            }
        }
    }
    
    public static function getAll(){
        $table = static::$objet;
        $title = static::$titre;
        $requete = "SELECT * FROM $table ORDER BY $title;";
        $resultat = Connexion::pdo()->query($requete);
        $resultat->setFetchmode(PDO::FETCH_CLASS,"$table");
        $tableau = $resultat->fetchAll();
        return $tableau;
    }

    public static function getObjetById($i){
        $key = static::$cle;
        $table = static::$objet;
        $requete_prep_user = "SELECT * FROM $table WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->FetchAll();
    }

    public static function getResearch($recherche){
        $table = static::$objet;
        $title = static::$titre;
        $author = static::$auteur;
        $key = static::$cle;
        $reqRechercheTitre = "SELECT * FROM $table WHERE INSTR(titre$table,'$recherche') != 0";
        $reqRechercheCreateur ="SELECT * FROM $table  T INNER JOIN $author A ON A.$key = T.$key INNER JOIN Individu I ON I.numIndividu = A.numIndividu WHERE INSTR(I.nom,'$recherche') != 0";
        $valeursT = array();
        $valeursC = array();

        $req_prepT = Connexion::pdo()->prepare($reqRechercheTitre);
        $req_prepC = Connexion::pdo()->prepare($reqRechercheCreateur);
        try {
            $req_prepT-> execute($valeursT);
            $req_prepT->setFetchmode(PDO::FETCH_CLASS,"$table");
            $tableauT = $req_prepT->fetchAll();

            $req_prepC-> execute($valeursC);
            $req_prepC->setFetchmode(PDO::FETCH_CLASS,"$table");
            $tableauC = $req_prepC->fetchAll();

            $tableau = $tableauT + $tableauC;
            return $tableau;

        } catch(PDOException $e) {
            return null;
        }
    }

    public static function getResearchFilm($recherche){
        $table = static::$objet;
        $reqRechercheTitre = "SELECT * FROM $table WHERE INSTR(titre$table,'$recherche') != 0";
        $reqRechercheCreateur ="SELECT * FROM $table F INNER JOIN Individu I ON I.numIndividu = F.realisateur WHERE INSTR(I.nom,'$recherche') != 0";
        $valeursT = array();
        $valeursC = array();

        $req_prepT = Connexion::pdo()->prepare($reqRechercheTitre);
        $req_prepC = Connexion::pdo()->prepare($reqRechercheCreateur);
        try {
            $req_prepT-> execute($valeursT);
            $req_prepT->setFetchmode(PDO::FETCH_CLASS,"$table");
            $tableauT = $req_prepT->fetchAll();

            $req_prepC-> execute($valeursC);
            $req_prepC->setFetchmode(PDO::FETCH_CLASS,"$table");
            $tableauC = $req_prepC->fetchAll();

            $tableau = $tableauT + $tableauC;
            return $tableau;

        } catch(PDOException $e) {
            return null;
        }
    }

    public static function researchAll($recherche){
        $reqRechercheTitreLivre = "SELECT * FROM Livre WHERE INSTR(titreLivre,'$recherche') != 0";
        $reqRechercheTitreFilm = "SELECT * FROM Film WHERE INSTR(titreFilm,'$recherche') != 0";
        $reqRechercheTitreAlbum = "SELECT * FROM Album WHERE INSTR(titreAlbum,'$recherche') != 0";

        $valeursL = array();
        $valeursF = array();
        $valeursA = array();

        $req_prepL = Connexion::pdo()->prepare($reqRechercheTitreLivre);
        $req_prepF = Connexion::pdo()->prepare($reqRechercheTitreFilm);
        $req_prepA = Connexion::pdo()->prepare($reqRechercheTitreAlbum);
        try {
            $req_prepL-> execute($valeursL);
            $req_prepL->setFetchmode(PDO::FETCH_CLASS,"Livre");
            $tableauL = $req_prepL->fetchAll();

            $req_prepF-> execute($valeursF);
            $req_prepF->setFetchmode(PDO::FETCH_CLASS,"Film");
            $tableauF = $req_prepF->fetchAll();

            $req_prepA-> execute($valeursA);
            $req_prepA->setFetchmode(PDO::FETCH_CLASS,"Album");
            $tableauA = $req_prepA->fetchAll();

            $tableau = array_merge($tableauL,$tableauF,$tableauA);
            return $tableau;

        } catch(PDOException $e) {
            return null;
        }
    }

    public static function getNouveaute(){

        $requeteL = "SELECT * FROM Livre INNER JOIN ExemplaireLivre ON Livre.numLivre = ExemplaireLivre.numLivre ORDER BY ABS(DATEDIFF(NOW(), ExemplaireLivre.dateAjout)) LIMIT 4;";
        $requeteF = "SELECT * FROM Film INNER JOIN ExemplaireFilm ON Film.numFilm = ExemplaireFilm.numFilm ORDER BY ABS(DATEDIFF(NOW(), ExemplaireFilm.dateAjout)) LIMIT 3;";
        $requeteA = "SELECT * FROM Album INNER JOIN ExemplaireAlbum ON Album.numAlbum = ExemplaireAlbum.numAlbum ORDER BY ABS(DATEDIFF(NOW(), ExemplaireAlbum.dateAjout)) LIMIT 3;";
        
        $resultatL = Connexion::pdo()->query($requeteL);
        $resultatF = Connexion::pdo()->query($requeteF);
        $resultatA = Connexion::pdo()->query($requeteA);

        $resultatL->setFetchmode(PDO::FETCH_CLASS,"Livre");
        $resultatF->setFetchmode(PDO::FETCH_CLASS,"Film");
        $resultatA->setFetchmode(PDO::FETCH_CLASS,"Album");
        
        $tableauL = $resultatL->fetchAll();
        $tableauF = $resultatF->fetchAll();
        $tableauA = $resultatA->fetchAll();

        $tableau = array_merge($tableauA,$tableauF,$tableauL);
        return $tableau;
    }

    public static function getCreateur($i){
        $key = static::$cle;
        $author = static::$auteur;
        $table = static::$objet;
        $requete_prep_user = "SELECT nom,prenom FROM $author NATURAL JOIN Individu WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->FetchAll();
    }

    public static function getReal($i){
        $key = static::$cle;
        $table = static::$objet;
        $requete_prep_user = "SELECT nom,prenom FROM $table INNER JOIN Individu i ON realisateur = i.numIndividu WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->FetchAll();
    }

    public static function getNbExemplaires($i){
        $key = static::$cle;
        $table = static::$objet;
        $requete_prep_user = "SELECT COUNT(numExemplaire) as nbEx FROM Exemplaire$table WHERE $key = :tag_$key AND empruntable=1 ";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->fetchAll();
    }

    public static function getLangues($i){
        $key = static::$cle;
        $table = static::$objet;
        $requete_prep_user = "SELECT DISTINCT(langue) FROM Exemplaire$table WHERE $key = :tag_$key AND empruntable=1 ";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->fetchAll();
    }

    public static function getEditeur($i){
        $key = static::$cle;
        $table = static::$objet;
        $requete_prep_user = "SELECT DISTINCT(libelleEditeur) FROM ExemplaireLivre NATURAL JOIN Edition NATURAL JOIN Editeur WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->fetchAll();
    }

    public static function getGenre($i){
        $key = static::$cle;
        $table = static::$objet;
        $genre = static::$M;
        $requete_prep_user = "SELECT libelle FROM Genre$genre NATURAL JOIN Genre$table WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->FetchAll();
    }

    public static function getTypeLivre($i){
        $key = static::$cle;
        $table = static::$objet;
        $genre = static::$M;
        $requete_prep_user = "SELECT libelleType FROM Type NATURAL JOIN $table WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $i
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"$table");
        return $req_prep->FetchAll();
    }

    public static function getNbPoints($m){
        $key = static::$cle;
        $requete_prep_user = "SELECT points FROM Carte NATURAL JOIN Emprunteur WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $m
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"Emprunteur");
        return $req_prep->FetchAll();
    }

    public static function getNom($m){
        $key = static::$cle;
        $requete_prep_user = "SELECT nom FROM Individu NATURAL JOIN Emprunteur WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $m
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"Emprunteur");
        return $req_prep->FetchAll();
    }

    public static function getPrenom($m){
        $key = static::$cle;
        $requete_prep_user = "SELECT prenom FROM Individu NATURAL JOIN Emprunteur WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $m
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"Emprunteur");
        return $req_prep->FetchAll();
    }

    public static function getCategorie($m){
        $key = static::$cle;
        $requete_prep_user = "SELECT libelleCategorie FROM Categorie NATURAL JOIN Emprunteur WHERE $key = :tag_$key";
        $req_prep = Connexion::pdo()->prepare($requete_prep_user);
        $val = array(
            ":tag_$key" => $m
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"Emprunteur");
        return $req_prep->FetchAll();
    }

    public static function deleteEmprunteur($m){
        $requete_prep_m = "DELETE FROM Emprunteur WHERE mail = :tag_mail";
        $req_prep = Connexion::pdo()->prepare($requete_prep_m);
        $val = array(
            ":tag_mail" => $m
        ); 
        try {
            $req_prep-> execute($val);
        } catch(PDOException $e) {
            echo $e ->getMessage();
        }
        $req_prep->setFetchmode(PDO::FETCH_CLASS,"Emprunteur");
        return $req_prep->FetchAll();
    }
    

}

?>
