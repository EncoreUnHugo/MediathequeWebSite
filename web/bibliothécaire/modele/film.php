<?php


   class Film {
	   
		public static function enregistrer(){
			
			$numFilm=$_POST["numFilm"];
			$titreFilm=$_POST["titreFilm"];
			$urlCouverture=$_POST["urlCouverture"];
			$description=$_POST["description"];
			$realisateur=$_POST["realisateur"];
			$saga=$_POST["saga"];
			


			
			
			$requete = "INSERT INTO Film (numFilm,titreFilm,urlCouverture,description,realisateur,saga) VALUES ($numFilm,'$titreFilm','$urlCouverture','$description',$realisateur,'$saga')";
			try {
				Connexion::pdo()->query($requete);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
					}
  
  }

?>