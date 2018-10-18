<?php
/**
 * Created by PhpStorm.
 * User: f17019047
 * Date: 05/10/2018
 * Time: 15:04
 */

$pseudo = $_GET['Pseudo'];
$email = $_GET['Email'];
$mdp = $_GET['Mot_de_passe'];
$mdpVerif = $_GET['Verif_Mot_de_passe'];
$action = $_GET['action'];


if ($action == 'S\'inscrire')
{
    if (empty($pseudo) || empty($mdp) || empty($email) || empty($mdpVerif))
    {
        $message = '<p>Veuillez remplir tous les champs</p>';
        echo $message;
        echo '<a href="form.php">Retour</a>';
    }
    elseif ($mdp != $mdpVerif )
    {

        $message = '<p>Mots de passe differents </p>';
        echo $message;
    }
}
elseif ($action == 'Se connecter')
{
    header('location:Connexion.php');
}
else{
    echo $action;
    echo 'Erreur Bouton';
}