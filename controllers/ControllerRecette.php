<?php

/**
 * Class ControllerRecette
 */
class ControllerRecette extends Controller
{
    /**
     * L'id de la recette.
     * @var int
     */
    private $id;

    /**
     * La recette demandée.
     * @var Recette
     */
    private $recette;

    public function init ($id)
    {
        $this->recette = RequetesRecette::getRecetteById($id);

        # Si la recette demandée n'est pas valide / existante, on redirige vers la liste des recettes.
        if ($id === null or $this->recette == Recette::$recetteVide)
        {
            header('location: /#conteneurRecettes');
            exit();
        }

        if ($this->recette->getBurn() < 10 and !Session::isConnected())
        {
            $url = '/recette/' . $id;
            Tools::redirectToConnexion($url, 'Vous devez être connecté pour voir cette recette !');
        }

        $this->id = $id;
    }

    function render ()
    {
        $recette = $this->recette;

        # Affichage de la recette valide
        require 'vues/vueRecette.php';
    }
}