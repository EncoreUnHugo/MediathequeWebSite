<?php
require_once("modele/livre.php");

class ControleurLivre {

	public static function afficherPage(){
		
		include("vue/livre.html");

	}	
	
	
	public static function enregist(){
		Livre::enregistrer();
		include("vue/livre.html");
		include("vue/footerEnregistrer.php");
	}
}




?>

