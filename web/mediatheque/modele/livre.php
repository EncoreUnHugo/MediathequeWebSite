<?php

    require_once("modele/modele.php");
    require_once("modele/individu.php");
    require_once("modele/exemplaire.php");
    require_once("modele/genre.php");

   class Livre extends Modele{

        protected static $objet = "Livre";
        protected static $cle = "numLivre";
        protected static $titre = "titreLivre";
        protected static $auteur = "Auteur";
        protected static $M = "Book";

        protected $numLivre;
        protected $titreLivre;
        protected $description;
        protected $numSaga;
        protected $type;
        protected $urlCouverture;
        protected $ISBN;

        public function afficher(){
            ?>

            <div class=principale>

                <div class="hautDePage">
                    <div class="transparent"></div>
                    <div class="cover2"><img src="<?php echo $this->urlCouverture ?>" alt=""></div>
                    <img src="<?php echo $this->urlCouverture ?>" alt="" class="couvertureUnique" width="250px">
                </div>

                <h1><?php echo $this->titreLivre ?></h1>
                <h2>
                    <?php 
                        $ind = self::getCreateur($this->numLivre);
                        include("vue/affichage/unIndividu.php");                      
                    ?>    
                </h2>
                
                <div class="detail">
                    <h3>Détails</h3>
                    <div class=traitDetail></div>
                </div>

                <div class="leTout">
                    <div class="propriete">
                        <h4>Titre</h4>
                        <p id=titre><?php echo $this->titreLivre ?></p>
                    </div>

                    <div class="propriete">
                        <h4>Auteur</h4>
                        <p id=auteur>
                            <?php 
                                $ind = self::getCreateur($this->numLivre);
                                include("vue/affichage/unIndividu.php");                      
                            ?>
                        </p>
                    </div>

                    <div class="propriete">
                        <h4>Genre</h4>
                        <p id=genre>
                            <?php 
                                $tpe = self::getTypeLivre($this->numLivre);
                                include("vue/affichage/unType.php");
                                $gnr = self::getGenre($this->numLivre);
                                include("vue/affichage/unGenre.php");
                            ?>
                        </p>
                    </div>

                    <div class="propriete">
                        <h4>Description</h4>
                        <p id="desc"><?php echo $this->description ?></p>
                    </div>

                    <div class="propriete">
                        <h4>Editeur</h4>
                        <p id=editeur>
                            <?php 
                                $edt = self::getEditeur($this->numLivre);
                                include("vue/affichage/unEditeur.php");
                            ?>
                        </p>
                    </div>

                    <div class="propriete">
                        <h4>Langue</h4>
                        <p id=langue>
                            <?php 
                                $lng = self::getLangues($this->numLivre);
                                include("vue/affichage/allLangue.php");
                            ?>
                        </p>
                    </div>

                    <div class="propriete">
                        <h4>N° ISBN</h4>
                        <p id="isbn"><?php echo substr($this->ISBN,1,13) ?></p>
                    </div>

                </div>
                
                <div class=emprunter>
                    <p>
                        <?php 
                            $nb = self::getNbExemplaires($this->numLivre);
                            include("vue/affichage/nbExemplaire.php");
                        ?>
                    </p>
                    <?php
                    echo (isset($_SESSION['mail'])) ? 
                    ' <button id="open-modal-button">Réserver pour emprunt</button>
                        <div id="modal" class="modal">
                            <div class="modal-content">
                                <span class="close-button">&times;</span>
                                <h2>Veuillez Sélectionner un exemplaire que vous souhaiter</h2>
                                <p>⚠️🚧 réservation en cours de développement 🚧⚠️</p>
                            </div>
                        </div>' 
                    : '<p>Veuillez-vous connecter pour réserver</p>';
                    ?>
                </div>

            </div>
            

            <?php
        }

        
        public function afficherGenerique(){
            ?>

            <div class="multiples">

                <div class="cover">
                    <img src="<?php echo $this->urlCouverture ?>" alt="" class="couvertureMult">
                </div>
                
                <div class="textMult">
    
                    <h2><?php echo $this->titreLivre ?></h2>

                    <h4>
                        <?php 
                            $ind = self::getCreateur($this->numLivre);
                            include("vue/affichage/unIndividu.php");                      
                        ?>
                    </h4>

                    <p>
                        <?php   
                        if(strlen($this->description)<=436)
                            echo $this->description;
                        else
                            echo substr($this->description,0,436) . "..." ?>
                    </p>

                </div> 

                <a href="index.php?controleur=controleurLivre&action=lireUnObjet&numLivre=<?php echo $this->numLivre ?>" class="detail">Details</a>

            </div>

            <?php
        }

    }

?>
