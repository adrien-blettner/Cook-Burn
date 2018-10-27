<?php

/**
 * Class ControllerConnexion
 */
class ControllerConnexion extends Controller
{
    /**
     * Le message d'erreur à afficher (si il existe).
     * @var string
     */
    private $messageErreur;

    /**
     * L'url où l'on redirige l'utilisateur après connexion.
     * @var string
     */
    private $pageSuivante;

    /**
     * @param $args
     * @throws RequetteException
     */
    protected function init ($args)
    {
        Session::disconnect();

        # Prépare la page suivante (par défaut renvoie à l'accueil).
        $this->pageSuivante = '/';
        if (isset($_POST['pageSuivante']))
            $this->pageSuivante = $_POST['pageSuivante'];

        # Si la personne est déjà connecté, rallonge la session (car action prouve activité) et redrige immédiatement
        if (Session::isConnected())
        {
            Session::extendSessionLife();
            header('location: ' . $this->pageSuivante);
        }

        # Vérifie s'il y a un message erreur à afficher
        if (!isset($_POST['messageErreur']))
            $this->messageErreur = null;
        else
            $this->messageErreur = $_POST['messageErreur'];

        # Si il n'y a rien à faire on quitte
        if (!isset($_POST['action']))
            return;

        # Traitement de la connection
        if ($_POST['action'] == 'connexion')
        {
            # Vérification que tout les champs sont remplie
            if (!isset($_POST['Pseudo'], $_POST['Mot_de_passe']) or $_POST['Pseudo'] == "" or $_POST['Mot_de_passe'] == "")
            {
                Tools::redirectToConnexion($this->pageSuivante, 'Veuillez remplir tout les champs.');
            }

            # Tente la connection de l'utilisateur
            $utilisateur = RequettesUtilisateur::connect($_POST['Pseudo'],$_POST['Mot_de_passe']);

            # Verification que la connection a réussie
            if ($utilisateur === False or $utilisateur == Utilisateur::$utilisateurNull)
            {
                Tools::redirectToConnexion($this->pageSuivante, 'Pseudo ou email et/ou mot de passe invalide.');
            }

            # Assigne les nouvelle variable de session
            Session::connect($utilisateur);

            # Redirige vers la page suivante

            header('location: ' . $this->pageSuivante);

        }

        # Retour à l'accueil
        elseif ($_POST['action'] == 'Retour')
            header ('location: /');
    }

    protected function render ()
    {
        $messageErreur = $this->messageErreur;
        $pageSuivante = $this->pageSuivante;
        require 'vues/vueConnexion.php';
    }
}