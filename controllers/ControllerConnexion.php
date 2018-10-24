<?php

class ControllerConnexion extends Controller
{
    private $pageSuivante;
    private $messageErreur;

    /**
     * @param $args
     * @throws RequetteException
     */
    protected function init ($args)
    {
        Session::disconnect();

        # Prépare la page suivante
        if (!isset($_POST['pageSuivante']))
            $this->pageSuivante = '/profil';
        else
            $this->pageSuivante = $_POST['pageSuivante'];

        # Si la personne est déjà connecté, rallonge la session (car action prouve activité) et redrige immédiatement
        if ($_SESSION['isConnected'] == true)
        {
            Session::extendSessionLife();
            header('location: ' . $this->pageSuivante);
        }

        # Check s'il y a un message erreur à afficher
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
                $url = '/connexion';
                $data = ['pageSuivante'=> $this->pageSuivante, 'messageErreur'=>'Veuillez remplir tout les champs.'];
                Tools::redirectWithPostMethod($url, $data);
            }

            # Tente la connection de l'utilisateur
            $utilisateur = RequettesUtilisateur::connect($_POST['Pseudo'],$_POST['Mot_de_passe']);

            # Verification que la connection a réussie
            if ($utilisateur === False or $utilisateur == Utilisateur::$utilisateurNull)
            {
                $url = '/connexion';
                $data = ['pageSuivante'=> $this->pageSuivante, 'messageErreur'=>'Pseudo ou email et/ou mot de passe invalide.'];
                Tools::redirectWithPostMethod($url, $data);
            }

            # Assigne les nouvelle variable de session
            # TODO Passer un objet utilisateur
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
        require 'vues/vueConnexion.php';
    }
}