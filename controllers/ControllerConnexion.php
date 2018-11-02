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
     * @throws RequeteException
     */
    protected function init ($args)
    {
        Session::disconnect();

        // Prépare la page suivante (par défaut renvoie à l'accueil).
        $this->pageSuivante = '/';
        if (isset($_POST['pageSuivante']))
            $this->pageSuivante = $_POST['pageSuivante'];

        // Récupère le message d'erreur à afficher s'il y en à un.
        if (!isset($_POST['messageErreur']))
            $this->messageErreur = null;
        else
            $this->messageErreur = $_POST['messageErreur'];

        // Si l'utilisateur est connecté mais qu'il à été redirigé vers la page de connection avec un message d'erreur, on le déconnecte.
        // Par exemple si l'utilisateur (en manipulant une requête post) tente d'éditer une recette qui ne lui appartient pas il sera redirigé ici et donc déconnecté pour se connecté avec un compte adéquat.
        if (Session::isConnected() and $this->messageErreur !== null)
            Session::disconnect();

        // Si la personne est déjà connecté, rallonge la session (car action prouve activité) et redrige immédiatement
        if (Session::isConnected()) {
            header('location: ' . $this->pageSuivante);
            exit();
        }

        // Si il n'y a rien à faire on quitte
        if (!isset($_POST['action']))
            return;

        // Traitement de la connection
        if ($_POST['action'] == 'connexion') {
            // Vérification que tout les champs sont remplie
            if (!isset($_POST['Pseudo'], $_POST['Mot_de_passe']) or $_POST['Pseudo'] == "" or $_POST['Mot_de_passe'] == "") {
                Tools::redirectToConnexion($this->pageSuivante, 'Veuillez remplir tout les champs.');
            }

            // Tente la connection de l'utilisateur
            $utilisateur = RequetesUtilisateur::connect($_POST['Pseudo'], $_POST['Mot_de_passe']);

            // Verification que la connection a réussie
            if ($utilisateur === False or $utilisateur == Utilisateur::$utilisateurNull) {
                Tools::redirectToConnexion($this->pageSuivante, 'Pseudo ou email et/ou mot de passe invalide.');
            }

            // Assigne les nouvelle variable de session
            Session::connect($utilisateur);

            // Redirige vers la page suivante

            header('location: ' . $this->pageSuivante);
            exit();
        } // Retour à l'accueil
        elseif ($_POST['action'] == 'Retour')
        {
            header('location: /');
            exit();
        }
    }

    protected function render ()
    {
        $messageErreur = $this->messageErreur;
        $pageSuivante = $this->pageSuivante;
        require 'vues/vueConnexion.php';
    }
}