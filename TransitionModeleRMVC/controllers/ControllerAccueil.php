<?php

class ControllerAccueil extends Controller
{
    public function __construct($args)
    {
        var_dump($args);
    }

    function render ()
    {
        require 'modeles/RequetteRecette.php';
        require_once 'classes/Recette.php';

        $recetteDuMoment = RequetteRecette::getRecetteDuMoment();

        require 'vues/vueAccueil.php';
    }
}