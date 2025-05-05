<?php

class ControleurHandler {




public static function handle(){
            if (isset($_POST['type'])) {
                $s = $_POST['type'];
                if ($s === "Album") {	
					header("location:".$_SERVER['PHP_SELF']."?controleur=controleurExemplaires&action=afficherPage");
                } else if ($s === "Film") {
                   header("location:".$_SERVER['PHP_SELF']."?controleur=controleurExemplairesFilm&action=afficherPage");
                } else if ($s === "Livre") {
                    header("location:".$_SERVER['PHP_SELF']."?controleur=controleurExemplairesLivre&action=afficherPage");
                }
            }
}

}




?>

