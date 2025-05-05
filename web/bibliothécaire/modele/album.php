<?php


   class Album {
	   
		public static function enregistrer(){
			
			$numAlbum=$_POST["numAlbum"];
			$titreAlbum=$_POST["titreAlbum"];
			$urlCouverture=$_POST["urlCouverture"];
			$description=$_POST["description"];

			
			
			$requete = "INSERT INTO Album (numAlbum,titreAlbum,urlCouverture,description) VALUES ($numAlbum,'$titreAlbum','$urlCouverture','$description')";
			try {
				Connexion::pdo()->query($requete);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
					}
  
  }

?>