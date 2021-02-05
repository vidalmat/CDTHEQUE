<?php

namespace Models;
use PDO;


class Disque extends DbConnect{

    // primary key sous forme de string (chaîne de caractère) avec un code de 6 caractères
    private $reference;

    // type string 
    private $titre;

    // type string avec un code de 4 caractères
    private $annee;

    // FK donnant le nom du Label
    private $nom;

    public function getReference(): ?string {
        return $this->reference;
    }

    public function setReference(string $ref) {
        // on vérifie la longueur de $ref 
        $this->reference = $ref;
    }


    public function getTitre(): ?string {
        return $this->titre;
    }

    public function setTitre(string $titre) {
        $this->titre = $titre;
    }


    public function getAnnee(): ?string {
        // on vérifie la longueur de $annee
        return $this->annee;
    }

    public function setAnnee(string $annee) {
        $this->annee = $annee;
    }


    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom) {
        $this->nom = $nom;
    }


       // variable contenant la requête SQL sous la forme d'une chaîne de caractère
       public function selectAll() {

        $query = "SELECT reference, titre, annee, nom FROM disques;";

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

        
        $query = "SELECT reference, titre, annee, nom FROM disques WHERE reference = :reference;";
        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetch();
        return $datas;

    }


     // sert à inserer dans la base de données
     public function insert() {

        
        $query = "INSERT INTO disques (reference, titre, annee, nom) VALUES (:reference, :titre, :annee, :nom); ";

        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);
        $result->bindValue("titre", $this->titre, PDO::PARAM_STR);
        $result->bindValue("annee", $this->annee, PDO::PARAM_STR);
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);
        
        if(!$result->execute()) {
            var_dump( $result->errorInfo()); // sert à détecter la moindre erreur dans la fonction
            return false;
        }else {
            return $this;
        }
    }

    public function update(){

        $query = "UPDATE disques SET titre = :titre, annee = :annee, nom = :nom WHERE reference = :reference;";

        $result = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);
        $result->bindValue("titre", $this->titre, PDO::PARAM_STR);
        $result->bindValue("annee", $this->annee, PDO::PARAM_STR);
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        if(!$result->execute()) {

            return false;

        }
            return $this;
        
    }



    public function delete() {

        
        $query = "DELETE FROM disques WHERE  reference = :reference;";

        $result = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);

        return $result->execute();

    }

  
}




?>