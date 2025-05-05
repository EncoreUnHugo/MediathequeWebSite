<?php
   class ExemplairesFilm {		
		
		//Méthode d'enregistrement d'un nouvel emprunt	


		public static function enregistrer(){
			
			
			$numExemplaire=$_POST["numExemplaire"];
			$langue=$_POST["langue"];
			$empruntable=$_POST["empruntable"];
			$existant=$_POST["existant"];
			$fonctionnel=$_POST["fonctionnel"];
			$support=$_POST["support"];
			$numFilm=$_POST["numFilm"];
			$dateAjout=$_POST["dateAjout"];


			$requete = "INSERT INTO ExemplaireFilm (numExemplaire, langue, empruntable,existant,fonctionnel,support,numFilm,dateAjout) VALUES ($numExemplaire,'$langue',$empruntable,$existant,$fonctionnel,'$support',$numFilm,'$dateAjout')";

			try {
				Connexion::pdo()->query($requete);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
			
		}
	
   }
   

?>