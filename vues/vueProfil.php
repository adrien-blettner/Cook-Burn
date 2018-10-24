<?php
require_once 'formatPage.inc.php';

start_page ('Profil', array ('profil.css','rolesUtilisateur.css'));
?>
        <div class="presentation">
            <div class="presentation_membre">
                <div class="titre">PROFIL</div>
                <p>Pseudo: <?php echo $pseudo ?></p>
                <p>Email: <?php echo $mail ?></p>
                <form action="" method="post" id="formMdp"/><br>
                    <input type="submit" value="Changer de mot de passe" />
                </form>
            </div>
        </div>
<?php
end_page ();
?>