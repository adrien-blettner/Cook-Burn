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


    <form action="/profil" method="post" id="formulaire">
        <input id="pseudo" name="pseudo" placeholder="nouveau pseudo">
        <button type="button" id="pseudoButton" onclick="dontChangePseudo();">ne pas change de pseudo</button>
        <input id="email" name="email" placeholder="nouveau email">
        <button type="button" id="emailButton" onclick="dontChangeMail();">ne pas change d'email</button>
        <?php
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
            echo '<input id="mdp" name="new password">';
            echo '<button type="button" id="mdpButton" onclick="dontChangePassword();">ne pas change de mot de passe</button>';
        }
        ?>
        <button name="action" value="update">Mettre à jour.</button>
    </form>

<?php
end_page();
?>