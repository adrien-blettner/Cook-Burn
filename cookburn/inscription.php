<?php
require_once "views/utils.inc.php";

start_page ('Inscription', array ('<link rel="stylesheet" type="text/css" href="/views/css/formulaire.css">'))
?>

    <h2>Inscription</h2>
    <div class="inscriptionConnexionDiv">
        <form action="process_formulaire.php" method="post" class="inscriptionConnexionForm"><br>
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
