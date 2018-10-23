<?php

require_once 'classes/AutoLoader.php';

# On charge l'autoloader
AutoLoader::register();

# Partie initialisation de session (commune pour toute les pages du coup)
Session::initSession();
# TODO Delete
var_dump($_SESSION);

try {
    $routeur = new Routeur ();

    # Ajout de la route vers '/' ou ' ' -> acceuil
    $routeur->ajouterRoute ('/', 'GET', function (){
        new ControllerAccueil(null);
    });

    # Ajout de la route vers /profil ->  le profil
    $routeur->ajouterRoute ('/profil', 'GET', function () {
        new ControllerProfil(null);
    });

    # TODO remove this temp
    $routeur->ajouterRoute('process_formulaire', 'POST', function () {
       require_once 'modeles/process_formulaire.php';
    });

    $routeur->ajouterRoute ('/connexion', ['GET','POST'], function () {
        new ControllerConnexion (null);
    });

    $routeur->ajouterRoute ('/admin', 'GET', function () {
       echo 'admin !';
       #TODO page admin
    });

    # Ajout de la route vers /recettes -> page avec toutes les recettes
    $routeur->ajouterRoute ('/recette', 'GET', function () {
        new ControllerRecette(null);
    });

    # Ajoute la route vers /recettes/(id de recette) -> page de recette
    $routeur->ajouterRoute ('/recette/:id', 'GET', function ($id) {
        new ControllerRecette($id);
    });

    $routeur->ajouterRoute ('/inscription', 'GET', function (){
        new ControllerInscription(null);
    });

    # TODO remove this temp
    $routeur->ajouterRoute('/modeles/process_formulaire','POST', function (){
        require 'modeles/process_formulaire.php';
    });

    # Ajout de la route vers /creationRecette -> page avec le formulaire de création de recette
    $routeur->ajouterRoute ('/creationRecette', 'GET', function () {
        new ControllerCreationRecette(null);

    });

    # Lance le routeur
    $routeur->run();

} catch (RouteurException $r) {
    $r->getTrace(); // meh
}