<?php
require_once 'formatPage.inc.php';

start_page ('Ajouter un membre', array ('formulaire.css'))
?>

    <h1 id="inscriptionTitre">Ajouter un membre.</h1>
    <div class="inscriptionConnexionDiv">
        <form action="/admin/ajouter-membre" method="post" class="inscriptionConnexionForm"><br>
            <fieldset class="inscriptionConnexionFieldset">
                <div class="erreurs">
                    <?php if ($this->erreurs !== null) echo '<p>'.$this->erreurs.'</p>'; ?>
                </div>
                <input type="text" name="pseudo" placeholder="pseudo du membre"/></br>

                <input type="email" name="email" placeholder="email du membre"/></br>

                <label for="admin">L'utilisateur a les droits admin: </label>
                <input id="admin" type="checkbox" name="isAdmin" value="yes"></br>

                <input type="submit" class="submitButton" name="action" value="ajouterCompte"/>
            </fieldset>
        </form>
    </div>

<?php
end_page ();
?>