<?php

require_once 'utils.inc.php';


start_page ('form', array ('<link rel="stylesheet" type="text/css" href="/views/css/styles.css">','<link rel="stylesheet" type="text/css" href="/views/css/menu.css">'));
?>
<ul id="menu-vertical" xmlns="http://www.w3.org/1999/html">
    <li><a href="#"></a>
        <ul>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Recettes</a></li>
            <li><a href="#">Index</a></li>
            <li><a href="#">Déconnexion</a></li>
        </ul>
        <div class="topnav">
            <a classe="nom" href="index.php" id="cookBurn">Cook&Burn</a>
            <a href="#recette">Recettes</a>
            <a href="#description">Description</a>
            <!-- Barre de recherche -->
            <form action="/search" id="searchthis" method="get">
                <input id="search" name="q" type="text" placeholder="Rechercher..." />
                <input class="search-btn" type="submit" value="">
            </form>
        </div>
        </li>

</ul>

