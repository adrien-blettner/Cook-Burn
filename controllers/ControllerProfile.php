<?php

class ControllerProfile extends Controller
{
    public function __construct($args)
    {
        if (!$_SESSION['isConnected']);
            # TODO GOTO CONNEXION

    }

    public function render()
    {
        require 'vues/vueProfile.php';
    }
}