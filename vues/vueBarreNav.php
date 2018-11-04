
    <script>
        function chercher() {
            let img = document.getElementById("rechercheBouton");
            let form = document.getElementById("formulaireDeRecherche");
            let recherche = document.getElementById("rechercheChamp");
            form.removeChild(img);
            form.setAttribute("action", "/recherche/" + recherche.value);
        }
    </script>

    <nav id="BarreHorizontale">
        <ul class="sideNav">
            <li id="iconeLi"><img alt="Icone de menu déroulant" src="/vues/images/iconeMenuDeroulant.png" id="iconeImage">
                <ul class="sous-menu">
                    <?php
                        if (Session::isConnected())
                            echo '<li><a href="/profil">Profil</a></li>' . PHP_EOL;

                    if ($_GET['url'] !== 'editeur-de-recette/creer')
                        echo "\t\t\t\t\t" . '<li id="CreationReponsive"><a href="/editeur-de-recette/creer">Créer une recette</a></li>' . PHP_EOL;

                    if (!Session::isConnected())
                        echo "\t\t\t\t" . '<li><a href="/connexion">Connexion</a></li>' . PHP_EOL;
                    else
                        echo  "\t\t\t\t\t" . '<li>
                        <form action="/" id="deconnexionForm" method="post" >
                            <input id="deconnexionBouton" type="submit" name="action" value="Déconnexion"/>
                        </form>
                    </li>' . PHP_EOL;
                    ?>
                </ul>
            </li>
            <li id="C&B"> <a href="/">Cook & Burn</a></li>
            <li id="Recette"> <a href="/#conteneurRecettes">Recettes</a></li>
            <?php
            if ($_GET['url'] !== 'editeur-de-recette/creer')
                echo "\t\t\t".'<li id="Creation"> <a href="/editeur-de-recette/creer">Créer une recette</a></li>'
            ?>
            <li id="rechercheLi">
                <div id="rechercheForm">
                    <form onsubmit="chercher();" id="formulaireDeRecherche">
                        <input id="rechercheChamp" type="text" placeholder="Recherche..."/>
                        <input id="rechercheBouton" type="image" src="/vues/images/look.png" alt="search"/>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
