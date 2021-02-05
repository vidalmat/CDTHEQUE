<?php

namespace models;
use PDO;

class Label extends DbConnect{

    // primary key sous forme de string (chaîne de caractère)
    private $nom;


    public function __construct() {
        
        $this->pdo = new PDO("mysql:host=localhost:3306;dbname=cdtheque;charset=utf8", "root", "");


    }



    public function getNom(): ?string {
        return $this->nom;
    }

    // attention le setter $nom est une propriété différente de la valeur $nom (primary key)
    public function setNom(string $nom) {
        $this->nom = $nom;
    }



     // variable contenant la requête SQL sous la forme d'une chaîne de caractère
     public function selectAll() {

        $query = "SELECT nom FROM labels;";

        // je récupère un objet de type PDOStatement => requête préparée
        $result = $this->pdo->prepare($query);

        // exécution de la requête préparée - $result récupère le jeu de résultat 
        $result->execute();

        //
        $datas = $result->fetchAll();

        return $datas;
    }


    // sert à afficher la base de données
    public function select() {

       
        $query = "SELECT nom FROM labels WHERE nom = :nom;";
        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetch();

        if($datas) {
            $this->nom = $datas['nom'];
        }
        return $datas;

    }

    // sert à inserer dans la base de données
    public function insert() {

        
        $query = "INSERT INTO labels (nom) VALUES (:nom); ";

        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" /NATHAELLE/BASES_DE_DONNEES
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        if(!$result->execute()){
            var_dump($result->errorInfo());
            return false;

        } 

        return $this;
    }


    public function update() {


        
    }



    public function delete() {

        
        $query = "DELETE FROM labels WHERE  nom = :nom;";

        $result = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        $result->execute();

    }
}




?>