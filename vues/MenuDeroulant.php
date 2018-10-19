<?php

require_once 'formatPage.inc.php';


start_page ('Menu', array ('menu.css','MenuDeroulant.css'));
?>
<ul id="menu">
    <li><a href="#"></a>
        <ul id = menu-vertical>
            <a href="#">Profil</a>
            <a href="#">Connexion</a>
            <a href="#">Déconnexion</a>
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
                        <img class="search-icon" src="images/look.png"/>
                    </button>
                </div>
            </div>
        </div>
    </li>
</ul>

<?php
end_page();
