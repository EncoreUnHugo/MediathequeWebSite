<?php

require_once("modele/modele.php");
require_once("modele/carte.php");
require_once("modele/emprunteur.php");
require_once("modele/categorie.php");

class Emprunteur extends Modele{

    protected static $objet = "Emprunteur";
    protected static $cle = "mail";

    protected $mail;
    protected $tel;
    protected $mdp;
    protected $numCategorie;
    protected $numCarte;
    protected $numIndividu;
    protected $tempsEmprunt;
    

    public function afficher(){
        
        ?>

        <div class="biblio">
            <div class="transparent"></div>
        </div>

        <div class="enTete">
            <h3 class="same">             
                <?php 
                    $pts = self::getNbPoints($this->mail);
                    include("vue/affichage/uneCarte.php");                      
                ?> 
            </h3>
            <h2 class="title">MON PROFIL</h2>
            <a href="index.php?controleur=controleurConnexion&action=deconnecterConnexion"><h3 class="same">Déconnexion</h3></a>
        </div>

        <div class="containInfo">
            <h3>Informations Générales</h3>

            <div class="group">
                <div class="info">
                    <p>Adresse e-mail</p>
                    <h4><?php echo $this->mail ?></h4>
                </div>
                <div class="info">
                    <p>Mot de Passe</p>
                    <h4>************</h4>
                </div>
            </div>
            
            <div class="group">
                <div class="info">
                    <p>N° tel</p>
                    <h4><?php echo "0" . $this->tel ?></h4>
                </div>
                <div class="info">
                    <p>Categorie</p>
                    <h4>
                        <?php 
                            $ctg = self::getCategorie($this->mail);
                            include("vue/affichage/uneCategorie.php");                      
                        ?> 
                    </h4>
                </div>
            </div>

            <div class="group">
                <div class="info">
                    <p>Nom</p>
                    <h4>
                        <?php 
                            $nm = self::getNom($this->mail);
                            include("vue/affichage/unNom.php");                      
                        ?> 
                    </h4>
                </div>
                <div class="info">
                    <p>Prénom</p>
                    <h4>
                        <?php 
                            $prn = self::getPrenom($this->mail);
                            include("vue/affichage/unPrenom.php");                      
                        ?> 
                    </h4>
                </div>
            </div>

            

            <div class="supp">
                <button id="open-modal-button">Supprimer le compte</button>
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <span class="close-button">&times;</span>
                        <h2>Etes-vous sur de vouloir supprimer votre compte ?</h2>
                        <p>cette action est irréversible</p>
                        <button onclick="window.location.href = 'index.php?controleur=controleurEmprunteur&action=supprimerEmprunteur';">supprimer</button>
                    </div>
                </div>
                <p>La suppression d'un compte entraîne la perte de toutes ses données ainsi que des droits de son détenteur</p>
            </div>
        </div>

        <?php
    }


    public static function addEmprunteur($n,$p,$m,$t,$nc,$mdp1){

        $requete1 = "SELECT MAX(numCarte) FROM Emprunteur;";
        $resultat1=connexion::pdo()->query($requete1);
        $maxNumCarte = $resultat1->fetchColumn();
        $numCarte=$maxNumCarte+1;

        $requete2 = "SELECT MAX(numIndividu) FROM Emprunteur;";
        $resultat2=connexion::pdo()->query($requete2);
        $maxNumIndividu = $resultat2->fetchColumn();
        $numIndividu=$maxNumIndividu+1;
        
        $requete3 = "INSERT INTO Emprunteur (mail, tel, mdp,numCategorie,numCarte,numIndividu,tempsEmprunt) VALUES (:tag_m, :tag_t, :tag_mdp,:tag_nc,:tag_nct,:tag_ni,20)";
        
        $req_prep3 = Connexion::pdo()->prepare($requete3);
  
        $valE = array(
            ":tag_m" => $m,
            ":tag_t" => $t,
            ":tag_mdp" => $mdp1,
            ":tag_nc" => $nc,
            ":tag_ni" => $numIndividu,
            ":tag_nct" => $numCarte 
        );

        try {
            $req_prep3 -> execute($valE);
            //$req_prep4 -> execute($valI);
            return true;
        } catch(PDOException $e) {
            return false;
        }


    }

}


?>