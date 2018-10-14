<?php

require      'Routeur/Routeur.php';
require_once 'classes/Recette.php';
require_once 'classes/Utilisateur.php';
require_once 'controllers/Controller.php';

try {
    $routeur = new Routeur ();

    # Ajout de la rouye vers '/' ou ' ' -> acceuil
    $routeur->ajouterRoute ('/', 'GET', function (){
        require_once 'controllers/ControllerAccueil.php';
        $renderer = new ControllerAccueil(null);
        $renderer->render();
    });

    # Ajout de la route vers /profil ->  le profil
    $routeur->ajouterRoute ('/profile', 'GET', function () {
        require_once 'controllers/ControllerProfile.php';
        $renderer = new ControllerProfile(null);
        $renderer->render();
        #TODO controller profile
    });

    $routeur->ajouterRoute('process_formulaire', 'POST', function () {
       require_once 'modeles/process_formulaire.php';
    });

    $routeur->ajouterRoute ('/connexion', 'GET', function () {
        require_once 'controllers/ControllerConnexion.php';
        $renderer = new ControllerConnexion (null);
        $renderer->render();
    });

    $routeur->ajouterRoute ('/admin', 'GET', function () {
       echo 'admin !';
       #TODO page admin
    });

    # Ajout de la route vers /recettes -> page avec toutes les recettes
    $routeur->ajouterRoute ('/recettes', 'GET', function () {
        require 'controllers/ControllerRecette.php';
        $renderer = new ControllerRecette(null);
        $renderer->render();
    });

    # Ajoute la route vers /recettes/(id de recette) -> page de recette
    $routeur->ajouterRoute ('/recettes/:id', 'GET', function ($id) {
        require 'controllers/ControllerRecette.php';
        $renderer = new ControllerRecette($id);
        $renderer->render();
    });

    $routeur->ajouterRoute ('/inscription', 'GET', function (){
        require 'controllers/ControllerInscription.php';
        $renderer = new ControllerInscription(null);
        $renderer->render();
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