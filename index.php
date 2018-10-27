<?php

/**
 * La page index.php sert de "page de redirection": elle va charger la page demander à l'aide du routeur.
 * Toutesles requêtes sont redirigées vers index.php par le fichier .htaccess
 */


require_once 'classes/AutoLoader.php';

# On charge l'autoloader, qui va se charger de requireles classes quand ont en a besoin (plus besoin de spécifier les require sauf pour les vues).
AutoLoader::register();

# Partie initialisation de session (commune pour toute les pages du coup).
Session::initSession();

try {
    # On créer un nouveau routeur.
    $routeur = new Routeur ();

    # Route vers la page d'accueil.
    $routeur->ajouterRoute ('/', ['GET', 'POST'], function (){
        new ControllerAccueil();
    });

    # La page de profil.
    $routeur->ajouterRoute ('/profil', ['GET','POST'], function () {
        new ControllerProfil();
    });

    # Page de connxion.
    $routeur->ajouterRoute ('/connexion', ['GET','POST'], function () {
        new ControllerConnexion ();
    });

    # Route versla partie admin TODO faire la page admin
    $routeur->ajouterRoute ('/admin', 'GET', function () {
       new ControllerAdmin();
    });

    # Page de recette liée à l'id demandé.
    $routeur->ajouterRoute ('/recette/:id', 'GET', function ($id) {
        new ControllerRecette($id);
    });

    # Route vers la page d'inscription TODO modif en page d'ajout de membre par admin
    $routeur->ajouterRoute ('/inscription', 'GET', function (){
        new ControllerInscription();
    });

    # Page de création de requête
    $routeur->ajouterRoute ('/creationRecette', ['GET','POST'], function () {
        new ControllerCreationRecette();
    });

    # Lance le routeur
    $routeur->run();

} catch (RouteurException $r) {
    $r->getTrace(); // meh
}