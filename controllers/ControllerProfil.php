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

    public function init ($args)
    {
        if (!Session::isConnected())
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour accéder à votre profil !');

        if (isset($_POST['action']) and $_POST['action'] == 'maj')
            Tools::betterDump($_POST);


        $this->idMembre = $_SESSION['id'];
        $utilisateur = RequettesUtilisateur::getUserByID($this->idMembre);
        $this->pseudo = $utilisateur->getPseudo();
        $this->mail = $utilisateur->getEmail();
    }

    public function render ()
    {
        $idCreateur = $this->idMembre;
        $pseudo = $this->pseudo;
        $mail = $this->mail;
        require 'vues/vueProfil.php';
    }
}