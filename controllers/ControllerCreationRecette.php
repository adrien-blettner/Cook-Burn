<?php

class ControllerCreationRecette extends Controller
{
    public function init ($id)
    {
        if (isset($_POST['action']) && $_POST['action'] == 'Poster recette')
        {
            echo '<pre>';
            var_dump($_POST);
            echo '</pre>';
            $idCreateur = $_SESSION['id'];
            $nomRecette = $_POST['nomRecette'];
            $nbConvives = $_POST['nbConvives'];
            $descriptionCourte = $_POST['descriptionCourte'];
            $descriptionLongue = $_POST['descriptionLongue'];
            $ingredients = $_POST['ingredients'];
            $etapes = $_POST['etapes'];
            $image = $_POST['image'];
        }
    }

    function render ()
    {
        require 'vues/vueCreationRecette.php';
    }
}