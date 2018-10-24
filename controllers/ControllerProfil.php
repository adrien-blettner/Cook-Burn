<?php

# Controller de la page de profil
class ControllerProfil extends Controller
{
    private $idCreateur;
    private $pseudo;
    private $mail;

    public function init ($args)
    {
        if (!$_SESSION['isConnected'] or $_SESSION['isConnected'] === false)
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour accéder à votre profil !');

        $this->idCreateur = $_SESSION['id'];
        $utilisateur = RequettesUtilisateur::getUserByID($this->idCreateur);
        $this->pseudo = $utilisateur->getPseudo();
        $this->mail = $utilisateur->getEmail();
    }

    public function render ()
    {
        $idCreateur = $this->idCreateur;
        $pseudo = $this->pseudo;
        $mail = $this->mail;
        require 'vues/vueProfil.php';
    }
}