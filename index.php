<?php

/**
 * La page index.php sert de "page de redirection": elle va charger la page demander à l'aide du routeur.
 * Toutesles requêtes sont redirigées vers index.php par le fichier .htaccess
 */


require_once 'classes/AutoLoader.php';

// On charge l'autoloader, qui va se charger de requireles classes quand ont en a besoin (plus besoin de spécifier les require sauf pour les vues).
AutoLoader::register();

// Partie initialisation de session (commune pour toute les pages du coup).
Session::initSession();

try {
    // On créer un nouveau routeur.
    $routeur = new Routeur ();

    // Route vers la page d'accueil.
    $routeur->ajouterRoute ('/', ['GET', 'POST'], function (){
        new ControllerAccueil();
    });

    // La page de profil.
    $routeur->ajouterRoute ('/profil', ['GET','POST'], function () {
        new ControllerProfil();
    });

    // Page de connxion.
    $routeur->ajouterRoute ('/connexion', ['GET','POST'], function () {
        new ControllerConnexion ();
    });

    // Route vers la partie admin.
    $routeur->ajouterRoute ('/admin', ['GET','POST'], function () {
       new ControllerAdmin(0);
    });

    // Route vers la page de suppression de compte.
    $routeur->ajouterRoute('/admin/supprimer-compte', 'POST', function () {
       new ControllerAdmin(1);
    });

    // Route vers la page pour supprimer une recette.
    $routeur->ajouterRoute('/admin/supprimer-recette', 'POST', function () {
       new ControllerAdmin(2);
    });

    // Route vers la page d'édition de profil.
    $routeur->ajouterRoute('/editeur-profil', 'POST', function () {
       new ControllerEditeurProfil();
    });

    // Route vers la page de recherche.
    $routeur->ajouterRoute('/recherche/:str', 'GET', function ($str) {
       new ControllerRecherche($str);
    });

    // Page de recette liée à l'id demandé.
    $routeur->ajouterRoute ('/recette/:id', ['GET','POST'], function ($id) {
        new ControllerRecette($id);
    });

    // Router vers la page qui va gérer l'édition et la cration de recette.
    $routeur->ajouterRoute('/editeur-de-recette/:action', ['GET','POST'], function ($action) {
       new ControllerModificationRecette($action);
    });

    // Route vers la page d'ajout de membre.
    $routeur->ajouterRoute ('/admin/ajouter-membre', ['GET', 'POST'], function (){
        new ControllerAjoutMembre();
    });

    // Lance le routeur
    $routeur->run();

} catch (RouteurException $r) {
    $r->getTrace(); // meh
}