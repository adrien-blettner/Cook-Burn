<?php
require './models/dataBaseRequest.php';
require './poo/Recette.php';

$topRecette = getRecetteByBurn(15);

require './views/indexView.php';