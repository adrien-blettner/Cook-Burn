<?php

class ControllerEditeurProfil extends Controller
{
    /**
     * L'id de lutilisateur dont on souhaite modifier les informations.
     * @var int
     */
    private $askedID;

    /**
     * Erreurs à afficher si besoin.
     * @var string
     */
    private $erreurs = null;

    protected function init($args)
    {
        if (!isset($_POST['id']))
            Tools::redirectToHome();

        if (Session::getID() !== $_POST['id'] and !Session::isAdmin())
            Tools::redirectToConnexion($_GET['url'], 'Vous n\'avez pas le droit d\'éditer ce profil' . PHP_EOL . 'Par sécurité vous avez été déconnecté !');

        $this->askedID = $_POST['id'];

        if (isset($_POST['erreurs']))
            $this->erreurs = $_POST['erreurs'];

        if (isset($_POST['action']) and $_POST['action'] == 'update')
        {
            $erreurs = [];
            if (isset($_POST['pseudo']) and trim($pseudo = $_POST['pseudo']) !== '')
                if (is_string($result = RequetesUtilisateur::updatePseudo($this->askedID, $pseudo)))
                    array_push($erreurs, $result);

            if (isset($_POST['email']) and trim($email = $_POST['email']) !== '')
                if (is_string($result = RequetesUtilisateur::updateEMail($this->askedID, $email)))
                    array_push($erreurs, $result);

            if (isset($_POST['newPassword']) and trim($pass = $_POST['newPassword']) !== '')
                if (RequetesUtilisateur::updatePassword($this->askedID, $pass) === false)
                    array_push($erreurs, 'Erreur lors de là MaJ du mot de passe.');

            if ($erreurs != [])
            {
                $datas = ['id' => $this->askedID, 'erreurs' => implode("\n", $erreurs)];
                Tools::redirectWithPostMethod('/editeur-profil', $datas);
            }

            if (Session::getID() != $this->askedID and Session::isAdmin())
            {
                header('location: /admin');
                exit();
            }
            else
            {
                header('location: /profil');
                exit();
            }
        }
    }

    protected function render()
    {
        $askedID = $this->askedID;
        $erreurs = $this->erreurs;
        require 'vues/vueEditeurProfil.php';
    }
}