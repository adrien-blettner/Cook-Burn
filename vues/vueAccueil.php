<?php
require 'formatPage.inc.php';

start_page('accueil', array('accueil.css'));
?>
    <div id="banniereImg"></div>
    <div id="description">
        <h1>Présentation du service</h1>
        <p>
            Cook&Burn est un site de partage de recettes orienté autour des grillades !<br/>
            Différents utilisateurs peuvent poster, consulter et noter des recettes.<br/>
            L'objectif du site est simple : vous permettre de partager vos créations tout en découvrant celles d'autres passionés du barbecue !<br/>
        </p>
        <h2>Fonctionnement du site</h2>
        <p>
            Avec Cook&Burn, vous serez en mesure de consulter les recettes les plus populaires du moment, et ça, sans même avoir de compte.<br/>
            La création d'un compte vous permettra de consulter l'intégralité des recettes, de créer et partager vos propres créations et bien plus encore !<br/>
            Pour obtenir un compte, il vous suffit de posséder un de nos barbecue. Un administrateur se chargera de vous créer votre compte avec toutes vos informations envoyées par mail !<br/>
        </p>
    </div>

    <div id="topRecette">
        <h1>Top recette</h1>
        <a href="/recette/<?php echo $recetteDuMoment->getId();?>"><img src="<?php echo $recetteDuMoment->getImageUrl(); ?>" alt="bug_imgTopRecette"/></a>
        <p>
            <?php echo $recetteDuMoment->getNom(); ?>
        </p>
        <p>
            <?php echo 'Burns : ' , $recetteDuMoment->getBurn(); ?>
        </p>
        <p>
            <?php echo $recetteDuMoment->getDescriptionCourte(); ?>
        </p>
    </div>

    <div id="recettes">
        <h1>Liste des recettes</h1>
        <div id="conteneurRecettes">
                <?php foreach ($lastRecettes as $recette)
                {
                    echo '<div class="recetteContenue">' ,'<p>' , $recette->getNom() , '</p>' , '<a href="/recette/' , $recette->getId() ,'"><img src="' , $recette->getImageUrl() , '" alt="bug_imgRecettes"/></a>' ,
                    '<p>' , 'Burns : ' ,$recette->getBurn() , '</p>' , '<p>' , $recette->getDescriptionCourte() , '</p>' , '</div>' , PHP_EOL;
                }
                ?>
        </div>
    </div>
<?php
end_page();
?>