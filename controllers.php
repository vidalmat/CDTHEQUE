<?php

    // Pour rappel : deux types de controllers (fonctionnalités): 
    //    - Ceux qui font appel à un template (affichage - code HTML (ex : $template))
    //    - Ceux qui redirige vers un affichage (ex : ajoutDisque())

    // FONCTIONS "CONTROLLERS" = traitements appelés


    function showFormLabel () {

        return ["template" => "formlabel.php"];
    }


    function ajoutLabel() {

        $label = new Models\Label();
        if(preg_match("#^.{1,50}$#", trim($_POST["label"]))) { // la fonction trim() sert à supprimer les espaces au début et à la fin
            $label->setNom($_POST["label"]); // récupérer les données fournis par l'utilisateur
            if(!$label->select()){
                $label = $label->insert();
            }              
        }else {
            echo "Format Label incorrect";
        }

        
        header("Location:index.php?route=showformlabel");
    }



    function ajoutDisque() {
        // contient tous les traitements nécessaires à l'ajout d'un disque 
        //echo "J'ajoute un disque";

        // Je dispose des données transmises par l'utilisateur dans $_POST

        if(isset($_POST["token"]) && $_POST["token"] == sha1(SALT)){

        //1) J'insere mon label

        // a. Instanciation d'un objet Label (pour pouvoir utiliser ses fonctionnalités)
        // b. Appels aux setters pour renseigner les propriétés de notre modèle
        // c. Appel de la méthode insert() de l'objet pour déclancher l'insertion des données (propriétés) du modèle
        $label = new Models\Label();
        if(preg_match("#^.{1,50}$#", trim($_POST["label"]))) { // la fonction trim() sert à supprimer les espaces au début et à la fin
            $label->setNom($_POST["label"]); // récupérer les données fournis par l'utilisateur
            if(!$label->select()){
                $label = $label->insert();
            }              
        }else {
            echo "Format Label incorrect";
        }
    
        
        //var_dump($label);

        //2) J'insère mon artiste
        $artiste = new Models\Artiste();
        if($artiste && $label && preg_match("#^a-zA-ZàâéèëêïîœôùüçñÑ'( )-{1,50}$#", trim($_POST["artiste"]))) {
            $artiste->setNom($_POST["artiste"]); // récupérer les données fournis par l'utilisateur
            if(!$artiste->selectByNom()) {
            $artiste = $artiste->insert(); 
            }
        }else {
            echo "Format artiste incorrect";
        }
        
        //var_dump($artiste);


        // Format pour la référence : 2 lettres majuscules, suivie de 2 chiffres ou lettres minuscules
        //3) J'insère mon disque
        $disque = new Models\Disque();

        if($artiste && $label && preg_match("#^[A-Z]{2}[0-9]{2}[a-z0-9]{2}$#", trim($_POST["reference"])) && preg_match("#^.{1,50}$#", trim($_POST["titre"])) && preg_match("#^[1-2]{1}[0-9]{3}$#", trim($_POST["annee"]))) {
            $disque->setReference($_POST["reference"]); // récupérer les données fournis par l'utilisateur
            $disque->setTitre($_POST["titre"]);
            $disque->setAnnee($_POST["annee"]);
            $disque->setNom($label->getNom()); // ici se trouve la clé étrangère 
            $disque = $disque->insert();
        } else {
            echo "Format du disque incorrect";
        }



        //4) J'insère la relation disque-artiste
            if($disque && $artiste) {
            $enr = new Models\Enregistrer();
            $enr->setIdArtiste($artiste->getIdArtiste());
            $enr->setReference($disque->getReference()); // récupérer les données fournis par l'utilisateur
            $enr->insert();  
            
            }

        } else {
            echo "Le formulaire a expiré";
        }

            // Résultat souhaité : l'enregistrement des données dans la base de données 
        

        // redirection sur le formulaire via la route "showformdisk"
        header("location:index.php?route=showformdisk");
    }

       


    function showFormDisque() {

        $label = new Models\Label();  
        $labels = $label->selectAll();  // fonctionnalité pour faire apparaître les labels

        $disque = new Models\Disque();
        $disques = $disque->selectAll();

        return [
            "template" => "formulaire.php", // contient les données de ma variable $toTemplate
            "labels" => $labels,
            "disques" => $disques,
            "action" => "show"
    ]; 

    }

    function showModDisque() {  // affichage de la modification du disque 

        $label = new Models\Label();  
        $labels = $label->selectAll();  // fonctionnalité pour faire apparaître les labels

        $disque = new Models\Disque;
        $disque->setReference($_GET["disk"]);
        $disk = $disque->select();

        $enr = new Models\Enregistrer;
        $enr->setReference($_GET["disk"]);
        $idartistes = $enr->selectByRefDisque(); // on ne récupère que les id des artistes donc la suite est de faire un tableau

        var_dump ($idartistes);

        $artistes = []; // création d'un tableau artistes


        // 
        foreach($idartistes as $art) {

            $artiste = new Models\Artiste();
            $artiste->setIdArtiste($art["id_artiste"]);
            array_push($artistes, $artiste->select());

        }

        var_dump ($artistes);


        return [
            "template" => "formulaire.php",
            "action" => "mod",
            "labels" => $labels,
            "disque" => $disk,
            "artistes" => $artistes
        ];
    }



    function modDisque() {  //

        $label = new Models\Label();
        if(preg_match("#^.{1,50}$#", trim($_POST["label"]))) { // la fonction trim() sert à supprimer les espaces au début et à la fin
            $label->setNom($_POST["label"]); // récupérer les données fournis par l'utilisateur
            if(!$label->select()){
                $label = $label->insert();
            }              
        }else {
            echo "Format Label incorrect";
        }


        $artiste = new Models\Artiste();
        if($artiste && $label && preg_match("#^a-zA-ZàâéèëêïîœôùüçñÑ'( )-{1,50}$#", trim($_POST["artiste"]))) {
            $artiste->setNom($_POST["artiste"]); // récupérer les données fournis par l'utilisateur
            if(!$artiste->selectByNom()) {
            $artiste = $artiste->insert(); 
            }
        }else {
            echo "Format artiste incorrect";
        }


        if(($label && $artiste)) {

            $disque = new Models\Disque();
            $disque->setReference($_POST["reference"]);
            $disque->setTitre($_POST["titre"]);
            $disque->setAnnee($_POST["annee"]);
            $disque->setNom($label->getNom());
            $disque = $disque->update();

        }

        if($disque && $artiste) {

            $enr = new Models\Enregistrer;
            $enr->setReference($disque->getReference());

            $lignes = $enr->selectByRefDisque();
            foreach($lignes as $ligne) {
                $enr->setIdArtiste($ligne["id_artiste"]);
                $enr->delete();
            }



            $enr->setIdArtiste($artiste->getIdArtiste());
            $enr->insert();
        }

        // Redirection
        header("location:index.php?route=showformdisk");
    }


    function supDisque() {

    $enr = new Models\Enregistrer();
    $enr->setReference($_GET["disk"]);
    $lignes = $enr->selectByRefDisque();


    // Redirection
    foreach($lignes as $ligne) {
        $enr->setReference($_GET["disk"]);
        $enr->delete();
    }

    $disque = new Models\Disque();
    $disque->setReference($_GET["disk"]);
    $verif = $disque->delete();

    if(!$verif) {
        foreach($lignes as $ligne) {
            $enr->setReference($ligne["reference"]);
            $enr->setReference($ligne["id_artiste"]);
            $enr->insert();
        }
    }

        header("Location:index.php?route=showformdisk");
    }


?>