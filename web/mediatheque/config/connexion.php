
<?php

class Connexion{

    static private $hostname = 'localhost'; 
    static private $database = 'sae-s3-hleroux'; 
    static private $login = 'sae-s3-hleroux';
    static private $mdp = '7c68dplcvZNYyKfl'; 

    static private $tabUTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    static private $pdo;
    static public function pdo() {return self::$pdo;}

    static public function connect(){
        $h = self::$hostname; $d = self::$database;
        $l = self::$login ; $m = self::$mdp;
        $t = self::$tabUTF8; 

        try{
            self::$pdo = new PDO("mysql:host=$h;dbname=$d",$l,$m,$t);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "erreur de connexion : ".$e->getMessage()."<br>";
        }
    }    
}

?>