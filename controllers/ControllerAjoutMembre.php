<?php

/**
 * Class ControllerAjoutMembre
 */
class ControllerAjoutMembre extends  Controller
{
    /**
     * Stockage des erreurs;
     * @var string
     */
    private $erreurs = null;

    protected function init ($args)
    {
        // Si l'utilisateur n'est pas admin, on demande la connexion.
        if(Session::isAdmin() === false)
            Tools::redirectToConnexion($_GET['url'], 'Vous n\'avez pas les droits nécessaire pour cette page');

        if (isset($_POST['action']) and $_POST['action'] == 'ajouterCompte')
        {
            if (isset($_POST['pseudo'], $_POST['email']))
            {
                // Récupère la valeur de la checkbox.
                if (isset($_POST['isAdmin']) and $_POST['isAdmin'] === 'yes')
                    $admin = 1;
                else
                    $admin = 0;

                // Normalement, son contenu est celui de l'attribut value si elle a été cochée.
                $result = RequetesAdmin::addUser($_POST['pseudo'], $_POST['email'], $admin);

                // Si le retour de la fonction d'ajout est une string, c'est une erreur.
                if (is_string($result))
                    $this->erreurs = $result;
                else
                {
                    // On retourne sur la page de l'admin.
                    header('location: /admin');
                    exit();
                }
            }
            else
            {
                $this->erreurs = 'Tous les champs ne sont pas remplis !';
            }
        }
    }

    protected function render ()
    {
        require 'vues/vueAjoutMembre.php';
    }
}