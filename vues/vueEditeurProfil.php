<?php
require 'formatPage.inc.php';

start_page('administration | supprimer un membre');
?>
    <script>
        function dontChangePseudo() {
            let fo = document.getElementById("formulaire");
            fo.removeChild(document.getElementById("pseudo"));
            fo.removeChild(document.getElementById("pseudoButton"));
        }
        function dontChangeMail() {
            let fo = document.getElementById("formulaire");
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
        <input id="pseudo" name="pseudo" placeholder="nouveau pseudo" required>
        <button type="button" id="pseudoButton" onclick="dontChangePseudo();">ne pas change de pseudo</button>
        <input id="email" name="email" placeholder="nouveau email" required>
        <button type="button" id="emailButton" onclick="dontChangeMail();">ne pas change d'email</button>
        <?php
        // Si l'id de la session correspond à l'id de la session à modifier (donc c'est le propriétaire, alors on peut change le mdp;
        if (Session::getID() == $askedID)
        {
            echo '
                <script>
                    function dontChangePassword() {
                        let fo = document.getElementById("formulaire");
                        fo.removeChild(document.getElementById("mdp"));
                        fo.removeChild(document.getElementById("mdpButton"));
                    }
                </script>
            ';
            echo '<input id="mdp" name="newPassword" required>';
            echo '<button type="button" id="mdpButton" onclick="dontChangePassword();">ne pas change de mot de passe</button>';
        }
        ?>
        <button name="action" value="update">Mettre à jour.</button>
    </form>

<?php
end_page();
?>