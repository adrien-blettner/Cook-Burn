<?php

class ControllerCreationRecette extends Controller
{
    public function init ($id)
    {
        if (!isset($_SESSION['isConnected']) or $_SESSION['isConnected'] === false)
            Tools::redirectToConnexion($_GET['url'], 'Vous devez être connecté pour accéder à votre profil.');

        if (isset($_POST['action']) && $_POST['action'] == 'Poster recette')
        {
            echo '<pre>';
            var_dump($_POST);
            echo '</pre>';
            $idCreateur = $_SESSION['id'];
            $nomRecette = htmlspecialchars($_POST['nomRecette'], ENT_QUOTES, 'UTF-8');
            $nbConvives = htmlspecialchars($_POST['nbConvives'], ENT_QUOTES, 'UTF-8');
            $descriptionCourte = htmlspecialchars($_POST['descriptionCourte'], ENT_QUOTES, 'UTF-8');
            $descriptionLongue = htmlspecialchars($_POST['descriptionLongue'], ENT_QUOTES, 'UTF-8');
            $ingredients = htmlspecialchars($_POST['ingredients'], ENT_QUOTES, 'UTF-8');
            $etapes = htmlspecialchars($_POST['etapes'], ENT_QUOTES, 'UTF-8');
            $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
        }
    }

    function render ()
    {
        require 'vues/vueCreationRecette.php';
    }
}