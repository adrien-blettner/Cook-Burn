<?php
require_once 'formatPage.inc.php';

start_page ($recette->getNOM(), array ('recette.css'));
?>

<div id="container">
    <div id="leftPanel">
        <img src="<?php echo $recette->getIMAGEURL();?>" alt="image">
        <p><?php echo $recette->getDESCCOURTE(); ?></p>
    </div>

    <div id="rightPanel">
        <p id="titreRecette"><?php echo $recette->getNOM();?></p>
        <p class="inline"><?php echo 'Créateur: ' . $recette->getCREATEUR();?></p>
        <p class="inline"><?php echo 'Burns: ' . $recette->getBURN();?></p>
        <p> <?php $recette->getDESCLONGUE();?> </p>
        <p>Ingédients:</p>
        <ol >
            <?php
            foreach ($recette->getINGREDIENTS() as $ingredient)
                echo "\t\t\t\t". '<li>' . $ingredient . '</li>' . PHP_EOL;
            ?>
        </ol>
        <p>Etapes:</p>
        <ol >
            <?php
            foreach ($recette->getETAPES() as $etapes)
                echo "\t\t\t\t". '<li>' . $etapes . '</li>' . PHP_EOL;
            ?>
        </ol>
    </div>
</div>

<?php
end_page();
?>
