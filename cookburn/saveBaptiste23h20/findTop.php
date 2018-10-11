<?php
require "bdRequest.php";
require "/poo/Recette.php";

$topRecette = getRecetteByBurn(15);
Recette::FromDBRow(getRecetteByBurn(15));

$p = [];

foreach ($dbresult as $dbrow)
{
    $p += Recette::FromDBRow($dbrow);
}





require 'index.php';