<?php
require_once 'vues/formatPage.inc.php';
require_once 'modeles/OLD.dataBaseRequest.php';
start_page ('Process_formulaire', array ('styles.css','formulaire.css'));

$pseudo = $_POST['Pseudo'];
$email = $_POST['Email'];
$mdp = $_POST['Mot_de_passe'];
$mdpVerif = $_POST['Verif_Mot_de_passe'];
$action = $_POST['action'];

//Gestion des boutons de inscription puis de connexion
if ($action == 'S\'inscrire')
{
    if (empty($pseudo) || empty($mdp) || empty($email) || empty($mdpVerif))     //Si un des champs est vide
    {
        $message = '<h2>Veuillez remplir tous les champs !</h2>';
        echo $message;
        echo '<a href="index.php">Retour</a>';
    }
    elseif ($mdp != $mdpVerif )     //Si le mot de passe est différent de la vérification
    {

        $message = '<h2>Mots de passe differents </h2>';
        echo $message;
    }
    else    //Tout est bon, création du compte avec envoie de mail
    {
        creationCompteUtilisateur($pseudo, $email, $mdp);
        $message = '<h2>Compte créé !</h2>';
        echo $message;
        echo '<a href="connexion.php">Retour</a>';
        /*$messageMail = 'Votre compte Cook-Burn vient d\'être créé.' . PHP_EOL
            . 'Votre nom d\'utilisateur est : ' . $pseudo . PHP_EOL
            . 'Votre Email est : ' . $email . PHP_EOL;

        mail($email, 'Création de votre compte Cook-Burn', $messageMail);*/
    }
}
elseif ($action == 'Connexion')
{
    if (empty($pseudo) || empty($mdp))  //Si un des champs est vide
    {
        $message = '<h2>Veuillez remplir tous les champs</h2>';
        echo $message;
        echo '<a href="connexion.php">Retour</a>';
    }
    else
    {
        $resultSQL = getConnexionCompte($pseudo, $mdp);
        if ($resultSQL['NOM'] == $pseudo && $resultSQL['PASSWORD'] == $mdp)   //Tout est bon
        {
            echo 'Le compte existe mais pas encore fait la connexion à l\'utilisateur';
        }
        else    //Le pseudo ou le mot de passe de correspond pas
        {
            $message = '<h2>Erreur dans le Pseudo ou le Mot de passe</h2>';
            echo $message;
            echo '<a href="connexion.php">Retour</a>';
        }
    }
}
elseif ($action == 'Retour')
{
    header('location:/');
}
else{
    echo $action;
    echo 'Erreur Bouton';
}