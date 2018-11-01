
    <script>
        function chercher() {
            // on ne forme pas de requêtes GET ou POST, on redirige.
            window.location = "/recherche/"+document.getElementById("rechercheChamp").value;
        }
    </script>

    <nav id="BarreHorizontale">
        <ul class="sideNav">
            <li id="iconeLi"><img alt="Icone de menu déroulant" src="/vues/images/iconeMenuDeroulant.png" id="iconeImage">
                <ul class="sous-menu">
                    <li><a href="/profil">Profil</a></li>
                    <li id="CreationReponsive"><a href="/creationRecette">Créer une recette</a></li>
                    <?php
                    if (!Session::isConnected())
                        echo "\t\t\t\t" . '<li><a href="/connexion">Connexion</a></li>' . PHP_EOL;
                    else
                        echo '<li>
                        <form action="/" id="deconnexionForm" method="post" >
                            <input id="deconnexionBouton" type="submit" name="action" value="Déconnexion"/>
                        </form>
                    </li>' . PHP_EOL;
                    ?>
                </ul>
            </li>
            <li id="C&B"> <a href="/">Cook & Burn</a></li>
            <li id="Recette"> <a href="/#conteneurRecettes">Recettes</a></li>
            <li id="Creation"> <a href="/editeur-de-recette/creer">Créer une recette</a></li>
            <li id="rechercheLi">
                <div id="rechercheForm">
                    <input id="rechercheChamp" type="text" placeholder="Recherche..."/>
                    <input onclick="chercher();" id="rechercheBouton" type="image" src="/vues/images/look.png" alt="search"/>
                </div>
            </li>
        </ul>
    </nav>
