<?php

require      'Routeur/Routeur.php';
require_once 'classes/Recette.php';
require_once 'classes/Utilisateur.php';
require_once 'controllers/Controller.php';
require_once 'modeles/tools.inc.php';
require_once 'classes/Session.php';

# Partie initialisation de session (commune pour toute les pages du coup)
Session::initSession();
# TODO Delete
var_dump($_SESSION);

try {
    $routeur = new Routeur ();

    # Ajout de la rouye vers '/' ou ' ' -> acceuil
    $routeur->ajouterRoute ('/', 'GET', function (){
        require_once 'controllers/ControllerAccueil.php';
        $renderer = new ControllerAccueil(null);
    });

    # Ajout de la route vers /profil ->  le profil
    $routeur->ajouterRoute ('/profil', 'GET', function () {
        require_once 'controllers/ControllerProfil.php';
        $renderer = new ControllerProfil(null);
    });

    $routeur->ajouterRoute('process_formulaire', 'POST', function () {
       require_once 'modeles/process_formulaire.php';
    });

    $routeur->ajouterRoute ('/connexion', ['GET','POST'], function () {
        require_once 'controllers/ControllerConnexion.php';
        $renderer = new ControllerConnexion (null);
    });

    $routeur->ajouterRoute ('/admin', 'GET', function () {
       echo 'admin !';
       #TODO page admin
    });

    # Ajout de la route vers /recettes -> page avec toutes les recettes
    $routeur->ajouterRoute ('/recette', 'GET', function () {
        require 'controllers/ControllerRecette.php';
        $renderer = new ControllerRecette(null);
    });

    # Ajoute la route vers /recettes/(id de recette) -> page de recette
    $routeur->ajouterRoute ('/recette/:id', 'GET', function ($id) {
        require 'controllers/ControllerRecette.php';
        $renderer = new ControllerRecette($id);
    });

    $routeur->ajouterRoute ('/inscription', 'GET', function (){
        require 'controllers/ControllerInscription.php';
        $renderer = new ControllerInscription(null);
    });

    # TODO remove this temp
    $routeur->ajouterRoute('/modeles/process_formulaire','POST', function (){
        require 'modeles/process_formulaire.php';
    });

    # Lance le routeur
    $routeur->run();

} catch (RouteurException $r) {
    $r->getTrace(); // meh
}