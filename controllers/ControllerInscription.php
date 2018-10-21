<?php

# Controller de la page d'inscription
class ControllerInscription extends  Controller
{
    protected function init ($args)
    {
        # TODO Traitement direct ici du post comme connection
    }

    protected function render ()
    {
        require 'vues/vueInscription.php';
    }
}