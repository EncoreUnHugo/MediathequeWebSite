<?php
   class EmpruntsEnCours {
		private $mail;
		private $numExemplaire;
		private $dateEmprunt;
		private $dateRetour;


		// getter
		public function getMail() {return $this->mail;}
		public function getNumExemplaire() {return $this->numExemplaire;}
		public function getDateEmprunt() {return $this->dateEmprunt;}
		public function getDateRetour() {return $this->dateRetour;}

		// setter
		public function setMail($m) {$this->mail = $m;}
		public function setNumExemplaire($ne) {$this->numExemplaire = $ne;}
		public function setDateEmprunt($de) {$this->dateEmprunt = $de;}
		public function setDateRetour($dr) {$this->dateRetour = $dr;}
		
		public function __construct($m=NULL, $ne=NULL, $de=NULL, $dr=NULL) {
		if (!is_null($m)) {
			$this->mail = $m;
			$this->numExemplaire = $ne;
			$this->dateEmprunt = $de;
			$this->dateRetour = $dr;
		}
	}
	
		public function afficher() {
			echo "<p class='shrink-0 font_2' style='color: #000000'>mail de emprunteur: $this->mail</p>";
			echo "<p class='shrink-0 font_2' style='color: #000000'>numExemplaire:$this->numExemplaire</p>";
			echo "<p class='shrink-0 font_2' style='color: #000000'>dateEmprunt:$this->dateEmprunt</p>";
			echo "<p class='shrink-0 font_2' style='color: #000000'>dateRetour:$this->dateRetour</p>";
		}

	 public static function getEmpruntsEnCours(){
        $requete1 = "SELECT * FROM EmpruntFilm ";
        $resultat1 = connexion::pdo()->query($requete1);
        $resultat1->setFetchmode(PDO::FETCH_CLASS,'EmpruntsEnCours');
        $tableau1= $resultat1->fetchAll();
		
		$requete2 = "SELECT * FROM EmpruntLivre ";
        $resultat2 = connexion::pdo()->query($requete2);
        $resultat2->setFetchmode(PDO::FETCH_CLASS,'EmpruntsEnCours');
        $tableau2 = $resultat2->fetchAll();
		
		$requete3 = "SELECT * FROM EmpruntAlbum ";
        $resultat3 = connexion::pdo()->query($requete3);
        $resultat3->setFetchmode(PDO::FETCH_CLASS,'EmpruntsEnCours');
        $tableau3 = $resultat3->fetchAll();
		
		$tableau = array_merge($tableau1, $tableau2, $tableau3);
        return $tableau;
		}
		
	public static function getUnEmpruntEnCours($i) {
		$table_names = array("EmpruntFilm", "EmpruntLivre", "EmpruntAlbum");
$e = null;
foreach ($table_names as $table_name) {
    $requetePreparee = "SELECT * FROM ".$table_name." WHERE mail = :login_tag;";
    $req_prep = Connexion::pdo()->prepare($requetePreparee);
    $req_prep->bindParam(":login_tag", $i);
    try {
        $req_prep->execute();
        $req_prep->setFetchmode(PDO::FETCH_CLASS,'EmpruntsEnCours');
        $e = $req_prep->fetch();
        if ($e) {
            break;
        }
    } catch(PDOException $x) {
        echo $x->getMessage();
    }
	}
		return $e;
	}

    }
	

?>