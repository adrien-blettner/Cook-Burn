<?php
/**
 * Created by PhpStorm.
 * User: f17019047
 * Date: 05/10/2018
 * Time: 14:03
 */
include "utils.inc.php";
echo ' <!DOCTYPE html> <html
        lang="fr"><head><meta charset="UTF-8"/> <title>' . PHP_EOL . 'Inscription</title><link rel="stylesheet" type="text/css" href="style.css"><link rel="stylesheet" type="text/css" href="form.css"></head><body>' . PHP_EOL
;

?>
<h2>Inscription</h2>
<div class="inscriptionConnexionDiv">
    <form action="process_form.php" method="get" class="inscriptionConnexionForm"><br>
        <fieldset class="inscriptionConnexionFieldset">
            <input type="text" name="Pseudo" placeholder="Pseudo"/></br>

            <input type="text" name="Email" placeholder="Email"/></br>

            <input type="password" name="Mot_de_passe" placeholder="Mot de Passe"/></br>

            <input type="password" name="Verif_Mot_de_passe" placeholder = "Vérification du mot de passe"/></br>

            <input type="submit" class="submitButton" name="action" value="S'inscrire"/>
            <input type="submit" class="submitButton" name="action" value="Se connecter"/></br>
        </fieldset>
    </form>
</div>

<?php
$pseudo = $_GET['Pseudo'];
$email = $_GET['Email'];
$mdp = $_GET['Mot_de_passe'];
$mdpVerif = $_GET['Verif_Mot_de_passe'];
$action = $_GET['action'];
$message='';


/*else //On check le mot de passe
{
    $query=$db->prepare('SELECT membre_mdp, membre_id, membre_rang, membre_pseudo
    FROM forum_membres WHERE membre_pseudo = :pseudo');
    $query->bindValue(':pseudo',$_POST['pseudo'], PDO::PARAM_STR);
    $query->execute();
    $data=$query->fetch();
    if ($data['membre_mdp'] == md5($_POST['password'])) // Acces OK !
    {
        $_SESSION['pseudo'] = $data['membre_pseudo'];
        $_SESSION['level'] = $data['membre_rang'];
        $_SESSION['id'] = $data['membre_id'];
        $message = '<p>Bienvenue '.$data['membre_pseudo'].', 
        vous êtes maintenant connecté!</p>
        <p>Cliquez <a href="./index.php">ici</a> 
        pour revenir à la page d accueil</p>';
    }
    else // Acces pas OK !
    {
        $message = '<p>Une erreur s\'est produite 
    pendant votre identification.<br /> Le mot de passe ou le pseudo 
        entré n\'est pas correcte.</p><p>Cliquez <a href="./connexion.php">ici</a> 
    pour revenir à la page précédente
    <br /><br />Cliquez <a href="./index.php">ici</a> 
    pour revenir à la page d accueil</p>';
    }
    $query->CloseCursor();
}
echo $message.'</div></body></html>';

}*/
end_page();
?>