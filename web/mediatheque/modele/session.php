<?php

class Session {

    public static function userConnected(){
        $bool = isset($_SESSION["mail"]);
        return $bool;
    }

    public static function adminConnected(){
        $bool = isset($_SESSION["numCategorie"]) && $_SESSION["numCategorie"] == 5;
        return $bool;
    }

    public static function userConnecting(){
        $bool = isset($_GET["action"]) && $_GET["action"]=="connecterConnexion";
    }

}

?>