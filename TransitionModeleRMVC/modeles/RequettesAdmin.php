<?php

require_once 'classes/ConnectionEcriture.php';

class RequettesAdmin
{
    # Ajouter un utilisateur à la bd
    public static function addUser ($pseudo, $email, $password, $isAdmin = 0)
    {
        # TODO verif que le pseudo et email ne sont pas deja utiliser
        # TODO relire ça m'a pas l'air top voir avec damien
        $lienBD = ConnectionEcriture::getConnection();
        assert ($lienBD instanceof mysqli, 'Erreur de connection.');
        $insert = $lienBD->prepare ('INSERT INTO MEMBRE (PSEUDO, EMAIL, PASSWORD, IS_ADMIN) VALUES (?,?,?,?)');

        if (is_bool($isAdmin))
            $isAdmin = intval($isAdmin);

        $insert->bind_param ('sssi',$pseudo, $email, password_hash($password, PASSWORD_BCRYPT, $isAdmin));

        # Renvoi true si l'ajout est un succès
        return $insert->execute();
    }


}