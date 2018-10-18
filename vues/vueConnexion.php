<?php
require_once 'formatPage.inc.php';

start_page ('Connexion', array ('formulaire.css'));
# TODO verif formulaire car lien changé
?>
    <h2>Connexion</h2>
    <div class="inscriptionConnexionDiv">
        <form action="/modeles/process_formulaire" method="post" class="inscriptionConnexionForm"><br>
            <fieldset class="inscriptionConnexionFieldset">
                <input type="text" name="Pseudo" placeholder="Pseudo"/></br>

                <input type="password" name="Mot_de_passe" placeholder="Mot de Passe"/></br>

                <input type="submit" class="submitButton" name="action" value="Connexion"/>
                <input type="submit" class="submitButton" name="action" value="Retour"/></br>
            </fieldset>
        </form>
    </div>

<?php
end_page ();
?>