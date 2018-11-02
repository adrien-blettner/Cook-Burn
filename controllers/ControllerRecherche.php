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

    /**
     * Le(s) mot(s) clé(s) recherché(s).
     * @var string
     */
    private $str;

    protected function init($str)
    {
        // On enleve les caractères spéciaux.
        $str = htmlspecialchars($str);
        $this->str = $str;

        // on enlève les accents pour mieux comparer et pardonner les fautes. Mais on créer d'abbord une seuvegarde pour l'affichage dans la vue.
        $strSave = $str;
        $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);

        $listRecettes = RequetesRecette::getLastRecettes();

        foreach ($listRecettes as $recette)
        {
            foreach ([$recette->getNom(), $recette->getIngredients(), $recette->getDescriptionCourte(), $recette->getDescriptionLongue()] as $element)
            {
                // Pour chaque élément on enlève les accent et on cherche notre mot clé dedans.
                // Si on trouve notre mot clé, on ajoute notre recette et on passe à la suivante.
                if (strpos(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $element), $str) !== false)
                {
                    array_push($this->resultRecherche, $recette);
                    break;
                }
            }
        }
    }

    protected function render()
    {
        $listeRecettes = $this->resultRecherche;
        require 'vues/vueRecherche.php';
    }

}