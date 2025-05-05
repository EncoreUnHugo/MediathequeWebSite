<?php
require_once("modele/emprunt.php");

class ControleurEmprunt {	
	
	public static function afficherPage(){	
		include("vue/emprunt.html");
	}		
	
	
	public static function enregistrerEmprunt(){
		Emprunt::enregistrer();
		include("vue/emprunt.html");
		include("vue/footerEmprunt.html");
	}
	
}


?>

