<?php
   class ExemplairesLivre {		


		public static function enregistrer(){
			
			
			$numExemplaire=$_POST["numExemplaire"];
			$langue=$_POST["langue"];
			$etat=$_POST["etat"];
			$empruntable=$_POST["empruntable"];
			$existant=$_POST["existant"];
			$consultable=$_POST["consultable"];
			$numLivre=$_POST["numLivre"];
			$dateAjout=$_POST["dateAjout"];


			$requete = "INSERT INTO ExemplaireLivre (numExemplaire, langue,etat,empruntable,existant,consultable,numLivre,dateAjout) VALUES ($numExemplaire,'$langue','$etat',$empruntable,$existant,$consultable,$numLivre,'$dateAjout')";

			try {
				Connexion::pdo()->query($requete);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
			
		}
	
   }
   

?>