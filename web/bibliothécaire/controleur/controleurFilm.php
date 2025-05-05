<?php
require_once("modele/film.php");

class ControleurFilm {

	public static function afficherPage(){
		
		include("vue/film.html");

	}	
	
	
	public static function enregist(){
		Film::enregistrer();
		include("vue/film.html");
		include("vue/footerEnregistrer.php");
	}
}




?>

