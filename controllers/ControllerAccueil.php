<?php

class ControllerAccueil extends Controller
{
    public function __construct($args)
    {
        var_dump($args);
    }

    function render ()
    {
        require_once 'modeles/RequettesRecette.php';

        $recetteDuMoment = RequettesRecette::getRecetteDuMoment();
        $lastRecettes = RequettesRecette::getLastRecettes();

        require 'vues/vueAccueil.php';
    }
}