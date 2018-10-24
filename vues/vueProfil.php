<?php
require_once 'formatPage.inc.php';

start_page ('Profil', array ('profil.css','rolesUtilisateur.css'));
?>
        <script>
            function show() {
                document.getElementById("update").style.display = "block";
            }
        </script>
        <div id="profil">
            <div id="presentation_membre">
                <div>
                    <h1 id="titre">Bienvenue sur votre profil.</h1>
                    <p class="info">Pseudo :<? echo $pseudo; ?></p>
                    <br>
                    <p class="info" >Mail: <? echo $mail; ?></p>
                    <br>
                    <button onclick="show();">edit</button>
                    <br>
                </div>
                <form method="post" action="" id="update">
                    <input name="pseudo" value="<? echo $pseudo; ?>">
                    <input name="mail"  value="<? echo $mail; ?>">
                    <button name="action" value="maj">save</button>
                </form>
            </div>
        </div>
<?php
end_page ();
?>