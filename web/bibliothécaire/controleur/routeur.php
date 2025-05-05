<?php

require_once("config/connexion.php");
Connexion::connect();
require_once("modele/session.php");
$controleur = "controleurInscription";
$action = "afficherPage";
$tableauControleurs = ["controleurEmprunt","controleurEmpruntsEnCours","controleurInscription","controleurLivre","controleurAlbum","controleurFilm","controleurExemplaires","controleurExemplairesFilm","controleurExemplairesLivre","controleurHandler"];
$actionParDefaut = array(
"controleurEmprunt" =>"afficherPage",
"controleurEmpruntsEnCours" =>"afficherPage",
"controleurInscription" =>"afficherPage",
"controleurAlbum" =>"afficherPage",
"controleurFilm" =>"afficherPage",
"controleurLivre" =>"afficherPage",
"controleurExemplaires" =>"afficherPage",
"controleurExemplairesFilm" =>"afficherPage",
"controleurExemplairesLivre" =>"afficherPage",
"controleurHandler" =>"handle"
);


/*if (!Session::userConnected() && !Session::userConnecting()) {
	$action = "afficherFormulaireConnexion";
	$controleur = "controleurUtilisateur";
	require_once("controleur/$controleur.php");
} else {*/
	if (isset($_GET["controleur"]) && in_array($_GET["controleur"],$tableauControleurs)) {
	$controleur = $_GET["controleur"];

  }
  	require_once("controleur/$controleur.php");

	if (isset($_GET["action"]) && in_array($_GET["action"],get_class_methods($controleur))) {
	$action = $_GET["action"];
  } 

//}

	$controleur::$action();


	

?>
