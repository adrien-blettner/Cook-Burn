<?php
require 'formatPage.inc.php';

start_page('accueil', array('accueil.css'));
?>

    <div class="topnav">
        <a href="index.php" id="cookBurn">Cook&Burn</a>
        <a href="#recette">Recette</a>
        <a href="#description">Description</a>
    </div>

    <div class="banniereImg">

    </div>

    <div class="description">
        <h1>Présentation du service</h1>
        <p>
            Cook&Burn est un site de partage de recettes orienté autour des grillades ! <br/>
            Différents utilisateurs peuvent poster, consulter et noter des recettes.
        </p>
    </div>

    <div class="topRecette">
        <h1>Top recette</h1>
        <p>
            <img src="<?php echo $recetteDuMoment->getImageUrl(); ?>" alt="bug_imgTopRecette"/>
        </p>
        <p>
            <?php echo $recetteDuMoment->getNom(); ?>
        </p>
        <p>
            <?php echo $recetteDuMoment->getBurn(); ?>
        </p>
        <p>
            <?php echo $recetteDuMoment->getDescriptionCourte(); ?>
        </p>
    </div>

    <div class="recettes">
        <h1>Liste des recettes</h1>
        <p>
            <?php foreach ($lastRecettes as $recettes) {echo '<img src="' , $recettes->getImageUrl() , '" alt="bug_imgRecette"/>';} ?>
        </p>
    </div>

<?php
end_page();
?>