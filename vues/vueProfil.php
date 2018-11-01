<?php
require_once 'formatPage.inc.php';

start_page ('Profil', array ('profil.css','rolesUtilisateur.css'));
?>
        <div id="profil">
            <div id="presentation_membre">
                <div>
                    <h1 id="titre">Bienvenue sur votre profil.</h1>
                    <p class="info">Pseudo :<? echo $pseudo; ?></p>
                    <br>
                    <p class="info" >Mail: <? echo $mail; ?></p>
                    <br>
                    <form method="post" action="/profil">
                        <input name="id" value="<? echo $id; ?>" hidden>
                        <button name="action" value="askUpdate">save</button>
                    </form>
                    <br>
                </div>
            </div>
            <?php if (Session::isAdmin()) echo '<form action="/admin"><button>Partie administrateur</button></form>'?>
        </div>
<?php
end_page ();
?>