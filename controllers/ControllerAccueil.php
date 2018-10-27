<?php

/**
 * Class ControllerAccueil
 */
class ControllerAccueil extends Controller
{
    /**
     * La recette du moment (15 burn le plus récent).
     * @var Recette
     */
    private $recetteDuMoment;

    /**
     * Les recettes ordonnées par dates.
     * @var array
     */
    private $lastRecettes;

    protected function init ($args)
    {
        # Récupère la recette du moment.
        $this->recetteDuMoment = RequettesRecette::getRecetteDuMoment();
        # Récupère la liste de recettes.
        $this->lastRecettes = RequettesRecette::getLastRecettes();
        if (ISSET($_POST['action']) && $_POST['action'] = 'Déconnexion') {
            Session::disconnect();
        }
    }

    protected function render ()
    {
        # On créer des variable avec une 'scope' lié a la fonction pour éviter d'écrire $this-> partout dans la vue de l'accueil (syntax sugar un peu).
        $recetteDuMoment = $this->recetteDuMoment;
        $lastRecettes = $this->lastRecettes;

        require 'vues/vueAccueil.php';
    }
}