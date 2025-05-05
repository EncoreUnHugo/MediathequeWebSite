<?php
require_once("modele/exemplairesLivre.php");
class ControleurExemplairesLivre {

	public static function afficherPage(){
		
		include("vue/exemplairesLivre.html");

	}	
	
	
	
	public static function enregistL(){
		ExemplairesLivre::enregistrer();
		include("vue/exemplairesLivre.html");
		include("vue/footerEnregistrer.php");
	}
}




?>

