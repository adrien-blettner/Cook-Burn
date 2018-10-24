<?php

# Controller de la page de profil
class ControllerProfil extends Controller
{
    public function init ($args)
    {
        if (!$_SESSION['isConnected'] or $_SESSION['isConnected'] === false)
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour accéder à votre profil !');
    }

    public function render ()
    {
        require 'vues/vueProfil.php';
    }
}