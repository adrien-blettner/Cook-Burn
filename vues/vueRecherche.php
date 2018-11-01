<?php
require_once 'formatPage.inc.php';

start_page ('recherche'.$this->str, array('recherche.css'));
// On reutilise le style de la page d'accueil.
?>

    <div id="container">
        <h1>Recettes contenant "<? echo $this->str; ?>"</h1>
        <div id="recettes">
            <?php
                $tab2 = "";
                foreach ($listeRecettes as $recette)
                {
                    echo $tab2 . '<div class="recetteContenue">
                <p>' . $recette->getNom() . '</p>
                <a href="/recette/' . $recette->getId() . '"><img src="' , $recette->getImageUrl() . '" alt="bug_imgRecettes"/></a>
                <p>Burns : ' . $recette->getBurn() . '</p>
                <p>' . $recette->getDescriptionCourte() . '</p>
                </div>' . PHP_EOL;
                    $tab2 = "\t\t\t";
                }
            ?>
        </div>
    </div>

<?php
end_page ();
?>