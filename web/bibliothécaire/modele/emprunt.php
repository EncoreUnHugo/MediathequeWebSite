<?php
   class Emprunt {		
		
		//Méthode d'enregistrement d'un nouvel emprunt	
		public static function enregistrer(){

			$mail=$_POST["mail"];
			$type=$_POST["type"];
			$numExemplaire=$_POST["numExemplaire"];
			$requete;

			if($type=="Album"){
			$requete = "INSERT INTO EmpruntAlbum (mail, numExemplaire, dateEmprunt, dateRetour) VALUES ('$mail', $numExemplaire,NULL, NULL)";
			}
			if($type=="Film"){
			$requete = "INSERT INTO EmpruntFilm (mail, numExemplaire, dateEmprunt, dateRetour) VALUES ('$mail', $numExemplaire,NULL, NULL)";
			}
			if($type=="Livre"){
			$requete = "INSERT INTO EmpruntLivre (mail, numExemplaire, dateEmprunt, dateRetour) VALUES ('$mail', $numExemplaire, NULL,NULL)";
			}
			
			try {
				Connexion::pdo()->query($requete);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
			
		}
	
   }
   

?>