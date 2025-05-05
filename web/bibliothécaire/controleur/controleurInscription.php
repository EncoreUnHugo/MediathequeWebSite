<?php
require_once("modele/inscription.php");

class ControleurInscription {

	public static function afficherPage(){
		
		include("vue/inscription.html");

	}	
	
	
	public static function enregistrerInscription(){
		Inscription::inscript();
		include("vue/inscription.html");
		include("vue/footerInscri.php");
	}
}




?>

