<?php

class ControllerRecette extends Controller
{
    private $id;
    private $recette;

    public function init ($id)
    {
        $this->recette = RequettesRecette::getRecetteById($id);

        # Si la recette demandée n'est pas valide / existante, on redirige vers la liste des recettes
        if ($id === null or $this->recette == Recette::$recetteVide)
            header('location: /recette');

        if ($this->recette->getBurn() < 10 and $_SESSION['role'] == 'visiteur')
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