<?php

class ControllerAccueil extends Controller
{
    public function __construct($args)
    {
        var_dump($args);
    }

    function render ()
    {
        require 'modeles/RequettesRecette.php';

        $recetteDuMoment = RequettesRecette::getRecetteDuMoment();

        require 'vues/vueAccueil.php';
    }
}