<?php
require_once 'formatPage.inc.php';
require_once 'MenuDeroulant.php';

start_page ('Inscription', array ('formulaire.css'))
// TODO verif formulaire car lien changé
?>

    <h2 id="inscriptionTitre">Inscription</h2>
    <div class="inscriptionConnexionDiv">
        <!-- todo action et modif en creation compte par admin-->
        <form action="" method="post" class="inscriptionConnexionForm"><br>
            <fieldset class="inscriptionConnexionFieldset">
                <input type="text" name="Pseudo" placeholder="Pseudo"/></br>

                <input type="email" name="Email" placeholder="Email"/></br>

                <input type="password" name="Mot_de_passe" placeholder="Mot de Passe"/></br>

                <input type="password" name="Verif_Mot_de_passe" placeholder = "Vérification du mot de passe"/></br>

                <input type="submit" class="submitButton" name="action" value="S'inscrire"/>
            </fieldset>
        </form>
    </div>

<?php
end_page ();
?>