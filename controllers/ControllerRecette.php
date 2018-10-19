<?php

require_once 'modeles/RequettesRecette.php';

class ControllerRecette extends Controller
{
    private $id;
    private $recette;

    public function __construct($id)
    {
        $this->recette = RequettesRecette::getRecetteById($id);

        # Si la recette demandée n'est pas valide / existante, on redirige vers la liste des recettes
        if ($id === null or $this->recette == Recette::$recetteVide)
            header('location: /recette');

        if ($this->recette->getBurn() < 10 and $_POST['role'] == 'visiteur')
        {
            xhttp.open("POST", "demo_post2.asp", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("fname=Henry&lname=Ford");
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