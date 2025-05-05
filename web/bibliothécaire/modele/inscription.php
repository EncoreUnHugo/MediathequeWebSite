<?php


   class Inscription {
	   
		public static function inscript(){
			
			//pour collecter les données des utilisateurs 
			$nom=$_POST["nom"];
			$prenom=$_POST["prenom"];
			$mail=$_POST["mail"];
			$telephone=$_POST["telephone"];
			$numCategorie=$_POST["numCategorie"];
			
			$query = "SELECT MAX(numCarte) FROM Emprunteur";
			$result = connexion::pdo()->query($query);
			$maxNumCarte = $result->fetchColumn();

			$requete1 = "SELECT MAX(numCarte) FROM Emprunteur;";
			$resultat1=connexion::pdo()->query($requete1);
			$maxNumCarte = $resultat1->fetchColumn();
			$numCarte=$maxNumCarte+1;
			
			$requete2 = "SELECT MAX(numIndividu) FROM Emprunteur;";
			$resultat2=connexion::pdo()->query($requete2);
			$maxNumIndividu = $resultat2->fetchColumn();
			$numIndividu=$maxNumIndividu+1;
			//pour générer des mots de passe aléatoires
			
			$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 
			'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's', 
			't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D', 
			'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O', 
			'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z', 
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
			$longueur = 11; // longueur du mot de passe 
			$keys = array_rand($chars, $longueur); 	
			$mdp = '';
			for($i = 0; $i < $longueur; $i++)
			{
				$mdp .= $chars[$keys[$i]];
			}
			//Ajouter les données utilisateur et l'identifiant généré à la base de données
			$requete3 = "INSERT INTO Emprunteur (mail, tel, mdp,numCategorie,numCarte,numIndividu,tempsEmprunt) VALUES ('$mail', '$telephone', '$mdp',$numCategorie,$numCarte,$numIndividu,0)";
			$requete4 = "INSERT INTO Individu(numIndividu,nom,prenom) VALUES ($numIndividu,'$nom','$prenom')";
			try {
				Connexion::pdo()->query($requete3);
				Connexion::pdo()->query($requete4);
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
			
			session_start();
			$_SESSION['username'] = $mail;
			$_SESSION['password'] = $mdp;
					}
  
  }

?>