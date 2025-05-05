<?php
   class Exemplaires{		
		
		//Méthode d'enregistrement d'un nouvel emprunt	


		public static function enregistrer(){
			
			
			$numExemplaire=$_POST["numExemplaire"];
			$langue=$_POST["langue"];
			$empruntable=$_POST["empruntable"];
			$existant=$_POST["existant"];
			$fonctionnel=$_POST["fonctionnel"];
			$support=$_POST["support"];
			$numAlbum=$_POST["numAlbum"];
			$dateAjout=$_POST["dateAjout"];


			$requete = "INSERT INTO ExemplaireAlbum (numExemplaire, langue, empruntable,existant,fonctionnel,support,numAlbum,dateAjout) VALUES ($numExemplaire,'$langue',empruntable,$existant,$fonctionnel,'$support',$numAlbum,'$dateAjout')";

			try {
				Connexion::pdo()->query($requete);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
			
		}
	
   }
   

?>