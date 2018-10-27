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
        # Si on a cliquer sur le bouton "Déconnexion", on déconnecte la session.
        if (ISSET($_POST['action']) && $_POST['action'] = 'Déconnexion') {
            Session::disconnect();
        }

        # Récupère la recette du moment.
        $this->recetteDuMoment = RequetesRecette::getRecetteDuMoment();

        # Récupère la liste de recettes.
        $this->lastRecettes = RequetesRecette::getLastRecettes();

        # Si l'utilisateur n'est pas connecté, on chache les recettes de moins de 10 burns.
        if (!Session::isConnected())
            foreach ($this->lastRecettes as $recette)
                if ($recette->getBurn() < 10)
                    unset ($this->lastRecettes[array_search($recette, $this->lastRecettes)]);
    }

    protected function render ()
    {
        # On créer des variable avec une 'scope' lié a la fonction pour éviter d'écrire $this-> partout dans la vue de l'accueil (syntax sugar un peu).
        $recetteDuMoment = $this->recetteDuMoment;
        $lastRecettes = $this->lastRecettes;

        require 'vues/vueAccueil.php';
    }
}