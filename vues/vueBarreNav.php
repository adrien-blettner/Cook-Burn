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
        <li id="C&B"> <a href="/">Cook & Burn</a></li>
        <li id="Recette"> <a href="#conteneurRecettes">Recette</a></li>
        <li id="Creation"> <a href="/creationRecette">Créer une recette</a></li>
        <li id="rechercheLi">
            <form action="" id="rechercheForm" >
                <label for="rechercheBouton"><input id="rechercheChamp" type="text" placeholder="Recherche..."/></label><input id="rechercheBouton" type="image" src="/vues/images/look.png" />
            </form>
        </li>
    </ul>
</nav>
