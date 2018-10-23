<?php
/**
 * Created by PhpStorm.
 * User: b17013542
 * Date: 23/10/18
 * Time: 15:26
 */

class ControllerCreationRecette extends controller
{
    private $id;
    private $recette;

    public function init ($id)
    {

    }

    function render ()
    {
        require 'vues/vueCreationRecette.php';
    }
}