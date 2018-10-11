<?php
$root = '/home/projetwebcookburn/www';
require_once $root . '/models/bdRequest.php';
require_once $root . '/poo/Recette.php';

$ID = $_GET ['id'];

$recetteAsked = Recette::FromDBRow (getRecetteByID($ID));

require $root . '/views/recetteView.php';