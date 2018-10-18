<?php
/**
 * Created by PhpStorm.
 * User: f17019047
 * Date: 09/10/2018
 * Time: 11:29
 */
include "utils.inc.php";
echo ' <!DOCTYPE html> <html
        lang="fr"><head><meta charset="UTF-8"/> <title>' . PHP_EOL . 'Inscription</title><link rel="stylesheet" type="text/css" href="style.css"><link rel="stylesheet" type="text/css" href="form.css"></head><body>' . PHP_EOL
;
?>

<h2>Connexion</h2>
<div class="inscriptionConnexionDiv">
    <form action="process_form.php" method="post" class="inscriptionConnexionForm"><br>
        <fieldset class="inscriptionConnexionFieldset">
            <input type="text" name="Pseudo" placeholder="Pseudo"/></br>

            <input type="password" name="Mot_de_passe" placeholder="Mot de Passe"/></br>

            <input type="submit" class="submitButton" name="action" value="Connexion"/>
            <input type="submit" class="submitButton" name="action" value="Retour"/></br>
        </fieldset>
    </form>
</div>

