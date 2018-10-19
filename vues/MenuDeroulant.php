<?php

require_once 'formatPage.inc.php';


start_page ('Menu', array ('menu.css','MenuDeroulant.css'));
?>
<ul id="menu-vertical">
    <li><a href="#"></a>
        <ul>
            <li><a></a></li>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Connexion</a></li>
            <li><a href="#">Déconnexion</a></li>
        </ul>
        <div class="topnav">
            <a classe="nom" href="../index.php" id="cookBurn">Cook&Burn</a>
            <a href="#recette">Recettes</a>
            <a href="#description">Description</a>
            <a href="#profil">Profil</a>

            <div class="BoutonRecherche">
                <div class="search">
                    <input type="text" class="searchTerm" placeholder="Rechercher...">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </li>
</ul>

<?php
end_page();
