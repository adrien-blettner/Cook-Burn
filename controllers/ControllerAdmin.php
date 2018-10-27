<?php

/**
 * Class ControllerAdmin
 */
class ControllerAdmin extends Controller
{
    protected function init($args)
    {
        // TODO: Implement init() method.
        if (!Session::isAdmin())
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecter avec des droits suffisants pour accéder à cette espace !');
    }

    protected function render()
    {
        // TODO: Implement render() method.
        echo 'admin !';
    }

}