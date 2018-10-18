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
function getRecetteByBurn ($burn)
{
	$query = 'SELECT NOM, BURN, DESCRIPTION_LONGUE, IMAGE_NAME FROM RECETTE WHERE BURN = ' . $burn . ';';
    $dbResult = mysqli_query(connectToBD(), $query);
    return  mysqli_fetch_assoc($dbResult);
}

function creationCompteUtilisateur ($nom, $email, $password)
{
    $query = 'INSERT INTO `MEMBRE`(`NOM`, `EMAIL`, `PASSWORD`, `IS_ADMIN`) VALUES (\''
        . $nom . '\', \''
        . $email . '\', \''
        . $password .'\', 0)';

    if (!($dbResult = mysqli_query(connectToBD(), $query)))
    {
        echo 'Erreur de requête <br/>';
        echo 'Erreur : ' . mysqli_error(connectToBD()) . '<br/>';
        echo 'Requête : ' . $query . '<br/>';
        exit();
    }
}

function getConnexionCompte ($pseudo, $mdp)
{
    $query = 'SELECT * FROM MEMBRE WHERE NOM = \'' . $pseudo . '\' AND PASSWORD = \'' . $mdp .'\'';
    $dbResult = mysqli_query(connectToBD(), $query);
    return mysqli_fetch_assoc($dbResult);
}

// RECETTE TOP (fin) //