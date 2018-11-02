<?php
require_once 'formatPage.inc.php';

start_page ('Profil', array ('profil.css'));
?>
        <div id="profil">
            <div id="presentation_membre">
                <div>
                    <h1 id="titre">Bienvenue sur votre profil.</h1>
                    <p class="info">Pseudo: <? echo $pseudo; ?></p>
                    <br>
                    <p class="info" >Mail: <? echo $mail; ?></p>
                    <br>
                    <form method="post" action="/editeur-profil">
                        <input name="id" value="<? echo $id; ?>" hidden>
                        <button>editer le profil</button>
                    </form>
                    <br>
                </div>
            </div>
            <?php if (Session::isAdmin()) echo '<form action="/admin" method="post"><button>Partie administrateur</button></form>'?>
        </div>
        <div id="favoris">
            <?php
            foreach ($listeFavoris as $recette)
            {
                echo '<a href="/recette/'.$recette->getId().'">'.$recette->getNom().'</a>'.PHP_EOL;
                echo '<form method="post" action="/profil"><input name="id" value="'.$recette->getId().'" hidden><button name="action" value="supprimerFavori">retirer des favoris</button></form>';
            }
            ?>
        </div>
<?php
end_page ();
?>