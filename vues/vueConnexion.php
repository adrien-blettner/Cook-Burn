<?php
require_once 'formatPage.inc.php';
require_once 'MenuDeroulant.php';

start_page ('Connexion', array ('formulaire.css'));
?>

    <h2 id="connexionTitre">Connexion</h2>
    <div class="inscriptionConnexionDiv">
        <form action="/connexion" method="post" class="inscriptionConnexionForm"><br>
            <fieldset class="inscriptionConnexionFieldset">
                <div class="erreurs">
                    <?php
                    if ($messageErreur !== null)
                        echo '<p>'.$messageErreur.'</p>'
                    ?>
                </div>

                <input type="text" name="pseudo" placeholder="Pseudo"/></br>

                <input type="password" name="mot_de_passe" placeholder="Mot de Passe"/></br>

                <input type="hidden" name="pageSuivante" value="<? echo $pageSuivante; ?>">

                <input type="submit" class="submitButton" name="action" value="connexion"/>
                <input type="submit" class="submitButton" name="action" value="Retour"/></br>

                <?php
                    if (in_array($messageErreur, [ControllerConnexion::VERIF_MAIL, ControllerConnexion::OULIE_SAISIR_MAIL, ControllerConnexion::INFOS_INVALIDE]))
                        echo '<input type="submit" class="submitButton" name="action" value="MDPOublier">';
                ?>

            </fieldset>
        </form>
    </div>

<?php
end_page ();
?>