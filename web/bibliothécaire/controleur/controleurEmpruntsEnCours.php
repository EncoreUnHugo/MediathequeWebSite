<?php
require_once("modele/empruntsencours.php");

class ControleurEmpruntsEnCours{
	

	public static function afficherPage(){
	
		$tab_e = EmpruntsEnCours::getEmpruntsEnCours();
		$tabAff = array();
		$tabid = array();
		foreach($tab_e as $e) {
			$mai = $e->getMail();
			$ide = $e->getNumExemplaire();
			$dtr = $e->getDateRetour();
			$tabAff[] = " $ide - $dtr";
			$tabid[] = "$mai";
		}
		include("vue/empruntsencours.html");
		include("vue/lesEmprunts.php");
		include("vue/footerEmpruntsEnCours.html");
	}
	
	public static function lireUnEmprunt() {
		$i = $_GET["mail"];
		$e = EmpruntsEnCours::getUnEmpruntEnCours($i);
		
		include("vue/empruntsencours.html");
		if (!$e)
		  include("vue/affichage/erreur.php");
		else
		  include("vue/infoEmprunt.php");
		include("vue/footerEmpruntsEnCours.html");
  }

}

?>