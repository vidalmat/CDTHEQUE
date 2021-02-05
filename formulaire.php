<?php

require_once "index.php";




// renvoie la valeur de $toTemplate["labels]
// renvoie la valeur de $toTemplate["disques]

//var_dump($toTemplate); 

$datas = $toTemplate["labels"]; // nommage d'une variable pour réduire l'écriture et la mémoire

if(isset($toTemplate["disques"])) {

    $disques = $toTemplate["disques"];
    ch_entities($disques); // appel de la fonction sur $disques
    $label = "";
    $titre = "";
    $reference = "";
    $annee = "";
    $artiste = "";

}


if(isset($toTemplate["disque"])) {

    $disque = $toTemplate["disque"];
    ch_entities($disque); // appel de la fonction sur $disques
    $label = $disque["nom"];
    $titre = $disque["titre"];
    $reference = $disque["reference"];
    $annee = $disque["annee"];
    ch_entities($toTemplate["artiste"]);
    $artiste = $toTemplate["artiste"][0]["nom"];

}


?>


<div class="container1">

    <!-- permet de changer la page en fonction de l'ajout ou de la modification du disque -->
    <?php $value = ($toTemplate["action"] == "show")? "ajoutdisque" : "moddisque"; ?>
    <form action="index.php?route=<?= $route ?>" method="POST">

        <select name="label">
        
            <?php foreach($datas as $data): ?>

                <option><?= $data["nom"] ?></option>  <!-- affiche via $data, tous les labels dans un select-->

            <?php endforeach ?>

        </select>

        <div>
            <input type="text" placeholder="Label du disque" name="label" value="<?= $label?>">
        </div>

        <div>
            <input type="text" placeholder="Titre de l'album"  name="titre" value="<?= $titre?>">
        </div>

        <div>
            <input type="text" placeholder="Année" name="annee" value="<?= $annee?>">
        </div>

        <div>
        <?php if($toTemplate["action"] == "mod"):?>
            (Référence disque : <?= $reference ?>)
                <input type="hidden" name="reference" value="<?= $reference ?>">
            <?php else: ?>
                <input type="text" placeholder="Référence du disque" name="reference" value="">
            <?php endif ?>
        </div>

        <div>
            <input type="text" placeholder="Artiste" name="artiste" value="<?= $artiste?>">
        </div>

        <div>
            <input type="hidden" value="<?= sha1(SALT) ?>" name="token">
        </div>

        <div>
        <!-- permet de changer la page en fonction de l'ajout ou de la modification du disque -->
        <?php $value = ($toTemplate["action"] == "show")? "Ajouter un disque" : "Modifier le disque"; ?>
            <input type="submit" value="<?= $value?>">
        </div>

    </form>


    <?php if($toTemplate["action"] == "show"): ?>
        <ul>

            <?php foreach($disques as $disk): ?>

                    <!-- affiche via $data, tous les disques dans une li avec le titre, le nom du label ainsi que l'année-->
                <li>
                    <?= $disk["titre"] ?> (Label : <?= $disk["nom"] ?>) [<?= $disk["annee"]?>]
                    <a href="index.php?route=showmoddisque&disk=<?= $disk["reference"] ?>">Modifier</a>
                    <a href="index.php?route=supdisque&disk=<?= $disk["reference"] ?>">Supprimer</a>
                </li>

            <?php endforeach ?>

        </ul>

    <?php endif ?>


</div>
