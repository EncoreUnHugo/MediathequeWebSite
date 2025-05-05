<?php
require_once("modele/exemplaires.php");
class ControleurExemplaires {

	public static function afficherPage(){
		
		include("vue/exemplaires.html");

	}	
	
	
	public static function enregist(){
		Exemplaires::enregistrer();
		include("vue/exemplaires.html");
		include("vue/footerEnregistrer.php");
	}
	

}


?>

