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

    private $update = false;

    private $askedID;

    public function init ($args)
    {
        if (!Session::isConnected())
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour accéder à votre profil !');

        if (isset($_POST['action']))
        {
            if ($_POST['action'] == 'update')
            {
                if (isset($_POST['pseudo']) and strlen($_POST['pseudo']) > 1)
                    RequetesUtilisateur::updatePseudo(Session::getID(), $_POST['pseudo']);

                if (isset($_POST['email']) and strlen($_POST['email']) > 1)
                    echo RequetesUtilisateur::updateEMail(Session::getID(), $_POST['mail']);
            }
            elseif ($_POST['action'] == 'askUpdate' and isset($_POST['id']))
            {
                $this->askedID = $_POST['id'];
                $this->update = true;
            }
        }

        $this->idMembre = Session::getID();
        $utilisateur = RequetesUtilisateur::getUserByID($this->idMembre);
        $this->pseudo = $utilisateur->getPseudo();
        $this->mail = $utilisateur->getEmail();
    }

    public function render ()
    {
        if ($this->update)
        {
            $askedID = $this->askedID;
            require 'vues/vueEditerProfil.php';
        }
        else
        {
            $id = $this->idMembre;
            $pseudo = $this->pseudo;
            $mail = $this->mail;
            require 'vues/vueProfil.php';
        }
    }
}