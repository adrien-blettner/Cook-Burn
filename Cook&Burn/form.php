<?php
/**
 * Created by PhpStorm.
 * User: f17019047
 * Date: 05/10/2018
 * Time: 14:03
 */

echo "<!DOCTYPE html><head><meta charset=\"utf-8\"><title>form</title></head>";
?>

<form action="" method="post"><br>
    <label>Identifiant</label>
    <input type="text" name="Pseudo" value="Pseudo"/></br>

    <label>E-mail</label>
    <input type="text" name="Email" value="Email"/></br>

    <label>Mot de passe</label>
    <input type="password" name="Mot_de_passe" value="Mot de Passe"/></br>

    <label>Vérification</label>
    <input type="password" name="Verif_Mot_de_passe" value = "Vérification du mot de passe"/></br>

    <input type="submit" name="action" value="S'inscrire"/></br>
    <input type="submit" name="action" value="Se connecter"/></br>
</form>
