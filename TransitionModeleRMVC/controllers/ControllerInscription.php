<?php

class ControllerInscription extends  Controller
{
    public function __construct($args)
    {
        # TODO Traitement direct ici du post commeconnection
    }

    function render()
    {
        require 'vues/vueInscription.php';
    }

}