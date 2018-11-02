<?php

/**
 * Class ControllerProfil
 */
class ControllerProfil extends Controller
{
    /**
     * L'id du membre.
     * @var int
     */
    private $idMembre;

    /**
     * Le pseudo du membre.
     * @var string
     */
    private $pseudo;

    /**
     * Le mail du membre.
     * @var string
     */
    private $mail;

    /**
     * Liste des recettes favorites de l'utilisateur.
     * @var Recette[]
     */
    private $listeFavoris;

    public function init ($args)
    {
        if (!Session::isConnected())
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour accéder à votre profil !');

        if (isset($_POST['action'], $_POST['id']) and $_POST['action'] == 'supprimerFavori')
            RequetesFavoris::removeFromFavorite($_POST['id'], Session::getID());

        $this->idMembre = Session::getID();
        $utilisateur = RequetesUtilisateur::getUserByID($this->idMembre);
        $this->pseudo = $utilisateur->getPseudo();
        $this->mail = $utilisateur->getEmail();

        $this->listeFavoris = RequetesFavoris::getAllRecetteFavorie(Session::getID());
    }

    public function render ()
    {
        $id = $this->idMembre;
        $pseudo = $this->pseudo;
        $mail = $this->mail;
        $listeFavoris = $this->listeFavoris;
        require 'vues/vueProfil.php';
    }
}