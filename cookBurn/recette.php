<?php
require_once 'models/dataBaseRequest.php';
require_once 'poo/Recette.php';

$ID = intval ($_GET ['recetteId']);

$recetteAsked = Recette::FromDBRow (getRecetteByID($ID));

// Si l'id de la recette est non valide (on ne trouve pas la recette), on renvoi une recette par défaut (1)
// TODO page recette non trouvée ou recette aléatoire
if ($recetteAsked->equals(Recette::$recetteVide))
{
    $ID = 1;
    header('location:?recetteId='.$ID);
}

require 'views/recetteView.php';