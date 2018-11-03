<?php
require_once 'formatPage.inc.php';

start_page ('Profil', array ('profil.css'));
?>
        <div id="profil">
            <div id="presentation_membre">
                <div>
                    <h1 id="titre">Bienvenue sur votre profil.</h1>
                    <p class="info">Pseudo: <? echo $pseudo; ?></p>
                    <br/>
                    <p class="info" >Mail: <? echo $mail; ?></p>
                    <br/>
                    <form method="post" action="/editeur-profil">
                        <input name="id" value="<? echo $id; ?>" hidden>
                        <button>Éditer le profil</button>
                    </form>
                    <br/>
                    <?php if (Session::isAdmin()) echo '<form action="/admin" method="post"><button class="boutonAdmin">Partie administrateur</button></form>'?>
                </div>
            </div>

        </div>
        <div id="favoris">
            <h1>Mes recettes favorites</h1>
            <?php
            foreach ($listeFavoris as $recette)
            {
                echo '<div class="containerFav"><a href="/recette/'.$recette->getId().'" class="mesFavoris">'.$recette->getNom().'</a>'.PHP_EOL;
                echo '<form method="post" action="/profil"><input name="id" value="'.$recette->getId().'" hidden><button name="action" class="supprimerFav" value="supprimerFavori">Retirer des favoris</button></form></div>';
            }
            ?>
        </div>
<?php
end_page ();
?>