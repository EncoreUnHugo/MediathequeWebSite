<?php


   class Livre {
	   
		public static function enregistrer(){
			
			$numLivre=$_POST["numLivre"];
			$titreLivre=$_POST["titreLivre"];
			$description=$_POST["description"];
			$saga=$_POST["saga"];
			$numType=$_POST["numType"];
			$urlCouverture=$_POST["urlCouverture"];
			$isbn=$_POST["isbn"];


			
			
			$requete = "INSERT INTO Livre (numLivre,titreLivre,description,saga,numType,urlCouverture,isbn) VALUES ($numLivre,'$titreLivre','$description',$saga,$numType,'$urlCouverture','$isbn')";
			try {
				Connexion::pdo()->query($requete);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
					}
  
  }

?>