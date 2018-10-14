<?php

class ControllerRecette extends Controller
{
    private $id;
    private $recette;

    public function __construct($id)
    {
        $this->recette = RequettesRecette::getRecetteById($id);

        # Si la recette demandée n'est pas valide / existante, on redirige vers la liste des recettes
        if ($id !== null and $this->recette == Recette::$recetteVide)
            header('location: /recettes');

        # Si l'id est null, le mettre à -1 (indique que l'on veut toutes les recettes)

        $this->id = ($id === null) ? -1 : $id;
    }

    function render ()
    {
        $recette = $this->recette;

        # Affichage de la page avec toutes les recettes
        if ($this->id == -1)
        {
            echo 'toute les recettes';
        }

        # Affichage de la page de la recette demander
        else
        {
            # Affichage de la recette valide
            require 'vues/vueRecette.php';
        }

    }
}