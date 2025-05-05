<?php
class Utilisateur{

	protected $mail;
	protected $mdp;
	protected $numCategorie;

    public function isAdmin() {return $this->numCategorie == 5;}

    public static function checkMDP($m,$mdp) {
		$requetePreparee = "SELECT * FROM Emprunteur WHERE mail = :m_tag and mdp = :mdp_tag;";
		$req_prep = connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"m_tag" => $m,
			"mdp_tag" => $mdp
		);
		$req_prep->execute($valeurs);
		$req_prep->setFetchMode(PDO::FETCH_CLASS,"Emprunteur");
		$tabUtilisateurs = $req_prep->fetchAll();
		if (sizeof($tabUtilisateurs) == 1)
			return true;
		else
			return false;
	}

}