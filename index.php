<?php
    //Point d'entrée des données UTILISATEURS (GET, POST, COOKIES...)

    // Installation du routeur 

    // var_dump($_GET);
    // var_dump($_POST);


    // appel de la page contenant toutes les fonctions 
    require_once "conf/fonctions.php";
    require_once "controllers.php";
    require_once "conf/global.php";
    //



    $route = (isset($_GET["route"]))? $_GET["route"] : "showformdisk";

    //Traduction de la ligne ci-dessus

    // if(isset($_GET["route"])) {
    //     $route = $_GET["route"];
    // }else {
    //     $route = "default";
    // }

    // Début du routeur
    switch ($route) {

        case "showformdisk" : $toTemplate = showFormDisque();
        break;
        case "showformlabel" : $toTemplate = showFormLabel();
        break;
        case "showmoddisque" : $toTemplate = showModDisque();
        break;
        case "ajoutdisque" : ajoutDisque();
        break;
        case "supdisque" : supDisque();
        break;
        case "moddisque" : modDisque();
        break;
        case "ajoutlabel" : ajoutLabel();
        break;
        default : // fonction par défaut

    }
    // fin du routeur
        





    // try {
    //     $label1 = new models\Label();

    //     // données récupérées via ma méthode selectAll() dans ma table `labels`
    //     $donnees = $label1->selectAll();

    //     var_dump($donnees);


    // } catch(Exception $e) {
    //     echo "Une exception est survenue, je peux faire quelque chose dans ce cas...";
    // }


    // $label1 = new models\Label();
    // //var_dump($label1->selectAll());
    // $label1->setNom("NRJ");
    // // var_dump($label1);
    // // var_dump($label1->select());
    // $label1->insert();

    // $artiste = new models\Artiste();
    // //var_dump($artiste->selectAll());
    // $artiste->setNom("Gorillaz");
    // // var_dump($artiste);
    // // var_dump($artiste->select());
    // $artiste->insert();
    

    // $disque = new models\Disque();
    // //var_dump($disque->selectAll());
    // // $disque->setReference("D00001");
    // // $disque->setTitre("Let's Go");
    // // $disque->setAnnee("2019");
    // // $disque->setNom("Sony");
    // //var_dump($disque);
    // // var_dump($disque->select());
    // // $disque->update();



    // $enregistrement = new models\Enregistrer();
    // //var_dump($enregistrement->selectAll());
    // //$enregistrement->setIdArtiste(3);
    // $enregistrement->setIdArtiste(8);
    // $enregistrement->setReference("D00008");
    // //var_dump($enregistrement);
    // // var_dump($enregistrement->selectByRefDisque());
    // $enregistrement->insert();





    // AFFICHAGE (réponse HTTP) DU HTML
    //var_dump($toTemplate);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/style.css">
    <title>CD'THEQUE</title>
</head>
<body>
        
        <!-- Contenu spécifique de chacune des pages -->

<!-- utilisation du require pour afficher le contenu de la variable $toTemplate voir fichier controllers.php (function showFormDisque())-->
        <?php require $toTemplate["template"] ?>
    
</body>
</html>