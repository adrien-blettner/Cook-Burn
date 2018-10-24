<?php
/**
 * Created by PhpStorm.
 * User: f17019047
 * Date: 22/10/2018
 * Time: 11:24
 */

require_once 'formatPage.inc.php';
start_page ('Menu', array ('barreNav.css'));
?>

<nav id="BarreHorizontale">
    <ul class="sideNav">
        <li id="iconeLi"><img alt="Icone de menu déroulant" src="images/iconeMenuDeroulant.png" id="iconeImage">
            <ul class="sous-menu">
                <li><a href="#">Profil</a></li>
                <li><a href="#">Connexion</a></li>
                <li><a href="#">Deconnexion</a></li>
            </ul>
        </li>
        <li> <a href="#">Cook & Burn</a></li>
        <li> <a href="#">Recette</a></li>
        <li> <a href="#">Description</a></li>
        <li> <a href="#">Barre de recherche</a></li>
    </ul>
</nav>

<?php
end_page();