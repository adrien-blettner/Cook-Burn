<?php

/**
 * Class ControllerRecherche
 */
class ControllerRecherche extends Controller
{
    /**
     * @var Recette[]
     */
    private $resultRecherche = [];

    private $str;

    protected function init($str)
    {
        // On enleve les caractères spéciaux
        $str = htmlspecialchars($str);
        $this->str = $str;

        // on enlève les accents pour mieux comparer et pardonner les fautes. Mais on créer d'abbord une seuvegardepour l'affichage.
        $strSave = $str;
        $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);

        $listRecettes = RequetesRecette::getLastRecettes();

        foreach ($listRecettes as $recette)
        {
            # TODO opti l'ordre (pas besoin de déclarer tout si on trouve dès le début la recherche dans le nom)
            $ingredients = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $recette->getIngredients());
            $nom = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $recette->getNom());
            $descCourte = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $recette->getDescriptionCourte());
            $descLongue = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $recette->getDescriptionLongue());

            # TODO peut être un système de classement: si le mot apparait plusieurs fois ou s'il est dans la description ET les ingredients...
            if (strpos($nom, $str) !== false or strpos($ingredients, $str) !== false or strpos($descCourte, $str) !== false or strpos($descLongue, $str) !== false)
                array_push($this->resultRecherche, $recette);
        }
    }

    protected function render()
    {
        $listeRecettes = $this->resultRecherche;
        require 'vues/vueRecherche.php';
    }

}