<?php

namespace Models;
use PDO;

class Artiste extends DbConnect{

    // primary key sous forme int
    private $idArtiste;

    //type string
    private $nom;

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

    
    public function setIdArtiste(int $id) {
        $this->idArtiste = $id;
    }


    public function getNom(): ?string {
        return $this->nom;
    }

    
    public function setNom(string $nom) {
        $this->nom = $nom;
    }


        // variable contenant la requête SQL sous la forme d'une chaîne de caractère
        public function selectAll() {

            $query = "SELECT id_artiste, nom FROM artistes;";

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

        
        $query = "SELECT id_artiste, nom FROM artistes WHERE id_artiste = :id;";
        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne 
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        $result->execute();
        $datas = $result->fetch(); 

        return $datas;

    }

    // fonction servant à verifier si l'artiste donné par l'utilisateur existe déjà dans la base de données
    public function selectByNom() {

        
        $query = "SELECT id_artiste, nom FROM artistes WHERE nom = :nom;";
        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        $result->execute();
        $datas = $result->fetch();
        
        // si $datas ne vaut pas FALSE (= aucune ligne correspondante)
        if($datas) {

            $this->idArtiste = $datas['id_artiste'];
            $this->nom = $datas['nom'];
        }
        
        return $datas;

    }



    // sert à inserer dans la base de données
    public function insert() {

        
        $query = "INSERT INTO artistes (nom) VALUES (:nom); ";

        $result  = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);

        if(!$result->execute()) {
            var_dump ($result->errorInfo());
        }

        $this->idArtiste = $this->pdo->lastInsertId();
        return $this;
    }


    public function update() {

        $query = "UPDATE artistes SET nom = :nom WHERE id_artiste = :id;";

        $result = $this->pdo->prepare($query);
        
        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("nom", $this->nom, PDO::PARAM_STR);
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        $result->execute();

        
    }


    public function delete() {

        
        $query = "DELETE FROM artistes WHERE  id_artiste = :id;";

        $result = $this->pdo->prepare($query);

        // Prévenir l'injection SQL, "voir cours et doc" 
        // ajout de la fonctionnalité "blindValue" pour associer une valeur à un paramètre 
        // + voir ci-dessus remplacer $this->nomdelacolonne par :nomdelacolonne
        $result->bindValue("id", $this->idArtiste, PDO::PARAM_INT);

        if(!$result->execute())
            var_dump($result->errorInfo());

    }
}




?>