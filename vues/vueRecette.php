<?php
require_once 'formatPage.inc.php';

start_page ($recette->getNOM(), array ('recette.css'));
?>

<div id="container">
    <div id="leftPanel">
        <img src="<?php echo $recette->getImageURL();?>" alt="image">
        <p><?php echo $recette->getDescriptionCourte(); ?></p>
    </div>

    <div id="rightPanel">
        <p id="titreRecette"><?php echo $recette->getNom();?></p>
        <p class="inline"><?php echo 'Créateur: ' . $recette->getCreateur();?></p>
        <p class="inline"><?php echo 'Burns: ' . $recette->getBurn();?></p>
        <p> <?php $recette->getDescriptionLongue();?> </p>
        <p>Ingrédients:</p>
        <ol >
            <?php
            foreach ($recette->getIngredients() as $ingredient)
                echo "\t\t\t\t". '<li>' . $ingredient . '</li>' . PHP_EOL;
            ?>
        </ol>
        <p>Étapes:</p>
        <ol>
            <?php
            foreach ($recette->getEtapes() as $etapes)
                echo "\t\t\t\t". '<li>' . $etapes . '</li>' . PHP_EOL;
            ?>
        </ol>
    </div>
</div>

<?php
end_page();
?>
