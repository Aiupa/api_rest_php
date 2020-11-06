<?php
class Database{
    // Connexion to the database
    private $host = "localhost";
    private $db_name = "api_rest";
    private $username = "root";
    private $password = "";
    public $connexion;

    // getter
    public function getConnection(){

        $this->connexion = null;

        try{
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connexion error : " . $exception->getMessage();
        }

        return $this->connexion;
    }   
}