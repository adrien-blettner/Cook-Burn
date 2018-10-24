<nav id="BarreHorizontale">
    <ul class="sideNav">
        <li id="iconeLi"><img alt="Icone de menu déroulant" src="/vues/images/iconeMenuDeroulant.png" id="iconeImage">
            <ul class="sous-menu">
                <li><a href="/vues/vueProfil.php">Profil</a></li>
                <li><a href="/vues/vueConnexion.php">Connexion</a></li>
                <li>
                    <form action="/" id="deconnexionForm" method="post" >
                        <input id="deconnexionBouton" type="submit" name="action" value="Déconnexion"/>
                    </form>
                </li>
            </ul>
        </li>
        <li> <a href="/">Cook & Burn</a></li>
        <li> <a href="#conteneurRecettes">Recette</a></li>
        <li> <a href="#">Description</a></li>
        <li id="rechercheLi">
            <form action="" id="rechercheForm" >
                <input id="rechercheChamp" type="text" placeholder="Recherche..."/><input id="rechercheBouton" type="image" src="/vues/images/look.png" />
            </form>
        </li>
    </ul>
</nav>
