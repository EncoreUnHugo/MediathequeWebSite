<?php
require_once("modele/exemplairesFilm.php");
class ControleurExemplairesFilm {

	public static function afficherPage(){
		
		include("vue/exemplairesFilm.html");

	}	
	
	public static function enregistF(){
		ExemplairesFilm::enregistrer();
		include("vue/exemplairesFilm.html");
		include("vue/footerEnregistrer.php");
	}
	
}




?>

