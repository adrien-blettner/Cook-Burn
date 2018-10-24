<?php

# Controller de la page de profil
class ControllerProfil extends Controller
{
    public function init ($args)
    {
        if (!$_SESSION['isConnected']);
            # TODO GOTO CONNEXION

        $_SESSION['id'];
    }

    public function render ()
    {
        require 'vues/vueProfil.php';
    }
}