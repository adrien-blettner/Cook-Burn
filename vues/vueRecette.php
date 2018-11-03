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
        <h1 id="titreRecette"><?php echo $recette->getNom();?></h1>
        <p class="inline"><?php echo 'Créateur: ' . $recette->getCreateur();?></p>
        <p class="inline"><?php echo 'Burns: ' . $recette->getBurn();?></p>
        <?php
            if (!$alreadyLiked and Session::isConnected())
                echo '<form method="post" action="/recette/'.$recette->getId().'"><button name="action"  class="like" value="like">Ajouter une burn</button></form>' . PHP_EOL;

            if (!$alreadyFavorie and Session::isConnected())
                echo '<form method="post" action="/recette/'.$recette->getId().'"><button name="action" class="favoris" value="favoris">Ajouter aux favoris</button></form>';

            if (Session::isAdmin() or Session::getID() == $recette->getIDCreateur())
            {
                echo '<form method="post" action="/editeur-de-recette/editer">';
                echo '<button name="idEditer" class="editer" value="'.$recette->getId().'">Éditer la recette</button>';
                echo '</form>';
            }
        ?>
        <p> <?php echo $recette->getDescriptionLongue();?> </p>
        <p>Ingrédients:</p>
        <ul>
            <?php
            foreach (explode('|', $recette->getIngredients()) as $ingredient)
            {
                $ingredient = explode('Δ', $ingredient);
                echo "\t\t\t\t". '<li>' . $ingredient[1] . ' : ' . $ingredient[0] . '</li>' . PHP_EOL;
            }
            ?>
        </ul>
        <p>Étapes:</p>
        <ol>
            <?php
            foreach (explode('|', $recette->getEtapes()) as $etapes)
                echo "\t\t\t\t". '<li>' . $etapes . '</li>' . PHP_EOL;
            ?>
        </ol>
    </div>
</div>

<?php
end_page();
?>
