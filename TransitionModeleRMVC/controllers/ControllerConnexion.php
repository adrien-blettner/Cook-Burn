<?php

class ControllerConnexion extends Controller
{
    public function __construct($args)
    {
        # TODO parler avec damien, on pourrait faire le traitement sur la même page et renvoyer sur /profil  -> evite de devoir charger un lien intermédiaire
        # TODO vérif que $_SESSION pas déjà mis (déjà co) si oui rediriger direct vers /profile
    }

    public function render()
    {
        require 'vues/vueConnexion.php';
    }
}