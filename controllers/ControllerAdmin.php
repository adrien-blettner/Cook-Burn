<?php

/**
 * Class ControllerAdmin
 */
class ControllerAdmin extends Controller
{
    /**
     * @var Utilisateur[]|Utilisateur
     */
    private $utilisateurs;
    private $recettes;
    private $vue;

    protected function init($arg)
    {
        if (!Session::isAdmin())
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecter avec des droits suffisants pour accéder à cette espace !');

        switch ($arg)
        {
            // page admin de base
            case 0:
                $this->vue = 1;
                $this->utilisateurs = RequetesAdmin::getAlluser();
                $this->recettes = RequetesAdmin::getAllRecette();
                break;

            // page admin de supression de compte.
            case 1:
                if (!isset($_POST['action'], $_POST['id']))
                {
                    header('location: /admin');
                    exit();
                }
                $this->utilisateurs = RequetesUtilisateur::getUserByID($_POST['id']);

                if ($_POST['action'] == 'supprimer-utilisateur')
                {
                    $this->vue = 2;
                }
                elseif ($_POST['action'] =='confirmer_supression')
                {
                    if (!RequetesAdmin::deleteUser($this->utilisateurs->getPseudo(), $this->utilisateurs->getEmail()))
                        echo '<script>alert("la supression du compte à échouer !")</script>';
                    else
                        Tools::sendRemovedAccountMail($this->utilisateurs->getEmail(), $_POST['raison']);

                    header('location: /admin');
                    exit();
                }
                break;

            case 2:
                if (!isset($_POST['action'], $_POST['id']) and $_POST['action'] != 'supprimer-recette')
                {
                    header('location: /admin');
                    exit();
                }

                if (!RequetesRecette::deleteRecette($_POST['id']))
                    echo '<script>alert("la supression du compte à échouer !")</script>';

                header('location: /admin');
                exit();
                break;

            default:
                Tools::redirectToHome();
        }
    }

    protected function render()
    {
        switch ($this->vue)
        {
            case 1:
                $listeUtilisateurs = $this->utilisateurs;
                $listeRecettes = $this->recettes;
                require 'vues/vueAdmin.php';
                break;

            case 2:
                $utilisateur = $this->utilisateurs;
                require 'vues/vueSupressionUtilisateur.php';
                break;

            default:
                header('location: /');
                exit();
        }
    }
}