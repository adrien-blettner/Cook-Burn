<?php

class ControllerProfile extends Controller
{
    public function __construct($args)
    {
        # TODO init les variables et $_SESSION
    }

    public function render()
    {
        require 'vues/vueProfile.php';
    }
}