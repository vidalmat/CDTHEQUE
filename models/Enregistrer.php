<?php

namespace Models;
use PDO;


class Enregistrer extends DbConnect{

    // foreign key sous forme de int qui référence un objet Artiste
    private $idArtiste;

    // foreign key sous forme de string qui référence un objet Disque
    private $reference;

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

   
    public function setIdArtiste(int $id) {
        $this->idArtiste = $id;
    }


    public function getReference(): ?string {
        return $this->reference;
    }

    
    public function setReference(string $ref) {
        $this->reference = $ref;
    }


    // variable contenant la requête SQL sous la forme d'une chaîne de caractère
    public function selectAll() {

        $query = "SELECT id_artiste, reference FROM enregistrer;";

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

        // POUR L'EXEMPLE!! NON SÉCURISÉ!!!
        $query = "SELECT id_artiste, reference FROM enregistrer WHERE id_artiste = :id AND reference = :reference;";
        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);
        
        $result->execute();
        $datas = $result->fetch();
        return $datas;

    }


    // fonction qui sert à afficher toutes les lignes de la base de données de la table "artistes" SQL
    public function selectByArtiste() {

        $query = "SELECT id_artiste, reference FROM enregistrer WHERE id_artiste = :id;";
        $result = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        $result->execute();
        $datas = $result->fetchAll();
        return $datas;

    }



    // fonction qui sert à afficher toutes les lignes de la base de données de la table "disques" SQL
    public function selectByRefDisque() {

        $query = "SELECT id_artiste, reference FROM enregistrer WHERE reference = :reference;";
        $result = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetchAll();
        return $datas;

    }


    // sert à inserer dans la base de données
    public function insert() {

        // POUR L'EXEMPLE!! NON SÉCURISÉ!!!
        $query = "INSERT INTO enregistrer (id_artiste, reference) VALUES (:id, :reference); ";

        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);

        $result->execute();

    }


    public function update(){

       

    }



    public function delete() {

        // POUR L'EXEMPLE!! NON SÉCURISÉ!!!
        $query = "DELETE FROM disques WHERE reference = :reference; AND id_article = :id;";

        $result = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("reference", $this->reference, PDO::PARAM_STR);
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        $result->execute();

    }

}




?>