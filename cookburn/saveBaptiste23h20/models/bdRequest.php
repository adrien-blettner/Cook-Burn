<?php
/* Connecte à la BD */
function connectToBD ()
{
    $dblink = mysqli_connect('mysql-projetwebcookburn.alwaysdata.net', '167330_everybody', 'superPassword');
    mysqli_select_db($dblink, 'projetwebcookburn_maindatabase');
    return $dblink;
}

/* Renvoie la recette qui correspond à l'id passé en paramètre */
function getRecetteByID ($id)
{
    $query = 'SELECT * FROM RECETTE WHERE ID = \'' . $id . '\';';
    $dbResult = mysqli_query(connectToBD(), $query);
    return mysqli_fetch_assoc($dbResult);
}

// RECETTE TOP (début) //

function getRecetteNameByBurn ($burn)
{
    $query = 'SELECT NOM FROM RECETTE WHERE BURN = \'' . $burn . '\';';
    $dbResult = mysqli_query(connectToBD(), $query);
    return  mysqli_fetch_assoc($dbResult);
}

function getRecetteBurnByBurn ($burn)
{
    $query = 'SELECT BURN FROM RECETTE WHERE BURN = \'' . $burn . '\';';
    $dbResult = mysqli_query(connectToBD(), $query);
    return  mysqli_fetch_assoc($dbResult);
}

function getRecetteLongDescByBurn ($burn)
{
    $query = 'SELECT DESCRIPTION_LONGUE FROM RECETTE WHERE BURN = \'' . $burn . '\';';
    $dbResult = mysqli_query(connectToBD(), $query);
    return  mysqli_fetch_assoc($dbResult);
}

function getRecetteImageByBurn ($burn)
{
    $query = 'SELECT IMAGE_NAME FROM RECETTE WHERE BURN = \'' . $burn . '\';';
    $dbResult = mysqli_query(connectToBD(), $query);
    return  mysqli_fetch_assoc($dbResult);
}

// RECETTE TOP (fin) //