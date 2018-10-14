<?php
require_once 'utils.inc.php';

start_page ($recetteAsked->getNOM(), array ('<link rel="stylesheet" type="text/css" href="/views/css/recette.css">'));
?>

    <div id="container">
        <div id="leftPanel">
            <img src="<?php echo $recetteAsked->getIMAGEURL();?>" alt="image">
            <p><?php echo $recetteAsked->getDESCCOURTE(); ?></p>
        </div>

        <div id="rightPanel">
            <p id="titreRecette"><?php echo $recetteAsked->getNOM();?></p>
            <p class="inline"><?php echo 'Créateur: ' . $recetteAsked->getCREATEUR();?></p>
            <p class="inline"><?php echo 'Burns: ' . $recetteAsked->getBURN();?></p>
            <p> <?php $recetteAsked->getDESCLONGUE();?> </p>
            <p>Ingédients:</p>
            <ol >
                <?php
                 foreach ($recetteAsked->getINGREDIENTS() as $ingredient)
                     echo "\t\t\t\t". '<li>' . $ingredient . '</li>' . PHP_EOL;
                ?>
            </ol>
            <p>Etapes:</p>
            <ol >
                <?php
                foreach ($recetteAsked->getETAPES() as $etapes)
                    echo "\t\t\t\t". '<li>' . $etapes . '</li>' . PHP_EOL;
                ?>
            </ol>
        </div>
    </div>

<?php
end_page();
?>
