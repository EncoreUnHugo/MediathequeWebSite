<?php
require_once("modele/album.php");

class ControleurAlbum {

	public static function afficherPage(){
		
		include("vue/album.html");

	}	
	
	
	public static function enregist(){
		Album::enregistrer();
		include("vue/album.html");
		include("vue/footerEnregistrer.php");
	}
}




?>

