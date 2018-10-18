<?php

require_once 'formatPage.inc.php';


start_page ('form', array ('menu.css','MenuDeroulant.css'));
?>
<ul id="menu-vertical">
    <li><a href="#"></a>
        <ul>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Recettes</a></li>
            <li><a href="#">Index</a></li>
            <li><a href="#">Déconnexion</a></li>
        </ul>
        <div class="topnav">
            <a classe="nom" href="../index.php" id="cookBurn">Cook&Burn</a>
            <a href="#recette">Recettes</a>
            <a href="#description">Description</a>
        </div>
    </li>
</ul>
