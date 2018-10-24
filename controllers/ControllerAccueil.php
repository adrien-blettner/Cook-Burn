<?php

class ControllerAccueil extends Controller
{
    private $recetteDuMoment;
    private $lastRecettes;

    protected function init ($args)
    {
        # Récupère la recette du moment
        $this->recetteDuMoment = RequettesRecette::getRecetteDuMoment();
        # Récupère la liste de recettes
        $this->lastRecettes = RequettesRecette::getLastRecettes();

    }

    protected function render ()
    {
        # On créer des variable avec une 'scope' lié a la fonction pour éviter d'écrrie $this-> partout dans la vue de l'accueil (syntax sugar un peu)
        $recetteDuMoment = $this->recetteDuMoment;
        $lastRecettes = $this->lastRecettes;

        require 'vues/vueAccueil.php';
    }
}