<?php

    require_once("modele/modele.php");

   class Film extends Modele{

        protected static $objet = "Film";
        protected static $cle = "numFilm";
        protected static $titre = "titreFilm";
        protected static $M = "Metrage";

        protected $numFilm;
        protected $titreFilm;
        protected $urlCouverture;
        protected $description;
        protected $realisateur; 


        public function afficher(){
            ?>

            <div class=principale>

                <div class="hautDePage">
                    <div class="transparent"></div>
                    <div class="cover2"><img src="<?php echo $this->urlCouverture ?>" alt=""></div>
                    <img src="<?php echo $this->urlCouverture ?>" alt="" class="couvertureUnique" width="250px">
                </div>

                <h1><?php echo $this->titreFilm ?></h1>
                <h2>
                    <?php 
                        $ind = self::getReal($this->numFilm);
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
                        <p id=titre><?php echo $this->titreFilm ?></p>
                    </div>

                    <div class="propriete">
                        <h4>Realisteur</h4>
                        <p id=auteur>
                            <?php 
                                $ind = self::getReal($this->numFilm);
                                include("vue/affichage/unIndividu.php");                      
                            ?>
                        </p>
                    </div>

                    <div class="propriete">
                        <h4>Genre</h4>
                        <p id=genre>
                            <?php    
                                $gnr = self::getGenre($this->numFilm);
                                include("vue/affichage/unGenre.php");
                            ?>
                        </p>
                    </div>

                    <div class="propriete">
                        <h4>Description</h4>
                        <p id="desc"><?php echo $this->description ?></p>
                    </div>

                    <div class="propriete">
                        <h4>Langue</h4>
                        <p id=langue>
                            <?php 
                                $lng = self::getLangues($this->numFilm);
                                include("vue/affichage/allLangue.php");
                            ?>
                        </p>
                    </div>

                </div>

                <div class=emprunter>
                    <p>
                        <?php 
                            $nb = self::getNbExemplaires($this->numFilm);
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

            <?php
        }

        
        public function afficherGenerique(){
            ?>

            <div class="multiples">

                <div class="cover">
                    <img src="<?php echo $this->urlCouverture ?>" alt="" class="couvertureMult">
                </div>

                <div class="textMult">
    
                    <h2><?php echo $this->titreFilm ?></h2>

                    <h4>
                        <?php 
                            $ind = self::getReal($this->numFilm);
                            include("vue/affichage/unIndividu.php");                      
                        ?>
                    </h4>

                    <p>
                        <?php   echo substr($this->description,0,436) . "..." ?>
                    </p>

                </div> 

                <a href="index.php?controleur=controleurFilm&action=lireUnObjet&numFilm=<?php echo $this->numFilm ?>" class="detail">Details</a>

            </div>

            <?php
        }

    }

?>