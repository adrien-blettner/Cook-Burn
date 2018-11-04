<?php
require 'formatPage.inc.php';

start_page('administration | supprimer un membre', array ('editeurProfil.css'));
?>
    <script>
        function dontChangePseudo() {
            let fo = document.getElementById("formulaire");
            fo.removeChild(document.getElementById("separationInputsPseudo"));
            fo.removeChild(document.getElementById("pseudo"));
            fo.removeChild(document.getElementById("pseudoButton"));
        }
        function dontChangeMail() {
            let fo = document.getElementById("formulaire");
            fo.removeChild(document.getElementById("separationInputsEmail"));
            fo.removeChild(document.getElementById("email"));
            fo.removeChild(document.getElementById("emailButton"));
        }
    </script>

    <?php
        if ($erreurs !== null)
        {
            echo '<div id="erreurs">' . PHP_EOL;
            echo '<p>'.$erreurs.'</p>' . PHP_EOL;
            echo '</div>' . PHP_EOL;
        }
    ?>

    <form action="/editeur-profil" method="post" id="formulaire">
        <input name="id" value="<? echo $askedID; ?>" hidden>
        <div id="separationInputsPseudo">
            <input id="pseudo" name="pseudo" placeholder="nouveau pseudo" required>
            <button type="button" id="pseudoButton" onclick="dontChangePseudo();">X</button>
        </div>
        <div id="separationInputsEmail">
            <input id="email" name="email" placeholder="nouveau email" required>
            <button type="button" id="emailButton" onclick="dontChangeMail();">X</button>
        </div>
        <?php
        // Si l'id de la session correspond à l'id de la session à modifier (donc c'est le propriétaire, alors on peut change le mdp;
        if (Session::getID() == $askedID)
        {
            echo '
                <script>
                    function dontChangePassword() {
                        let fo = document.getElementById("formulaire");
                        fo.removeChild(document.getElementById("separationInputsMdp"));
                        fo.removeChild(document.getElementById("mdp"));
                        fo.removeChild(document.getElementById("mdpButton"));
                    }
                </script>
            ';
            echo '<div id="separationInputsMdp"><input type="password" id="mdp" name="newPassword" placeholder="nouveau mot de passe" required>' . PHP_EOL;
            echo '<button type="button" id="mdpButton" onclick="dontChangePassword();">X</button></div>';
        }
        ?>
        <div id="separationInputsUpdate">
            <button name="action" value="update">Mettre à jour</button>
        </div>
    </form>

<?php
end_page();
?>